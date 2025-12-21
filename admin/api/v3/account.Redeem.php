<?php

    /*!
	 * POCKET v3.4
	 *
	 * http://www.droidoxy.com
	 * support@droidoxy.com
	 *
	 * Copyright 2019 DroidOXY ( http://www.droidoxy.com )
	 */

include_once("../api.inc.php");

if (!empty($_POST)) {
    
    $data = $_POST['data'];
    
    $json = json_decode($data, true);

    $clientId = isset($json['clientId']) ? $json['clientId'] : 0;

    $accountId = isset($json['accountId']) ? $json['accountId'] : '';
    $accessToken = isset($json['accessToken']) ? $json['accessToken'] : '';
    
    $user = isset($json['user']) ? $json['user'] : '11';
    
    $clientId = helper::clearInt($clientId);
    $accountId = helper::clearInt($accountId);
    
    $accessToken = helper::clearText($accessToken);
    $accessToken = helper::escapeText($accessToken);
    
    $result = array("error" => true);
    $auth = new auth($dbo);
    
    if(!isset($json['name'])){
        
        api::printError(ERROR_UNKNOWN, "Error on Redeem DATA");
        
    }else if(!isset($json['value'])) {

        api::printError(ERROR_UNKNOWN, "Error on Redeem Request DATA");
        
    }else if($clientId != CLIENT_ID) {

        api::printError(ERROR_UNKNOWN, "Error client Id.");
        
    }else if(!$auth->authorize($accountId, $accessToken)) {

        api::printError(ERROR_ACCESS_TOKEN, "Error authorization");
    }
    
    $payoutId = $json['name'];
    $payoutTo = $json['value'];
    
    $dev_name = $json['dev_name'];
    $dev_man = $json['dev_man'];
    
    $redeem = new redeem($dbo);
    $payoutdata = $redeem->getSinglePayout($payoutId);

    $account = new account($dbo, $accountId);
    $userdata = $account->get();
    $notify = new functions($dbo);
    
    if($payoutdata['payout_id'] != $payoutId){

        api::printError(ERROR_ACCESS_TOKEN, "Invalid Redeem Request DATA");
        
    }else if($userdata['username'] != $user){
        
        api::printError(ERROR_UNKNOWN, "Account Mismatch");
    
    }else if($userdata['points'] < $payoutdata['payout_pointsRequired']){
        
        api::printError(420, "No Enough Balance");
        
    }else{
        
        // THE START
        
        $newBalance = $userdata['points'] - $payoutdata['payout_pointsRequired'];
        
        $sql = "UPDATE users SET points = '$newBalance' WHERE login = '$user'";
        $stmt = $dbo->prepare($sql);
        
        $time  = date("Y-m-d", time());
        
        if($stmt->execute()){
            
            $payout_title = $payoutdata['payout_title'];
            $payout_amount = $payoutdata['payout_amount'];
            $payout_pointsRequired = $payoutdata['payout_pointsRequired'];
            
            $sql = "INSERT INTO Requests(request_from, dev_name, dev_man, gift_name, req_amount, points_used, date, status, username) VALUES ('$payoutTo', '$dev_name', '$dev_man', '$payout_title', '$payout_amount', '$payout_pointsRequired', '$time', 0, '$user')";
            $stmt = $dbo->prepare($sql);
            
            if($stmt->execute()){
                
                $result = array("error" => false, "error_code" => ERROR_SUCCESS, "response_title" => "Redeem Success", "response_message" => "Redem All Good");
                
                $notify->sendPush($userdata['gcm'], "redeemed", $payout_amount ." ". $payout_title, "none", "none");
                
            }else{
                
                /**
                 * @ INCASE OF DATABASE ERROR ( IT HAPPENS ONLY ON RARE CASES LIKE SLOW INTERNET CONNECTION OR SERVER FAILURE )
                 * 
                 * Incase of Points debited From User but Request Not Added because of database Connectivity issue.
                 * It'll be saved in Error_Log File - Process it Manually or return the Points to the user Manually incase user contacts the App Admin.
                 * 
                 * Also, Please Check the Error_Log Files Regurarly for any issues.. 
                 * 
                 * if found any serious error/issue, please contact the developers AKA DROIDOXY Suport Team Immediately.
                 * 
                 * SUPPORT FORUM : http://www.droidoxy.com/support/
                 * 
                 * 
                 * The Demo LOG : [11-Oct-2018 12:02:51] Points Debited but Redeem request not added to Database, the Redeem is from the user : testUser the Points Used are : 1000 request came from device : OPPO the Redeem was for : $1 USD Paypal Requested to : test@usertesting.com on the Date of : 1539259371
                 * 
                 * 
                **/
                
                error_log("Points Debited but Redeem request not added to Database, the Redeem is from the user : ".$user." the Points Used are : ".$payout_pointsRequired." request came from device : ".$dev_name." the Redeem was for : " .$payout_amount ." " . $payout_title . " Requested to : " . $payoutTo . " on the Date of : " .$time );
                
                api::printError(ERROR_UNKNOWN, "Sever Error");
            }
            
        }else{
            
            api::printError(ERROR_UNKNOWN, "Sever Error");
        }
        
        // THE END
    }

    echo json_encode($result);
    exit;
}
