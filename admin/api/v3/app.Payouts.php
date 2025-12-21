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

    $payouts = new redeem($dbo);
    $result = $payouts->getPayouts();

    echo json_encode($result);
    exit;