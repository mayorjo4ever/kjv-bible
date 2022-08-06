<?php 
	error_reporting(0);  	
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
	<link rel="stylesheet" href="assets/summernote/summernote-lite.min.css">
	<title>Bible Search</title>
		<meta charset="utf-8" />	
	</head>
		
	<body style="max-height:600px;"> 
		
		<div class="row ">
		
				<div class="col-md-12 offset-0 col-sm-12"  style="background-color:#000; height:auto;">					 
					<header>
					<?php require "navbar.php"; ?>
					</header>
					
					<div class="card" style="top: 90px; border-bottom:0 solid #fff; "> 
					 
						<div class="card-body ">
							<div class="row ">    
							 <div class="col-md-4 offset-6 searching search_result" style="z-index:800;">
								 <div class="form-group offset-1 ">
									<ul class="num_list list-inline"></ul>
								 </div>	
							   </div> <!-- ./ form-group --> 
								
								<div class="col-md-12 offset-0 col-sm-12 mb-0 pb-0" >
									 	
										<div class="papa" style=" min-height:500px; height:auto; background:#; text-color:#000;  ">
										
										  <div class="verse_ref" ></div>
										 
										</div>
										
									</div> <!-- ./ ./ col-md-12  -->

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
	<script src="assets/js/jquery.fittext.js"></script>
	<script src="assets/fontawesome/js/all.min.js"></script>
	<link rel="stylesheet" href="assets/fontawesome/css/all.min.css" /> 
	<link rel="stylesheet" href="assets/jquery-ui-1.12.1/jquery-ui.min.css" /> 
	<script src="assets/alertifyjs/alertify.min.js"></script>
	<script src="assets/js/textToSpeech.js"></script>
	<script src="assets/summernote/summernote-lite.min.js"></script>
	
	
</html>
