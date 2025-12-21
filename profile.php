<?php

    /*!
	 * POCKET v3.4
	 *
	 * http://www.droidoxy.com
	 * support@droidoxy.com
	 *
	 * Copyright 2019 DroidOXY ( http://www.droidoxy.com )
	 */


	$pagename = 'admin-profile';
	$container = 'settings';
	
	include_once("core/init.inc.php");
	
	$data = false;

    if (!admin::isSession()) {

        header("Location: index.php");
		
    }else if(!empty($_POST) && !APP_DEMO){
		
		$old_pass = $_POST['old_pass'];
		$new_pass = $_POST['new_pass'];
		$cnf_pass = $_POST['cnf_pass'];
		
		$data = true;
		
		$settings = new settings($dbo);
		$acid = admin::getAdminID();
		
		$result = $settings->changepass($acid, $old_pass, $new_pass, $cnf_pass);
		
		if($result == 420){
			
			$error = true;
			$error_message = "Admin Not Found";
			
		}elseif($result == 422){
			
			$error = true;
			$error_message = "New Password & Confirm Password do not Match";
			
		}elseif($result == 425){
			
			$error = true;
			$error_message = "Incorrect Old Password";
			
		}elseif($result == 424){
			
			$error = true;
			$error_message = "There was some issue changing the password";
			
		}elseif($result == 1){
			
			$error = false;
			$error_message = "Password Changed Successfully";
			
		}
		
	}
	
	$acid = admin::getAdminID();
	$configs = new functions($dbo);
	$configs->updateConfigs(time(),'LAST_ADMIN_ACCESS');

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
                            <h4>Admin Profile</h4>
                        </div>
                    </div>
					<?php if(APP_DEMO) { include_once 'inc/demo-notice.php'; } ?>
					
					<!-- START MAIN CONTENT HERE -->
					
					<div class="col-md-4">
                        <div class="block mb-4" style="box-shadow: 0 7px 15px var(--primary-alpha-Dot25); transition: all 0.3s;">
							<div class="user-profile-menu bg-white">
								<div class="avatar-info">
									<img class="profile-img rounded-circle" id="adminImage" align="middle" src="images/<?php echo $configs->getConfig('ADMIN_IMAGE'); ?>" alt="profile image" style="width: 168px; height: 168px;" />
									<h4 class="name"><?php echo $helper->getAdminFullName($acid); ?></h4>
									<p class="designation">Admin</p>
								</div>
							</div>
							
						</div>
					</div>
					
                    <div class="col-md-8">
                        <div class="block form-block mb-4">
                            <div class="block-heading">
                                <h5>Admin Details</h5>
                            </div>

                            <form action="process/profile.php" method="post" enctype="multipart/form-data" class="horizontal-form"/>
							
                                <div class="form-group">
                                    <div class="form-row">
                                        <label class="col-md-3">Admin Name</label>
                                        <div class="col-md-9">
                                            <input class="form-control" name="admin_name" placeholder="Full name" value="<?php echo $helper->getAdminFullName($acid); ?>" type="text" autocomplete="off" required=""/>
                                        </div>
                                    </div>
                                </div>
							
                                <div class="form-group">
                                    <div class="form-row">
                                        <label class="col-md-3">Admin Image</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input id="admin_image_name" class="form-control" type="text" name="admin_image_name" value="<?php echo $configs->getConfig('ADMIN_IMAGE'); ?>" placeholder="Choose Image" style="background: #e9ecef; " autocomplete="off" disabled/>
												<span class="input-group-addon text-dark"><label for="file-upload" class="custom-file-upload"><i class="ion-ios-folder"></i><span>Change Image</span></label>
													<input id="file-upload" onchange="readURL(this);" name="admin_image" accept="image/png, image/jpeg, image/jpg" type="file"/>
												</span>
											</div>
                                        </div>
                                    </div>
                                </div>

                                <hr />
                                <button class="btn btn-primary mr-0 pull-right" type="submit" value="upload">Update Details</button>
								<br><br>
                            </form>
                        </div>
						
                        <div class="block form-block mb-4">
                            <div class="block-heading">
                                <h5>Change Password</h5>
                            </div>
							
							<?php if ($data){ ?>
						
								<div class="alert <?php if($error){ echo "alert-danger"; }else{ echo "alert-success"; } ?>">
									<?php echo $error_message; ?>
								</div>
							
							<?php } ?>

                            <form action="" method="post" />
                                
                                <div class="form-group">
                                    <label>Old Password</label>
                                    <input class="form-control" placeholder="Old Password" type="password" name="old_pass" required=""/>
                                </div>
								
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>New Password</label>
                                        <input class="form-control" placeholder="New Password" type="password" name="new_pass" required=""/>
                                    </div>
									
                                    <div class="form-group col-md-6">
                                        <label>Confirm New Password</label>
                                        <input class="form-control" placeholder="Confirm New password" type="password" name="cnf_pass" required=""/>
                                    </div>
									
                                </div>

                                <hr />
                                <button class="btn btn-primary mr-0 pull-right" type="submit">Change Password</button>
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
<script type="text/javascript">


function readURL(input) {
	
	if (input.files && input.files[0]) {
		
		var reader = new FileReader();
		
		reader.onload = function (e) {
			$('#adminImage')
				.attr('src', e.target.result)
				.width(168)
				.height(168);
			};
		reader.readAsDataURL(input.files[0]);
		$('#admin_image_name').val(input.files[0].name);
		$('#admin_image_name').prop('disabled', false);
	}
}

</script>

</body>
</html>