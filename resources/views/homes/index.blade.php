@extends('home')
@section('title', 'A Great Resource Hub for Fleet Owners, Drivers, Dispatchers & Shippers!
')
@section('content')

<!--Main Wrapper Start-->
<div class="main-wrapper" stlye="width:100%;">
  <nav id="sticky-nav-right"></nav>
  <img src="/img/home/banner_home.jpg" alt="" class="img-responsive" style="width:100%">
    {{-- <section class="container-fluid module__hero-v2" style="background-image: url(/img/home/banner_home.jpg); 100% 100%"  stlye="width:100%;margin:10%"> --}}
      {{-- <div class="banner" id="removebanner" style="padding:35px 25px; height:65%"> --}}
  			{{-- <span onclick="removebanner()" class="remove">&#10006;</span> --}}
        {{-- <img src="/img/home/OvalFleet Soft-Launch Banner.jpg" style=" border:1px solid #000; box-shadow: 0px 0px 5px #000" class="img-responsive"> --}}
  			{{-- <span class="oval">OVALFLEET</span> --}}
        {{-- <p class="smaller">Sign Up and Stay Tuned for Updates</p> --}}
  			{{-- <p class="smaller">For better security, we are configuring our Server and the site will be up and running shortly. Stay tuned.</p> --}}
		  {{-- </div> --}}
    {{-- </section> --}}
    <div class="container">
      <br>
    <div class="panel panel-info" style="margin-bottom:-10px">
      <div class="panel-footer">
        <p style="font-size:16px">OvalFleet novel use of technology helps trucking companies of all sizes solve traditional fleet management problems. We provide an all-in-one web-based service to handle your entire transport process – load planning, worldwide street-level routing, dispatching, invoicing, and paying your truck drivers. No large up-front costs and long term commitments to automated tools that help improve, cargo shipping, customer experience, increase efficiency and profitability. OvalFleet easy-to-use platform is available anywhere, anytime with a <a href="/signup" style="color:blue">30-day free trial</a>.</p>
      </div>
    </div>
    </div>

    
    
  <div class="container" style="margin-top: 30px; margin-bottom: 30px; padding-left: 15px !important;">
    <div class="row">
      <div class="content clearfix">
        <div class="field field-name-body field-type-text-with-summary field-label-hidden">
          <div class="field-items">
            <div class="field-item even" property="content:encoded">
              <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="homebox">
                  <a href="/login"><img class="img-responsive" src="/img/home/FLEET OWNERS.jpg"></a>
                </div>
              </div>
              <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="homebox">
                  <a href="/login"><img class="img-responsive" src="/img/home/DISPATCHERS.jpg"></a>
                </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6">
                  <div class="homebox">
                    <a href="/login"><img class="img-responsive" src="/img/home/drivers.jpg"></a>
                  </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6">
                  <div class="homebox">
                    <a href="/login">
                      <img class="img-responsive" src="/img/home/SHIPPERS.jpg">
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> <!-- section main -->
  <script>
  	function removebanner(){
  		document.getElementById('removebanner').style.display= 'none';
  	}
  </script>

  <div class="chat-window" style="position:fixed; right:5px; bottom:70px">
    <!-- mibew button -->
    <a id="mibew-agent-button" href="https://webchat.ovalfleet.net/chat?locale=en&amp;style=default" target="_blank" onclick="Mibew.Objects.ChatPopups['5e52b315363e1296'].open();return false;"><img src="https://webchat.ovalfleet.net/b?i=mibew&amp;lang=en" border="0" alt="" /></a>
    <script type="text/javascript" src="https://webchat.ovalfleet.net/js/compiled/chat_popup.js"></script>
    <script type="text/javascript">Mibew.ChatPopup.init({"id":"5e52b315363e1296","url":"https:\/\/webchat.ovalfleet.net\/chat?locale=en&style=default","preferIFrame":true,"modSecurity":false,"forceSecure":false,"style":"default","height":480,"width":640,"resizable":true,"styleLoader":"https:\/\/webchat.ovalfleet.net\/chat\/style\/popup\/default"});</script>
    <div id="mibew-invitation"></div>
    <script type="text/javascript" src="https://webchat.ovalfleet.net/js/compiled/widget.js"></script>
    <script type="text/javascript">Mibew.Widget.init({"inviteStyle":"https:\/\/webchat.ovalfleet.net\/styles\/invitations\/default\/invite.css","requestTimeout":10000,"requestURL":"https:\/\/webchat.ovalfleet.net\/widget","locale":"en","visitorCookieName":"MIBEW_VisitorID"})</script>
    <!-- / mibew button -->
  </div>

  <style type="text/css">
  div.mibew-chat-frame-toggle, div.mibew-chat-frame-toggle-off{margin-bottom:6%;}
  div.mibew-chat-wrapper{margin-bottom:5.5% !important;}
  </style>
  
@endsection