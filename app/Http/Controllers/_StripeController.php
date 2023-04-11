<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Package;
use Stripe\{Stripe, Subscription, Token, Customer, Charge, Error};

class StripeController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $this->middleware('auth');
    }

    public function subscription(Request $request, Package $package)
    {
        try{
            $package = Package::findOrFail($request->get('plan'));
            if($request->user()->subscribedToPlan($package->stripe_plan_id, $package->package_name)) {
                return redirect()->route('select_package')->with('success', 'You have already subscribed the plan');
            }
            
            $request->user()
                ->newSubscription($package->package_name, $package->stripe_plan_id)
                ->create($request->stripeToken);
            
            $user = $request->user();
            $user->current_billing_plan = $package->package_name;
            $user->save();
            return redirect()->route('select_package')->with('success', 'Your plan subscribed successfully');    
        }catch(\Exception $e){
            if($e->declineCode == 'insufficient_funds'){
                return redirect()->route('select_package')->with('error', 'Your card has been insufficient balance.');
            }
            if($e->declineCode == 'lost_card'){
                return redirect()->route('select_package')->with('error', 'The payment has been declined because the card is reported lost.');
            }
            if($e->declineCode == 'stolen_card'){
                return redirect()->route('select_package')->with('error', 'The payment has been declined because the card is reported stolen.');
            }
        }
    }

    public function unsubscription(Request $request, Package $package)
    {
        $package = Package::findOrFail($request->get('plan'));
        $user = $request->user();
        $user->current_billing_plan = null;
        $user->save();

        $subscriptionDB = \App\Subscription::where('user_id', $user->id)->where('stripe_plan', $package->stripe_plan_id)->first();
        $subscription = Subscription::retrieve($subscriptionDB->stripe_id);
        $subscription->cancel();
        $subscriptionDB->delete();

        return redirect()->route('select_package')->with('success', 'Your plan un-subscribed successfully');
    }
}
