<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Package;
use App\Mypackage;
use Session;
use Stripe\{Stripe, Plan};

class PackageCtrl extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $this->middleware('auth:admin');
    }
    public function serviceIndex($type)
    {
        $status = [];
        if($type == 'active'){
            $status = [1];
        }elseif($type == 'inactive'){
            $status = [0];
        }elseif($type == 'all'){
            $status = [0,1,2,3,4,5];
        }

        $services = Mypackage::leftJoin('users', 'users.id', 'mypackages.user_id')
        ->leftJoin('packages', 'packages.id', 'mypackages.package_id')
        ->whereIn('mypackages.status', $status)
        ->groupBy('mypackages.user_id', 'users.first_name', 'users.last_name', 'users.account_number')
        ->orderBy('mypackages.id', 'DESC')
        ->select('mypackages.user_id', 'users.first_name', 'users.last_name', 'users.account_number')->paginate(20);

        return view('admins.view_services')->withServices($services)->withType($type);
    }

    public function userSubscriptions($id)
    {
        $services = Mypackage::leftJoin('packages', 'packages.id', 'mypackages.package_id')
        ->leftJoin('users', 'users.id', 'mypackages.user_id')
        ->orderBy('mypackages.id', 'DESC')
        ->where('mypackages.user_id', $id)->select('mypackages.*', 'packages.package_name', 'packages.package_price', 'users.first_name', 'users.last_name', 'users.account_number')->paginate(20);
        return view('admins.view_user_subscriptions')->withServices($services);
    }

    public function index()
    {
        $packages = Package::orderBy('id', 'DESC')->paginate(20);
        return view('admins.view_packages')->withPackages($packages);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admins.create_package');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $admin = Auth::guard('admin')->user(); //logged in user
        $this->validate($request, [
            'package_name'   => 'required|max:255',
            'package_price'  => 'required',
            'max_dispatcher' => 'required|numeric|min:1|max:100',
            'max_driver'     => 'required|numeric|min:1|max:100',
            'duration'       => 'required|max:255',
            'bg_color'       => 'max:255',
            'btn_color'      => 'max:255',
            'status'         => 'max:255',
            'details'        => 'max:9999'
        ]);

        $stripePlan = Plan::create(array(
            "amount"   => $request->package_price*100,
            "interval" => $request->duration, //day, week, month or year,[semiannual, quarter]
            "product"  => array(
                "name" => $request->package_name
            ),
            "currency" => "usd"
        ));

        $create = New Package;
        $create->package_name   = $request->package_name;
        $create->package_price  = $request->package_price;
        $create->stripe_plan_id = $stripePlan->id;
        $create->max_dispatcher = $request->max_dispatcher;
        $create->max_driver     = $request->max_driver;
        $create->duration       = $request->duration;
        $create->details        = $request->details;
        $create->bg_color       = $request->bg_color;
        $create->btn_color      = $request->btn_color;
        $create->status         = $request->status;
        $create->created_by     = $admin->id;
        $create->save();

        $pkgid = Package::orderBy('id', 'DESC')->first()->id;

        Session::flash('success', 'Package successfully created.');
        return redirect('/admin/package/'.$pkgid);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $package = Package::find($id);
        // dd(Plan::where('id', $package->stripe_plan_id)->get());
        return view('admins.read_package')->withPackage($package);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $package = Package::find($id);
        return view('admins.edit_package')->withPackage($package);
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
        $admin = Auth::guard('admin')->user(); //logged in user
        $this->validate($request, [
            'package_name'   => 'required|max:255',
            'package_price'  => 'required',
            'max_dispatcher' => 'required',
            'max_driver'     => 'required',
            'duration'       => 'max:255',
            'bg_color'       => 'max:255',
            'btn_color'      => 'max:255',
            'status'         => 'max:255',
            'details'        => 'max:9999'
        ]);

        $package = Package::find($id);

        // $stripePlan = Plan::update($package->stripe_plan_id, array(
        //     "nickname" => $request->package_name
        // ));

        $update = Package::find($id);
        $update->package_name   = $request->package_name;
        $update->slug           = $request->slug;
        $update->package_price  = $request->package_price;
        $update->max_dispatcher = $request->max_dispatcher;
        $update->max_driver     = $request->max_driver;
        $update->duration       = $request->duration;
        $update->details        = $request->details;
        $update->bg_color       = $request->bg_color;
        $update->btn_color      = $request->btn_color;
        $update->status         = $request->status?1:0;
        $update->updated_by     = $admin->id;
        $update->save();

        Session::flash('success', 'Package successfully updated.');
        return redirect('/admin/package/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $package = Package::find($id);
        $plan = Plan::retrieve(
            $package->stripe_plan_id
        );
        $plan->delete();
        $package->delete();

        Session::flash('success', 'Service Plan deleted!');
        return redirect('/admin/package');
    }

    public function disable($id)
    {
        $package = Package::find($id);
        $package->status = 2;
        $package->save();

        Session::flash('success', 'Service Plan successfully disabled!');
        return redirect('/admin/package');
    }

    public function restore($id)
    {
        $package = Package::find($id);
        $package->status = 1;
        $package->save();
        
        Session::flash('success', 'Service Plan successfully restored!');
        return redirect('/admin/package');
    }
}