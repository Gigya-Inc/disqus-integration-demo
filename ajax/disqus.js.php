<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

require_once '../inc/config.php';
require_once 'GSSDK.php';

$response = array();
try {
  // Confirm POST data is present
  $requiredKeys = array('UID', 'UIDSignature', 'signatureTimestamp');
  foreach($requiredKeys as $key) {
    if(empty($_POST[$key])) {
      throw new InvalidArgumentException('Missing parameter: ' . $key);
    }
  }

  // Validate user signature
  $validSignature = SigUtils::validateUserSignature($_POST['UID'], $_POST['signatureTimestamp'], GIGYA_SECRET, $_POST['UIDSignature']);
  if(!$validSignature) {
    throw new ErrorException('Invalid user signature.');
  }

  // Fetch user account info directly from Gigya
  // If accounts, it is preferable to use accounts.getAccountInfo generally but getUserInfo works for both implementations for basic info
  $request = new GSRequest(GIGYA_API_KEY, GIGYA_SECRET, "socialize.getUserInfo", new GSObject(array(
    'UID' => $_POST['UID'],
  )));
  $userInfo = $request->send();
  if($userInfo->getErrorCode() != 0) {
    throw new ErrorException($userInfo->getErrorMessage());
  }

  // Generate Disqus signature
  // http://help.disqus.com/customer/portal/articles/236206-single-sign-on
  $message = base64_encode(json_encode(array(
    'id'        => $userInfo->getString('UID'),
    'username'  => $userInfo->getString('nickname'),
    'email'     => $userInfo->getString('email', ''),
    'avatar'    => $userInfo->getString('thumbnailURL', ''),
    'url'       => $userInfo->getString('profileURL', ''),
  )));
  $timestamp = time();
  $hmac = hash_hmac('sha1', $message . ' ' . $timestamp, DISQUS_SECRET_KEY);
  $signature = $message . ' ' . $hmac . ' ' . $timestamp;
  $response = array(
    'success'   => true,
    'signature' => $signature,
  );
} catch(Exception $e) {
  $response = array(
    'success'       => false,
    'errorMessage'  => $e->getMessage(),
  );
}

// Return as JSON
header('Content-Type: text/javascript; charset=utf8');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Max-Age: 1');
header('Access-Control-Allow-Origin: http://' . SITE_DOMAIN . '/');
echo json_encode($response);