<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Package;
use App\Mypackage;
use Mail;
use Session;
use Image;
use Auth;
use PDF;

class HomeController extends Controller
{
    public function dailyCheckup()
    {
        //mypackage checkup
        $mypackages = Mypackage::where('status', 1)->select('id', 'actual_duration', 'expires_on', 'status', 'user_id')->get();
        foreach($mypackages as $mypack)
        {
            $dateDiffer = number_format((strtotime($mypack->expires_on) - strtotime(date('Y-m-d')))/24/3600);
            // dd($dateDiffer <= 0);
            if($dateDiffer == 7 || $dateDiffer == 3 || $dateDiffer == 2 || $dateDiffer == 1)
            {
                $user = User::find($mypack->user_id);
                //sent email to the customer
                $data = array(
                    'id'        => $mypack->id,
                    'name'      => $user->first_name.' '.$user->last_name,
                    'expdate'   => $mypack->expires_on,
                    'email'     => $user->email,
                    'details'   => 'Your account will expire '.$mypack->expires_on,
                    'host'      => SourceController::host()
                );

                Mail::send('emails.account_expiration', $data, function($message) use ($data){
                    $message->from('do_not_reply@ovalfleet.com');
                    $message->to($data['email']);
                    $message->subject('Account Expiration || OvalFleet.com');
                });
            }
            elseif($dateDiffer <= 0)
            {
                $update = Mypackage::find($mypack->id);
                $update->payment_status = $mypack->payment_status == 'Free Trial'?'Free Trial':'Cancel';
                $update->status = 2;
                $update->save();
            }
        }

        return "Success: Action Completed.";
    }

    public function pdfstream()
    {
        $shipment = 'shipment test';
        $pdf = PDF::loadView('homes.pdf_stream', compact('shipment'));
        return $pdf->stream();
    }

    //user dashboard login by admin
    public function adminLoginTo()
    {
        if(!empty(Session::get('_admuser'))){
            $admuser = Session::get('_admuser');

            if(Auth::guard('admin')->check() == true){

                if(Auth::loginUsingId($admuser['userId'])){
                    Session::forget('_admuser');
                    return redirect('/home');
                }
            }
        }

        return redirect('admin/view_users/active');
    }

    //test
    public function emailVerification(){
        $name = 'Rojar Benedict';
        $host = SourceController::host();
        $email = 'admin@ovalfleet.com';
        return view('emails.password_reset')
        ->withName($name)
        ->withHost($host)
        ->withToken('$token')
        ->withEmail($email);
    }

    public function emailInviteTest()
    {
        $name = 'OvalFleet';
        $host = SourceController::host();
        $email = 'admin@ovalfleet.com';
        return view('emails.send_invitation')
        ->withName($name)
        ->withHost($host)
        ->withToken('$token')
        ->withAccount_type('$token')
        ->withDetails('$token')
        ->withUser_email('$token')
        ->withEmail($email);
    }


    public function createReferral($email){
        $user = User::where('email', $email)->first();
        if(!empty($user)){
            Session::put('referral', $user->id);
        }

        return redirect('/signup');
    }

    public function index()
    {
        return view('homes.index');
    }

    public function create()
    {
        return view('homes.register');
    }

    public function store(Request $request)
    {
        //validate the data
        $this->validate($request, array(
            'first_name'     => 'required|max:50',
            'middle_name'    => 'max:50',
            'last_name'      => 'Required|max:50',
            'email'          => 'required|max:50',
            'contact'        => 'required|max:18',
            'password'       => 'required|confirmed|min:8|max:32',
            'account_type'   => 'required|max:50',
            'driver_license' => 'max:50',
            'organization'   => 'max:100',
            'referral'       => 'max:999999',
            'g-recaptcha-response' => 'recaptcha'
        ));

        if($request->account_type == 'Fleet Owner'){
            $this->validate($request, ['vat_id' => 'required|max:50']);
        }

    // include('/banded_word_list.php');
    if(HomeController::wordcheck($request->first_name) || HomeController::wordcheck($request->last_name) || HomeController::wordcheck($request->email) || HomeController::wordcheck($request->organization)){
        Session::flash('error', 'Please do not use this/these word(s). -> <b> '.HomeController::wordcheck($request->first_name).' '.HomeController::wordcheck($request->last_name).' '.HomeController::wordcheck($request->email).' '.HomeController::wordcheck($request->organization).'</b>');
        return redirect('/signup');
    }

        //token generator
        $token = md5(rand(789, 3));
        //enduser checking
        $enduser = User::where('email', $request->email)->first();
        if(!empty($enduser)){
            //session flashing
            Session::flash('error', 'You already have an account. Please log into your account.');
            
            //return to the show page
            return redirect('/login');
        } else {
            //store in the database
            $user = new User();
            $user->first_name      = ucfirst(strtolower($request->first_name));
            $user->middle_name     = $request->middle_name;
            $user->last_name       = ucfirst(strtolower($request->last_name));
            $user->email           = $request->email;
            $user->contact         = $request->contact;
            $user->password        = bcrypt($request->password);
            $user->remember_token  = $token;
            $user->user_role       = $request->account_type;
            $user->driver_license  = bcrypt($request->driver_license);
            $user->organization    = $request->organization;
            $user->vat_id          = $request->vat_id;
            $user->referral        = $request->referral?$request->referral:0;
            $user->save();

            $lastuser = User::orderBy('id', 'DESC')->first();

            $data = array(
                'user_id' => $lastuser->id,
                'name'    => $lastuser->first_name.' '.$lastuser->last_name,
                'token'   => $token,
                'email'   => $lastuser->email,
                'details' => $request->message,
                'host'    => SourceController::host()
            );

            Mail::send('emails.user_email_verify', $data, function($message) use ($data){
                $message->from('do_not_reply@ovalfleet.com');
                $message->to($data['email']);
                $message->subject('Email Verification || OvalFleet.com');
            });

            if(Session::get('referral')){
                //forget session(referral)
                Session::forget('referral');
            }

            //session flashing
            Session::flash('success', 'Sign up successfully completed! Please check your email and complete the verification. You will receive information related to service launch updates, important notifications, new features and upcoming OvalFleet Events. <br>Please check your junk/spam folder if you have not received the email in your inbox.');
            
            //return to the show page
            return redirect('/');
        }
    }

    public function confirm_verification($id, $token){
        //
        $user = User::where('id', $id)->where('remember_token', $token)->first();
        if(empty($user)){
            
            Session::flash('error', 'Your account is already verified.');
            return redirect('/');
        }else{
            Session::put('__userID', $user->id);
            return redirect('/complete_verification');
        }
    }

    public function completeVerify()
    {
        $user = User::find(Session::get('__userID'));
        return view('homes.complete_verification')->withUser($user);
    }

    public function verifyStore(Request $request)
    {
        $user = User::find(Session::get('__userID'));

        $this->validate($request, [
            'address'  => 'required',
            'city'     => 'required',
            'state'    => 'required',
            'zip_code' => 'required',
            'country'  => 'required',
            'image'    => 'image|mimes:jpg,jpeg,png,bmp|max:2000',
            'g-recaptcha-response' => 'recaptcha'
            ]);

        //account number check and create
        $account_number = 1001111;
        $ext_acc_no = User::where('account_number', '!=', '')->orderBy('id', 'DESC')->first()->account_number;
        if(!empty($ext_acc_no) && $ext_acc_no >= 1001111){
            $acc_no = substr($ext_acc_no, 0, -3)+1;
            $account_number = $acc_no.rand(111, 999);
        }

        if(!empty($user) && $user->status == 0){
            $update = User::find($user->id);
            $update->account_number = $account_number;
            $update->address        = $request->input('address');
            $update->city           = $request->input('city');
            $update->state          = $request->input('state');
            $update->zip_code       = $request->input('zip_code');
            $update->country        = $request->input('country');
            $update->status         = 1;
            $update->verify_date    = date('Y-m-d');
            $update->remember_token = '';

            if($request->hasFile('image')){
                $image = $request->file('image');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $location = ('img/profile/' . $filename);
                Image::make($image)->resize(600, 600)->save($location);

                $update->image = $filename;
            }

            $update->save();

            if($user->user_role == 'Fleet Owner'){
                /*getpackage details calculation*/
                $package = Package::where('slug', 'Trial')->first();
                $expdate = date('Y-m-d', strtotime('+30 days'));
                $actduration = 30;

                /*create package for user*/
                $mypackage = New Mypackage;
                $mypackage->user_id          = $user->id;
                $mypackage->package_id       = $package?$package->id:0;
                $mypackage->package_price    = $package?$package->package_price:0;
                $mypackage->amount_payable   = 0;
                $mypackage->actual_duration  = $actduration;
                $mypackage->payment_status   = 'Free Trial';
                $mypackage->expires_on       = $expdate;
                $mypackage->buy_date         = date('Y-m-d');
                $mypackage->status           = 1;
                $mypackage->created_by       = $user->id;
                $mypackage->save();
            }

            /*Update users table*/
            // $user = User::find($user->id);
            // $user->current_billing_plan = $package->package_name;
            // $user->save();

            /*remove user id from session data*/
            Session::forget('__userID');

            Session::flash('success', 'Email verification successfully completed. Now you can log into your account.');
            return redirect('/login');
        } else {
            Session::flash('error', 'Getting error to verified.');
            return redirect('/');
        }
    }

    public function serviceTerms()
    {
        return view('homes.service_terms');
    }

    public function faq()
    {
        return view('homes.faq');
    }

    // method for password reset
    public function createPasswordReset()
    {
        return view('homes.create_password_reset');
    }
    
    public function PasswordReset(Request $request)
    {
        //validate the data
        $this->validate($request, array(
            'email' => 'required|max:50',
            'g-recaptcha-response' => 'recaptcha'
        ));

        $user = User::where('email', $request->email)->first();
        if(!empty($user) && $user->status != 1){
            Session::flash('error', 'Account has to be active in order for you to update your password.');
            return redirect('/create_password_reset');
        }
        if(empty($user)){
            //session flashing
            Session::flash('error', 'You do not have an account in the system. Please check your email or Sign Up.');
            
            //return to the show page
            return redirect('/create_password_reset');
        }else{
            $token = md5(rand(789, 3));
            $user = User::find($user->id);
            $user->remember_token  = $token;
            $user->save();

            $data = array(
                'user_id' => $user->id,
                'name'    => $user->first_name.' '.$user->last_name,
                'token'   => $token,
                'email'   => $user->email,
                'host'    => SourceController::host()
            );

            Mail::send('emails.password_reset', $data, function($message) use ($data){
                $message->from('do_not_reply@ovalfleet.com');
                $message->to($data['email']);
                $message->subject('Reset Password || OvalFleet.com');
            });

            //session flashing
            Session::flash('success', 'An email has been sent to your registered email! Please check your email to reset your password.');
            
            //return to the show page
            return redirect('/login');
        }
        
    }


    public function create_new_password($id, $token){
        $user = User::where('id', $id)->where('remember_token', $token)->first();
        // dd($user);
        if(empty($user)) {
            //session flashing
            Session::flash('error', 'This link has expired.');
            
            //return to the show page
            return redirect('/');
        }

        Session::put('user_id', $user->id);

        return view('homes.create_new_password');
    }

    public function updatePassword(Request $request)
    {
        //validate the data
        $this->validate($request, array(
            'password' => 'required|confirmed|min:8|max:32',
            'g-recaptcha-response' => 'recaptcha'
        ));

        $session_user = Session::get('user_id');
        $user = User::find($session_user);
        $user->password       = bcrypt($request->password);
        $user->remember_token = '';
        $user->save();

        Session::flash('success', 'Password reset successfully completed.');
        return redirect('/login');

    }


    public function wordcheck($words) {
    $dictionary = array("sexually", "bscene", "obscene", "sexy","nigga", "nigger", "bitch", "asshole", "nude", "stupid", "bastard", "redneck", "prick", "xxx","porn","choda", "chuda", "anal", "anus", "arse", "ass", "ballsack", "balls", "bastard", "bitch", "biatch", "bloody", "blowjob","blow job", "bollock", "bollok", "boner", "boob", "bugger", "bum", "butt", "buttplug", "clitoris", "cock", "coon", "crap", "cunt", "damn", "dick", "dildo", "dyke", "fag", "feck", "fellate", "fellatio", "felching", "fuck", "fudgepacker", "fudge", "packer", "flange", "Goddamn", "God damn", "hell", "homo", "jerk", "jizz", "knobend", "knob", "labia", "lmao", "lmfao", "muff", "nigger", "nigga", "omg", "penis", "piss", "poop", "prick", "pube", "pussy", "queer", "scrotum", "shit", "sh1t", "slut", "smegma", "spunk", "tit", "tosser", "turd", "twat", "vagina", "wank", "whore", "wtf","4r5e","5h1t","5hit","a55","anal","anus","ar5e","arrse","arse","ass","asses","assfucker","assfukka","asshole","assholes","asswhole","btch","b00bs","b17ch","b1tch","ballbag","balls","ballsack","bastard","beastial","beastiality","bellend","bestial","bestiality","bich","biatch","bitch","bitcher","bitchers","bitches","bitchin","bitching","bloody","blowjob","blowjobs","boiolas","bollock","bollok","boner","boob","boobs","booobs","boooobs","booooobs","booooooobs","breasts","buceta","bugger","bum","bunny fucker","butt","butthole","buttmuch","buttplug","c0ck","c0cksucker","carpet","muncher","cawk","chink","cipa","cl1t","clit","clitoris","clits","cnut","cock","cock","sucker","cockface","cockhead","cockmunch","cockmuncher","cocks","cocksuck","cocksucked","cocksucker","cocksucking","cocksucks","cocksuka","cocksukka","cok","cokmuncher","coksucka","coon","cox","crap","cum","cummer","cumming","cums","cumshot","cunilingus","cunillingus","cunnilingus","cunt","cuntlick","cuntlicker","cuntlicking","cunts","cyalis","cyberfuc","cyberfuck","cyberfucked","cyberfucker","cyberfuckers","cyberfucking","d1ck","damn","dick","dickhead","dildo","dildos","dink","dinks","dirsa","dlck","dog","doggin","dogging","donkeyribber","doosh","duche","dyke","ejaculate","ejaculated","ejaculates","ejaculating","ejaculatings","ejaculation","ejakulate","fuck","fucker","f4nny","fag","fagging","faggitt","faggot","faggs","fagot","fagots","fags","fanny","fannyflaps","fannyfucker","fanyy","fatass","fcuk","fcuker","fcuking","feck","fecker","felching","fellate","fellatio","fingerfuck","fingerfucked","fingerfucker","fingerfuckers","fingerfucking","fingerfucks","fistfuck","fistfucked","fistfucker","fistfuckers","fistfucking","fistfuckings","fistfucks","flange","fook","fooker","fucka","fucked","fucker","fuckers","fuckhead","fuckheads","fuckin","fucking","fuckings","fuckingshitmotherfucker","fuckme","fucks","fuckwhit","fuckwit","fudge packer","fudgepacker","fuk","fuker","fukker","fukkin","fuks","fukwhit","fukwit","fux","fux0r","gangbang","gangbanged","gangbangs","gaylord","gaysex","goatse","God","damned","goddamn","goddamned","hardcoresex","hell","heshe","hoar","hoare","hoer","homo","hore","horniest","horny","hotsex","jack-off","jackoff","jap","jerk-off","jism","jiz","jizm","jizz","kawk","knob","knobead","knobed","knobend","knobhead","knobjocky","knobjokey","kock","kondum","kondums","kum","kummer","kumming","kums","kunilingus","l3ich","l3itch","labia","lmfao","lust","lusting","m0f0","m0fo","m45terbate","ma5terb8","ma5terbate","masochist","master-bate","masterb8","masterbat","masterbat3","masterbate","masterbation","masterbations","masturbate","mo-fo","mof0","mofo","mothafuck","mothafucka","mothafuckas","mothafuckaz","mothafucked","mothafucker","mothafuckers","mothafuckin","mothafucking","mothafuckings","mothafucks","fucker","motherfuck","motherfucked","motherfucker","motherfuckers","motherfuckin","motherfucking","motherfuckings","motherfuckka","motherfucks","muff","mutha","muthafecker","muthafuckker","muther","mutherfucker","n1gga","n1gger","nazi","nigg3r","nigg4h","nigga","niggah","niggas","niggaz","nigger","niggers","nob","nobjokey","nobhead","nobjocky","nobjokey","numbnuts","nutsack","orgasim","orgasims","orgasm","orgasms","p0rn","pawn","pecker","penis","penisfucker","phonesex","phuck","phuk","phuked","phuking","phukked","phukking","phuks","phuq","pigfucker","pimpis","piss","pissed","pisser","pissers","pisses","pissflaps","pissin","pissing","pissoff","poop","porn","porno","pornography","pornos","prick","pricks","pron","pube","pusse","pussi","pussies","pussy","pussys","rectum","retard","rimjaw","rimming","shit","sob","sadist","schlong","screwing","scroat","scrote","scrotum","semen","sex","shit","sh1t","shag","shagger","shaggin","shagging","shemale","shit","shitdick","shite","shited","shitey","shitfuck","shitfull","shithead","shiting","shitings","shits","shitted","shitter","shitters","shitting","shittings","shitty","skank","slut","sluts","smegma","smut","snatch","bitch","spac","spunk","shit","t1tt1e5","t1tties","teets","teez","testical","testicle","tit","titfuck","tits","titt","tittie5","tittiefucker","titties","tittyfuck","tittywank","titwank","tosser","turd","tw4t","twat","twathead","twatty","twunt","twunter","v14gra","v1gra","vagina","viagra","vulva","w00se","wang","wank","wanker","wanky","whoar","whore","willies","willy","xrated","xxx");
        $dictionary = implode(' ', $dictionary);
        $symble = array('`', '~', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '[', ']', '{', '}', ':', ':', ',', '|', '-', '_', '=', '+', ';', '<', '>', '?', '\/', '/', '.');

        $input = strtolower($words);
        $input = str_replace($symble, '', $input);

        $pieces1 = str_word_count($dictionary, 1);
        $pieces2 = str_word_count($input, 1);
        $wordcheck = array_intersect(array_unique($pieces1), array_unique($pieces2));
        $wordcheck = implode(', ', $wordcheck);
        return $wordcheck;
    }
    

} //class