<?php

    /*!
	 * POCKET v3.7
	 *
	 * http://www.droidoxy.com
	 * support@droidoxy.com
	 *
	 * Copyright 2020 DroidOXY ( http://www.droidoxy.com )
	 */

	$pagename = 'postbacks';
	$container = 'settings';
	
	include_once("core/init.inc.php");

    if (!admin::isSession()) {

        header("Location: index.php");
    }
	
	$configs = new functions($dbo);
	$configs->updateConfigs(time(),'LAST_ADMIN_ACCESS');
    $url  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $url .= $_SERVER['SERVER_NAME'].= $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta content="ie=edge" http-equiv="x-ua-compatible" />
	<?php include_once 'inc/title.php'; ?>

    <!--Preloader-CSS-->
    <link rel="stylesheet" href="./assets/plugins/preloader/preloader.css" />

    <!--bootstrap-4-->
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css" />

    <!--Custom Scroll-->
    <link rel="stylesheet" href="./assets/plugins/customScroll/jquery.mCustomScrollbar.min.css" />
    <!--Font Icons-->
    <link rel="stylesheet" href="./assets/icons/simple-line/css/simple-line-icons.css" />
    <link rel="stylesheet" href="./assets/icons/dripicons/dripicons.css" />
    <link rel="stylesheet" href="./assets/icons/ionicons/css/ionicons.min.css" />
    <link rel="stylesheet" href="./assets/icons/eightyshades/eightyshades.css" />
    <link rel="stylesheet" href="./assets/icons/fontawesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="./assets/icons/foundation/foundation-icons.css" />
    <link rel="stylesheet" href="./assets/icons/metrize/metrize.css" />
    <link rel="stylesheet" href="./assets/icons/typicons/typicons.min.css" />
    <link rel="stylesheet" href="./assets/icons/weathericons/css/weather-icons.min.css" />

    <!--Date-range-->
    <link rel="stylesheet" href="./assets/plugins/date-range/daterangepicker.css" />
    <!--Drop-Zone-->
    <link rel="stylesheet" href="./assets/plugins/dropzone/dropzone.css" />
    <!--Full Calendar-->
    <link rel="stylesheet" href="./assets/plugins/full-calendar/fullcalendar.min.css" />
    <!--Normalize Css-->
    <link rel="stylesheet" href="./assets/css/normalize.css" />
    <!--Main Css-->
    <link rel="stylesheet" href="./assets/css/main.css" />
    <!--Custom Css-->
    <link rel="stylesheet" href="./assets/css/custom.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<?php include_once 'inc/preloader.php'; ?>

<?php include_once 'inc/navigation.php'; ?>

<!--Page Container-->
<section class="page-container">
    <div class="page-content-wrapper">
        <!--Header Fixed-->
		<?php include_once 'inc/header-fixed.php'; ?>

        <!--Main Content-->
        <div class="content sm-gutter">
            <div class="container-fluid padding-25 sm-padding-10">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h4>Postbacks</h4>
                        </div>
                    </div>
					<?php if(APP_DEMO) { include_once 'inc/demo-notice.php'; } ?>
					
					<!-- START MAIN CONTENT HERE -->
					
                    <div class="col-md-12">
                        <div class="block form-block mb-4">
                            <div class="block-heading" style="border: none;">
                                <h5>Postbacks S2S ( Server to Server )</h5>
                                <p class="mt-2">Whenever a user completes an offer, the AdNetworks will send a URL request, called a 'Server to Server Postback' with some information. Using this information, we can Reward the user who performed/completed the action/offer accordingly.
                                To receive a successful postback request, you need to give below url's as a postback url for each AdNetwork Accordingly or else user will not be rewarded. Please Read the Documentation for more information on it.<br><br>
                                The Below URL's are given asuming that the postback files are in the folder named <strong>postbacks</strong>. Incase if you change the postbacks folder name to something else, then you need to change the same in the url while giving it to the AdNetworks ..</p>
                            </div>
                            
                            <form action="" method="post" class="horizontal-form">
                                
                                <h5 class="block-bw-heading">AdMantum</h5>
                                
                                <div class="form-group">
                                    <div class="form-row">
                                        <label class="col-md-2">Postback URL</label>
                                        <div class="col-md-10">
                                            <input name="oftro_pb" class="form-control" value="<?php echo $configs->getConfig('WEB_ROOT'); ?>postbacks/admantum.php?user_id={uid}&amount={virtual_currency}" type="text" autocomplete="off" required="" style="background: #e9ecef; " disabled/>
                                        </div>
                                    </div>
                                </div>
                                
                                <h5 class="block-bw-heading">Wannads</h5>
                                
                                <div class="form-group">
                                    <div class="form-row">
                                        <label class="col-md-2">Postback URL</label>
                                        <div class="col-md-10">
                                            <input name="oftro_pb" class="form-control" value="<?php echo $configs->getConfig('WEB_ROOT'); ?>postbacks/wannads.php" type="text" autocomplete="off" required="" style="background: #e9ecef; " disabled/>
                                        </div>
                                    </div>
                                </div>
                                
                                <h5 class="block-bw-heading">CpaLead</h5>
                                
                                <div class="form-group">
                                    <div class="form-row">
                                        <label class="col-md-2">Postback URL</label>
                                        <div class="col-md-10">
                                            <input name="oftro_pb" class="form-control" value="<?php echo $configs->getConfig('WEB_ROOT'); ?>postbacks/cpalead.php?subid={subid}&subid2={subid2}&virtual_currency={virtual_currency}" type="text" autocomplete="off" required="" style="background: #e9ecef; " disabled/>
                                        </div>
                                    </div>
                                </div>
                                
                                <h5 class="block-bw-heading">AdGatemedia</h5>
                                
                                <div class="form-group">
                                    <div class="form-row">
                                        <label class="col-md-2">Postbacks URL</label>
                                        <div class="col-md-10">
                                            <input name="oftro_pb" class="form-control" value="<?php echo $configs->getConfig('WEB_ROOT'); ?>postbacks/adgatemedia.php?tx_id={transaction_id}&user_id={s2}&point_value={points}&usd_value={payout}&offer_title={vc_title}" type="text" autocomplete="off" required="" style="background: #e9ecef; " disabled/>
                                        </div>
                                    </div>
                                </div>
                                
                                <h5 class="block-bw-heading">AdscendMedia</h5>
                                
                                <div class="form-group">
                                    <div class="form-row">
                                        <label class="col-md-2">Postbacks URL</label>
                                        <div class="col-md-10">
                                            <input name="oftro_pb" class="form-control" value="<?php echo $configs->getConfig('WEB_ROOT'); ?>postbacks/adscendmedia.php?offerid=[OID]&name=[ONM]&rate=[CUR]&sub1=[SB1]" type="text" autocomplete="off" required="" style="background: #e9ecef; " disabled/>
                                        </div>
                                    </div>
                                </div>
                                
                                <h5 class="block-bw-heading">KiwiWall</h5>
                                
                                <div class="form-group">
                                    <div class="form-row">
                                        <label class="col-md-2">Postbacks URL</label>
                                        <div class="col-md-10">
                                            <input name="oftro_pb" class="form-control" value="<?php echo $configs->getConfig('WEB_ROOT'); ?>postbacks/kiwiwall.php" type="text" autocomplete="off" required="" style="background: #e9ecef; " disabled/>
                                        </div>
                                    </div>
                                </div>
								
                                <hr/>
								<br><br>
                            </form>
                        </div>
                    </div>
	
					
					<!-- END MAIN CONTENT HERE -->
					<?php include_once 'inc/support.php'; ?>
					
                </div>
            </div>
        </div>
    </div>
	
	<?php include_once 'inc/footer-fixed.php'; ?>

</section>

<!--Jquery-->
<script type="text/javascript" src="./assets/js/jquery-3.2.1.min.js"></script>
<!--Bootstrap Js-->
<script type="text/javascript" src="./assets/js/popper.min.js"></script>
<script type="text/javascript" src="./assets/js/bootstrap.min.js"></script>
<!--Modernizr Js-->
<script type="text/javascript" src="./assets/js/modernizr.custom.js"></script>

<!--Morphin Search JS-->
<script type="text/javascript" src="./assets/plugins/morphin-search/classie.js"></script>
<script type="text/javascript" src="./assets/plugins/morphin-search/morphin-search.js"></script>
<!--Morphin Search JS-->
<script type="text/javascript" src="./assets/plugins/preloader/pathLoader.js"></script>
<script type="text/javascript" src="./assets/plugins/preloader/preloader-main.js"></script>

<!--Chart js-->
<script type="text/javascript" src="./assets/plugins/charts/Chart.min.js"></script>

<!--Sparkline Chart Js-->
<script type="text/javascript" src="./assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<script type="text/javascript" src="./assets/plugins/sparkline/jquery.charts-sparkline.js"></script>

<!--Custom Scroll-->
<script type="text/javascript" src="./assets/plugins/customScroll/jquery.mCustomScrollbar.min.js"></script>
<!--Sortable Js-->
<script type="text/javascript" src="./assets/plugins/sortable2/sortable.min.js"></script>
<!--DropZone Js-->
<script type="text/javascript" src="./assets/plugins/dropzone/dropzone.js"></script>
<!--Date Range JS-->
<script type="text/javascript" src="./assets/plugins/date-range/moment.min.js"></script>
<script type="text/javascript" src="./assets/plugins/date-range/daterangepicker.js"></script>
<!--CK Editor JS-->
<script type="text/javascript" src="./assets/plugins/ckEditor/ckeditor.js"></script>
<!--Data-Table JS-->
<script type="text/javascript" src="./assets/plugins/data-tables/datatables.min.js"></script>
<!--Editable JS-->
<script type="text/javascript" src="./assets/plugins/editable/editable.js"></script>
<!--Full Calendar JS-->
<script type="text/javascript" src="./assets/plugins/full-calendar/fullcalendar.min.js"></script>

<!--- Main JS -->
<script src="./assets/js/main.js"></script>

</body>
</html>