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
        
        api::printError(ERROR_UNKNOWN, "Error on Refer DATA");
        
    }else if(!isset($json['value'])) {

        api::printError(ERROR_UNKNOWN, "Error on Referer Code");
        
    }else if($clientId != CLIENT_ID) {

        api::printError(ERROR_UNKNOWN, "Error client Id.");
        
    }else if(!$auth->authorize($accountId, $accessToken)) {

        api::printError(ERROR_ACCESS_TOKEN, "Error authorization.");
    }
    
    $refererCode = $json['value'];

    $account = new account($dbo, $accountId);
    $notify = new functions($dbo);
    $userdata = $account->get();
    $referdata = $account->getreferer($refererCode);
    $userOldReferData = $account->getOldRefersData($user);
    
    $refererCodefromreferData = isset($referdata['refer']) ? $referdata['refer'] : '11';
    
    $checkusername = isset($userOldReferData['username']) ? $userOldReferData['username'] : "none";
    
    if($userdata['username'] != $user){
        
        api::printError(ERROR_UNKNOWN, "Account Mismatch");
        
    }else if($userdata['refered'] == 1){
        
        api::printError(400, "Referral Bonus Received Already");
        
    }else if($checkusername == $user){
        
        // Old Refer checking and updating user status
        $oldrefererCode = $userOldReferData['referer'];
        $sql = "UPDATE users SET referer = '$oldrefererCode', refered = '1' WHERE login = '$user'";
        $stmt = $dbo->prepare($sql);
        $stmt->execute();
        
        api::printError(400, "Referral Bonus Received Already");
        
    }else if($refererCodefromreferData != $refererCode){
        
        api::printError(404, "Invalid Refer Code");
        
    }else if($userdata['username'] == $referdata['username']){
        
        api::printError(420, "Self Refer Not Allowed");
        
    }else{
        
        // THE START
        
        $time  = date("Y-m-d", time());
        $referReward = $notify->getConfig('REFER_REWARD');
        $referBonusTitle = $notify->getConfig('REFERAL_BONUS_TITLE');
        $refererBonusTitle = $notify->getConfig('REFERER_BONUS_TITLE');
        
        $rererUserName = $referdata['username'];
        
        $newUserBalance = $userdata['points'] + $referReward;
        $newRefererBalance = $referdata['points'] + $referReward;
        
        // Updating user Points & Refer status
        $sql = "UPDATE users SET points = '$newUserBalance', referer = '$refererCode', refered = '1' WHERE login = '$user'";
        $stmt = $dbo->prepare($sql);
        $stmt->execute();
        
        // Updating Referer Points
        $sql = "UPDATE users SET points = '$newRefererBalance' WHERE login = '$rererUserName'";
        $stmt = $dbo->prepare($sql);
        $stmt->execute();
        
        // INSERT INTO `tracker` (`username`, `points`, `type`, `date`) VALUES ('testUser', '10', 'Referral Income', '2018-10-03');
        
        // Updating user Tracker
        $sql = "INSERT INTO tracker(username, points, type, date) values ('$user', '$referReward', '$referBonusTitle', '$time')";
        $stmt = $dbo->prepare($sql);
        
        if($stmt->execute()){ $notify->sendPush($userdata['gcm'], "invite", $referReward, "none", "none"); }
        
        // Updating Referer Tracker
        $sql = "INSERT INTO tracker(username, points, type, date) values ('$rererUserName', '$referReward', '$refererBonusTitle', '$time')";
        $stmt = $dbo->prepare($sql);
        
        if($stmt->execute()){ $notify->sendPush($referdata['gcm'], "referer", $referReward, "none", "none"); }
        
        $result = array("error" => false, "error_code" => ERROR_SUCCESS, "response_title" => "Refer Success", "response_message" => "Refer All Good");
        
        
        // THE END
    }

    echo json_encode($result);
    exit;
}
