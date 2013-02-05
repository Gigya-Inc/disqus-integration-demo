Gigya / Disqus integration demo
=======================

View working example online here:
http://demo.gigyahosting1.com/disqus/


Setup
=======================

1) Download source code

2) Edit inc/config.php with your Gigya and Disqus API configurations

3) Load the Javascript integration module on any page with a Disqus thread -- parameters are passed within the script tag:

`````javascript
<!-- Disqus.js synchronizes Disqus with Gigya -->
<!-- All disqus_config options are supported: -->
<script src="js/disqus.js" type="text/javascript">{
  init: true, // Load Disqus SDK -- set to false if SDK will be loaded externally
  short_name: 'disqusshortname',
  token_ajax_url: 'ajax/disqus.js.php', // Included is full example code for this process in PHP
  page: {
    api_key: '12345'
  },
  sso: { // All URLs must be absolute path:
    name: 'Gigya',
    button: 'http://example.com/img/login.gif',
    url: 'http://example.com/login',
    logout: 'http://example.com/logout.php?returnURL=http://example.com/currentpage',
    width: 740,
    height: 430
  }
}</script>
`````


Server-side dependencies
=======================

Authentication and token generation must be done on the server-side for security reasons. This module includes an example integration in PHP. The PHP server-side components are extremely simple and can be refactored to any environment or language.
