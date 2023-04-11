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

class MyPackageCtrl extends Controller
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

        $expdate = date('Y-m-t');
        $actduration = number_format((strtotime($expdate) - strtotime(date('Y-m-d')))/24/3600);
        $payable = $package->package_price/$package->duration*$actduration;
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

        } else {
            
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

    //Yearly Subscription
    public function yearlySubscription($id)
    {
        $plan = Mypackage::where('package_id', $id)->where('user_id', Auth::id())->orderBy('id', 'DESC')->whereIn('status', [0,1])->first();
        if($plan){
            Session::flash('error', 'You already subscribed this plan.');
            return redirect('/get_package/'.$id);
        }
        $package = Package::find($id);
        //pacakge create
        $create = New Mypackage;
        $create->user_id          = Auth::id();
        $create->package_id       = $id;
        $create->package_price    = $package->package_price;
        $create->amount_payable   = $package->package_price;
        // $create->previous_package = $mypackage?$mypackage->package_id:0;
        $create->actual_duration  = 365;
        $create->expires_on       = date('Y-m-d', strtotime('+1 Year'));
        $create->buy_date         = date('Y-m-d');
        $create->payment_status   = 'Pending';
        $create->status           = 0;
        $create->created_by       = Auth::id();
        $create->save();

        Session::flash('success', 'Yearly Subscription successful.');
        return redirect('/get_package/'.$id);
    }
}