<?php

define('DOC_ROOT', realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..'));
set_include_path(implode(PATH_SEPARATOR, array(
  DOC_ROOT . DIRECTORY_SEPARATOR . 'lib',
  DOC_ROOT . DIRECTORY_SEPARATOR . 'inc',
  get_include_path(),
)));

define('SITE_DOMAIN', 'demo.gigyahosting1.com');
define('WEB_ROOT', 'http://' . SITE_DOMAIN . '/disqus/');

// See: http://developers.gigya.com/010_Developer_Guide/82_Socialize_Setup
define('GIGYA_API_KEY', '');
define('GIGYA_SECRET', '');

// Disqus configuration
define('DISQUS_API_KEY', '');
define('DISQUS_SECRET_KEY', '');
define('DISQUS_SHORTNAME', '');