<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>OvalFleet</title>
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
					<p style="font-size: 28px;color: #191616;">{{$contact_for}}</p>
					<p style="font-size: 20px;">We're glad to have you as an OvalFleet Rewards Member.</p>
				</div>
			</div>
		</div>

		<!-- section: email text body -->
		<div section="body" style="background:#fff; padding: 20px 25px; margin-bottom:5px">

			<div style="overflow: hidden; padding:20px 30px">
				<div style="text-align:left; margin-left: 15px;font-family:sans-serif;color: #525252;">