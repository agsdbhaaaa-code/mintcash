<?php

    /*!
	 * POCKET v3.4
	 *
	 * http://www.droidoxy.com
	 * support@droidoxy.com
	 *
	 * Copyright 2019 DroidOXY ( http://www.droidoxy.com )
	 */

	$pagename = '';
	$container = '';
	
	include_once("core/init.inc.php");

    if (!admin::isSession()) {

        header("Location: index.php");
    }

    $accountInfo = array();

    if (isset($_GET['id'])) {

        $accountId = isset($_GET['id']) ? $_GET['id'] : 0;
        $accessToken = isset($_GET['access_token']) ? $_GET['access_token'] : 0;
        $act = isset($_GET['act']) ? $_GET['act'] : '';

        $accountId = helper::clearInt($accountId);

        $account = new account($dbo, $accountId);
        $accountInfo = $account->get();

        if ($accessToken === admin::getAccessToken() && !APP_DEMO) {

            switch ($act) {

                case "close": {

                    $auth->removeAll($accountId);

                    header("Location: user-details.php?id=".$accountInfo['id']);
                    break;
                }

                case "block": {

                    $account->setState(ACCOUNT_STATE_BLOCKED);

                    header("Location: user-details.php?id=".$accountInfo['id']);
                    break;
                }

                case "rem": {

                    $account->remAccount($accountId);

                    header("Location: users.php");
                    break;
                }

                case "unblock": {

                    $account->setState(ACCOUNT_STATE_ENABLED);

                    header("Location: user-details.php?id=".$accountInfo['id']);
                    break;
                }

                default: {

                    header("Location: user-details.php?id=".$accountInfo['id']);
                    exit;
                }
            }
        }

    } else {

        header("Location: users.php");
    }

    if ($accountInfo['error'] === true) {

        header("Location: users.php");
    }

    $stats = new stats($dbo);

    $error = false;
    $error_message = '';

    helper::newAuthenticityToken();

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
                            <h4>Account info</h4>
                        </div>
                    </div>
					<?php if(APP_DEMO) { include_once 'inc/demo-notice.php'; } ?>
					
					<!-- START MAIN CONTENT HERE -->
					
					<div class="col-md-4">
                        <div class="block mb-4" style="box-shadow: 0 7px 15px var(--primary-alpha-Dot25); transition: all 0.3s;">
							<div class="user-profile-menu bg-white">
								<div class="avatar-info">
									<img class="profile-img rounded-circle" align="middle" src="assets/images/person-placeholder.png" alt="profile image" />
									<h4 class="name"><?php echo $accountInfo['fullname']; ?></h4>
									<p class="designation"><?php echo "Member Since : ". date("d M Y", $accountInfo['regtime']); ?></p>
								</div>
							</div>
							
						</div>
					</div>
					
                    <div class="col-md-8">
                        <div class="block form-block mb-4">
                            <div class="block-heading">
                                <h5>Account info</h5>
                            </div>
								
                                <div class="form-group">
                                    <div class="form-row">
                                        <label class="col-md-3">Account state</label>
                                        <div class="col-md-9 price">
                                            <?php

                                            if ($accountInfo['state'] == ACCOUNT_STATE_ENABLED) {

                                                echo '<span class="badge badge-pill bg-success">Account is Active</span>';

                                            } else {
												
                                                echo '<span class="badge badge-pill bg-danger">Account is blocked</span>';
                                            }
                                        ?>
                                        </div>
                                    </div>
                                </div>

                            <form action="" class="horizontal-form" />
							
                                <div class="form-group">
                                    <div class="form-row">
                                        <label class="col-md-3">Username</label>
                                        <div class="col-md-9">
                                            <input class="form-control" type="text" value="<?php echo $accountInfo['username']; ?>" disabled/>
                                        </div>
                                    </div>
                                </div>
								
                                <div class="form-group">
                                    <div class="form-row">
                                        <label class="col-md-3">email</label>
                                        <div class="col-md-9">
                                            <input class="form-control" type="text" value="<?php if (!APP_DEMO) { echo $accountInfo['email']; }else{ echo "xxxxx@xxxxx.xxx"; } ?>" disabled/>
                                        </div>
                                    </div>
                                </div>
								
                                <div class="form-group">
                                    <div class="form-row">
                                        <label class="col-md-3">Points Balance</label>
                                        <div class="col-md-9">
                                            <input class="form-control" type="text" value="<?php echo $accountInfo['points']; ?>" disabled/>
                                        </div>
                                    </div>
                                </div>
								
                                <div class="form-group">
                                    <div class="form-row">
                                        <label class="col-md-3">SignUp Ip address</label>
                                        <div class="col-md-9">
                                            <input class="form-control" type="text" value="<?php if (!APP_DEMO) { echo $accountInfo['ip_addr']; }else{ echo "xxx.xxx.xxx.xx"; } ?>" disabled/>
                                        </div>
                                    </div>
                                </div>

                                <hr />

                            </form>
                                <div class="ticket_controls">
                                    <?php

                                        if ($accountInfo['state'] == ACCOUNT_STATE_ENABLED) {

                                            ?>
                                                <a class="btn btn-danger" style="float: right; margin-top: 2%;" href="user-details.php?id=<?php echo $accountInfo['id']; ?>&access_token=<?php echo admin::getAccessToken(); ?>&act=block">Block account</a>
                                            <?php

                                        } else {

                                            ?>
                                                <a class="btn btn-warning" style="float: right; margin-top: 2%;" href="user-details.php?id=<?php echo $accountInfo['id']; ?>&access_token=<?php echo admin::getAccessToken(); ?>&act=unblock">Unblock account</a>
                                            <?php
                                        }
                                    ?>

                                    <a class="btn btn-primary" style="margin-top: 2%;" href="user-details.php?id=<?php echo $accountInfo['id']; ?>&access_token=<?php echo admin::getAccessToken(); ?>&act=close">Close all authorizations</a>
                                   

                                    <button class="btn btn-success" style="margin-top: 2%;" data-target="#addPoints" data-toggle="modal">Add Points</button>
                                   
                                    <a class="btn btn-danger" style="float: right; margin-right: 2.5%; margin-top: 2%;" href="user-details.php?id=<?php echo $accountInfo['id']; ?>&access_token=<?php echo admin::getAccessToken(); ?>&act=rem">Delete User</a>
                                </div>
                                <!----- Add Points Modal ----->
                                <div aria-hidden="true" aria-labelledby="addPoints" class="modal fade" id="addPoints" role="dialog" tabindex="-1">
    								<div class="modal-dialog modal-dialog-centered" role="document">
    									<div class="modal-content">
    										<div class="modal-header">
    											<h5 class="modal-title">Add Points to <?php echo $accountInfo['fullname']; ?></h5>
    											<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
    										</div>
    										<div class="modal-body">
    											<form name="form_add_points" id="form_add_points" action="process/add-points.php" method="post" role="form" data-toggle="validator">
    												<input type="text" value="<?php echo $accountInfo['id']; ?>" name="id" hidden>
    												<input type="text" value="<?php echo $accountInfo['username']; ?>" name="user" hidden>
    												<div class="form-group">
    													<label> Points to Add</label>
    													<input class="form-control" placeholder="50" type="number" name="points_to_add" required="true" required>
    												</div>
    												<div class="form-group">
    													<label> Reason for Adding Points</label>
    													<input class="form-control" placeholder="Manual Admin Credit" name="reason_for_adding_points" type="text" maxlength="60" required="true">
    												</div>
    											</form>
    										</div>
    										<div class="modal-footer">
    											<button class="btn btn-secondary" data-dismiss="modal" type="button"> Close</button>
    											<button class="btn btn-primary" onclick="add_points()" type="submit" value="submit"> Add Points</button>
    										</div>
    									</div>
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

<!-- Notify JS-->
<script type="text/javascript" src="./assets/js/bootstrap-notify.min.js"></script>

<script>
    function add_points() {
        document.getElementById("form_add_points").submit();
   }
   
   <?php  $_SESSION["points_added"] = isset($_SESSION["points_added"]) ? $_SESSION["points_added"] : '0';
   
   if($_SESSION["points_added"] == 1){ $_SESSION["points_added"] = 0; ?>
   
   $.notify({
	    // options
	    message: ' Points Added Successfully',
	    icon: 'dripicons-checkmark'
	    
    },{
    	// settings
    	type: 'success'
    });
       
   <?php }else if($_SESSION["points_added"] == 2){ $_SESSION["points_added"] = 0; ?>
   
   $.notify({
	    // options
	    title: ' Points Not Added',
	    message: ' There was some issue for adding points, Try Again',
	    icon: 'dripicons-cross'
	    
    },{
    	// settings
    	timer: 10,
		enter: 'animated fadeInDown',
		exit: 'animated fadeOutUp',
    	type: 'danger'
    });
       
   <?php } ?>
   
</script>

</body>
</html>