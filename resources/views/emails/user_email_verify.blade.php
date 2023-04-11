<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Email Verification | OvalFleet</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
</head>
<body style="background: #ddd;">
	<div class="wrapper" style="max-width:700px; margin:auto; font-family: sans-serif;">

		<!-- email header -->
		<div section="header" style="clear:both; padding:15px; background:#FFEDB6 url({{ $message->embed(asset('/img/angel-white-bg.png')) }}) no-repeat left bottom;">
			<div class="head" style="display: flow-root;">
				<img src="{{ $message->embed(asset('/img/logo.png')) }}" alt="Logo" style="width: 200px;">
				<p style="float: right; font-size: small;">Date: {{date('d M Y')}}</p>
			</div>
			<div name="banner" style="width:100%; display:table">
				<div name="banner-image" style="display:table-cell; float:left;width:100%;max-width:40%; vertical-align: baseline;">
					<img src="{{ $message->embed(asset('/img/lorry.png')) }}" style="width: 184px; margin-top: 80px;" alt="Lorry">	
				</div>
				<div name="banner-text" style="display:table-cell; float:left;width:100%;max-width:60%; margin-top: 32px; text-align:right">
					<p style="font-size: 28px;color: #191616;">Thank you for signing up.</p>
					<p style="font-size: 20px;">We're glad to have you as an OvalFleet Rewards Member.</p>
				</div>
			</div>
		</div>

		<!-- section: email text body -->
		<div section="body" style="background:#fff; padding: 20px 25px; margin-bottom:5px">
			<div style="overflow: hidden; padding:20px 30px">
				<div style="text-align:left; margin-left: 15px;font-family:sans-serif;color: #525252;">
					<h3>Subject: Email Verification.</h3>

					<p style="margin-bottom: 20px;font-size: 15px;">Hi {{$name}}, <br> Thank you for signing up.</p>

					<p style="line-height: 20px;font-size: 15px;">Please click on the button below to complete the verification process.</p>

					<p style="margin-bottom: 20px; font-size: 15px; color: #525252;">Please <a style="background-color: #00a1e6;color: white; padding: 7px 15px; text-decoration: none;display: inline-block;border-radius: 4px;" href="{{$host}}/confirm_verification/{{$user_id}}/{{$token}}">Click Here</a> to verify your email. </p>

					<em style="color:red; font-size: 15px;">This is a system generated email message, please do not respond to this email.</em>

					<p style="padding-bottom: 10px;font-size: 15px;">Thank you.<br>OvalFleet.com</p>
				</div>
			</div>
		</div>

		<!-- email footer -->

		<div style="padding-bottom: 30px; background: #fff; padding: 25px; display: inline-flex;">
			<img src="{{ $message->embed(asset('/img/msg-icon.png')) }}" alt="Message Icon" style="float: left; display: flex; width: 100px; padding: 20px;">
			<p style="font-size: 21px;">
			Invite Your Friends, Colleagues and Business Partners. Earn Referral Points and Get Rewards.</p>
		</div>

		<div style="background: #276df0; color: #fff;text-align: center;">
			<img src="{{ $message->embed(asset('/img/logo.png')) }}" alt="" style="width: 230px;padding: 22px;">
		</div>

		<div class="footer" style="color: #fff; clear:both; background: #000; width: 100%; display:table;">
			<div section="footer-left" style="display:table-cell; width: 60%; position:relative; padding:25px; line-height:25px">
				<a href="#" style="float: left; text-decoration: none; color:#fff;background: #000">FAQ</a> 
				<br>
				<a href="#" style="color:#fff; text-decoration: none;">Forgot password?</a><br>
				<a href="#" style="color:#fff; text-decoration: none;">Privacy</a> <br>
				<a href="#" style="color:#fff; text-decoration: none;">Terms</a>
			</div>
			<div section="footer-right" style="display:table-cell; width:100%;max-width: 40%; padding:25px">
				<strong style="font-size:16px">OvalFleet</strong>
			</div>
		</div>

	</div>
</body>
</html>