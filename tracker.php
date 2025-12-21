<?php

    /*!
	 * POCKET v3.4
	 *
	 * http://www.droidoxy.com
	 * support@droidoxy.com
	 *
	 * Copyright 2019 DroidOXY ( http://www.droidoxy.com )
	 */

	$pagename = 'tracker';
	$container = '';
	
	include_once("core/init.inc.php");

    if (!admin::isSession()) {

        header("Location: index.php");
    }
	
	if(!empty($_GET)){
		
		$user = isset($_GET['user']) ? $_GET['user'] : '';
		
		$completed = new completed($dbo);
		$requests = new requests($dbo);
		$tracker = new tracker($dbo);
		
	}

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
                            <h4>Tracking User's History..</h4>
                        </div>
                    </div>
					<?php if(APP_DEMO) { include_once 'inc/demo-notice.php'; } ?>
					
					<!-- START MAIN CONTENT HERE -->
					
					<div class="col-12">
                        <div class="block form-block mb-4">
                            <div class="block-heading">
                                <h5>Enter UserName to Track</h5>
                            </div>
                            <form class="form-inline" action="tracker.php" method="get"/>

                                <label class="sr-only"> Username</label>
                                <div class="input-group mb-2 mr-sm-2 mb-md-0">
                                    <span class="input-group-addon">@</span>
                                    <input class="form-control" placeholder="Username" name="user" type="text" />
                                </div>

                                <button class="btn btn-primary" type="submit"> Submit</button>
                            </form>
                        </div>
                    </div>
					
					<div class="col-12">
                        <div class="block bg-white table-block mb-4">
                            <div class="block-heading">
                                <h5>User Redeem History</h5>
                                <p class="mt-2">Showing Users Redeem History. You can Track every Activity of a user including his/her Redeem Records. You can Search for a Record.</a></p>
                            </div>

                            <div class="row">
                                <div class="table-responsive">
                                    <table id="dataTable1" class="display table table-striped" data-table="data-table">
                                        <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>User</th>
                                            <th>Amount</th>
                                            <th>Gift Name</th>
                                            <th>Requested To</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Points Used</th>
                                        </tr>
                                        </thead>
                                        <tbody>
										
										<?php
										
										if(!empty($user)){
										
											$result = $requests->getuserRequests($user);
											$requests_loaded = count($result['requests']);
											
											$counter = 1;
											
											if ($requests_loaded != 0) {
												
												foreach ($result['requests'] as $key => $value) {
													draw($value,$counter);
													$counter ++;
												}
											}
										
											$result = $completed->getuserRequests($user);
											$requests_loaded = count($result['requests']);
											
											if ($requests_loaded != 0) {
												
												foreach ($result['requests'] as $key => $value) {
													draw($value,$counter);
													$counter ++;
												}
											}
											
										}
											
											
										?>
										
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
					
					
					<div class="col-12">
                        <div class="block bg-white table-block mb-4">
                            <div class="block-heading">
                                <h5>User Earning History</h5>
                                <p class="mt-2">Showing User's Earinig Status Activity. You can Track every Activity of a user including his/her Earning Records. You can Search for a Record.</p>
                            </div>

                            <div class="row">
                                <div class="table-responsive">
                                    <table id="dataTable1" class="display table table-striped" data-table="data-table">
                                        <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>User</th>
                                            <th>Earned From</th>
                                            <th>Date</th>
                                            <th>Credited Points</th>
                                        </tr>
                                        </thead>
                                        <tbody>
										
										<?php
										
										if(!empty($user)){
										
											$result = $tracker->getuserTrackerData($user);
											$trackerdata_loaded = count($result['requests']);
											
											$trackercounter = 1;
											
											if ($trackerdata_loaded != 0) {
												
												foreach ($result['requests'] as $key => $value) {
													drawTracker($value,$trackercounter);
													$trackercounter ++;
												}
											}
											
										}
											
											
										?>
										
                                        </tbody>
                                    </table>
                                </div>
                            </div>

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

	function draw($request,$counter)
    {
	?>
		<tr>
            <td class="text-left"><?php echo $counter; ?></td>
            <td><?php echo $request['username']; ?></td>
            <td class="price"><?php echo $request['req_amount']; ?></td>
            <td><?php echo $request['gift_name']; ?></td>
			<?php if (!APP_DEMO) { ?><td><?php echo $request['request_from']; ?></td><?php }else{ ?><td data-toggle="tooltip" data-original-title="Not Available in the Demo Version">xxxxxxxx</td><?php } ?>
			<?php if($request['status'] == 1){ ?>
				<td><span class="badge badge-pill bg-success">Completed</span></p></td><?php	
			}else if($request['status'] == 2){ ?>
				<td><span class="badge badge-pill bg-warning">Processing</span></p></td><?php	
			}else if($request['status'] == 3){ ?>
				<td><span class="badge badge-pill bg-danger">Rejected</span></p></td><?php	
			}else if($request['status'] == 0){ ?>
				<td><span class="badge badge-pill bg-warning">Pending</span></p></td><?php	
			}
			?>
            <td class="date"><?php $timestamp = strtotime($request['date']); echo date('d M Y, D',$timestamp); ?></td>
            <td class="price"><?php echo "- ".$request['points_used']; ?></td>
        </tr>
	<?php
    }

	function drawTracker($request,$trackercounter)
    {
	?>
		<tr>
            <td class="text-left"><?php echo $trackercounter; ?></td>
            <td><?php echo $request['username']; ?></td>
            <td><?php echo $request['type']; ?></td>
            <td class="date"><?php $timestamp = strtotime($request['date']); echo date('d M Y, D',$timestamp); ?></td>
            <td class="price"><?php echo "+ ".$request['points']; ?></td>
			
        </tr>
	<?php
    }
?>