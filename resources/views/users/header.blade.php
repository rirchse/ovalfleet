<?php
$user = Auth::user();
?>
  <header class="main-header">
    <!-- Logo -->
    <a href="/home" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="/img/home/favicon.png" width="50"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="/img/home/logo.png" class="img-responsive"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">{{-- 4 --}}</span>
            </a>
            {{-- <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <!-- end message -->
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        AdminLTE Design Team
                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Developers
                        <small><i class="fa fa-clock-o"></i> Today</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Sales Department
                        <small><i class="fa fa-clock-o"></i> Yesterday</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Reviewers
                        <small><i class="fa fa-clock-o"></i> 2 days</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul> --}}
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <?php //$notifications = DB::table('notifications')->where('status', 0)->where('user_id', $user->id)->orderBy('id', 'DESC')->get(); ?>
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              {{-- <span class="label label-danger">{{count($notifications) > 0?count($notifications):''}}</span> --}}
              <span class="label label-danger alertCounter" id="alertCounter"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have <span class="alertCounter">0</span> notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu" id="Notifications">
                  {{-- <li>json data will show here...</li>
                  @foreach($notifications as $notification)
                  <li>
                    <a href="/notification/{{$notification->id}}/details">
                      <i class="fa fa-circle-o text-aqua"></i> {{$notification->title}}
                    </a>
                  </li>
                  @endforeach --}}
                </ul>
              </li>
              <li class="footer"><a href="/view_notifications">View all</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            {{-- <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a> --}}
            {{-- <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Create a nice theme
                        <small class="pull-right">40%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">40% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  end task item
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Some task I need to do
                        <small class="pull-right">60%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Make beautiful transitions
                        <small class="pull-right">80%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">80% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul> --}}
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="/img/{{$user->image?'profile/'.$user->image:'avatar.png'}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{$user?$user->first_name.' '.$user->last_name:''}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="/img/{{$user->image?'profile/'.$user->image:'avatar.png'}}" class="img-circle" alt="User Image">

                <p>
                  {{$user->first_name.' '.$user->last_name}}
                  <small>Member since {{date('M Y', strtotime($user->created_at))}}</small>
                </p>

              </li>
              <!-- Menu Body -->
              {{-- <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
              </li> --}}
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="/profile/edit" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="/logout" class="btn btn-default btn-flat" onclick="return confirm('Are you sure you want to Sign Out?')">Sign Out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          {{-- <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> --}}
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="/img/{{$user->image?'profile/'.$user->image:'avatar.png'}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info" style="text-align:right">
          <p>{{$user->first_name.' '.$user->last_name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> {{$user->user_role.' - '.$user->account_number}}</a><br>
          {{-- <span>Account No. {{$user->account_number}}</span> --}}
        </div>
      </div>
      <!-- search form -->
      {{-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
            </button>
          </span>
        </div>
      </form> --}}
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <br>
      <ul class="sidebar-menu" data-widget="tree">
        {{-- <li class="header">MAIN NAVIGATION</li> --}}
        <li class="">
          <a href="/home">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            {{-- <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span> --}}
          </a>
        </li>
        @if($user->user_role == 'Fleet Owner' || $user->user_role == 'Dispatcher')

        {{-- <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Users</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/create_user"><i class="fa fa-circle-o"></i> Create New User</a></li>
            <li><a href="/view_user_accounts"><i class="fa fa-circle-o"></i> View User Accounts</a></li>
          </ul>
        </li> --}}

        <li class="treeview">
          <a href="#">
            <i class="fa fa-truck"></i>
            <span>Vehicles</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @if($user->user_role == 'Fleet Owner')
            <li><a href="/create_vehicle"><i class="fa fa-truck"></i> Create Vehicle</a></li>
            <li><a href="/view_vehicles"><i class="fa fa-truck"></i> View Vehicles</a></li>
            <li><a href="/view_vehicles_archive"><i class="fa fa-truck"></i> Vehicles Archive</a></li>
            @else
            <li><a href="/view_vehicles"><i class="fa fa-truck"></i>List of Vehicles</a></li>
            @endif
          </ul>
        </li>
        @endif

        @if($user->user_role != 'Fleet Owner')

        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Fleet Owners</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @if($user->user_role != 'Fleet Owner' && $user->user_role != 'Dispatcher' && $user->user_role != 'Driver')
            <li><a href="/search/fleet owner"><i class="fa fa-search-plus"></i> Add to My Fleet Owners</a></li>
            @endif
            <li><a href="/my/fleet owners"><i class="fa fa-users"></i> My Fleet Owners</a></li>
          </ul>
        </li>
        @endif

        @if($user->user_role != 'Driver' && $user->user_role != 'Shipper')

        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Drivers</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @if($user->user_role == 'Fleet Owner')
            <li><a href="/create_user/driver"><i class="fa fa-plus"></i> Create Driver</a></li>
            <li><a href="/search/driver"><i class="fa fa-circle-o"></i> Add to My Drivers</a></li>
            <li><a href="/my/drivers"><i class="fa fa-circle-o"></i> My Drivers</a></li>
            @else
            <li><a href="/view_listof/driver"><i class="fa fa-circle-o"></i> List of Drivers</a></li>
            @endif
          </ul>
        </li>

        @endif

        @if($user->user_role != 'Dispatcher')
        @if($user->user_role == 'Fleet Owner')
    
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Dispatcher</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/create_user/dispatcher"><i class="fa fa-plus"></i> Create Dispatcher</a></li>
            <li><a href="/search/dispatcher"><i class="fa fa-search-plus"></i> Add to My Dispatchers</a></li>
            <li><a href="/my/dispatchers"><i class="fa fa-users"></i> My Dispatchers</a></li>
          </ul>
        </li>
        @endif
        @endif

        @if($user->user_role != 'Shipper' && $user->user_role != 'Driver')

        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Shippers</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @if($user->user_role == 'Fleet Owner')
            <li><a href="/create_user/shipper"><i class="fa fa-plus"></i> Create Shipper</a></li>
            <li><a href="/search/shipper"><i class="fa fa-search-plus"></i> Add to My Shippers</a></li>
            <li><a href="/my/shippers"><i class="fa fa-users"></i> My Shippers</a></li>
            @else
            <li><a href="/view_listof/shipper"><i class="fa fa-circle-o"></i> List of Shippers</a></li>
            @endif
          </ul>
        </li>

        @endif

        <li class="treeview">
          <a href="#">
            <i class="fa fa-truck"></i> <span>Shipment</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @if($user->user_role == 'Driver')
            {{-- <li><a href="/active/shipments/driver"><i class="fa fa-circle-o"></i>Active Shipments</a></li> --}}
            {{-- <li><a href="/completed/shipments/driver"><i class="fa fa-circle-o"></i>Completed Shipments</a></li> --}}
            @endif
            @if($user->user_role == 'Fleet Owner' || $user->user_role == 'Dispatcher')
            <li><a href="/create_shipment"><i class="fa fa-pencil"></i>Create Shipment</a></li>
            @endif
            <li><a href="/view_shipments"><i class="fa fa-circle-o"></i>View Shipments</a></li>
          </ul>
        </li>

        @if($user->user_role == 'Fleet Owner')

        <li class="treeview">
          <a href="#">
            <i class="fa fa-list"></i> <span>Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/shipment_reports"><i class="fa fa-circle-o"></i>Shipment Reports</a></li>
            <li><a href="/vehicle_reports"><i class="fa fa-circle-o"></i>Vehicle Reports</a></li>
            <li><a href="/driver_reports"><i class="fa fa-circle-o"></i>Driver Reports</a></li>
            <li><a href="/dispatcher_reports"><i class="fa fa-circle-o"></i>Dispatcher Reports</a></li>
            <li><a href="/financial_reports"><i class="fa fa-circle-o"></i>Financial Reports</a></li>
          </ul>
        </li>
        @endif

        <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i> <span>Referrals</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/create_invitation"><i class="fa fa-envelope"></i>Send Invitation</a></li>
            <li><a href="/my_referrals"><i class="fa fa-circle-o"></i>My Referrals</a></li>
            <li><a href="/view_pending_referrals"><i class="fa fa-circle-o"></i>Pending Referrals</a></li>
            {{-- <li><a href="#"><i class="fa fa-circle-o"></i>Referral Points</a></li> --}}
          </ul>
        </li>

        @if($user->user_role == 'Fleet Owner')
        <li class="treeview">
          <a href="#">
            <i class="fa fa-list"></i> <span>Billing & Services</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            {{-- <li><a href=""><i class="fa fa-circle-o"></i>Choose Service Plan</a></li> --}}
            <li><a href="/select_package"><i class="fa fa-circle-o"></i>View Services</a></li>
            <li><a href="/view_invoices"><i class="fa fa-circle-o"></i>View Invoices</a></li>
            <li><a href="/my_packages"><i class="fa fa-circle-o"></i>View Orders</a></li>
          </ul>
        </li>
        @endif

        <li class="treeview">
          <a href="#">
            <i class="fa fa-support"></i> <span>Support</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            {{-- <li><a href="/coming_soon"><i class="fa fa-circle-o"></i> View Tickets</a></li> --}}
            {{-- <li><a href="/create_contact"><i class="fa fa-circle-o"></i> Contact Support</a></li> --}}
            <li><a href="/ticket/create"><i class="fa fa-envelope"></i> Submit a Ticket</a></li>
            <li><a href="/ticket"><i class="fa fa-envelope-o"></i> View Tickets</a></li>
          </ul>
        </li>
    
        <li class="treeview">
          <a href="#">
            <i class="fa fa-gear"></i> <span>Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/profile/edit"><i class="fa fa-user"></i> My Profile</a></li>
            <li><a href="/change_my_password"><i class="fa fa-lock"></i> Change My Password</a></li>
          </ul>
        </li>
        {{-- <li><a href="/calendar"><i class="fa fa-calendar"></i> Calendar</a></li> --}}
        
        <!--
        <li>
          <a href="pages/calendar.html">
            <i class="fa fa-calendar"></i> <span>Calendar</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red">3</small>
              <small class="label pull-right bg-blue">17</small>
            </span>
          </a>
        </li>
        <li>
          <a href="pages/mailbox/mailbox.html">
            <i class="fa fa-envelope"></i> <span>Mailbox</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-yellow">12</small>
              <small class="label pull-right bg-green">16</small>
              <small class="label pull-right bg-red">5</small>
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-folder"></i> <span>Examples</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
            <li><a href="pages/examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
            <li><a href="pages/examples/login.html"><i class="fa fa-circle-o"></i> Login</a></li>
            <li><a href="pages/examples/register.html"><i class="fa fa-circle-o"></i> Register</a></li>
            <li><a href="pages/examples/lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
            <li><a href="pages/examples/404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
            <li><a href="pages/examples/500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
            <li><a href="pages/examples/blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
            <li><a href="pages/examples/pace.html"><i class="fa fa-circle-o"></i> Pace Page</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Multilevel</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Level One
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o"></i> Level Two
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
          </ul>
        </li>

        <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
        <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
    -->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <div class="alert-section" style="">
    <div class="clearfix"></div>
    @include('partials.messages')
    <!-- account expire calculation -->
    @if($user->user_role == 'Fleet Owner' && empty($user->subscription->name))
      <?php $mypackage = DB::table('mypackages')->where('user_id', $user->id)->orderBy('id', 'DESC')->first();?>

      @if(!empty($mypackage))
      <?php $remaining = number_format((strtotime($mypackage->expires_on) - strtotime(date('Y-m-d')))/24/3600); ?>

        @if($mypackage->payment_status == 'Pending' && $remaining > 0)
        <div class="alert alert-danger"> Your subscription payment is yet to clear.</div>

        @elseif($mypackage->payment_status != 'Paid' && $remaining > 0)
        <div class="alert alert-danger">You are on a Free Trial Service Plan. You have <strong>{{$remaining}}</strong> days remaining for Free Trial. <a href="/select_package">Choose a Service Plan.</a> To view details <a href="/my_packages">Click Here</a></div>

        @elseif($remaining == 0)
        <div class="alert alert-danger"> Your account is expiring today. <a href="/select_package">Choose a Service Plan</a> for uninterrupted service.</div>

        @elseif($mypackage->payment_status != 'Paid' && $remaining < 0)
          <div class="alert alert-danger">Your 30 day trial period has expired. You are free to continue using OvalFleet Services with a limited set of features. <br><a class="text-success" style="font-size:16px; color:#008" href="/select_package">Choose a Service Plan</a> to restore access for all your account features.</div>
        @elseif($mypackage->status != 1 || $remaining < 0)
          <div class="alert alert-danger">Your account has expired.<br><a class="text-success" style="font-size:16px; color:#008" href="/select_package">Choose a Service Plan</a> to restore access.</div>
        @endif
      @else
      <div class="alert alert-danger">You are on a Free Trial Service Plan. <a href="/select_package">Choose a Service Plan.</a> To view details <a href="/my_packages">Click Here</a></div>
      @endif
    @endif

    @if($user->user_role == 'Fleet Owner' && $user->requested_plan_id != '')
    <div class="alert alert-success">Two small deposits are made to your bank account. <a href="/verify_account/{{$user->requested_plan_id}}" class="text-warning text-bold"> Enter the amounts here </a> to finalize your subscription.</div>
    @endif

    <div class="clearfix"></div>
  </div>