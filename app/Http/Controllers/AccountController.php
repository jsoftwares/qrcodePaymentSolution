<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Repositories\AccountRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\AccountHistory;
use App\Models\Account;
use Illuminate\Http\Request;
use Flash;
use Auth;
use Carbon\Carbon;
// use DateTime;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AccountController extends AppBaseController
{
    
    /** @var  AccountRepository */
    private $accountRepository;

    public function __construct(AccountRepository $accountRepo)
    {
        $this->accountRepository = $accountRepo;

    }

    /**
     * Display a listing of the Account.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->accountRepository->pushCriteria(new RequestCriteria($request));
        $accounts = $this->accountRepository->all();

        return view('accounts.index')
            ->with('accounts', $accounts);
    }

    /**
     * Receive account-ID, then check if logged in user is same as the owner of the account
     * update Apply_for_payout to 1 & paid to 0 field in accounts table, 
     * Create transaction on AccountHistory
     * redirect & show success message
    */
    public function apply_for_payout(Request $request)
    {
        $account = $this->accountRepository->findWithoutFail($request->input('apply_for_payout'));
        // dd($account);
        if (empty($account)) {
            Flash::error('Invalid Account');
            return redirect()->back();
        }

        if (Auth::user()->id !== $account->user_id) {
            Flash::error('You are not authorized to perform this operation.');
            return redirect()->back();
        }

        Account::whereId($account->id)->update([
            'applied_for_payout'=> 1,
            'paid' => 0,
            'last_date_applied' => Carbon::now()
        ]);

        $this->updateAccountHistory = AccountHistory::create([
            'account_id'=>$account->id,
            'user_id'=>$account->user_id,
            'message'=>'Payout request initiated by: '.Auth::user()->name]);

        Flash::success('Application Submission Successful.');
        return redirect()->back();
    }

    /**
     * Receive account-ID, then check if logged in user is same as the owner of the account
     * update Apply_for_payout to 0 & Paid to 1 field in accounts table, 
     * update AccountHistory
     * redirect & show success message
    */
    public function confirm_transfer(Request $request)
    {
        $account = $this->accountRepository->findWithoutFail($request->input('confirm_transfer'));
        if (empty($account)) {
            Flash::error('Invalid Account');
            return redirect()->back();
        }

        if (Auth::user()->id > 2) {
            Flash::error('You are not authorized to perform this operation.');
            return redirect()->back();
        }

        Account::whereId($account->id)->update([
            'applied_for_payout'=> 0,
            'paid' => 1,
            'last_date_paid' => new Carbon()
        ]);

        AccountHistory::create([
            'account_id'=>$account->id,
            'user_id'=> $account->user_id, 
            'message'=>'Payment Aprroved by Admin: '.Auth::user()->name .' (- ID: '. Auth::user()->id .')'
            ]);
            
            
        Flash::success('Payment request approved.');
        return redirect()->back();
    }

    /**
     * Show the form for creating a new Account.
     *
     * @return Response
     */
    public function create()
    {
        return view('accounts.create');
    }

    /**
     * Store a newly created Account in storage.
     *
     * @param CreateAccountRequest $request
     *
     * @return Response
     */
    public function store(CreateAccountRequest $request)
    {
        $input = $request->all();

        $account = $this->accountRepository->create($input);

        Flash::success('Account saved successfully.');

        return redirect(route('accounts.index'));
    }

    /**
     * Display the specified Account.
     *
     * @param  int $id
     *
     * @return Response
     */

    //  We make $id null so that it's not requested for compulsorily when the show route
    // is visited. Since me made it optional so that we can show account of the current logged in
    // user when and ID is not supplied via route
    public function show($id=null)
    {
        if (!isset($id)) {
            $account = Account::where('user_id', Auth::user()->id)->first();
        }else {
            $account = $this->accountRepository->findWithoutFail($id);
        }

        if (empty($account)) {
            Flash::error('Account not found');

            return redirect(route('accounts.index'));
        }

        $accountHistories = $account->account_histories;
        return view('accounts.show')
        ->with('account', $account)
        ->with('accountHistories', $accountHistories);
    }

    /**
     * Show the form for editing the specified Account.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $account = $this->accountRepository->findWithoutFail($id);

        if (empty($account)) {
            Flash::error('Account not found');

            return redirect(route('accounts.index'));
        }

        return view('accounts.edit')->with('account', $account);
    }

    /**
     * Update the specified Account in storage.
     *
     * @param  int              $id
     * @param UpdateAccountRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAccountRequest $request)
    {
        $account = $this->accountRepository->findWithoutFail($id);

        if (empty($account)) {
            Flash::error('Account not found');

            return redirect(route('accounts.index'));
        }

        $account = $this->accountRepository->update($request->all(), $id);

        Flash::success('Account updated successfully.');

        return redirect(route('accounts.index'));
    }

    /**
     * Remove the specified Account from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $account = $this->accountRepository->findWithoutFail($id);

        if (empty($account)) {
            Flash::error('Account not found');

            return redirect(route('accounts.index'));
        }

        $this->accountRepository->delete($id);

        Flash::success('Account deleted successfully.');

        return redirect(route('accounts.index'));
    }
}
