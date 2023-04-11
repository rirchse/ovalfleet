<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Package;
use App\Mypackage;
use App\Payment;

class SourceController extends Controller
{
    static function host()
    {
        $protocol = isset($_SERVER['HTTPS']) ? "https://" : "http://";
        return $protocol.$_SERVER['HTTP_HOST'];
    }

    static function accountExpire()
    {
        $user = Auth::user();
        /* account expire calculation */
        if($user->user_role == 'Fleet Owner'){
            $mypackage = Mypackage::where('user_id', $user->id)->orderBy('id', 'DESC')->first();
            if(!empty($mypackage)){
                $remaining = number_format((strtotime(date('Y-m-d')) - strtotime($mypackage->expires_on))/24/3600);
                if($mypackage->status != 1 || $remaining > 0){
                    return true;
                }
                return false;
            }
            return false;
        }
        return false;
    }

    /* create package */
    static function createMyPackage($user_id, $pakage_id)
    {
        $package = Package::find($package_id);
        $expdate = date('Y-m-d', strtotime("+1 ".$package->duration));

        //find existing package
        $mypackage = Mypackage::where('user_id', $user_id)->where('package_id', $package_id)->orderBy('id', 'DESC')->first();

        if(!empty($mypackage)){
            //package update
            $update = Mypackage::find($mypackage->id);
            $update->amount_payable   = $package->package_price;
            $update->actual_duration  = $package->duration;
            $update->expires_on       = $expdate;
            $update->renew_date       = date('Y-m-d');
            $update->payment_status   = 'Paid';
            $update->status           = 1;
            $update->updated_by       = $user_id;
            $update->save();

        } else {
            
            //pacakge create
            $create = New Mypackage;
            $create->user_id          = $user_id;
            $create->package_id       = $package_id;
            $create->package_price    = $package->package_price;
            $create->amount_payable   = $package->package_price;
            $create->previous_package = $mypackage?$mypackage->package_id:0;
            $create->actual_duration  = $package->duration;
            $create->expires_on       = $expdate;
            $create->buy_date         = date('Y-m-d');
            $create->payment_status   = 'Paid';
            $create->status           = 1;
            $create->created_by       = $user_id;
            $create->save();
        }

        $mypackage = Mypackage::where('user_id', $user->id)->orderBy('id', 'DESC')->first();

        $payment = New Payment;
        $payment->user_id      = $user_id;
        $payment->mypackage_id = $mypackage->id;
        $payment->paid_amount  = $package->package_price;
        $payment->extra_cost   = 0;
        $payment->valid_until  = $expdate;
        $payment->status       = 1;
        $payment->created_by   = $user_id;
        $payment->save();
    }

}