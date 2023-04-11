<!-- top bar  -->
<style>
  #header{ padding: 15px; background: rgb(255,255,255,0.8);color: #000}
    .header_logo{width: 120px; padding-left: 50px;margin-top: -7px;margin-bottom: -10px}
    .header_a{float:none;}
    .header_menu{float: right;}
    .header_menu a{color: #000!important}
    .item{margin:9px; color:#eee!important;font-size:18px}
    .alert{margin: 10px auto;float: none;}
</style>

  <div id="header" class="row" style="margin-bottom:15px;color:#000!important">
    <div class="container-fluid">
      <div class="col-md-8">
      <a href="/" class=" header_a" style="color:#000;font-size:18px">
      <img class="header_logo" src="/img/home/logo.png" alt="Fleet Management Services">&nbsp; &nbsp; Fleet Management Services
      </a>
      </div>

      <div class="col-md-2 header_menu">
       <a href="/signup" class="item">Sign up</a>
       <a href="/login" class="item">Login</a>
     </div>
  </div>
</div>

  <!-- Header -->
    {{-- <header id="header" class="row alt">
      <div class="logo">
        <a href="#">
          <img src="/images/home/logo.png" alt="" width="100">
        </a>
      </div>
    </header> --}}


  <!-- <style type="text/css">
  .alert {
    left: 2.5%;
    margin-bottom: 0;
    margin-left: auto;
    margin-right: auto;
    position: absolute;
    top: 62px;
    width: 95%;
    z-index: 999;
    padding: 10px
  }

  .alert-container {
      position: relative;
  }

  .alert.alert-success {
    background-color: #5cb860;
    border-radius: 3px;
    box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(76, 175, 80, 0.4);
    color: #ffffff;
  }
  .alert-danger{color:#a94442;background-color:#f2dede;border-color:#ebccd1}
  .alert-i{padding: 0 5px; border:1px solid #f00; border-radius: 50%;color: #f00; cursor: pointer; float: right;max-width: 50px; display: block;}
  </style>
 -->
  @include('partials.messages')