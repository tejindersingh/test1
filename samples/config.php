<?php
/**
 * This file contains config info for the sample app.
 */

//Adjust this to point to the Authorize.Net PHP SDK

require_once 'anet_php_sdk/AuthorizeNet.php';

$METHOD_TO_USE = "AIM";

//$METHOD_TO_USE = "DIRECT_POST";         // Uncomment this line to test DPM

define("AUTHORIZENET_API_LOGIN_ID","7Z8HFbJ8c2u3");// Add your API LOGIN ID
define("AUTHORIZENET_TRANSACTION_KEY","3a883C4s9mBc7QNk"); // Add your API transaction key
define("AUTHORIZENET_SANDBOX",true);// Set to false to test against production
define("TEST_REQUEST", "FALSE");// You may want to set to true if testing against production

//You only need to adjust the two variables below if testing DPM

define("AUTHORIZENET_MD5_SETTING",""); // Add your MD5 Setting.
$site_root = "http://localhost/samples/your_store/"; // Add the URL to your site

if(AUTHORIZENET_API_LOGIN_ID == "")
{
die('Enter your merchant credentials in config.php before running the sample app.');
}
?>