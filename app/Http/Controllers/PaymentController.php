<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Qrcode as QrcodeModel;
use App\Models\Transaction;
use Laracasts\Flash\Flash;
use Paystack;

class PaymentController extends Controller
{

    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway()
    {
        return Paystack::getAuthorizationUrl()->redirectNow();
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();

        // Check if a success fieldaback was NOT sent from Gateway
        if ($paymentDetails['data']['status'] != 'success') {
            Flash::error('Sorry, Payment failed!');
            return redirect()->route('qrcode.show', ['id'=>$paymentDetails['data']['metadata']['qrcode_id']]);
        }

        // Compare amount to be received to amount paid via paystack
        $qrode_id = $paymentDetails['data']['metadata']['qrcode_id'];
        $qrcode = QrcodeModel::find($qrode_id);
        if ($qrcode->amount != $paymentDetails['data']['amount']) {
            Flash::error('Sorry, you paid the wrong amount. Contact admininstrator.');
            return redirect()->route('qrcode.show', ['id'=>$paymentDetails['data']['metadata']['qrcode_id']]);
        }

        // Update transaction is everything goes well
        Transaction::whereId($paymentDetails['data']['metadata']['transaction_id'])->update([
            'status' => 'Completed'
            ]);


        //Update QRcode owner Account and AccountHistories

        // Updater Buyer Account and AccountHistories

        // @TODO Send email and SMS notification


        dd($paymentDetails);
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
    }
}