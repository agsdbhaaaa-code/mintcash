<?php

    /*!
	 * POCKET v3.4
	 *
	 * http://www.droidoxy.com
	 * support@droidoxy.com
	 *
	 * Copyright 2019 DroidOXY ( http://www.droidoxy.com )
	 */

    include_once("core/init.inc.php");

	if (admin::isSession()) {

		header("Location: admin.php");
		
	}else{
	    
		header("Location: login.php");
	}
	
	
	?>