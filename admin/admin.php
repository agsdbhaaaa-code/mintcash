<?php

    /*!
	 * POCKET v3.4
	 *
	 * http://www.droidoxy.com
	 * support@droidoxy.com
	 *
	 * Copyright 2019 DroidOXY ( http://www.droidoxy.com )
	 */


	$pagename = 'dashboard';
	$container = '';
	
	include_once("inc/admin.inc.php");
	

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
							<!--<button class="mr-2 btn btn-info btn-small" data-target=".percentage-breakdown-modal-lg" data-toggle="modal">More</button>-->
							
							<div aria-labelledby="PercentageBreakdown" class="modal fade percentage-breakdown-modal-lg" role="dialog" tabindex="-1" aria-hidden="true" style="display: none;">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title">Percentage Breakdown Explanation </h5>
											<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
										</div>
										<div class="modal-body">
											
										</div>
										<div class="modal-footer">
											<button class="btn btn-info" data-dismiss="modal" type="button"> OK</button>
										</div>
									</div>
								</div>
							</div>
							
                        </div>
                    </div>
					
					<!-- START MAIN CONTENT HERE -->
					
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="block counter-block mb-4">
                            <div class="value"><?php echo $totalUsers; ?></div>
                            <div class="trending trending-up">
                                <span><?php echo $totalusersPercent; ?> %</span>
                                <i class="fa fa-caret-up"></i>
                            </div>
                            <p class="label">Total Users</p>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="block counter-block mb-4">
							<div class="value"><?php echo $pendingRequests + $processingRequests; ?></div>
							<p class="label">Pending Requests</p>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="block counter-block <?php if($usersIncreased){ echo "up"; }else{ echo "down"; } ?> mb-4">
                            <div class="value"><?php echo $newUsers; ?></div>
                            <div class="trending">
                                <span><?php echo $newusersPercent; ?> % </span>
                                <i class="fa fa-caret-<?php if($usersIncreased){ echo "up"; }else{ echo "down"; } ?>"></i>
                            </div>
                            <p class="label">New Users</p>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="block counter-block counter-bg-img mb-4" style="background: url(./assets/images/counter-bg-img.jpg);">
                            <div class="fade-color">
                                <div class="value text-white"><?php echo $todayActiveusers; ?></div>
                                <p class="label text-white">Active Users Today</p>
                            </div>
                        </div>
                    </div>
					
					<?php if($configs->getConfig("INCOME_OVERVIEW") == 1){ ?>
					<?php if($configs->getConfig("INCOME_OVERVIEW_TITLE") == 1){ ?>
					<div class="col-12">
                        <div class="section-title">
                            <h4>Income Overview (Approx.)</h4>
                        </div>
                    </div><?php } ?>
					
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="block counter-block mb-4">
                            <div class="value">$<?php echo $todayProfit; ?></div>
                            <div class="trending trending-<?php if($profitIncreased){ echo "up"; }else{ echo "down"; } ?>-basic">
                                <span><?php echo $todayProfitPercent; ?>%</span>
                                <i class="fa fa-long-arrow-<?php if($profitIncreased){ echo "up"; }else{ echo "down"; } ?>"></i>
                            </div>
                            <p class="label">Todays Profit</p>
                        </div>
                    </div>

					
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="block counter-block mb-4">
                            <div class="row">
                                <div class="col-12">
                                    <h4 style="font-weight: 700;">$<?php echo $weekProfitFinal; ?></h4>
                                    <p class="label">This Week</p>
                                </div>
                                <div class="col-12">
                                    <div class="progress mt-2">
                                        <div class="progress-bar bg-success" style="width: <?php echo $configs->calcPercent($weekProfitFinal, "week"); ?>%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="block counter-block mb-4">
                            <div class="row">
                                <div class="col-12">
                                    <h4 style="font-weight: 700;">$<?php echo $monthProfitFinal; ?></h4>
                                    <p class="label">This Month</p>
                                </div>
                                <div class="col-12">
                                    <div class="progress  mt-2">
                                        <div class="progress-bar" style="width: <?php echo $configs->calcPercent($monthProfitFinal, "month"); ?>%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					
					
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="block counter-block bg-primary ptb mb-4">
                            <div class="row">
                                <div class="col-6">
                                    <h4 class="text-white" style="font-weight: 700;">$<?php echo $totalProfitFinal; ?></h4>
                                    <p class="label text-white">All Time</p>
                                </div>
                                <div class="col-6">
                                    <span class="allTimeProfitChart float-right"></span>
                                </div>
                            </div>
                        </div>
                    </div>
					<?php } ?>
					

                    <div class="col-12 col-md-9 col-lg-9">
                        <div class="section-title">
                            <h4>Analytics Chart</h4>
                        </div>

                        <div class="block graph-block mb-4">
                            <div class="graph-big-text mb-4">
                                <p class="graph-label">App Sessions</p>
                                <h4 class="graph-value"><?php echo $todaySessions; ?></h4>
                            </div>
                            <div class="graph-pills today-text">
                                <?php echo date( 'd M Y, D, g:i A', $time); ?>
                            </div>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <canvas id="sessionAanalyticsChart" height="100"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 col-md-3 col-lg-3">

                        <div class="section-title">
                            <h4>Orders Chart</h4>
                        </div>

                        <div class="block chart-block mb-4">

                            <div class="doughnut-chart mb-3">
                                <div class="inside-doughnut-chart-label">
                                    <strong><?php echo $totalRequests; ?></strong>
                                    <span>Total Orders</span>
                                </div>
                                <canvas id="ordersChart" class="chart"></canvas>
                            </div>

                            <div class="chart-legends">
                                <div class="legend-value-w">
                                    <div class="legend-pin" style="background-color: var(--warning-color)"></div>
                                    <div class="legend-value">Processing</div>
                                </div>
                                <div class="legend-value-w">
                                    <div class="legend-pin" style="background-color: var(--light-color)"></div>
                                    <div class="legend-value">Pending</div>
                                </div>
                                <div class="legend-value-w">
                                    <div class="legend-pin" style="background-color: var(--success-color)"></div>
                                    <div class="legend-value">Completed</div>
                                </div>
                                <div class="legend-value-w">
                                    <div class="legend-pin" style="background-color: var(--danger-color)"></div>
                                    <div class="legend-value">Rejected</div>
                                </div>
                            </div>

                        </div>
                    </div>
					

                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="block table-block mb-4">
                            <div class="block-heading d-flex align-items-center" style="border:0; padding-bottom: 0;">
                                <h5 class="text-truncate">Recently Registerd Users</h5>
                            </div>
                            <div class="custom-scroll table-responsive" style="max-height: 250px;">
                                <div class="table-responsive text-no-wrap">
                                    <table class="display table table-striped" class="table" >
										<thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Fullname</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-middle">
										<?php
										
											$recent5users = $stats->getRecentAccounts();
											$recent5users_loaded = count($recent5users['users']);
											$recentUsersCounter = 1;
											
											if ($recent5users_loaded != 0) {
												
												foreach ($recent5users['users'] as $key => $value) {
													drawRecentUsers($value,$recentUsersCounter);
													$recentUsersCounter ++;
												}
											}
										?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
					
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="block table-block mb-4">
                            <div class="block-heading d-flex align-items-center" style="border:0; padding-bottom: 0;">
                                <h5 class="text-truncate">Recent Requests</h5>
                            </div>
                            <div class="custom-scroll table-responsive" style="max-height: 250px;">
                                <div class="table-responsive text-no-wrap">
                                    <table class="display table table-striped" class="table" >
                                        <tbody class="text-middle">
                                        <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Giftname</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-middle">
										<?php
										
											$recent5Requests = $requests->recentRequests();
											$recent5Requests_loaded = count($recent5Requests['requests']);
											
											if ($recent5Requests_loaded != 0) {
												
												foreach ($recent5Requests['requests'] as $key => $value) {
													drawRequests($value);
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

<!--- JS Variables  -->
<script type="text/javascript">
var pending = <?php echo $pendingRequests; ?>;
var processing = <?php echo $processingRequests; ?>;
var rejected = <?php echo $rejectedRequests; ?>;
var completed = <?php echo $completedRequests; ?>;
var sessionsjsondata = '<?php echo json_encode($sessionsdata); ?>';
</script>

<!--- Custom Chart JS  -->
<script src="./assets/js/custom-chart.js"></script>

</body>
</html>
<?php

    function drawRecentUsers($user,$counter)
    {
	?>
		<tr>
            <td class="text-left"><?php echo $counter; ?></td>
            <td><?php echo $user['fullname']; ?></td>
			<?php if (!APP_DEMO) { ?><td><?php echo $user['email']; ?></td><?php }else{ ?><td data-toggle="tooltip" data-original-title="Not Available in the Demo Version">xxxxx@xxxxx.xxx</td><?php } ?>
            <td><a href="user-details.php?id=<?php echo $user['id']; ?>" class="btn btn-primary btn-small">View</a></td>
        </tr>
	<?php
    }

    function drawRequests($request)
    {
	?>
		<tr>
            <td><?php echo $request['username']; ?></td>
            <td><?php echo $request['gift_name']; ?></td>
            <td><?php echo $request['req_amount']; ?></td>
			<?php if($request['status'] == 1){ ?>
				<td><a href="requests.php"><span class="badge badge-pill bg-success">Completed</span></a></td><?php	
			}else if($request['status'] == 2){ ?>
				<td><a href="requests.php"><span class="badge badge-pill bg-warning">Processing</span></a></td><?php	
			}else if($request['status'] == 3){ ?>
				<td><a href="requests.php"><span class="badge badge-pill bg-danger">Rejected</span></a></td><?php	
			}else{ ?>
				<td><a href="requests.php"><span class="badge badge-pill bg-warning">Pending</span></a></td><?php	
			}
			?>
        </tr>
	<?php
    }
?>