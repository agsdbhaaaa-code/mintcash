<?php

    /*!
	 * POCKET v3.4
	 *
	 * http://www.droidoxy.com
	 * support@droidoxy.com
	 *
	 * Copyright 2019 DroidOXY ( http://www.droidoxy.com )
	 */
	
	include_once("../core/init.inc.php");

    if (!admin::isSession()) {

        header("Location: ../index.php");
		
    }else if(isset($_GET['id']) && isset($_GET['action']) && !APP_DEMO){
		
		$id = $_GET['id'];
		$status = $_GET['action'];
		$configs = new functions($dbo);
		
        $sql = "UPDATE youtube SET status = '$status' WHERE id = '$id'";
        $stmt = $dbo->prepare($sql);
        
        $result = $stmt->execute();
        

        if($result){
			
			header("Location: ../youtube-offers.php");
			
		}else{
			
			header("Location: ../youtube-offers.php");
		}
		
	}else{
		
		header("Location: ../youtube-offers.php");
		
	}
	
	
	

?>