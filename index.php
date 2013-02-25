<?php
require_once 'inc/config.php';
?><!DOCTYPE html>
<html>
  <head>
    <title>Gigya / Disqus integration demo</title>

    <!-- Gigya SDK. Configuration is flexible. See all options at: -->
    <!-- http://developers.gigya.com/020_Client_API/010_Socialize/010_Objects/Conf_object -->
    <script src="http://cdn.gigya.com/JS/socialize.js?apiKey=<?php echo GIGYA_API_KEY; ?>&lang=en" type="text/javascript">{
      connectWithoutLoginBehavior: "alwaysLogin",           // Turn off temporary users
      forceProvidersLogout: false                           // Do not log user out of connected providers when they log out of site
    }</script>

    <!-- JQuery and JQuery cookie REQUIRED by disqus.js -->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.cookie.min.js"></script>

    <!-- Disqus.js synchronizes Disqus with Gigya -->
    <!-- All disqus_config options are supported: -->
    <script src="js/disqus.js" type="text/javascript">{
      init: true, // Load Disqus SDK -- set to false if SDK will be loaded externally
      short_name: '<?php echo DISQUS_SHORTNAME; ?>',
      token_ajax_url: '<?php echo WEB_ROOT; ?>ajax/disqus.js.php',
      page: {
        api_key: '<?php echo DISQUS_API_KEY; ?>'
      },
      sso: {
        name: 'Gigya',
        button: '<?php echo WEB_ROOT; ?>img/login.gif',
        url: '<?php echo WEB_ROOT; ?>login.php',
        logout: '<?php echo WEB_ROOT; ?>logout.php?returnURL=<?php echo urlencode('http://' . SITE_DOMAIN . $_SERVER["REQUEST_URI"]); ?>',
        width: 740,
        height: 430
      }
    }</script>

    <!--  For the demo only, not required by module - powers the login/logout buttons on this page -->
    <script src="js/index.js" type="text/javascript"></script>
  </head>
  <body>
    <div class="user-functions"><ul>
      <li class="login logged-out" style="display: none;"><a href="javascript:void(0);">Login</a></li>
      <li class="logout logged-in" style="display: none;"><a href="javascript:void(0);">Logout</a></li>
    </ul></div>
    <div id="disqus_thread"></div>
  </body>
</html>