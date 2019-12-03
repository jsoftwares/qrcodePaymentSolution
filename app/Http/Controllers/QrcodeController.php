<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateQrcodeRequest;
use App\Http\Requests\UpdateQrcodeRequest;
use App\Repositories\QrcodeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use QRCode; //QRcode library we downloaded
use App\Models\Qrcode as QrcodeModel;
use App\Http\Resources\Qrcode as QrcodeResource;
use App\Models\Transaction;
use App\Models\User;
use Auth;
use ErrorException;
use Hash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class QrcodeController extends AppBaseController
{
    /** @var  QrcodeRepository */
    private $qrcodeRepository;

    public function __construct(QrcodeRepository $qrcodeRepo)
    {
        $this->qrcodeRepository = $qrcodeRepo;
    }

    /**
     * Display a listing of the Qrcode.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->qrcodeRepository->pushCriteria(new RequestCriteria($request));

        //Only admin user can view all QRCodes
        if (Auth::user()->id < 3 ) 
        {
            $qrcodes = $this->qrcodeRepository->all();
        }else {
            $qrcodes = QrcodeModel::where('user_id', Auth::user()->id)->get();
        }

        /**
         * Checks if request expects JSON
         * DOC: https://laravel.com/api/5.6/Illuminate/Http/Request.html
         */
        if ($request->expectsJson()) {
            return response([
                'data' =>  QrcodeResource::collection($qrcodes)
            ], SymfonyResponse::HTTP_OK);
        }
        
        return view('qrcodes.index')
            ->with('qrcodes', $qrcodes);
    }

    /**
     * Show the form for creating a new Qrcode.
     *
     * @return Response
     */
    public function create()
    {
        return view('qrcodes.create');
    }

    /**
     * Store a newly created Qrcode in storage.
     *
     * @param CreateQrcodeRequest $request
     *
     * @return Response
     */
    public function store(CreateQrcodeRequest $request)
    {
        $input = $request->all();
        //dd($input);

        //Persist form input to DB
        //$input['qrcode_path'] = 'Null';
        $qrcode = $this->qrcodeRepository->create($input);

        //Generate QRCode
        $QrcodePath = 'qrcodes_img/' . $qrcode->id . '.png';
        QRCode::text('Buying '.$qrcode->product_name. ' at '. $qrcode->amount)
        ->setSize(7)
        ->setMargin(2)
        ->setOutfile($QrcodePath)
        ->png();

        //Update QRCode path in Db
        $newQrcode = QrcodeModel::whereId($qrcode->id)->update(['qrcode_path'=>$QrcodePath]);

        if ($newQrcode) { 

            $getQrcode = QrcodeModel::whereId($qrcode->id)->first();
         /**
         * Checks if request expects JSON
         * DOC: https://laravel.com/api/5.6/Illuminate/Http/Request.html
         */
        if ($request->expectsJson()) {
            return response([
                'data' => new QrcodeResource($getQrcode)
            ], SymfonyResponse::HTTP_CREATED);
        }
            return redirect(route('qrcodes.show', ['qrcode'=>$qrcode]));  
            Flash::success('Qrcode saved successfully.');
        }else{
            Flash::error('Qrcode failed to saved successfully.');
            return redirect(route('qrcodes.index'));
        }
        
    }

    /**
     * Display the specified Qrcode.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id, Request $request)
    {
        $qrcode = $this->qrcodeRepository->findWithoutFail($id);

        if (empty($qrcode)) {
            // Throw this error and don't proceed if the request is a JSON request
            if ($request->expectsJson()) {
                throw new ErrorException();
            }
            Flash::error('Qrcode not found');

            return redirect(route('qrcodes.index'));
        }

        $transactions = $qrcode->transactions;
        return view('qrcodes.show')->with('qrcode', $qrcode)->with('transactions', $transactions);
    }

    /**
     * Show the form for editing the specified Qrcode.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $qrcode = $this->qrcodeRepository->findWithoutFail($id);

        if (empty($qrcode)) {
            Flash::error('Qrcode not found');

            return redirect(route('qrcodes.index'));
        }

        return view('qrcodes.edit')->with('qrcode', $qrcode);
    }

    /**
     * Update the specified Qrcode in storage.
     *
     * @param  int              $id
     * @param UpdateQrcodeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateQrcodeRequest $request)
    {
        $qrcode = $this->qrcodeRepository->findWithoutFail($id);

        if (empty($qrcode)) {
            Flash::error('Qrcode not found');

            return redirect(route('qrcodes.index'));
        }

        $qrcode = $this->qrcodeRepository->update($request->all(), $id);

        Flash::success('Qrcode updated successfully.');

        return redirect(route('qrcodes.index'));
    }

    /**
     * Remove the specified Qrcode from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        $qrcode = $this->qrcodeRepository->findWithoutFail($id);

        if (empty($qrcode)) {
            Flash::error('Qrcode not found');

            return redirect(route('qrcodes.index'));
        }

        $this->qrcodeRepository->delete($id);
        if ($request->expectsJson()) {
            return response([
                'message'=>'Qrcode Deleted.'
            ], SymfonyResponse::HTTP_NOT_FOUND);
        }

        Flash::success('Qrcode deleted successfully.');

        return redirect(route('qrcodes.index'));
    }


    /**
     * Recieve buyers email from form
     * Retreive buyers information from DB using supplied email
     * create user using email if user does not exist in DB
     * Initiate transaction
     * Transfer buyer to paystack payment form
     */

     public function show_payment_page(Request $request)
     {
         $input = $request->all();

         $user = User::where('email', $input['email'])->first();

        //  if user is not found in DB, create as new user
         if (empty($user)) {
             $user = User::create([
                 'name' => $input['email'],
                 'email' => $input['email'],
                 'password' => Hash::make($input['email'])
             ]);
         }

        //  get the qrcode details
         $qrcode = QrcodeModel::where('id', $input['qrcode_id'])->first();

         //Initiate Transaction (this way we can get a trasaction ID for the payment form to enable us track trans with app)
         $transaction = Transaction::create([
             'user_id' => $user->id,
             'qrcode_id' => $qrcode->id,
             'qrcode_owner_id' => $qrcode->user_id,
             'amount' => $qrcode->amount,
             'status' => 'Initiated',
             'payment_method' => 'Paystack'
         ]);


         return view('qrcodes.paystack-form', ['qrcode'=>$qrcode, 'user'=> $user, 'transaction'=>$transaction]);
     }
}
