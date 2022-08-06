<?php 
	error_reporting(0); require "connector.php";
	require("bible_to_sql.php");
	@session_start(); 
?>
	
<!DOCTYPE html>
<html lang="en">
	<head>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" /> 
	<link rel="stylesheet" href="assets/css/bootstrap-datepicker.css" /> 
	
	<link rel="stylesheet" href="assets/css/styles.css" /> 
	<link rel="shortcut icon" href="imgs/icon.jpg">
	<link rel="stylesheet" href="assets/fontawesome/css/all.min.css" /> 
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/jquery-ui-1.12.1/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="assets/alertifyjs/css/alertify.min.css">	
	<link rel="stylesheet" href="assets/alertifyjs/css/themes/bootstrap.min.css">
	<title>Bible Search</title>
		<meta charset="utf-8" />	
	</head>
	
	
	<body> 
		
		<div class="row ">
		
				<div class="col-md-12 offset-0 col-sm-12"  style="background-color:#FFF; height:auto;">					 
										
					<div class="card" style="">		
						<div class="card-header"><h2>MESSAGE NOTES </h2></div>
						<div class="card-body ">
							<div class="row ">    
							
								<div class="col-md-12 offset-0 col-sm-12"> 
									 	<table class="table table-borderd table-sm table-striped">
											<thead>	<tr class="table-dark text-dark">
												<th> SN </th>
												<th> DATE </th>
												<th> TOPIC </th>
												<th> SCRIPTURES </th>
												<th> NOTES </th>
												<th> PREACHER </th>
												
											</tr>
											</thead>
											<tbody class="post-list"> <?php $table = "messages"; ## $mydbm = new DbController();
													$total_count = $mydbm->num_rows("SELECT * FROM $table WHERE status='active'"); 													
													$notes = $mydbm->runBaseQuery("SELECT * FROM $table ORDER BY sn DESC LIMIT 10");
													?> <input type="hidden" name="total_count" id="total_count" value="<?php echo $total_count; ?>" />
													<?php if(!empty($notes)) foreach($notes as $k=>$v){ ?>
												<tr class="post-item" id="<?php echo $notes[$k]['sn']; ?>"> 
													<th> <?php echo $k+1; ?>  <?php # echo $notes[$k]['sn']; ?> </th>
													<td> <?php echo date('l, F d, Y',strtotime($notes[$k]['date_c'])); ?></td>
													<td> <?php echo $notes[$k]['topic']; ?> </td>
													<td> <?php $bb = explode("**",$notes[$k]['bible_ref']); echo implode("<br/>",$bb); ?> </td>
													<td> <?php echo htmlspecialchars_decode($notes[$k]['messages']); ?> </td>
													<td> <?php echo $notes[$k]['preacher']; ?> </td>
												</tr>
												<?php  }
												else {  ?>
														<tr> 													 
														<th colspan="7" class="text-danger" > EMPTY RECORDS </th>													 
												</tr>
												<?php };?>
											</tbody>
										</table>
										 
									
								</div> <!-- ./ col-md-12  -->
								<div class="col-md-6 offset-3 pb-4 mb-4">
									<div class="ajax-loader text-center">
										<span class="fa fa-spin fa-spinner fa-3x"> </span> Loading More Notes...
									</div>
								</div>
								</div><!-- ./ row  -->
						</div> <!-- ./ card-body  -->						
					</div>  <!-- ./ card  -->
		
			</div> <!-- ./ col-md-12-->
			</div> <!-- ./ row -->
			
	</body>
	
	<!-- 
	<footer class="footer bg-dark" style="position:absolute; bottom:30px; left:0px; ">
		 
		<div class="mt-2 mb-5 pt-3 pb-5" style="width:100%; text-align:center">
		<span class="text-white d-block text-center text-sm-left d-sm-inline-block font-16"> Copyright © 2021 &nbsp;    End-Time Message Believers Ministry, Ilorin Church, Kwara State
		  <a href="https://facebook.com/mayorjo4ever" target="_blank"> : mayorjo4ever </a>. All rights reserved. </span>						 
		</span>
	  </div>  
	</footer> -->
	
	<?php require "modal.php"; ?>
	
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<script src="assets/js/bootstrap-datepicker.js"></script>
	<script src="assets/js/script.js"></script>
	<script src="assets/fontawesome/js/all.min.js"></script>
	<link rel="stylesheet" href="assets/fontawesome/css/all.min.css" /> 
	<link rel="stylesheet" href="assets/jquery-ui-1.12.1/jquery-ui.min.css" /> 
	<script src="assets/alertifyjs/alertify.min.js"></script>
	
	
	<script type="text/javascript">
	$(document).ready(function(){
			windowOnScroll(); 
	});
	function windowOnScroll() {
		   $(window).on("scroll", function(e){  // alert('scrolling');
			if ($(window).scrollTop() >= ($(document).height() - $(window).height())-5){
				if($(".post-item").length < $("#total_count").val()) {
					var lastId = $(".post-item:last").attr("id");
					var lastIndex = $(".post-item").length;
					getMoreData(lastId,lastIndex);
				}
			}
			// console.log('window scrolltop - '+$(window).scrollTop()+', doc height: '+$(document).height()+', window height: '+$(window).height());
			// console.log( 'diff: '+$(window).scrollTop()+' / '+($(document).height() - $(window).height()));
		});
	}

	function getMoreData(lastId,lastIndex) {
		   $(window).off("scroll");
			$.ajax({  url: 'ajax.php', type: "post",
			data:{getMoreNotes:'',lastId:lastId, lastIndex:lastIndex }, 
			beforeSend: function ()
			{
				$('.ajax-loader').show(); // console.log('lastId='+lastId);
			},
			success: function (data) {
				 setTimeout(function() {
					$('.ajax-loader').hide();
					$(".post-list").append(data);
					windowOnScroll();
				  }, 1000);
			}
	   });
	}
	</script>

	
</html>
