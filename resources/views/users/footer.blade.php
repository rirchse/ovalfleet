  @if(ENV('WEB_CHAT') == 'enable')
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
  /*div.mibew-chat-frame-toggle, div.mibew-chat-frame-toggle-off{margin-bottom:6%;}*/
  /*div.mibew-chat-wrapper{margin-bottom:5.5% !important;}*/
  </style>
  @endif

<footer class="main-footer">
    <strong>Copyright &copy; <script> document.write(new Date().getFullYear()) </script> <a href="#">OvalFleet</a>.</strong> All rights
    reserved.
  </footer>
  
  <div class="control-sidebar-bg"></div>