<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Package;
use App\Mypackage;
use App\Payment;
use Stripe\{Stripe, Subscription, Token, Customer, Charge, Error, Exception};
use DB;
use Illuminate\Support\Facades\Validator;
use Mail;

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
            $notSubscribe = DB::table('subscriptions')->where('user_id', auth()->user()->id)->where('stripe_plan', $package->stripe_plan_id)->first();
            if($notSubscribe != null) {
                return redirect()->route('select_package')->with('success', 'You have already subscribed the plan');
            }

            $customer = Customer::create([
                'email' => $request->user_email,
                'source'  => $request->stripeToken
            ]);
            $subscription = Subscription::create([
                'customer' => $customer->id,
                'items' => [['plan' => $package->stripe_plan_id]],
            ]);

            if($subscription->status == 'active'){
                $subscriptionDB = new \App\Subscription();
                $subscriptionDB->user_id       = $request->user()->id;
                $subscriptionDB->package_id    = $package->id; /* Added by Rocky */
                $subscriptionDB->name          = $package->package_name;
                $subscriptionDB->stripe_id     = $subscription->id;
                $subscriptionDB->stripe_plan   = $package->stripe_plan_id;
                $subscriptionDB->quantity      = 1;
                $subscriptionDB->trial_ends_at = null;
                $subscriptionDB->ends_at       = null;
                $subscriptionDB->save();
                
                $user = $request->user();
                $user->stripe_id         = $customer->id;
                $user->account_last_four = $customer->sources->data[0]->last4;
                $user->payment_type      = 'CARD_PAYMENT';
                $user->save();

                /** Start Subscription Store(added by Rocky) **/
                $expdate = date('Y-m-d', strtotime("+1 ".$package->duration));

                //find existing package
                $mypackage = Mypackage::where('user_id', $request->user()->id)->where('package_id', $package->id)->orderBy('id', 'DESC')->first();

                if(!empty($mypackage)){
                    //package update
                    $update = Mypackage::find($mypackage->id);
                    $update->amount_payable   = $package->package_price;
                    $update->actual_duration  = $package->duration;
                    $update->expires_on       = $expdate;
                    $update->renew_date       = date('Y-m-d');
                    $update->payment_status   = 'Paid';
                    $update->status           = 1;
                    $update->updated_by       = $request->user()->id;
                    $update->save();

                } else {
                    
                    //pacakge create
                    $create = New Mypackage;
                    $create->user_id          = $request->user()->id;
                    $create->package_id       = $package->id;
                    $create->package_price    = $package->package_price;
                    $create->amount_payable   = $package->package_price;
                    $create->previous_package = $mypackage?$mypackage->package_id:0;
                    $create->actual_duration  = $package->duration;
                    $create->expires_on       = $expdate;
                    $create->buy_date         = date('Y-m-d');
                    $create->payment_status   = 'Paid';
                    $create->status           = 1;
                    $create->created_by       = $request->user()->id;
                    $create->save();
                }

                $mypackage = Mypackage::where('user_id', $request->user()->id)->orderBy('id', 'DESC')->first();

                $payment = New Payment;
                $payment->user_id      = $request->user()->id;
                $payment->mypackage_id = $mypackage->id;
                $payment->paid_amount  = $package->package_price;
                $payment->extra_cost   = 0;
                $payment->valid_until  = $expdate;
                $payment->status       = 1;
                $payment->created_by   = $request->user()->id;
                $payment->save();

                /* send email when complete the subscription */
                $user = $request->user();
                $data = array(
                    'name'         => $user->first_name.' '.$user->last_name,
                    'account_no'   => $user->account_number,
                    'duration'     => $package->duration,
                    'amount'       => $package->package_price,
                    'package_name' => $package->package_name,
                    'email'        => $user->email,
                    'contact_for'  => 'Subscription Payment Successful',
                    'host'         => SourceController::host()
                );

                Mail::send('emails.send_subscription_to_user', $data, function($message) use ($data){
                    $message->from('do_not_reply@ovalfleet.com');
                    $message->to($data['email']);
                    $message->subject('Subscription Payment Successful || OvalFleet.com');
                });
                /** End: subscription stored **/

                return redirect()->route('select_package')->with('success', 'Your plan subscribed successfully');    
            }else{
                return redirect()->route('select_package')->with('error', 'Subscription failed. Check your card balance or validity. If problem persists, please contact support team.');
            }            
        }catch(\Exception $e){
            $msg = json_decode($e->httpBody);
            return redirect()->route('select_package')->with('error', $msg->error->message);
        }
    }

    public function unsubscription(Request $request, Package $package)
    {
        $package = Package::findOrFail($request->get('plan'));
        $user    = $request->user();
        if($user->payment_type == 'CARD_PAYMENT'){
            $user->stripe_id    = null;
            $user->payment_type = null;
            $user->save();
        }else{
            $user->stripe_id         = null;
            $user->bank_account_id   = null;
            $user->payment_type      = null;
            $user->account_last_four = null;
            $user->save();
        }

        $subscriptionDB = \App\Subscription::where('user_id', $user->id)->where('stripe_plan', $package->stripe_plan_id)->first();
        $subscription = Subscription::retrieve($subscriptionDB->stripe_id);
        $subscription->cancel();
        $subscriptionDB->delete();
        
        /* change the subscription status(changed by rocky)*/
        $mypackage = Mypackage::where('user_id', $user->id)->where('package_id', $package->id)->orderBy('id', 'DESC')->first();
        $update = Mypackage::find($mypackage->id);
        $update->status = 3;
        $update->payment_status = 'Cancel';
        $update->save();
        /* subscription status changed end */

        return redirect()->route('select_package')->with('success', 'Your plan un-subscribed successfully');
    }

    public function bankPayment($id)
    {
        /* send bank account verify request */
        $user = \Auth::user();
        $package = Package::find($id);
        if($user->bank_account_id != null && $user->account_last_four != null){
            return redirect()->route('verify.account', $package->id)->with('success', 'Next Steps: Trial Deposits <br>To verify your ownership of the OvalFleet account, we use a simple security measure called Trial Deposits. You must successfully complete this one-time only process before you can make ACH subscription payment and begin using OvalFleet Platform.<br> Here\'s a quick overview of what you need to do:<br>
                1. We will make two small deposits (less than $1.00) to your bank account in 1-2 business days.<br>
                2. Enter the exact amounts of the two trial deposits after signing in to OvalFleet.com platform to verify your bank account and complete the subscription.<br>
                3. Sign on to OvalFleet.com and continue using the platform.<br>
                Please note that any small deposits sent to your bank account for verification purposes will be withdrawn from the bank account within 10 business days, and may be withdrawn in two separate withdrawals or into a single withdrawal amount.');
        }else{
            return view('users.ach_payment.bank_details')->withPackage($package);
        }
    }
    
    public function verifyBankView($id)
    {
        $package = Package::find($id);
        return view('users.ach_payment.payment')->withPackage($package);
    }
    
    public function achPayment(Request $request)
    {
        try {
            // validate form data
            $validator = Validator::make($request->all(), [
                'account_holder_name' => 'required',
                'account_holder_type' => 'required',
                'routing_number'      => 'required',
                'account_number'      => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }else{
                // if validation succeeded then process payment
                $package_id = $request->input('package_id');
                $bank_token = Token::create([
                    "bank_account" => [
                        "country"  => "US",
                        "currency" => "USD",
                        "account_holder_name" => $request->account_holder_name,
                        "account_holder_type" => $request->account_holder_type,
                        "routing_number" => $request->routing_number,
                        "account_number" => $request->account_number
                    ]
                ]);
                $b_token = $bank_token->toJson();
                $obj_token = json_decode($b_token, TRUE);
                $b_tok = $obj_token['id'];
                $bank_account_id = $obj_token['bank_account']['id'];
                
                $customer = Customer::create([
                    'email' => $request->user_email,
                    "source" => $b_tok,
                    "description" => $request->account_holder_name
                ]);
        
                // customer created now need to verify bank account
                if($customer){
                    $user = $request->user();
                    $user->stripe_id         = $customer->id;
                    $user->requested_plan_id = $package_id; //changed by rocky
                    $user->bank_account_id   = $bank_account_id;
                    $user->payment_type      = 'ACH_PAYMENT';
                    $user->account_last_four = $obj_token['bank_account']['last4'];
                    $user->save();

                    return redirect()->route('verify.account', $package_id)->with('success', 'Two small deposits will be credited to your bank account in 1-2 business days. <br>
                    <br>
                    Once you receive the two small deposits, please enter the amounts to verify your bank account. The small deposits will expire in 10 days. <br>
                    <br>
                    Please note that any small deposits sent to your bank account for verification purposes will be withdrawn from the bank account within 10 business days, and may be withdrawn in two separate withdrawals or combined into a single small withdrawal amount.');
                }else{
                    return redirect()->route('select_package')->with('error', 'Due to some reason we can\'t proceed your payment.');
                }
            }
        } catch(Error\Card $e) {
            return redirect()->route('select_package')->with('error', $e->getMessage());
        } catch (Error\RateLimit $e) {
            return redirect()->route('select_package')->with('error', $e->getMessage());
        } catch (Error\InvalidRequest $e) {
            return redirect()->route('select_package')->with('error', $e->getMessage());
        } catch (Error\Authentication $e) {
            return redirect()->route('select_package')->with('error', $e->getMessage());
        } catch (Error\ApiConnection $e) {
            return redirect()->route('select_package')->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->route('select_package')->with('error', $e->getMessage());
        }
    }
    
    public function verify_bank_account(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'amount1' => 'required|digits:2',
                'amount2' => 'required|digits:2',
            ],[
                'amount1.required' => "You must insert first micro-payment amount.",
                'amount2.required' => "You must insert second micro-payment amount.",
                'amount1.digits' => "Amount must be a number. Please enter interger value.",
                'amount2.digits' => "Amount must be a number. Please enter interger value.",
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }else{
                // if validatin succeeded then process payment
                $user = $request->user();
                $customer_id = $user->stripe_id;
                $bank_account_id = $user->bank_account_id;
    
                $package = Package::find($request->package_id);
                $bank_account = Customer::retrieveSource(
                    $customer_id,
                    $bank_account_id
                );
                
                // verify the account
                $bank_account->verify(['amounts' => [$request->amount1, $request->amount2]]);
    
                // charge amounut
                if($bank_account->status == 'verified'){
                    $subscription = Subscription::create([
                        'customer' => $customer_id,
                        'items' => [['plan' => $package->stripe_plan_id]],
                    ]);
                    if($subscription->status == 'active'){
                        $subscriptionDB = new \App\Subscription();
                        $subscriptionDB->user_id       = $request->user()->id;
                        $subscriptionDB->name          = $package->package_name;
                        $subscriptionDB->stripe_id     = $subscription->id;
                        $subscriptionDB->stripe_plan   = $package->stripe_plan_id;
                        $subscriptionDB->quantity      = 1;
                        $subscriptionDB->trial_ends_at = null;
                        $subscriptionDB->ends_at       = null;
                        $subscriptionDB->save();
                        
                        return redirect()->route('get_package_details', ['id' => $request->package_id])->with('success', 'Dear valued customer, <br>
                        <br>
                        We are pleased to confirm that your annual [enter the annual plan name] has been activated and your chosen payment method has been debited. <br>
                        You can view your annual plan details at any time. Simply login to your account and navigate to “View Orders”. <br>
                        Feel free to contact us if you have any questions or if we can help you further. <br>
                        As always, we appreciate you and your business. <br>
                        <br>
                        Thank you, <br>
                        Billing Department <br>
                        Phone: +1 (972) 294-3460 <br>
                        Customer Portal: https://www.ovalfleet.com/login');
                    }else{
                        $user = $request->user();
                        $user->stripe_id = null;
                        $user->bank_account_id = null;
                        $user->payment_type = null;
                        $user->account_last_four = null;
                        $user->save();
                        return redirect()->route('select_package')->with('error', 'Subscription failed. Check your account balance or validity. If problem persists, please contact support team.');
                    }
                }else{
                    $user = $request->user();
                    $user->stripe_id = null;
                    $user->bank_account_id = null;
                    $user->payment_type = null;
                    $user->account_last_four = null;
                    $user->save();
                    return redirect()->route('select_package')->with('error', 'Your account is not verified.');
                }
            }
        } catch (Exception\CardException $e) {
            $user = $request->user();
            $user->stripe_id = null;
            $user->bank_account_id = null;
            $user->payment_type = null;
            $user->account_last_four = null;
            $user->save();
            return redirect()->route('select_package')->with('error', $e->getMessage());
        } catch (Exception\InvalidRequestException $e) {
            return redirect()->route('select_package')->with('error', $e->getMessage());
        } catch(Error\Card $e) {
            $user = $request->user();
            $user->stripe_id = null;
            $user->bank_account_id = null;
            $user->payment_type = null;
            $user->account_last_four = null;
            $user->save();
            return redirect()->route('select_package')->with('error', 'Your account is not verified.');
        } catch (Error\RateLimit $e) {
            return redirect()->route('select_package')->with('error', $e->getMessage());
        } catch (Error\InvalidRequest $e) {
            return redirect()->route('select_package')->with('error', $e->getMessage());
        } catch (Error\Authentication $e) {
            return redirect()->route('select_package')->with('error', $e->getMessage());
        } catch (Error\ApiConnection $e) {
            return redirect()->route('select_package')->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->route('select_package')->with('error', $e->getMessage());
        }
    }
}
