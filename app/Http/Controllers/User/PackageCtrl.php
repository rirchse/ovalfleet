<?php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SourceController;
use Auth;
use App\Package;
use App\Mypackage;
use App\Payment;
use Session;
use Mail;
use PDF;

class PackageCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function cancelled()
    {
        $user = Auth::user();
        $mypackage = Mypackage::where('user_id', $user->id)->orderBy('id', 'DESC')->where('status', 0)->first();
        $mypackage->delete();
        
        return view('users.read_payment_status')->withPaymentstatus('Payment Cancelled');
    }

    public function selectPackage()
    {
        $packages = Package::orderBy('package_price', 'ASC')->where('status', 1)->get();
        return view('users.create_select_package')->withPackages($packages);
    }

    public function index()
    {
        $user = Auth::user();
        $packages = Mypackage::leftJoin('packages', 'packages.id', 'mypackages.package_id')->orderBy('mypackages.id', 'DESC')->where('mypackages.user_id', $user->id)->select('mypackages.*', 'packages.package_name')->get();
        return view('users.view_mypackages')->withPackages($packages);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create($id)
    {
        $package = Package::find($id);

        // $expdate = date('Y-m-t');
        $expdate = date('Y-m-d', strtotime('+30 days'));
        // $actduration = number_format((strtotime($expdate) - strtotime(date('Y-m-d')))/24/3600);
        $actduration = 30;
        // $payable = $package->package_price/$package->duration*$actduration;
        $payable = $package->package_price;
        $getpackage = ['expdate' => $expdate, 'actduration' => $actduration, 'payable' => $payable];

        //create session
        Session::put('_package', $package);

        return view('users.create_get_package')->withPackage($package)->withGetpackage($getpackage);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'package_id' => 'required'
            ]);

        //find package
        $package   = Package::find($request->package_id);

        //find existing package
        $mypackage = Mypackage::where('user_id', $user->id)->where('package_id', $package->id)->orderBy('id', 'DESC')->first();

        //getpackage details calculation
        $expdate     = date('Y-m-t');
        $actduration = number_format((strtotime($expdate) - strtotime(date('Y-m-d')))/24/3600);
        $payable     = $package->package_price/$package->duration*$actduration;

        //get dynamic host
        $host = SourceController::host();

        // For test payments we want to enable the sandbox mode. If you want to put live
        // payments through then this setting needs changing to `false`.
        $enableSandbox = false;

        // PayPal settings. Change these to your account details and the relevant URLs
        // for your site.
        $paypalConfig = [
            'email'      => 'ovalfleet@gmail.com',
            'return_url' => $host.'/payment-successful',
            'cancel_url' => $host.'/payment-cancelled',
            'notify_url' => $host.'/payment'
        ];

        $paypalUrl = $enableSandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';

        // Product being purchased.
        $itemName   = $package->package_name;
        $itemAmount = $payable;

        // Check if paypal request or response
        if (!isset($request->txn_id) && !isset($request->txn_type)) {

            // Grab the post data so that we can set up the query string for PayPal.
            // Ideally we'd use a whitelist here to check nothing is being injected into
            // our post data.
            $data = [];
            foreach ($_POST as $key => $value) {
                $data[$key] = stripslashes($value);
            }

            // Set the PayPal account.
            $data['business'] = $paypalConfig['email'];

            // Set the PayPal return addresses.
            $data['return'] = stripslashes($paypalConfig['return_url']);
            $data['cancel_return'] = stripslashes($paypalConfig['cancel_url']);
            $data['notify_url'] = stripslashes($paypalConfig['notify_url']);

            // Set the details about the product being purchased, including the amount
            // and currency so that these aren't overridden by the form data.
            $data['item_name'] = $itemName;
            $data['amount'] = $itemAmount;
            $data['currency_code'] = 'USD';

            // Add any custom fields for the query string.
            $data['custom'] = $user->first_name.' '.$user->last_name;

            // Build the query string from the data.
            $queryString = http_build_query($data);

            // Redirect to paypal IPN
            header('location:' . $paypalUrl . '?' . $queryString);
            exit();

        } else {
            // Handle the PayPal response.
        }

        // Handle the PayPal response.

        // Assign posted variables to local data array.
        $data = [
            'item_name'        => $request->item_name,
            'item_number'      => $request->item_number,
            'payment_status'   => $request->payment_status,
            'payment_amount'   => $request->mc_gross,
            'payment_currency' => $request->mc_currency,
            'txn_id'           => $request->txn_id,
            'receiver_email'   => $request->receiver_email,
            'payer_email'      => $request->payer_email,
            'custom'           => $request->custom,
        ];

        // We need to verify the transaction comes from PayPal and check we've not
        // already processed the transaction before adding the payment to our
        // database.
        if (verifyTransaction($_POST) && checkTxnid($data['txn_id'])) {
            if (addPayment($data) !== false) {
                // Payment successfully added.
                //
        // dd($mypackage);

            if(!empty($mypackage)){

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
                $create->package_id       = $request->package_id;
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

            $payment = New Payment;
            $payment->user_id      = $user->id;
            $payment->mypackage_id = $mypackage->id;
            $payment->paid_amount  = $payable;
            $payment->extra_cost   = 0;
            $payment->valid_until  = $expdate;
            $payment->status       = 1;
            $payment->created_by   = $user->id;
            $payment->save();

            //
            $payment = Payment::leftJoin('mypackages', 'payments.mypackage_id', 'mypackages.id')->leftJoin('packages', 'packages.id', 'mypackages.package_id')->orderBy('payments.id', 'DESC')->where('payments.user_id', $user->id)->select('payments.*', 'packages.package_name')->first();

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
        } //payment confirm response
    }
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //............................. invoice ................................//
    public function invoiceIndex()
    {
        $user = Auth::user();
        $invoices = Payment::leftJoin('mypackages', 'mypackages.id', 'payments.mypackage_id')->leftJoin('packages', 'packages.id', 'mypackages.package_id')->select('payments.*', 'packages.package_name')->where('payments.user_id', $user->id)->orderBy('payments.id', 'DESC')->get();
        return view('users.view_invoices')->withInvoices($invoices);
    }

    public function invoiceShow($id)
    {
        $invoice = Payment::leftJoin('mypackages', 'mypackages.id', 'payments.mypackage_id')->leftJoin('users', 'users.id', 'mypackages.user_id')->leftJoin('packages', 'packages.id', 'mypackages.package_id')->select('payments.*', 'users.first_name', 'users.last_name', 'users.email','users.contact','users.organization', 'users.address', 'users.city', 'users.zip_code', 'users.country','users.vat_id', 'users.state', 'users.city','packages.package_name')->find($id);
        return view('users.read_invoice')->withInvoice($invoice);
    }

    //invoice pdf
    public function pdf($id)
    {
        $invoice = Payment::leftJoin('mypackages', 'mypackages.id', 'payments.mypackage_id')->leftJoin('users', 'users.id', 'mypackages.user_id')->leftJoin('packages', 'packages.id', 'mypackages.package_id')->select('payments.*', 'users.first_name', 'users.last_name', 'users.email','users.contact','users.organization', 'users.address', 'users.city', 'users.zip_code', 'users.country','users.vat_id', 'users.state', 'users.city','packages.package_name')->find($id);
        //create pdf
        $pdf = PDF::loadView('users.pdf_invoice', compact('invoice'));
        return $pdf->stream('invoice-'.$id.'.pdf');
        // return view('users.pdf_invoice')->withInvoice($invoice);
    }

    /*-------- Request for update from another controller -------*/

    public function CreatePackage($source)
    {
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

    public function UpdatePackage($source)
    {
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
    }
}