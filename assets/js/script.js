	
	$(function(){
			 
			 alertify.set('notifier','position', 'bottom-center');
			 alertify.set('notifier','delay', 6);
			 
			  $('textarea.note_messages').summernote({
				height: 200,
				tabsize: 1
			  });  
			 // send request to fetch all bible 
			 resize(); 
			 
			 // load_books($('.book_ref'));
			 
			 /** $('div.verse_ref p').on('click',function(){
				 $(this).css('font-weight','bold');
			 });
			 **/
			  
			  $('input.text-search').on('keyup',function(){
				search_text = $(this).val();  elem = $('.search_result'); 
				displayer = $('.num_list');  
				if(search_text.length >=1) {  $.ajax({	url: 'ajax.php', type: 'POST',
						data: {auto_search_bible_reference:"",keyword:search_text},			
						cache: false,
						beforeSend : function (){  console.log(' ffff '); }, 
						success:function(data){ 	displayer.show(); displayer.html(data); }
					}); 
					}
					else {
					displayer.hide(); 
				}
			});  
			/*****************/
						 
			 $('input.text-search').keypress(function (e) {
				 var key = e.which;
				 if(key == 13)  // the enter key code
				  {
					e.preventDefault(); elem = 'div.verse_ref'; texts = $(this).val(); 
					v = $('select#v').val(); 
					if(texts == ""){ alertify.error('No Scripture T o Read'); }
					else {readBookbySearch(texts,elem,v); }					
				  }
				}); 
				
				/***************************/
				$('button.read-book').on('click',function(e){
					e.preventDefault(); elem = 'div.verse_ref'; texts = $('input.text-search').val();
					v = $('select#v').val();
					if(texts == ""){ alertify.error('No Scripture To Read ' ); }
					else {readBookbySearch(texts,elem,v); }	
				});
				/***************************/
				
				$('button.search-book').on('click',function(e){
					e.preventDefault(); 
					elem = 'div.verse_ref'; texts = $('input.text-search').val();
					if(texts == ""){ alertify.error('No Text To Search');  }
					else {	searchBibleWords(texts,elem);  }					
				});
				/***************************/	 
				$('.datepicker').datepicker({
						// format : 'yyyy-mm-dd hh:ii:ss',
						 format : 'yyyy-mm-dd',						 
						 autoclose : true,
						 todayBtn:  1,
						 todayHighlight: 1,
					});
				/***************************/
				count_total_messages('span.total_notes');
				/***************************/
				     
				// manage font-size of bible verses 
				 var handle = $( "#custom-handle" );
				$('div.font_slide').slider({min:16, value:24, max:72,  orientation: "horizontal",					
					create: function() { handle.text( $( this ).slider( "value" ) );  },
					slide: function( event, ui ) { handle.text( ui.value );  $('div.verse_ref').css("font-size",ui.value+"px");  }
					});  // end slider 
			    $('div.verse_ref').css("font-size",$('div.font_slide').slider("option","value")+"px"); 
 
				/***** DETECT NEXT & PREVIOUS KEY STROKE *****************/
				$('body div.verse_ref').on('mouseover',function(){
					$(document).bind("keydown",function(e){
					  var key = e.keyCode || e.which; 
					  console.log("key code : "+key);  
					  // 37 = left arrow  , 38 = up arrow,  39 = right arrow,   40 = down arrow
					  if(key == 80 ){
						  $("button#pressPrev").click(); 
					  }
					  if(key == 78){
						  $("button#pressNext").click(); 
					  }
				  });
				}).on("mouseout",function(){
					$(document).unbind("keydown");
				});
				
				
				 
		}); // end jQuery 
		
		
		function load_books(elem){
			$.ajax({
				url: "ajax.php",
				type: "POST",
				data: { load_books:"all"},
				cache: false,
				beforeSend : function (){  console.log('fetching bibles'); }, 
				success: function(response) {
					elem.html(response);	$('div.chp_ref').html('');						
					}
			  }); 
			}
		
		
		
		function save_bible_passage(){ 
			passage = $('input.text-search').val(); 
			if(passage!=""){ $.ajax({
					url: "ajax.php", type: "POST",	data: { save_bible_passage:"this", passage:passage  },								
					cache: false, beforeSend : function (){  console.log('saving '+passage); }, 
					success: function(response) { alertify.success(response); 	}	 
				});  
				}
			}
		
		/********************************/
		
		function get_bible_passage(elem){ 			
			 $.ajax({
					url: "ajax.php", type: "POST",	data: { get_bible_passage:"all" },								
					cache: false, beforeSend : function (){  },       
					success: function(response) { 
						$(elem).html(response); 
						reload_saved_notes(); 
					}	 
				});  				
			}
		function reload_saved_notes(){
			 $.ajax({
					url: "ajax.php", type: "POST",	data: { reload_saved_notes:"all" },								
					cache: false, beforeSend : function (){  },       
					success: function(res) { 
						 // alert(res);
						 response = $.parseJSON(res);   // alert(response['bible_ref']);
						 $('span.preacher').html(response['preacher']); $('input.preacher').val(response['preacher']); 
						 $('span.date').html(response['date_c']); $('input.date').val(response['date_c']); 
						 $('span.topic').html(response['topic']); $('input.topic').val(response['topic']); 
						 $('span.note-title').html(response['note_title']); $('input.note-title').val(response['note_title']); 
						 $('textarea.note_messages').val(response['messages']);
						 //  [{"note_title":"Sunday School","messages":"","bible_ref":"Acts 19:1-6**John 3:16**Rom 5","finalized":"no","status":"active"}]
					}	 
				});  	
			}
			
		function open_notes(){
			url = "notes.php"; 
                        window.open(url);
		}
		
		/********************************/
		function load_chp(book_id,elem){
			 
				$.ajax({
					url: "ajax.php",
					type: "POST",
					data: { load_chapters:"all", book_id:book_id},
					cache: false,
					beforeSend : function (){  console.log(book_id); }, 
					success: function(response) {
						// alert(response); 
						$(elem).html(response); $('div.vs_ref').html('');				
					}
			  }); 

		}		
		/********************************/
		function load_vs(book_id, chapter, elem){
			 
				$.ajax({
					url: "ajax.php",
					type: "POST",
					data: { load_verses:"all", book_id:book_id, chapter:chapter },
					cache: false,
					beforeSend : function (){  console.log(book_id); }, 
					success: function(response) {
						// alert(response); 
						$(elem).html(response);							
					}
			  }); 

		}
		/********************************/
		function set_active_list(body,child){			
                 $(body + ' ul > li').removeClass('active');
                 $(child).addClass('active');    
				 console.log($(child)); 
		}
		/********************************/
		function setIds(texts,elem){ 
			// create ID for selected bible references 			
			$(elem).val(texts); 			
		}
		
		function show_verse(elem){
			id = $('#vid1').val()+$('#vid2').val()+$('#vid3').val();
			$.ajax({
					url: "ajax.php",type: "POST",data: { show_verse:"all", id:id  },					
					cache: false, beforeSend : function (){  console.log(id); }, 
					success: function(response) { $(elem).html(response);	}	 
				}); 
			  
			var scT = $('p.active'); var conT = $(elem); 			  
			conT.animate({ scrollTop:scT.offset().top - conT.offset().top + conT.scrollTop(),scrollLeft:0},0); 		
		}
		/********************************/
		function readBookbySearch(texts,elem,v = "t_kjv"){ 
			$.ajax({
					url: "ajax.php", type: "POST",	data: { read_text_verse:"all", book:texts ,v:v },								
					cache: false, beforeSend : function (){  console.log(texts); }, 
					success: function(response) { $(elem).html(response); 
					console.log(response);// $("div.versetext").html()
					}	 
				});   // tts();
			}
		/********************************/
		function searchBibleWords(texts,elem,v = "t_kjv"){ 
			$.ajax({
					url: "ajax.php", type: "POST",	data: { search_bible_words:"all", texts:texts,v:v  },							
					cache: false, beforeSend : function (){ $(elem).html('Searching, Plese Wait...'); }, 
					success: function(response) { $(elem).html(response);	}	 
				});  
			}
		/********************************/
		function addPreliminaries(){ 
			 $('span.date').html($('input.datepicker').val());
			 $('span.preacher').html($('input.preacher').val());
			 $('span.topic').html($('input.topic').val());
			 $('span.note-title').html($('input.note-title').val());
			}
		/********************************/	
		function delete_bible_ref(){
			 if(confirm("Do you want to delete all saved bible references ? ")){
				  $.ajax({
					url: "ajax.php", type: "POST",	data: { delete_bible_passage:"all" },								
					cache: false, beforeSend : function (){  },       
					success: function(response) {  get_bible_passage('.bible_ref');	}	 
				});  
			 }
		}
		/********************************/	
		function get_message_params(){
			
			var _notes = $('textarea.note_messages').val(); 
			var date = $('span.date').html();
			var preacher = $('span.preacher').html();
			var topic = $('span.topic').html();
			var note_title = $('span.note-title').html();
			
			return [date,_notes,preacher,topic,note_title]; 
			// return ['note':_notes,'date':date,'preacher':preacher,'topic':topic,'title':note_title]; 
		}
		
		function reset_message_params(){
			
			  $('textarea.note_messages').val(''); 
			  $('span.date').html('');
			  $('span.preacher').html('');
			  $('span.topic').html('');
			  $('span.note-title').html('');
			
			return [date,_notes,preacher,topic,note_title]; 
			// return ['note':_notes,'date':date,'preacher':preacher,'topic':topic,'title':note_title]; 
		}
		
		function  save_message_draft(){
			variables = get_message_params(); 
			   $.ajax({
					url: "ajax.php", type: "POST",	data: { save_message_as_draft:"all", variables:variables },								
					cache: false, beforeSend : function (){  },       
					success: function(response) { alertify.success(response); get_bible_passage('.bible_ref');	}	 
				});  
		}
		
		/********************************/	
		function  save_message_final(){
			variables = get_message_params();
			 if(confirm("Do you want to finalize your message notes ")){
				  
			  $.ajax({
					url: "ajax.php", type: "POST",	data: { save_message_as_final:"all", variables:variables },								
					cache: false, beforeSend : function (){  },       
					success: function(response) { alertify.success(response); reset_message_params(); get_bible_passage('.bible_ref');
					
					}	 
				});  
			 } // end if 
		}
		
		function count_total_messages(elem){ 			
			 $.ajax({
					url: "ajax.php", type: "POST",	data: { count_total_messages:"all" },								
					cache: false, beforeSend : function (){  },       
					success: function(response) { $(elem).html(response);	}	 
				});  				
			}
		
		
		function nextId(curId,maxId){
			curId = parseInt(curId); 
			maxId = parseInt(maxId); 
			
			if( curId < maxId ) {
				return curId+=1; 
			} 
			
			else return maxId;  
			
		}
		
		function prevId(curId,minId){
			curId = parseInt(curId); 
			minId = parseInt(minId); 
			
			if( minId < curId ) {
				return curId-=1;  
			}
			
			return minId; 
		}
		
		function setPrevId(curId,minId){
			newId = prevId(curId,minId);
			elem = $('input.text-search');  btn = $('button.read-book');
			script = elem.val().split(":") ; 
			newVerse = script[0]+":"+newId;
			elem.val(newVerse);  btn.click();  
		}
		
		function setNextId(curId,maxId){
			newId = nextId(curId,maxId);
			elem = $('input.text-search');  btn = $('button.read-book');
			script = elem.val().split(":") ; 
			newVerse = script[0]+":"+newId;
			elem.val(newVerse);  btn.click(); 
			// console.log(' new id : '+newId+' prev id: '+curVerse);  
		}
		
		 function set_bible_found(name,id) {
			// change input value
			$('input.text-search').val(name);
			 $('input.text-search').focus(); 				
			$('.num_list').hide(); elem = $('.disp_content');
		 }
			 
		function reset_verse(book, chapter){ btn = $('button.read-book');
			$('input.text-search').val(book+" "+chapter);
			btn.click(); 
		}
		
		function tts(){			
			$("#cancel").click();  
			if($("input#tts").prop('checked')){ 
			setTimeout(function(){ $("#start").click();},300);
			}
			
		}
	///////////////////////
	function resize(){
		 
	  }
	  

		

		// input.addEventListener('input', processInput);
	  
	  