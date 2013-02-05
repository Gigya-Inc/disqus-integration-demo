<?php
require_once 'inc/config.php';

// Validate return URL
if(empty($_GET['returnURL'])) {
  echo 'Invalid returnURL';
  exit;
}
$parsed = parse_url($_GET['returnURL']);
if(empty($parsed['host']) || strpos(SITE_DOMAIN, $parsed['host']) === false) {
  echo 'Invalid returnURL';
  exit;
}
?><!DOCTYPE html>
<html>
  <head>
    <title>Logout</title>

    <!-- Gigya SDK. Configuration is flexible. See all options at: -->
    <!-- http://developers.gigya.com/020_Client_API/010_Socialize/010_Objects/Conf_object -->
    <script src="http://cdn.gigya.com/JS/socialize.js?apiKey=<?php echo GIGYA_API_KEY; ?>&lang=en" type="text/javascript">{
      connectWithoutLoginBehavior: "alwaysLogin",           // Turn off temporary users
      forceProvidersLogout: false,                          // Do not log user out of connected providers when they log out of site
      sessionExpiration: <?php echo SESSION_EXPIRATION; ?>  // Standardize sessionExpiration
    }</script>

    <!--  For the demo only, not required by module - renders the page UI -->
    <script src="js/jquery.min.js"></script>
    <script src="js/user.js"></script>
    <script type="text/javascript">
    site.user.logout({
      callback: function() {
        window.location = '<?php echo str_replace("'", "\'", $_GET['returnURL']); ?>';
      }
    });
    </script>
  </head>
  <body>
    <div id="login"></div>
  </body>
</html>