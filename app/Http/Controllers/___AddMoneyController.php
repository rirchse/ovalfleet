<?php
namespace App\Http\Controllers;

use App\Http\Controllers\SourceController;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;
use URL;
use Session;
use Redirect;
// use Input;

/** All Paypal Details class **/
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

use App\Package;
use App\Mypackage;
use App\Payments;
use Mail;
use Auth;

class AddMoneyController extends HomeController
{
    private $_api_context;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // parent::__construct();

        /** setup PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }



    /**
     * Show the application paywith paypalpage.
     *
     * @return \Illuminate\Http\Response
     */
    public function payWithPaypal()
    {
        return view('homes.paywithpaypal');
    }

    /**
     * Store a details of payment with paypal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postPaymentWithpaypal(Request $request)
    {
        $user = Auth::user();
        /* Package data query start */
        //find package
        // $package   = Package::find($request->package_id);
        $package   = Session::get('_package');
        //getpackage details calculation
        $expdate     = date('Y-m-t');
        $actduration = number_format((strtotime($expdate) - strtotime(date('Y-m-d')))/24/3600);
        // $payable     = $package->package_price/$package->duration*$actduration;
        $payable     = 5;

        /* package data query end */

        $total_description = $user->first_name.' '.$user->last_name.', Acct:'.$user->account_number.', '.$user->email.', '.$user->contact.', Plan:'.$package->package_name;

        /* paypal server connetivity */
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item_1 = new Item();

        $item_1->setName($total_description) /** item name **/
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($payable); /** unit price **/

        $item_list = new ItemList();
        $item_list->setItems(array($item_1));

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($payable);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription($package->package_name.' Service Plan');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('payment.status')) /** Specify return URL **/
            ->setCancelUrl(URL::route('payment.status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
            /** dd($payment->create($this->_api_context));exit; **/
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                Session::flash('error','Connection timeout');
                return redirect('/select_package');
                /** echo "Exception: " . $ex->getMessage() . PHP_EOL; **/
                /** $err_data = json_decode($ex->getData(), true); **/
                /** exit; **/
            } else {
                Session::flash('error','There has been a problem processing your request. Please submit a ticket to resolve the issue. Sorry for the inconvenience.');
                return redirect('/select_package');
                /** die('Some error occur, sorry for inconvenient'); **/
            }
        }

        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        /** add payment ID to session **/
        Session::flash('paypal_payment_id', $payment->getId());

        if(isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }

        Session::flash('error','There has been a problem processing your request. Please submit a ticket to resolve the issue. Sorry for the inconvenience.');
        return redirect('/select_package');
    }

    public function getPaymentStatus()
    {
        $user = Auth::user();
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');

        /*if payment id empty rediret*/
        if(empty($payment_id)){
            return redirect('/select_package');
        }
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            Session::flash('error','There has been a problem processing your request. Please submit a ticket to resolve the issue. Sorry for the inconvenience.');
            return redirect('/select_package');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        /** PaymentExecution object includes information necessary **/
        /** to execute a PayPal account payment. **/
        /** The payer_id is added to the request query parameters **/
        /** when the user is redirected from paypal back to your site **/
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
        /** dd($result);exit; /** DEBUG RESULT, remove it later **/
        if ($result->getState() == 'approved') { 

            /** it's all right **/
            /** Here Write your database logic like that insert record or value in database if you want **/
            $package   = Session::get('_package');

            //find existing package
            $mypackage = Mypackage::where('user_id', $user->id)->orderBy('id', 'DESC')->first();

            //getpackage details calculation
            $expdate     = date('Y-m-t');
            $actduration = number_format((strtotime($expdate) - strtotime(date('Y-m-d')))/24/3600);
            $payable     = $package->package_price/$package->duration*$actduration;

            //get dynamic host
            $host = SourceController::host();

            if(!empty($mypackage) && $mypackage->package_id == $package->id){

                //package update
                $update = Mypackage::find($mypackage->id);
                $update->amount_payable   = $payable;
                $update->actual_duration  = $actduration;
                $update->expires_on       = $expdate;
                $update->renew_date       = date('Y-m-d');
                $update->payment_status   = 'Paid';
                $update->status           = 1;
                $update->updated_by       = $user->id;
                $update->save();

            }else{
                
                //pacakge create
                $create = New Mypackage;
                $create->user_id          = $user->id;
                $create->package_id       = $package->id;
                $create->package_price    = $package->package_price;
                $create->amount_payable   = $payable;
                $create->previous_package = $mypackage?$mypackage->package_id:0;
                $create->actual_duration  = $actduration;
                $create->expires_on       = $expdate;
                $create->buy_date         = date('Y-m-d');
                $create->payment_status   = 'Paid';
                $create->status           = 1;
                $create->created_by       = $user->id;
                $create->save();
            }

            $mypackage = Mypackage::where('user_id', $user->id)->orderBy('id', 'DESC')->first();

            $payment = New Payments;
            $payment->user_id      = $user->id;
            $payment->mypackage_id = $mypackage->id;
            $payment->paid_amount  = $payable;
            $payment->extra_cost   = 0;
            $payment->valid_until  = $expdate;
            $payment->status       = 1;
            $payment->created_by   = $user->id;
            $payment->save();

            $payment = Payments::leftJoin('mypackages', 'payments.mypackage_id', 'mypackages.id')->leftJoin('packages', 'packages.id', 'mypackages.package_id')->orderBy('payments.id', 'DESC')->where('payments.user_id', $user->id)->select('payments.*', 'packages.package_name')->first();

            /* create data for email */
            $data = array(
                'name'       => $user->first_name.' '.$user->last_name,
                'company'    => $user->company,
                'address'    => $user->address.' '.$user->city.' '.$user->state.' '.$user->zip_code.' '.$user->country,
                'email'      => $user->email,
                'vat_id'     => $user->vat_id,
                'contact'    => $user->contact,
                'plan_name'  => $payment->package_name,
                'paid'       => $payment->paid_amount,
                'valid_until'=> $payment->valid_until,
                'invoice_id' => $payment->id,
                'created_on' => date('d M Y h:i', strtotime($payment->created_at)),
                'host'       => SourceController::host()
            );

            /* sent invoice */
            Mail::send('emails.send_invoice', $data, function($message) use ($data){
                $message->from('do_not_reply@ovalfleet.com');
                $message->to($data['email']);
                $message->subject('Invoice | OvalFleet');
            });

            /* database write and email sending end */

            Session::flash('success', 'Payment successfully completed. Thank you. An Invoice has been sent to your email.');
            return redirect('/my_packages');
        }

        Session::flash('error', 'Payment did not go through. There has been a problem processing your payment.');
        return redirect('/select_package');
    }
  }