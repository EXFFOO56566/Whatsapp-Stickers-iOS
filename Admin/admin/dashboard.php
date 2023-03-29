<?php

	/* Include the content of header */
	require_once('header.php');
	require_once('controller/dashboardController.php');
	
?>
        <div class="content">
            <div class="container-fluid">
			    <div class="row">
                    <div class="col-md-3">
                        <div class="card "> 
							<div class="header">
                                <h4 class="title">TOTAL SLIDER</h4>
                            </div>
							<hr>
                            <div class="content">
								<div class="dash-body">
									<div class="stats">
                                       <h4 class="value"><?php echo $slider_count; ?></h4>
                                    </div>	
								</div>
                            </div> 
                        </div>
                    </div>
					<div class="col-md-3">
                        <div class="card "> 
							<div class="header">
                                <h4 class="title">TOTAL CATEGORY</h4>
                            </div>
							<hr>
                            <div class="content">
								<div class="dash-body">
									<div class="stats">
                                       <h4 class="value"><?php echo $category_count; ?></h4>
                                    </div>	
								</div>
                            </div>
                        </div>
                    </div>
					<div class="col-md-3">
                        <div class="card "> 
							<div class="header">
                                <h4 class="title">TOTAL SUB-CATEGORY</h4>
                            </div>
							<hr>
                            <div class="content">
								<div class="dash-body">
									<div class="stats">
                                       <h4 class="value"><?php echo $sub_cat_count; ?></h4>
                                    </div>	
								</div>
                            </div>
                        </div>
                    </div>
					<div class="col-md-3">
                        <div class="card "> 
							<div class="header">
                                <h4 class="title">TOTAL WEBP STICKER</h4>
                            </div>
							<hr>
                            <div class="content">
								<div class="dash-body">
									<div class="stats">
                                       <h4 class="value"><?php echo $webp_sticker_count; ?></h4>
                                    </div>	
								</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php

	/* Include the content of footer */
	require_once('footer.php');

?>

<script type="text/javascript">
	$(document).ready(function(){

		// demo.initChartist();

		$.notify({
			icon: 'pe-7s-gift',
			message: "Welcome to <b>WA Sticker Dashboard</b>."

		},{
			type: 'info',
			timer: 4000
		});

	});
</script>