<?php
require_once 'coffee_store_settings.php';

if ($METHOD_TO_USE == "AIM") {
 $transaction = new AuthorizeNetAIM;
  
  
/*  $transaction = new AuthorizeNetDPM;
  

// The SDK
 $url = "http://localhost/your_store/process_sale.php"; 
 $api_login_id = '7Z8HFbJ8c2u3'; 
 $transaction_key = '3a883C4s9mBc7QNk';
  $md5_setting = ''; // Your MD5 Setting
   $amount = "5.99"; 
  $data =  AuthorizeNetDPM::directPostDemo($url, $api_login_id, $transaction_key, $amount, $md5_setting);
 
 
  print_r($data);
    die;*/
  
  
	
  $transaction->setSandbox(AUTHORIZENET_SANDBOX);

    $transaction->setFields(
        array(
        'amount' => $amount, 
        'card_num' => $_POST['x_card_num'], 
        'exp_date' => $_POST['x_exp_date'],
        'first_name' => $_POST['x_first_name'],
        'last_name' => $_POST['x_last_name'],
        'address' => $_POST['x_address'],
        'city' => $_POST['x_city'],
        'state' => $_POST['x_state'],
        'country' => $_POST['x_country'],
        'zip' => $_POST['x_zip'],
        'email' => $_POST['x_email'],
        'card_code' => $_POST['x_card_code'],
        )
    );
    $response = $transaction->authorizeAndCapture();


    if ($response->approved) {
	
		
		$firstname=$response->first_name;
		$lastname= $response->last_name;
		$email = $response->email_address;
		$city =$response->city;
		$state = $response->state;
		$country = $response->country;
		$address=$response->address;
		$amount=$response->amount;
		$transaction_id=$response->transaction_id;
		$accnum=$response->account_number;
		$authorization_code = $response->authorization_code;
		$cardtype=$response->card_type;
		
		mysql_connect('localhost','root','') or die('could not connect with mysql'.mysql_error());
		mysql_select_db('phpauthorizedotnet') or die('could not select the database'.mysql_error());
		
$sql="INSERT INTO transactiondetail VALUES(NULL,'".$firstname."','".$lastname."','".$email."',
'".$city."','".$state."','".$country."','".$address."','".$amount."','".$transaction_id."'
		,'".$accnum."','".$authorization_code."','".$cardtype."')";

		$result=mysql_query($sql);
				
        // Transaction approved! Do your logic here.
        header('Location: thank_you_page.php?transaction_id=' . $response->transaction_id);
    } else {
        header('Location: error_page.php?response_reason_code='.$response->response_reason_code.'&response_code='.$response->response_code.'&response_reason_text=' .$response->response_reason_text);
    }
} elseif (count($_POST)) { echo "else part";
die;
    $response = new AuthorizeNetSIM;
    if ($response->isAuthorizeNet()) {
        if ($response->approved) {
	
            // Transaction approved! Do your logic here.
            // Redirect the user back to your site.
            $return_url = $site_root . 'thank_you_page.php?transaction_id=' .$response->transaction_id;
        } else {
            // There was a problem. Do your logic here.
            // Redirect the user back to your site.
            $return_url = $site_root . 'error_page.php?response_reason_code='.$response->response_reason_code.'&response_code='.$response->response_code.'&response_reason_text=' .$response->response_reason_text;
        }
        echo AuthorizeNetDPM::getRelayResponseSnippet($return_url);
    } else {
        echo "MD5 Hash failed. Check to make sure your MD5 Setting matches the one in config.php";
    }
}