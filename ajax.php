<?php error_reporting(0); require "connector.php";	require "bible_to_sql.php"; @session_start();	
	$glob_time = date('H:i:s',time()-3600);
	if(isset($_POST['save_bible_passage'])) {
		 $passage = $dbm->clean($_POST['passage']);		 
		 if(!isset($_SESSION['passages'])) $_SESSION['passages'] = array(); 
		 if(!in_array($passage,$_SESSION['passages'])) array_push($_SESSION['passages'],$passage);
		 #save to database
		 $psg = $_SESSION['passages']; 	 $psg = empty($psg)?"":implode("**",$psg);
		 
		 $data = array('bible_ref'=>$psg);
		 $table = "messages";
		 $exists = $dbm->select($table,array('finalized'=>'no')); 
		 if(empty($exists)){
			 $dbm->insert($table,$data); 
			 echo "Note Successfully saved ";
		 }
		 else {
			 $dbm->updateTb($table,$data,array('finalized'=>'no')); 
			 echo "Note Successfully Updated ";
		 } 
		  
	}
	/*********************************/
	if(isset($_POST['get_bible_passage'])) {
		if(isset($_SESSION['passages']))  {			
			$passages = array_map(function($text){
				if($text!="") return $text = "<li>".ucwords($text)."</li>";  
			},$_SESSION['passages']);
			echo "<ol style='line-height:2em;'>";
			foreach($passages as $text){
				echo $text;
			}
			echo "</ol>";
			echo "<span onclick='delete_bible_ref()' class='pointer text-danger' > &nbsp; &nbsp; &nbsp; Delete All &nbsp; &nbsp; <i class='fa fa-trash'> </i>  </span>"; 
		}  
		else echo "<ul><li class='text-danger'><span> No Saved Bible References  </span></li></ul>"; 
	}
	
	/*********************************/
	if(isset($_POST['reload_saved_notes'])) {
		  $cur_note = $dbm->select('messages',array('finalized'=>'no','status'=>'active'));
		  if(!empty($cur_note)) $cur_note = $dbm->getFields($cur_note,$mydal->tableFields('messages')); 
		   if(!empty($cur_note)) $_SESSION['passages'] = explode('**',$cur_note['bible_ref'][0]);
		   
		 echo json_encode($cur_note); 
	}
	/*********************************/
	if(isset($_POST['delete_bible_passage'])) {
		if(isset($_SESSION['passages']))  {
			unset($_SESSION['passages']); 
		} 
	}
	
	/*******/
	# save_message_as_draft:"all", variables:variables
	/*********************************/
	if(isset($_POST['save_message_as_draft'])) {
		 $passages = $_SESSION['passages']; 	 $passages = empty($passages)?"":implode("**",$passages);
		 $variables = $_POST['variables'];	// [date,_notes,preacher,topic,note_title]; 
		
		 $keys = array('date_c','messages','preacher','topic','note_title');
		 $data = array_combine($keys,$variables); 
		 $data = array_merge($data,array('bible_ref'=>$passages,'time_c'=>$glob_time));
		 $table = "messages";
		 $exists = $dbm->select($table,array('finalized'=>'no')); 
		 if(empty($exists)){
			 $dbm->insert($table,$data); 
			 echo "Note Successfully saved ";
		 }
		 else {
			 $dbm->updateTb($table,$data,array('finalized'=>'no')); 
			 echo "Note Successfully Updated ";
		 } 
	}
	
	
	# save_message_as_final:"all", variables:variables
	/*******/
	# save_message_as_draft:"all", variables:variables
	/*********************************/
	if(isset($_POST['save_message_as_final'])) {
		 $passages = $_SESSION['passages'];  $passages = empty($passages)?"":implode("**",$passages); 
		 $variables = $_POST['variables'];	// [date,_notes,preacher,topic,note_title]; 
		 $variables = array_map(function($text){ return htmlspecialchars($text); },$variables);
		 $keys = array('date_c','messages','preacher','topic','note_title');
		 $data = array_combine($keys,$variables); 
		 $data = array_merge($data,array('bible_ref'=>$passages,'finalized'=>'yes'));
		 $table = "messages";
		 $exists = $dbm->select($table,array('finalized'=>'no')); 
		 if(empty($exists)){
			 $dbm->insert($table,$data); 
			 echo json_encode(array('success',"Note Successfully Saved  and Finalized"));  unset($_SESSION['passages']);
		 }
		 else {
			 $dbm->updateTb($table,$data,array('finalized'=>'no')); 
			 echo json_encode(array('success',"Note Successfully Updated  and Finalized"));  unset($_SESSION['passages']);
		 } 
	}
		# count_total_messages:"all", 
	/*********************************/
	if(isset($_POST['count_total_messages'])) {
		 $table = "messages";
		 $total = $mydbm->num_rows("SELECT * FROM $table");
		 echo $total; 
	}
	
	
	function wordcount($text){
		return $counts = count(explode(" ",$text));
	}
	function resize($text){
		$counts = count(explode(" ",$text));
		$font = 80;
			switch($counts){
				case ($counts <= 10 ) : { $font = 110; } break;
				case ($counts <= 15 ) : { $font = 105; } break;
				#case ($counts <= 20 ) : { $font = 100; } break;
				case ($counts <= 20 ) : { $font = 90; } break;
				case ($counts <= 25 ) : { $font = 80; } break;
				case ($counts <= 30 ) : { $font = 75; } break;
				case ($counts <= 35 ) : { $font = 70; } break;				 
				case ($counts <= 40 ) : { $font = 65; } break;				 
				case ($counts <= 45 ) : { $font = 60; } break;				 
				case ($counts <= 50 ) : { $font = 55; } break;	
				case default : { $font = 60; } break;					
			}
			return $font;
		}
		
	
	if(isset($_POST['load_books'])) {
		 $books = $dbm->select('key_english',array(''));
		 echo "<ul style='list-style:none; margin:0em; padding:0em;'>";
		 if(!empty($books))foreach($books as $k=>$v){ 
			$id =  $books[$k]['b'];
		 ?>
			  <li onclick=" setIds('<?php echo addZeros($id,2); ?>','#vid1'),set_active_list('div.book_ref',this), load_chp('<?php echo $id; ?>','div.chp_ref')" class="pl-1"><?php echo $books[$k]['n']; ?></li>
			  <?php 
		 }
		 echo "</ul>"; 		 
	}
	
	/************************/
		
	if(isset($_POST['load_chapters'])) {
		 $book_id = $_POST['book_id'];
		 $chapters = $mydbm->runBaseQuery("SELECT DISTINCT MAX(c) as last from t_kjv WHERE b = $book_id ");		 
		 echo "<ul style='list-style:none; margin:0em; padding:0em;'>";
		 $len = range(1,$chapters[0]['last']); foreach($len as $ch) {
		 // $id =  $books[$k]['b'];
		 ?>
			<li onclick="setIds('<?php echo addZeros($ch,3); ?>','#vid2'), set_active_list('div.chp_ref',this), load_vs('<?php echo $book_id;?>','<?php echo $ch;?>','div.vs_ref')" class="pl-l"><?php echo $ch; ?></li>
			  <?php  
		 }
		 echo "</ul>"; 		 
	}
	/************************/
	
	# load_verses:"all", book_id:book_id, chapter:chapter
	if(isset($_POST['load_verses'])) {
		 $book_id = $_POST['book_id'];  $chapter = $_POST['chapter'];  
		 $verses = $mydbm->runBaseQuery("SELECT DISTINCT MAX(v) as last from t_kjv WHERE b = $book_id AND c = $chapter  ");		 
		 echo "<ul style='list-style:none; margin:0em; padding:0em;'>";
		 $len = range(1,$verses[0]['last']); foreach($len as $vs) {
		 // $id =  $books[$k]['b'];
		 ?>
			<li onclick="set_active_list('div.vs_ref',this), setIds('<?php echo addZeros($vs,3); ?>','#vid3'), show_verse('.verse_ref')" class="pl-1"><?php echo $vs; ?></li>
			  <?php  
		 }
		 echo "</ul>"; 		 
	}
	
	
	# show_verse:"all", id:id
	if(isset($_POST['show_verse'])) {
		 $id = $_POST['id'];  $table = "t_kjv";
		 $verses = $mydbm->runBaseQuery("SELECT * FROM $table WHERE id = $id ");		 
		
		if(!empty($verses)){  
			$bk = $verses[0]['b'];
			$ch = $verses[0]['c'];
			$vs = $verses[0]['v'];
			$text =  $verses[0]['t']; 
			
			# book name
			$bk_sql = $mydbm->runBaseQuery("SELECT n FROM key_english WHERE b = $bk "); 
			$bk_name = $bk_sql[0]['n'];
			
			#max verse
			$sql = $mydbm->runBaseQuery("SELECT DISTINCT MAX(v) as last from t_kjv WHERE b = $bk AND c = $ch  ");	
			$mxV = $sql[0]['last']; 
			
			$head =  " <h3> <b> $bk_name  $ch : $vs </b> </h3>"; 
			
			echo $head; 
			
			# show full scripture 
			
			for($i = 1; $i <= $mxV; $i++){
				
				$id = addZeros($bk,2)."".addZeros($ch,3)."".addZeros($i,3); 
				$newVerse = get_verse($id);
				$text = "<p> $i. ". $newVerse[0]['t'] ." </p>";
				
				if($i == $vs) $text = "<p class='active'><b> $text </b> </p> ";

				echo $text; 
			} 
			 
			}
			else { echo "Unknown Reference "; }
		}
	 
	 // read_text_verse:"all", book:texts 
	 if(isset($_POST['read_text_verse'])) {
		 $default_text = "";
		 $default_version = "t_kjv";
		//split at commas
		$refText = empty($_POST['book'])?$default_text:$_POST['book']; 
		$version = empty($_POST['v'])?$default_version:$_POST['v'];		
		$references = explode(",",$refText); 
		 
		#  echo $refText; 
		## search where the scripture is 
		foreach ($references as $r) {
													
				$ret = new bible_to_sql($r, NULL, $mysqli);
				// print "sql query: " . $ret->sql() . "<br />";
				// print_r($ret); 
				$book_id = $ret->getBookId();
				$curVerse = $ret->getVerse();
				$lastVerse = $ret->getLastVerse();
				$firstId = $ret->getFirstId(); 
				$curChapter = $ret->getChapter();
			  				
				 //echo "sql query: " . $ret->sql() . "<br />";
				 
				$sqlquery = "SELECT * FROM " . $version . " WHERE id = $firstId "; // . $ret->sql();
				$stmt = $mysqli->prepare($sqlquery);
				$stmt->execute();
				$result = $stmt->get_result();  
				if ($result->num_rows > 0) {
					//$row = $result->fetch_array(MYSQLI_NUM);
					//0: ID 1: Book# 2:Chapter 3:Verse 4:Text
					
					//print "<article><header><strong>{$ret->getBook()} {$ret->getChapter()} ${row[3]}</strong></header>";
					
					while ($row = $result->fetch_row()) { 
						$size = resize($row[4]);  $wc = wordcount($row[4]);
					 print " <div class=\"versetext tosize-$size\">${row[4]} </div> "; #<small> $wc = $size</small>
					}
					// print "</article>";
					
				} else {
					print "<span class='text-danger'>Did not understand your input. </span>";
				}
				$stmt->close();
			}
			$mysqli->close(); 
		## end search 		 
		
		?>
			
		<!--	<p>&nbsp; </p>  -->
			
		<div class="col-md-12 offset-0" id="">
			
			<div class="float-left " style="position:relative; left:1%; visibility:hidden;  ">
				<select class="btn btn-light btn-lg versions" id="v" onchange="$('button.read-book').click()">
				<?php $versions = $dbm->select('bible_version_key',array('')); 
				if(!empty($versions))foreach($versions as $k=>$v){ 
					$type =  $versions[$k]['table']; 	?>			
					<option value="<?php echo $type;?>" <?php echo ($type == $version)?"selected":""; ?>>  <?php echo $versions[$k]['version'];?> </option>
				<?php } ?>
				</select> 
			</div>
			
			<div class="float-left " style="position:relative; left:5%;  visibility:hidden; ">
				<select class="btn btn-light btn-lg books" onchange="reset_verse($(this).val(),$('select.chapters').val())">
				<?php $books = $dbm->select('key_english',array('')); 
				if(!empty($books))foreach($books as $k=>$v){ 
					$id =  $books[$k]['b']; $id = addZeros($id,2);	?>			
					<option value="<?php echo $books[$k]['n'];?>" <?php echo ($id == $book_id)?"selected":""; ?>>  <?php echo $books[$k]['n'];?> </option>
				<?php } ?>
				</select> 
			</div>
			
			<div class="float-left " style="position:relative; left:10%;  visibility:hidden;">
				<select class="btn btn-light btn-lg chapters" onchange="reset_verse($('select.books').val(),$(this).val())">
				<?php $chapters = $mydbm->runBaseQuery("SELECT DISTINCT MAX(c) as last from t_kjv WHERE b = $book_id ");
				$len = range(1,$chapters[0]['last']); foreach($len as $ch) {
					?>			
					<option value="<?php echo $ch;?>" <?php echo ($ch==$curChapter)?"selected":""; ?>>  <?php echo $ch;?> </option>
				<?php } ?>
				</select> 
			</div>
			
			<div class="float-left " style="position:relative; left:15%;  visibility:hidden; ">
			<span class="btn btn-dark btn-lg pull-right"> <?php echo intval($curVerse) . " of ". intval($lastVerse);; ?>  </span> 
			</div>
			
			
			<div class="float-left " style="position:absolute; left: 25%; ">
				<button id="pressPrev" class="btn btn-white btn-lg prev-verse"  onclick="setPrevId($(this).attr('data-text'),$(this).attr('min'))" data-text="<?php echo intval($curVerse);?>" min="1" ><i class="fa fa-chevron-left"></i></button> 
			</div>
			
			<div class="float-left  " style="position:absolute; left: 75%; font-size" >
				<button id="pressNext" class="btn btn-white btn-lg pull-right next-verse" onclick="setNextId($(this).attr('data-text'),$(this).attr('max'))" data-text="<?php echo intval($curVerse);?>" max="<?php echo intval($lastVerse);?>" > &nbsp; <i class="fa fa-chevron-right"></i> </button> 
			</div>
			<!--
			<div class="float-left  mb-2 pb-2" style="position:relative; left:23%; " >
				<button id="start" class="btn btn-primary btn-lg pull-right" >&nbsp; <i class="fa fa-play"></i> </button> 
			</div>-->
			
			
		 </div>
		<?php
	 }
	  
	 // search_bible_words :"all", texts:texts
	 if(isset($_POST['search_bible_words'])) {
		 $default_text = "";
		 $default_version = "t_kjv";  $table = "t_kjv";
		//split at commas
		 $refText = empty($_POST['texts']) ? $default_text : $dbm->clean($_POST['texts']); 		 
		 $version = empty($_POST['v']) ? $default_version : $dbm->clean($_POST['v']);		
		 $fields = $mydal->TableFields($table);
		 $booknames = $dbm->getFields($dbm->select('key_english',array('')),$mydal->TableFields('key_english')); 
		 $verses = $mydbm->runBaseQuery("SELECT * FROM $table WHERE t LIKE  '%$refText%' ");
		 $verses = empty($verses)?null:$dbm->getFields($verses,$fields);
		 $books = empty($verses)?null:array_unique($verses['b']);
		 # re_map the bible names
		 $bnk = $booknames['b']; $bnv = $booknames['n']; $newbiblename = array_combine($bnk,$bnv); 
		 
		 $bks = empty($books)?0:count($books); 
		 $vs = empty($verses)?0:count($verses['id']);
		 
		 echo "<small><i> found $vs verse(s) &nbsp; &nbsp; in &nbsp; &nbsp;  $bks book(s) </i>  </small> </br/></br/> "; 
		
		 $listed_books  = array(); 
		 $index = 0;	 
		 if(!empty($verses)) {  
			 foreach($verses['id'] as $bbid){
				 
				if(!in_array($verses['b'][$index], $listed_books)){
					$bbname = $newbiblename[$verses['b'][$index]]; 
					array_push($listed_books,$verses['b'][$index]);
					echo "<b>".$bbname ; echo "</b><hr style='margin:0em'/>";
				}  
					$chp = $verses['c'][$index]; 
					$vss = $verses['v'][$index]; 
					$txt = $verses['t'][$index]; 
					$txt = highlight($txt,$refText);
				 echo "<p> <b>".$chp.":</b>$vss &nbsp;".$txt." <small><i>(".$bbname.")</i></small> </p>";
				 
				 $index++;
			}
		 } 
		 else {
			 print "<span class='text-danger'> cannot find '$refText' </span>";
		 }
		 
		## end search 		 
	 }
	 
	 
	 if(isset($_POST['auto_search_bible_reference'])){ $dbm = new DbTool(); 
		$word = $dbm->clean($_POST["keyword"]); 
		if(!empty($word)) { 
			// $info = $dbm->regExpSearch('key_english', array('n'=>$word),array('n'), " ASC ",'10');
			$info = $dbm->regExpSearch('key_abbreviations_english', array('a'=>$word,'p'=>1),array('a'), " ASC ",'10');
			if(!is_null($info)) $info = $dbm->getFields($info,array('a','b')); 
			$tot = empty($info)?0:count($info['a']);
			 if(!is_null($info)){
			   $l=0; $m=0;
				  foreach($info['a'] as $ref) {
				## for($p = 1;$p<=10; $p++) {
					  $names = str_replace($word, "<b class='text-purple'>".$word."</b>", $ref);
				 ?>
				<li onclick="set_bible_found('<?php echo $ref." "; ?>','<?php echo $info['b'][$m]; ?>');">  <?php echo $names; ?></li>
				<?php 
					if($l>20) break; 
				  $l++; $m++;
			    	}
				} ## end not null 	
				else {
					echo "";
				}
			 }  // end not empty keyword 
		} ### end post 
	  
	 ## getMoreNotes:'',lastId:lastId
	  if(isset($_POST['getMoreNotes'])){ 
		$lastId = $dbm->clean($_POST["lastId"]); $lastIndex =$dbm->clean($_POST["lastIndex"]); $table = "messages";
		$notes = $mydbm->runBaseQuery("SELECT * FROM $table WHERE sn <  $lastId LIMIT 10");
		if(!empty($notes)){
			foreach($notes as $k=>$v){ ?>
				<tr class="post-item" id="<?php echo $notes[$k]['sn']; ?>"> 
					<th> <?php echo ++$lastIndex; ?>  <?php # echo $notes[$k]['sn']; ?> </th>
					<td> <?php echo date('l, F d, Y',strtotime($notes[$k]['date_c'])); ?></td>
					<td> <?php echo $notes[$k]['topic']; ?> </td>
					<td> <?php $bb = explode("**",$notes[$k]['bible_ref']); echo implode("<br/>",$bb); ?> </td>
					<td> <?php echo htmlspecialchars_decode($notes[$k]['messages']); ?> </td>
					<td> <?php echo $notes[$k]['preacher']; ?> </td>
				</tr>
			<?php } ## end foreach
		} ## end not empty
	  }
	
	function addZeros($input,$max) {
			$len = strlen($input); 
			for ($len; $len < $max; $len++) {
				$input = "0".$input;
			} 
			return  $input; 
		}
	 
	
	function get_verse($refId){ 
		 $mydbm = new DBController(); 
		 $table = "t_kjv";
		 $verse = $mydbm->runBaseQuery("SELECT * FROM $table WHERE id = $refId ");		 
		
		return empty($verse)?"Unknown Reference":$verse;
		
	}
	function highlight($astring,$aword){		
		return preg_replace('@\b('.$aword.')\b@si','<strong style="color:orange">$1</strong>',$astring);
	}
	
?>