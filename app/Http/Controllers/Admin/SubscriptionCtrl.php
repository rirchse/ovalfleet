<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Package;
use App\Mypackage;
use Session;

class SubscriptionCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function subscribeApprove($id)
    {
    	$plan = Mypackage::find($id);

    	$update = Mypackage::find($id);
    	$update->status         = 1;
    	$update->payment_status = 'Paid';
    	$update->expires_on     = date('Y-m-d', strtotime('+1 Year'));
    	$update->buy_date       = date('Y-m-d');
    	$update->save();

    	$user = User::find($plan->user_id);
    	$user->current_billing_plan = Package::find($plan->package_id)->package_name;
    	$user->save();

    	Session::flash('success', 'Subscription successfully updated.');
    	return redirect('/admin/view_services/all');
    }

    public function subscribeCancel($id)
    {
    	$plan = Mypackage::find($id);

    	$update = Mypackage::find($id);
    	$update->status         = 2;
    	$update->payment_status = 'Cancel';
    	$update->expires_on     = date('Y-m-d');
    	$update->save();

    	$user = User::find($plan->user_id);
    	$user->current_billing_plan = NULL;
    	$user->save();

    	Session::flash('success', 'Subscription successfully cancelled.');
    	return redirect('/admin/view_services/all');
    }
}

?>