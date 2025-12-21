<?php

    /*!
	 * POCKET v3.4
	 *
	 * http://www.droidoxy.com
	 * support@droidoxy.com
	 *
	 * Copyright 2019 DroidOXY ( http://www.droidoxy.com )
	 */
	 
	$pagename = 'pending-requests';
	$container = 'redeem-requests';
	
	include_once("core/init.inc.php");

    if (!admin::isSession()) {

        header("Location: index.php");
    }
	
    $requests = new requests($dbo);

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
                            <h4>Pending Requests</h4>
                        </div>
                    </div>
					<?php if(APP_DEMO) { include_once 'inc/demo-notice.php'; } ?>
					
					<!-- START MAIN CONTENT HERE -->
					
					<div class="col-12">
                        <div class="block bg-white table-block mb-4">
                            <div class="block-heading">
                                <h5>All Pending Requests</h5>
                                <p class="mt-2">Showing All Requests from the Users. You can Proccess the Request, Reject the Request (or) Search for the Request.</p>
                            </div>

                            <div class="row">
                                <div class="table-responsive">
                                    <table id="dataTable1" class="display table table-striped" data-table="data-table">
                                        <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>User</th>
                                            <th>Requested To</th>
                                            <th>Gift Name</th>
                                            <th>Amount</th>
                                            <th>Points Used</th>
                                            <th>Device Name</th>
                                            <th>Model No.</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
										
										<?php
										
											$result = $requests->getRequests(0);
											$requests_loaded = count($result['requests']);
											
											if ($requests_loaded != 0) {
												
												foreach ($result['requests'] as $key => $value) {
												    
												    if($value['status'] == 0){
												        draw($value);
												    }
													
												}
											}
										?>
										
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <!----- Requests Modal ----->
                            <div aria-hidden="true" aria-labelledby="requestsModel" class="modal fade" id="requestsModel" role="dialog" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="requestModalTitle">Add Some Note ?</h5>
                                            <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> ×</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <form name="form_request" id="form_request" action="process/complete.php" method="post" role="form" data-toggle="validator">
                                                <input id="requestId" type="text" value="" name="id" hidden>
                                                <input id="requestType" type="text" value="" name="type" hidden>
                                                <div class="form-group">
                                                    <label>A Note for the User</label>
                                                    <textarea id="requestNote" class="form-control" placeholder="" name="note" type="text" maxlength="100" required="true"></textarea>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-dismiss="modal" type="button"> Close</button>
                                            <button id="requestModalBtn" class="btn btn-primary" onclick="doRequest()" type="submit" value="submit">OK</button>
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

<script>
    
    function doRequest() {
        document.getElementById("form_request").submit();
    }

    function processRequest(type, rid){
        
        document.getElementById("requestId").value = rid;
        document.getElementById("requestType").value = type;
        
        var requestNotePlaceHolder = 'This is a fraud request';
        
        var requestModalTitle = 'Add Some Note ?';
        var requestModalBtn = 'OK';
        
        if(type == 'complete'){
            
            requestNotePlaceHolder = "Payment Reference like TransactionId or something";
            
            requestModalTitle = 'Request Processed ?'
            requestModalBtn = "Mark as Completed";
            
        }else if('process'){
            
            requestNotePlaceHolder = "you'll get your reward within 2 days";
            
            requestModalTitle = 'Move Request to Processing ?'
            requestModalBtn = "Mark as Processing";
            
        }else if('reject'){
            
            requestNotePlaceHolder = "We do not allow fake referrals";
            
            requestModalTitle = 'Reject this Request ?'
            requestModalBtn = "Mark as Rejected";
            
        }
        
        $('#requestNote').attr('placeholder',requestNotePlaceHolder);
        document.getElementById("requestModalTitle").innerHTML = requestModalTitle;
        document.getElementById("requestModalBtn").innerHTML = requestModalBtn;
        
        
        $('#requestsModel').modal('show');
        
    }

</script>

</body>
</html>
<?php

	function draw($request)
    {
	?>
		<tr>
            <td class="text-left"><?php echo $request['rid']; ?></td>
            <td><?php echo $request['username']; ?></td>
			<?php if (!APP_DEMO) { ?><td><?php echo $request['request_from']; ?></td><?php }else{ ?><td data-toggle="tooltip" data-original-title="Not Available in the Demo Version">xxxxxxxx</td><?php } ?>
            <td><?php echo $request['gift_name']; ?></td>
            <td class="price"><?php echo $request['req_amount']; ?></td>
            <td class="price"><?php echo $request['points_used']; ?></td>
            <td><?php echo $request['dev_name']; ?></td>
            <td><?php echo $request['dev_man']; ?></td>
            <td class="date"><?php $timestamp = strtotime($request['date']); echo date('d M Y, D',$timestamp); ?></td>
            <td>
                <a href="tracker.php?user=<?php echo $request['username']; ?>" class="btn btn-primary btn-small"><i class="dripicons-graph-line"></i>Track</a>
                <a href="#" onclick="processRequest('process','<?php echo $request['rid']; ?>')" class="btn btn-warning btn-small"><i class="dripicons-clock"></i>Processing</a>
                <a href="#" onclick="processRequest('reject','<?php echo $request['rid']; ?>')" class="btn btn-danger btn-small"><i class="dripicons-cross"></i>Reject</a>
                <a href="#" onclick="processRequest('complete','<?php echo $request['rid']; ?>')" class="btn btn-success btn-small"><i class="dripicons-checkmark"></i>Complete</a>
            </td>
        </tr>
	<?php
    }
?>