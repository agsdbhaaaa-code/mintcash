<?php

    /*!
	 * POCKET v3.4
	 *
	 * http://www.droidoxy.com
	 * support@droidoxy.com
	 *
	 * Copyright 2019 DroidOXY ( http://www.droidoxy.com )
	 */

	$pagename = 'push-single';
	$container = 'push';
	
	include_once("core/init.inc.php");

    if (!admin::isSession()) {

        header("Location: index.php");
    }

    $stats = new stats($dbo);

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
                            <h4>Overview</h4>
                        </div>
                    </div>
					<?php if(APP_DEMO) { include_once 'inc/demo-notice.php'; } ?>
					
					<!-- START MAIN CONTENT HERE -->
					
					<div class="col-md-6">
                        <div class="block form-block mb-4">
                            <div class="block-heading">
                                <h5>Text Notication</h5>
                            </div>

                            <form action="process/pushnotify.php" method="post" />
							
                                <div class="form-group">
                                    <label>Select User</label>
                                    <select class="custom-select form-control" name="fcm" required="">
                                        <option selected="" value="null" disabled>Select User</option>
										<?php 
										
											$result = $stats->getAccounts(0);
											$users_loaded = count($result['users']);
											
											if ($users_loaded != 0) {
												
												foreach ($result['users'] as $key => $value) {
													draw($value);
												}
											}
											
										?>
                                    </select>
                                </div>
								
                                <div class="form-group">
                                    <input class="form-control" placeholder="Image" type="text" name="img" value="none" hidden/>
                                </div>
								
                                <div class="form-group">
                                    <label>Title</label>
                                    <input class="form-control" placeholder="Title" type="text" name="title" required=""/>
                                </div>

                                <div class="form-group">
                                    <label>Message</label>
                                    <textarea class="form-control" placeholder="Message" name="msg" rows="3" required=""></textarea>
                                </div>

                                <hr />
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
					
					<div class="col-md-6">
                        <div class="block form-block mb-4">
                            <div class="block-heading">
                                <h5>Image Notication</h5>
                            </div>

                            <form action="process/pushnotify.php" method="post" />
							
                                <div class="form-group">
                                    <label>Select User</label>
                                    <select class="custom-select form-control" name="fcm" required="">
                                        <option selected="" value="nulll" disabled>Select User</option>
										<?php 
										
											$result = $stats->getAccounts(0);
											$users_loaded = count($result['users']);
											
											if ($users_loaded != 0) {
												
												foreach ($result['users'] as $key => $value) {
													draw($value);
												}
											}
											
										?>
                                    </select>
                                </div>
								
                                <div class="form-group">
                                    <label>Image url</label>
									<div class="input-group">
										<span class="input-group-addon text-dark"><i class="ion-ios-calendar-outline"></i></span>
										<input class="form-control" type="text" name="img" placeholder="Image URL" required=""/>
									</div>
                                </div>
								
                                <div class="form-group">
                                    <label>Title</label>
                                    <input class="form-control" placeholder="Title" name="title" type="text" required=""/>
                                </div>

                                <div class="form-group">
                                    <label>Message</label>
                                    <textarea class="form-control" placeholder="Message" name="msg" rows="3" required=""></textarea>
                                </div>

                                <hr />
                                <button class="btn btn-primary" type="submit">Submit</button>
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
<?php

    function draw($user)
    {
	?>
                                        <option value="<?php echo $user['gcm']; ?>"><?php echo $user['fullname']; ?></option>
	<?php
    }
?>