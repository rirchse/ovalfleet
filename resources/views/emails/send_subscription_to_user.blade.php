@include('emails.email_header')

	<!-- section: email text body -->
	<div section="body" style="background:#fff; padding: 20px 25px; margin-bottom:5px">

		<div style="overflow: hidden; padding:20px 30px">
			<div style="text-align:left; margin-left: 15px;font-family:sans-serif;color: #525252;">
				<h3>Subject: Receipt for OvalFleet Account {{$account_no}}.</h3>

				<p style="margin-bottom: 20px;font-size: 15px;">Hi {{$name}}, <br> Your subscription with OvalFleet is successful. <br>For any query or assistance, feel free to contact support.</p>

				<table style="border-collapse: collapse; border:1px solid #ddd; padding:5px; font-size:16px">
					<tr>
						<td>Plan Name:</td>
						<td>{{$package_name}}</td>
					</tr>
					<tr>
						<td>Subscription:</td>
						<td style="text-align:left"> {{$duration.'ly'}}</td>
					</tr>
					<tr>
						<td>Subscription Amount:</td>
						<td>${{$amount}}</td>
					</tr>
				</table>

				<br>

				{{-- <p style="margin-bottom: 20px; font-size: 15px; color: #525252;">Please <a style="background-color: #00a1e6;color: white; padding: 7px 15px; text-decoration: none;display: inline-block;border-radius: 4px;" href="{{$host}}/create_referral/{{$id}}">Click Here</a> to join OvalFleet and connect with us.</p> --}}

				<em style="color:red; font-size: 15px;">This is a system generated email message, please do not respond to this email.</em>

				<p style="padding-bottom: 10px;font-size: 15px;">Thank you.<br>OvalFleet.com</p>
			</div>
		</div>
	</div>

@include('emails.email_footer')