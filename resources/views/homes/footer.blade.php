  <footer class="main" role="contentinfo" style="background: {{$_SERVER['REQUEST_URI'] == '/'?'rgba(0,0,0,0.6)':'#3c8dbc'}};padding:0; position:fixed; bottom:0">
    <div class="container">
      <p class="copyrighttext">&copy; {{date('Y')}} OVALFLEET | All Rights Reserved</p>
      <div class="menu-footer-container">
        <ul id="menu-footer-1" class="menu">
          <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-188">
            <a href="/service_terms">Service Terms</a>
          </li>
          <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-187">
            <a href="/faq">FAQ</a>
          </li>
          {{-- <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-15244">
            <a href="#" data-ps2id-api="true">Contact</a>
          </li> --}}
        </ul>
      </div>
    </div>
  </footer>
</div>