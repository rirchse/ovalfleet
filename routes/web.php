<?php

Route::group(['middleware' => ['web']], function() {

	Route::get('/admin', function(){
		return redirect('/admin/login');
	});

	// view()->share('adm', 'cessna');
	Route::get('/send-contact', 'User\TicketCtrl@sendContact');

	//test
	Route::get('/create_session', function(){
		return view('users.msscript');
	});
	Route::get('/paypal_subscription', function(){
		return view('homes.paypal_subscription');
	});

	//------------------------------//
	Route::get('/create_paypal_plan', 'PaypalController@create_plan');
	Route::get('/subscribe/paypal', 'PaypalController@paypalRedirect')->name('paypal.redirect');
	Route::get('/subscribe/paypal/return', 'PaypalController@paypalReturn')->name('paypal.return');
	//------------------------------//

//web pages
	Route::get('/', 'HomeController@index');	
	Route::get('/signup', 'HomeController@create');
	Route::post('/signup', 'HomeController@store')->name('register.new.user');
	Route::get('/confirm_verification/{id}/{token}', 'HomeController@confirm_verification');
	Route::get('/complete_verification', 'HomeController@completeVerify');
	Route::post('/complete_verification', 'HomeController@verifyStore')->name('complete.verification');

	Route::get('/service_terms', 'HomeController@serviceTerms');
	Route::get('/faq', 'HomeController@faq');
	Route::get('/create_password_reset', 'HomeController@createPasswordReset');
	Route::post('/create_password_reset', 'HomeController@PasswordReset')->name('home.password.reset');

	Route::get('/create_new_password/{id}/{token}', 'HomeController@create_new_password');
	Route::post('/create_new_password', 'HomeController@updatePassword')->name('update.password');

	//test
	Route::get('/email_verification', 'HomeController@emailVerification');
	Route::get('/email_invite_test', 'HomeController@emailInviteTest');

	Route::get('/email_template', function(){
		return view('emails.email_template');
	});

	Route::get('/email_template_update', function(){
		return view('emails.user_email_verify-final');
	});

	Route::get('/all_graph', function(){
		return view('homes.all_graph');
	});

	Route::get('/google_map_direction', function(){
		return view('homes.google_map_direction');
	});

	Route::get('/google_map_location_search', function(){
		return view('homes.google_map_location_search');
	});

	//temp pdf streaming...
	Route::get('/pdf_stream', 'HomeController@pdfstream');

	/* CronJob: Daily Automated Check by Cronjob */
	Route::get('/daily_checkup', 'HomeController@dailyCheckup');

Auth::routes();
///////////////--Admin--///////////////////
	Route::prefix('admin')->group(function() {
		
		//login to user panel by admin
		Route::get('/admin_loginto', 'HomeController@adminLoginTo');
	
		Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
		Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login');
		Route::get('/', 'Admin\AdminHomeController@index')->name('admin.dashboard');
		Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

		Route::get('/change_my_password', 'Admin\AdminsController@changePassword');
		Route::put('/change_my_password', 'Admin\AdminsController@updatePassword')->name('admin.password_change.admin');
		
		Route::resource('/account', 'Admin\AdminsController');

		Route::get('/show_admins', 'Admin\AdminsController@index');
		Route::get('/admin/{id}/edit', 'Admin\AdminsController@edit');
		Route::put('/admin/{id}', 'Admin\AdminsController@update')->name('admin.update.admin');
		Route::delete('/admin/{id}', 'Admin\AdminsController@destroy')->name('admin.delete.admin');

		Route::get('/create_new_admin', 'Admin\AdminsController@create');
		Route::post('/create_new_admin', 'Admin\AdminsController@store')->name('create.new.admin');

		// admin auth user profile
		Route::get('/profile', 'Admin\ProfileController@edit');
		Route::put('/profile', 'Admin\ProfileController@update')->name('admin.profile.update');

		Route::get('/view_users/{types}', 'Admin\UsersController@index');
		Route::get('/user/{id}/details', 'Admin\UsersController@show');
		Route::get('/user/{id}/edit', 'Admin\UsersController@edit');
		Route::put('/user/{id}', 'Admin\UsersController@update')->name('update.user.account');
		Route::delete('/user/{id}', 'Admin\UsersController@destroy')->name('admin.user.delete');
		Route::get('/user/{id}/delete', 'Admin\UsersController@delete');
		Route::get('/user/{id}/restore', 'Admin\UsersController@restore');
		Route::get('/user/{email}/{token}/login', 'Admin\UsersController@userLogin');
		Route::get('/resend_email_verification/{id}', 'Admin\UsersController@reverify');

		Route::get('/user/{id}/delete_permanently', 'Admin\UsersController@permDelUser');

		Route::get('/loginto/{id}', 'Admin\UsersController@login');

		/* user subscription */
		Route::get('/user/{id}/subscribe', 'Admin\UsersController@subscribe');
		Route::post('/user/subscribe', 'Admin\UsersController@subscribeStore')->name('user_subscribe.store');

		//////////////////- Other Routes form here -///////////////////

		//vehicle
		Route::get('/create_vehicle', 'Admin\VehicleController@create');
		Route::post('/create_vehicle', 'Admin\VehicleController@store')->name('create.vehicle');
		Route::get('/view_vehicles', 'Admin\VehicleController@index');
		Route::get('/view_vehicles_archive', 'Admin\VehicleController@archive');
		Route::get('/vehicle/{id}/edit', 'Admin\VehicleController@edit');
		Route::put('/vehicle/{id}', 'Admin\VehicleController@update')->name('admin.update.vehicle');
		Route::get('/vehicle/{id}/details', 'Admin\VehicleController@show');
		Route::get('/vehicle/{id}/delete', 'Admin\VehicleController@delete');
		Route::get('/vehicle_archive/{id}/return', 'Admin\VehicleController@returnToActive');
		Route::get('/vehicle/{id}/print', 'Admin\VehicleController@printVehicle');

		//shipments
		Route::get('/view_shipments', 'Admin\ShipmentController@index');

		//referrals
		Route::get('/referral/{id}/details', 'Admin\ReferralCtrl@show');
		Route::get('/view_referrals', 'Admin\ReferralCtrl@index');
		Route::get('/view_pending_referrals', 'Admin\ReferralCtrl@indexPending');
		Route::get('/pending_referral/{id}/details', 'Admin\ReferralCtrl@showPending');
		Route::get('/resend_invitation/{id}', 'Admin\ReferralCtrl@resendInvitation');

		/* Routes for package */
		Route::resource('/package', 'Admin\PackageCtrl');
		Route::put('/package/{id}', 'Admin\PackageCtrl@update')->name('admin.update.package');
		Route::get('/view_user_packages/{id}', 'Admin\PackageCtrl@userSubscriptions');
		Route::get('/view_services/{type}', 'Admin\PackageCtrl@serviceIndex');
		Route::get('/package/{id}/disable', 'Admin\PackageCtrl@disable');
		Route::get('/package/{id}/restore', 'Admin\PackageCtrl@restore');

		//reports
		Route::get('/shipment_reports', 'Admin\ShipmentController@reports');
		Route::post('/shipment_reports', 'Admin\ShipmentController@reportPost')->name('admin.reports.shipment');
		Route::get('/vehicle_reports', 'Admin\VehicleController@reports');
		Route::get('/driver_reports', 'Admin\UsersController@driverReports');
		Route::get('/dispatcher_reports', 'Admin\UsersController@dispatcherReports');
		Route::get('/financial_reports', 'Admin\ShipmentController@financialReports');
		Route::post('/financial_reports', 'Admin\ShipmentController@financeReportPost')->name('admin.reports.finance');

		//ticketing system
		Route::resource('ticket', 'Admin\TicketCtrl');
		Route::get('/view_opened_tickets', 'Admin\TicketCtrl@opened');
		Route::put('/ticket/{id}/provide', 'Admin\TicketCtrl@provide')->name('ticket.provide');
		Route::get('/ticket/{id}/close', 'Admin\TicketCtrl@close')->name('ticket.close');
		Route::post('/ticket/reply/{id}', 'Admin\TicketCtrl@reply')->name('admin.ticket.reply');

		//Notification Routes
		Route::resource('/notification', 'Admin\NotificationCtrl');

		//subscription approved
		Route::get('/subscribe/{id}/approve', 'Admin\SubscriptionCtrl@subscribeApprove');
		Route::get('/subscribe/{id}/cancel', 'Admin\SubscriptionCtrl@subscribeCancel');

	});



	/*------------------ User's Routes Start from here -----------------*/

	Route::get('/all_users', 'Admin\UsersController@index');
	Route::put('/permit_as_admin/{id}', 'Admin\UsersController@permitAdmin')->name('admin.permit.admin');

	//user login functionality	
	Route::get('/home', 'User\HomeController@index');
	Route::get('/login', 'Auth\UserLoginController@getLogin');
	Route::post('/login', 'Auth\UserLoginController@login')->name('user.login');
	Route::get('/logout', 'Auth\UserLoginController@logout')->name('user.logout');

	//user profile
	Route::get('/profile/edit', 'User\ProfileController@show');
	Route::get('/profile/edit', 'User\ProfileController@edit');
	Route::put('/profile/edit', 'User\ProfileController@update')->name('profile.update');

	Route::get('/change_my_password', 'User\ProfileController@changePassword');
	Route::put('/change_my_password', 'User\ProfileController@updatePassword')->name('user.password_change');

	//route for driver account
	Route::get('/create_user_account', 'User\UserController@create');
	Route::post('/create_user_account', 'User\UserController@store')->name('create.user.account');
	Route::get('/view_user_accounts', 'User\UserController@index');
	Route::get('/driver/{id}/edit', 'User\UserController@edit');
	Route::put('/driver/{id}', 'User\UserController@update')->name('update.driver.account');
	Route::get('/driver/{id}/delete', 'User\UserController@destroy')->name('delete.driver.account');
	Route::get('/driver_reports', 'User\UserController@driverReports');
	Route::get('/dispatcher_reports', 'User\UserController@dispatcherReports');


	//route for dispatch

	//User related users
	Route::get('/create_user', 'User\UserController@create');
	Route::get('/user/{id}/details', 'User\UserController@show');
	Route::get('/view_relation_users', 'User\UserController@relationUsers');

	//referrals
	Route::get('/create_invitation', 'User\ReferralCtrl@create');
	Route::post('/create_invitation', 'User\ReferralCtrl@store')->name('create.invitation');
	Route::get('/create_referral/{id}', 'HomeController@createReferral');
	Route::get('/my_referrals', 'User\ReferralCtrl@index');
	Route::get('/referral/{id}/details', 'User\ReferralCtrl@show');
	Route::get('/view_referrals', 'User\ReferralCtrl@Referrals');
	Route::get('/view_pending_referrals', 'User\ReferralCtrl@indexPending');
	Route::get('/pending_referral/{id}/details', 'User\ReferralCtrl@showPending');
	Route::get('/resend_invitation/{id}', 'User\ReferralCtrl@resendInvitation');


	//User Creation: Driver, Shipper, Dispatcher
	Route::get('/create_user/{usertype}', 'User\UserController@createUser');
	Route::get('/create_user/{usertype}/{section}', 'User\UserController@createUserShipment');
	Route::get('/create_vehicle/{section}', 'User\VehicleController@createVehicleShipment');

	//shipments
	Route::get('/create_shipment', 'User\ShipmentController@create');
	Route::post('/create_shipment', 'User\ShipmentController@store')->name('create.shipment');
	Route::get('/view_shipments', 'User\ShipmentController@index');
	Route::get('/shipment/{id}/details', 'User\ShipmentController@show');
	Route::get('/shipment/{id}/edit', 'User\ShipmentController@edit');
	Route::put('/shipment/{id}', 'User\ShipmentController@update')->name('update.shipment');
	Route::get('/shipment/{id}/print', 'User\ShipmentController@printShipment');
	Route::put('/shipment_confirm/{id}', 'User\ShipmentController@changeStatus')->name('shipment.confirm');
	Route::get('/shipment/{id}/complete', 'User\ShipmentController@complete');
	Route::get('/shipment/{id}/pdf', 'User\ShipmentController@pdf');
	Route::get('/shipment/{id}/show_pdf', 'User\ShipmentController@showPdf');

	//shipment update by driver
	Route::get('/shipment/driver/{id}/edit', 'User\ShipmentController@editShipmentDriver');
	Route::get('/shipment/driver/{id}/details', 'User\ShipmentController@detailsShipmentDriver');
	Route::put('/shipment/driver/{id}', 'User\ShipmentController@updateShipmentDriver')->name('update.shipment.driver');
	Route::get('/shipment/{id}/delete', 'User\ShipmentController@delete');
	
	//shipment expense: under ShipmentExpenseCtrl Controller
	Route::get('/create_shipment/{id}/expense', 'User\ShipmentExpenseCtrl@create');
	Route::post('/create_shipment/expense', 'User\ShipmentExpenseCtrl@store')->name('create.shipment.expense');
	Route::get('/view_shipment/{id}/expenses', 'User\ShipmentExpenseCtrl@index');
	Route::get('/shipment/{id}/expense/{expid}/details', 'User\ShipmentExpenseCtrl@show');
	Route::get('/shipment/{id}/expense/{expid}/edit', 'User\ShipmentExpenseCtrl@edit');
	Route::put('/shipment/expense/{id}', 'User\ShipmentExpenseCtrl@update')->name('update.shipment.expense');
	Route::get('/shipment/{id}/expense/{expid}/delete', 'User\ShipmentExpenseCtrl@delete');
	//shipment reports
	Route::get('/shipment_reports', 'User\ShipmentController@reports');
	Route::post('/shipment_reports', 'User\ShipmentController@reportPost')->name('reports.shipment');
	Route::get('/shipments_status/{status}', 'User\ShipmentController@byStatus');


	//vehicle
	Route::get('/create_vehicle', 'User\VehicleController@create');
	Route::post('/create_vehicle', 'User\VehicleController@store')->name('create.vehicle');
	Route::get('/view_vehicles', 'User\VehicleController@index');
	Route::get('/view_vehicles_archive', 'User\VehicleController@archive');
	Route::get('/vehicle/{id}/edit', 'User\VehicleController@edit');
	Route::get('/vehicle/{id}/details', 'User\VehicleController@show');
	Route::put('/vehicle/{id}', 'User\VehicleController@update')->name('update.vehicle');
	Route::get('/vehicle/{id}/delete', 'User\VehicleController@delete');
	Route::get('/vehicle_archive/{id}/return', 'User\VehicleController@returnToActive');
	Route::get('/vehicle/{id}/print', 'User\VehicleController@printVehicle');
	Route::get('/view_listof_vehicles', 'User\VehicleController@listofVehicles');
	Route::get('/vehicle/{id}/pdf', 'User\VehicleController@pdf');
	Route::get('/vehicle_reports', 'User\VehicleController@reports');

	//Relations: user add to account
	Route::get('/user/{usertype}/{id}/add', 'User\UserController@userAddToAccount');

	//this route for dispatchers
	Route::get('/view_listof/{usertype}', 'User\RelationCtrl@listofUsers');

	//Route for create relation to the users
	Route::get('/my/{usertype}', 'User\UserController@connectedUsers');
	Route::get('/my/{usertype}/{id}/details', 'User\UserController@connectedUsersShow');
	Route::get('/my/{usertype}/{id}/remove', 'User\UserController@connectedUserRemove');

	//find users
	Route::get('/search/{usertype}', 'User\UserController@findUser');
	Route::get('/search/{usertype}/{for}', 'User\UserController@findUserFor');
	Route::post('/search', 'User\UserController@find_user')->name('search.user.account');
	Route::get('/search/{usertype}/{id}/details', 'User\UserController@user_search_result');

	//associated with the fleet owner
	Route::get('/view_associated_vehicles/{id}', 'User\VehicleController@assocVehicles');
	Route::get('/vehicle/associated/{id}/details', 'User\VehicleController@readAssocVehicle');
	Route::get('/view_associated/{id}/{usertype}', 'User\UserController@assocUsers');
	Route::get('/view_associated_shippers/{id}/{usertype}', 'User\UserController@assocShippers');
	Route::get('/associated/{usertype}/{user_id}/details', 'User\UserController@readAssocUser');

	Route::get('/view_associated_shipments/{id}', 'User\ShipmentController@assocShipments');
	Route::get('/shipment/{id}/associated/details', 'User\ShipmentController@readAssocShipment');

	Route::get('/my/{usertype}/{id}/resend_email_verification', 'User\UserController@resendEmailVerify');

	/* Package selection and billing system */
	Route::get('/select_package', 'User\PackageCtrl@selectPackage')->name('select_package');
	Route::get('/get_package/{id}', 'User\PackageCtrl@create')->name('get_package_details');
	Route::post('/payment', 'User\PackageCtrl@store')->name('create.payment');
	Route::get('/my_packages', 'User\PackageCtrl@index');

	//invoice
	Route::get('/view_invoices', 'User\PackageCtrl@invoiceIndex');
	Route::get('/invoice/{id}/details', 'User\PackageCtrl@invoiceShow');
	Route::get('/invoice/{id}/pdf', 'User\PackageCtrl@pdf');

	//financial reports
	Route::get('/financial_reports', 'User\ShipmentController@financialReports');
	Route::post('/financial_reports', 'User\ShipmentController@financeReportPost')->name('reports.finance');
	Route::get('/financial_details', 'User\ShipmentController@financialDetails');


	Route::get('/payment-successful', function(){
		return view('users.read_payment_status')->withPaymentstatus('Payment Successful');
	});
	Route::get('/payment-cancelled', 'User\PackageCtrl@cancelled');

	Route::get('/view_notifications', 'User\NotificationCtrl@index');
	Route::get('/notification/{id}/details', 'User\NotificationCtrl@show');
	Route::get('/create_contact', 'User\HomeController@support');
	Route::post('/create_contact', 'User\HomeController@supportStore')->name('create.contact');

	//paypal payment gateway routes
	Route::get('paywithpaypal', array('as' => 'addmoney.paywithpaypal','uses' => 'AddMoneyController@payWithPaypal',));
	Route::post('paypal', array('as' => 'addmoney.paypal','uses' => 'AddMoneyController@postPaymentWithpaypal',));
	Route::get('paypal', array('as' => 'payment.status','uses' => 'AddMoneyController@getPaymentStatus',));

	/* paypal subscription routes */
	Route::get('paypal/createPlan/{pkgid}', array('as' => 'subscription.createPlan','uses' => 'AddMoneyController@createPlan'));
	Route::get('paypal/listPlan', array('as' => 'subscription.listPlan','uses' => 'AddMoneyController@listPlan'));
	Route::get('paypal/getPlan/{id}', array('as' => 'subscription.getPlan','uses' => 'AddMoneyController@getPlan'));
	Route::get('paypal/activatePlan/{id}', array('as' => 'subscription.activatePlan','uses' => 'AddMoneyController@activatePlan'));
	Route::get('/paypal/showPlan/{id}', 'AddMoneyController@showPlan');

	Route::post('paypal/createAgreement/{id}', array('as' => 'subscription.createAgreement','uses' => 'AddMoneyController@createAgreement'));
	Route::get('paypal/executeAgreement/{status}', array('as' => 'subscription.executeAgreement','uses' => 'AddMoneyController@executeAgreement'));
	Route::post('paypal/suspendAgreement/{id}', array('as' => 'subscription.suspendAgreement','uses' => 'AddMoneyController@suspendAgreement'));
	
	//ticket controller
	Route::resource('ticket', 'User\TicketCtrl');
	Route::put('/ticket/{id}/feedback', 'User\TicketCtrl@feedback')->name('ticket.feedback');
	Route::post('/ticket/reply/{id}', 'User\TicketCtrl@reply')->name('ticket.reply');
	Route::get('/ticket/{id}/feedback/{fb}', 'User\TicketCtrl@feedback');


	Route::get('/calendar', 'User\HomeController@calendar');

	//Notification Controller
	Route::resource('/notification', 'User\NotificationCtrl');

	//test
	Route::get('/text-editor', function(){
		return view('users.text-editor');
	});

	// stripe routes
	Route::post('/subscription', 'StripeController@subscription')->name('subscription.create');
	Route::post('/unsubscription', 'StripeController@unsubscription')->name('unsubscription');

	Route::post('stripe/webhook', 'StripeWebhookController@handleWebhook');

	//yearly subscription by user
	Route::get('/subscription-yearly/{id}', 'User\MyPackageCtrl@yearlySubscription');

	// ACH payment routes
	Route::get('bank_payment/{id}', 'StripeController@bankPayment')->name('bankPayment');
	Route::post('ach_payment', 'StripeController@achPayment')->name('ach.payment');
	
	Route::get('verify_account/{id}', 'StripeController@verifyBankView')->name('verify.account');
	Route::post('process_verify_account', 'StripeController@verify_bank_account')->name('process.verify.account');

});