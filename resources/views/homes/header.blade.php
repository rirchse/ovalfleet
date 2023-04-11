<!-- Google Analytics -->
<script>
window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
ga('create', 'UA-135619819-1', 'auto');
ga('send', 'pageview');
</script>
<script async src='https://www.google-analytics.com/analytics.js'></script>
<!-- End Google Analytics -->
<body style="padding-top: 0px;">
  {{-- <noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NK2MTW2"
    height="0" width="0" style="display:none;visibility:hidden"></iframe>
  </noscript> --}}
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="background:{{$_SERVER['REQUEST_URI'] == '/'?'rgba(0,0,0,0.3)':'#3c8dbc'}}">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          @if($_SERVER['REQUEST_URI'] != '/')
          <a class="navbar-brand" href="/" style="margin-left:60px">
            <img class="img-responsive" src="{{asset('img/home/logo.png')}}">
          </a>
          @endif
          <ul class="social-icons" style="float:left;color:#fff!important">
          <li>
          <a href="https://www.facebook.com/OvalFleet/" target="_blank" class="ss-login">
            <i class="fab fa-facebook-f"></i>
          </a>
        </li>
        <li>
          <a href="https://www.youtube.com/OvalFleet/" target="_blank" class="ss-login">
            <i class="fab fa-youtube"></i>
          </a>
        </li>
        <li>
          <a href="#" target="_blank" class="ss-login">
            <i class="fab fa-instagram"></i>
          </a>
        </li>
        </div>
          <div id="navbar" class="collapse navbar-collapse">
            <style type="text/css">
            .freetrial{max-width:100px;background: url(/img/home/freetrial.gif) left 100% no-repeat;height: 62px;display: table-cell;}
            /*.freetrial:hover{background: url(/img/home/freetrial.gif) right 100% no-repeat;}*/
            .freetrial-li a:hover{background: #19B48A!important}
            </style>
            <ul class="nav navbar-nav navbar-right" style="font-family:Arial; font-weight: 400;">
              <li>{{-- +1.972.294.3460 --}}
        {{-- <li><p class="navbar-text">&#9993; support@ovalfleet.com</p></li> --}} &nbsp; &nbsp;</li>
              <li class="freetrial-li" style="background:#19B48A">
                <a style="font-size:16px;padding-left:10px;padding:0;display:block;" href="/signup">
                  <div style="float:left;width:60px;font-size:20px;text-align:center;line-height:1.3;text-transform:uppercase;padding:5px">Free <br>Trial</div>
                  <div class="freetrial" style="width:100px"></div>
                </a>
              </li>
              <li><a href="/"><i class="fas fa-home"></i></a></li>      
              <li><a href="/signup" class="ss-login">Sign up</a></li>
              <li><a href="/login" class="ss-login">Login</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <style type="text/css">
    .alert-section .alert{position: absolute; z-index: 9999999999}
    </style>

    <div class="alert-section" style="margin-bottom:-50px;position:relative;top:10%;margin:0 auto;max-width:800px;margin-bottom:1px">
     @include('partials.messages')
     <div class="clearfix"></div>
  </div>