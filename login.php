<?php
require_once 'inc/config.php';
?><!DOCTYPE html>
<html>
  <head>
    <title>Login</title>

    <!-- Gigya SDK. Configuration is flexible. See all options at: -->
    <!-- http://developers.gigya.com/020_Client_API/010_Socialize/010_Objects/Conf_object -->
    <script src="http://cdn.gigya.com/JS/socialize.js?apiKey=<?php echo GIGYA_API_KEY; ?>&lang=en" type="text/javascript">{
      connectWithoutLoginBehavior: "alwaysLogin",           // Turn off temporary users
      forceProvidersLogout: false                           // Do not log user out of connected providers when they log out of site
    }</script>

    <!--  For the demo only - renders the page UI -->
    <script src="js/jquery.min.js"></script>
    <script type="text/javascript">
    gigya.socialize.addEventHandlers({
      onLogin: function() {
        window.close();
      }
    });
    $(document).ready(function() {
      gigya.socialize.showLoginUI({
        containerID: "login"
      });
    });
    </script>
  </head>
  <body>
    <div id="login"></div>
  </body>
</html>