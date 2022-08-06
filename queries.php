<?php error_reporting(0); require "connector.php";	require "bible_to_sql.php"; @session_start(); 	
	
	// print_r($_POST['oldbook']);
	/**
		Joṣua
		Onidajọ
		Ọba
		Ẹkún
		Iṣe
		Jakọbu
	**/
	// print_r($_POST['book']);
	if(isset($_POST['updateBB'])){
		$oldbook = $_POST['oldbook'];
		$book = $_POST['book']; 
		#######################
		$n = 1; $i = 0; 
		foreach($oldbook as $odbk){
			$nbk = htmlspecialchars($book[$i]);
			echo $dbm->updateTb("t_yoruba",array('n'=>$nbk, 'b'=>$n), array('n'=>$odbk));			
			# echo $dbm->runBaseQuery("UPDATE t_yoruba SET n=$nbk, b=$n WHERE n=$odbk");			
			
			  echo " <br/>";  # $nbk - $odbk 
			
			$n++; $i++; 
		}
	}
	

?><head>
	<link rel="stylesheet" href="../demos/bootstrap.min.css" /> 
	</head>
	
	<body>
	<div class="row"> <div class="col-lg-6 offset-2"> <form method="post">
	<?php echo "<table class='table'>";
		  
			$books = $mydbm->runBaseQuery("SELECT DISTINCT n,b FROM t_yoruba ");
			$allow_edit = "yes";
			foreach($books as $k=>$v){ 
				# echo "<p>".html_entity_decode($books[$k]['n'])."</p>";
				$name = $books[$k]['n']; 
				$id = $books[$k]['b']; 
				?>
				<tr> 					
									<td style=""> <?php echo $k+1; ?>  </td>
									<td style=""> <?php echo $id; ?>  </td>
									<td style=""> <?php echo $name; ?>  </td>
									<?php if($allow_edit == "yes" ) {?>
									<td> 
										<input type="hidden" name="oldbook[]"  value="<?php echo $name;?>" />
										<input type="text" name="book[]" class="form-control" value="<?php echo ucwords($name);?>"  style="min-width:500px; height:40px; font-size:20px" />
									</td>
									 
									<?php } // end $allow_edit ?>
								</tr>
			<?php }
			?>
			
			<tr>
				<td colspan="4"> <button type="submit" name="updateBB" data-text="<?php echo $name;?>"  class="btn btn-dark btn-rounded  btn-lg btn-block" > Update </button> </td> 
			</tr>
		  
		  
		  <?php echo "</table>"; ?>

			</form>
			
		</div>
	</div>
</body>