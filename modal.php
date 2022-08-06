 
<!-- Modal HTML -->
  <!-- Dummy Modal Starts -->
	<div class="modal demo-modal" id="_settings">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title bold"> Settings  &nbsp; <i class="fa fa-cog "></i></h5>
			<button type="button" class="close" data-dismiss="modal">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<div class="row ">   
				<div class="col-md-12 col-lg-12 col-sm-12"> 
					 
					<div class="form-group row">
					 
						<label class="col-md-3 offset-1 font-weight-bold"> Text Font Size </label> 
						 
							<div class="font_slide col-md-7" style="width:658px">
								<div id="custom-handle" class="ui-slider-handle"></div>
							</div>
						  
					</div>  
					<div class="clearfix"></div> <hr/>
					
					<div class=" row"> 	 	  
							<table class="table-sm" style="margin-left:12%"> <tr class="">  <td> <label class="switch"> 
							  <input type="checkbox" id="tts" value="yes" checked> 
							  <span class="slider round"></span>
							</label>	
							</td> <td>   <strong> Enable Text To Speech </strong> </td></tr></table>		
					</div>  
					<div class="clearfix"></div>
					<div class="row"> 
								<div class="col-md-8 ml-5 pl-5 mb-3 font-weight-bold">
										Select Voice 
										<select id="voices" class="form-control text-dark"></select>
									</div>
								<div class="d-flex ml-5 pl-5">
									
									  <div class=" ">
										<p class="lead">Volume</p>
										<input type="range" min="0" max="1" value="1" step="0.1" id="volume" />
										<span id="volume-label" class="ms-2">1</span>
									  </div>
									  <div class="mx-5  ">
										<p class="lead">Rate</p>
										<input type="range" min="0.1" max="10" value="1" id="rate" step="0.1" />
										<span id="rate-label" class="ms-2">1</span>
									  </div>
									  <div class=" ">
										<p class="lead">Pitch</p>
										<input type="range" min="0" max="2" value="1" step="0.1" id="pitch" />
										<span id="pitch-label" class="ms-2">1</span>
									  </div>
									 </div>
								</div>
								<div class="row">
									 <div class="mb-5 ml-5 pl-5">
										   <button id="start" class="btn btn-primary mt-5 me-3"> <i class="fa fa-play "></i></button>
										  <button id="pause" class="btn btn-warning mt-5 me-3"><i class="fa fa-pause "></i></button>
										  <button id="resume" class="btn btn-info mt-5 me-3"> Resume</button>
										  <button id="cancel" class="btn btn-danger mt-5 me-3"><i class="fa fa-stop "></i></button>
										</div>
								
								</div>
					<!--
					<div class="form-group float-left">
						<label class="switch"> 
						  <input id="ref_auto_save" type="checkbox" value="yes" checked> 
						  <span class="slider round"></span>
						</label> &nbsp; &nbsp;  <span class="small"> <strong> <i> Auto-Save References  when searched</i></strong> </span>
					</div> -->
				</div>
								
			
			</div>
		  </div>
		  <div class="modal-footer">			
			<button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
		  </div>
		</div>
	  </div>
	</div>
	<!-- Dummy Modal Ends -->
	
	<div class="modal demo-modal" id="_notes">
	  <div class="modal-dialog modal-xl" style="width:100%">
		<div class="modal-content">
		  <div class="modal-header bg-light">
			<h5 class="modal-title bold"> Message Note [ <span class="current_id">1</span> ] 
				<!-- &nbsp; &nbsp; <button class="btn btn-icons btn-danger" ><i class="fa fa-plus"></i> New Notes </button> -->
				&nbsp; &nbsp; <span class="btn btn-icons btn-info" data-toggle="modal" data-target="#_note_preliminaries"><i class="fa fa-info-circle"></i>  Set Message Info </span> 
				</h5>
			<button type="button" class="close" data-dismiss="modal">
			  <span aria-hidden="true" class="text-danger">&times;</span>
			</button>
		  </div>
		  <div class="modal-body "> 
			  <div class="row">
				<div class="col-md-4 ">
					<h4  > <u> Bible References </u> &nbsp; <i class="fa fa-book pointer" onclick="get_bible_passage('.bible_ref')"></i> </h4> 
					<div class="bible_ref"></div>
				</div><!-- ./ col-md-12 -->
			 
				<div class="col-md-8  ">
					<h4> Notes  </h4> 
					<div class="">
					<textarea class="form-control note_messages" rows="10"></textarea>
					</div>
				</div><!-- ./ col-md-12 -->
			 </div><!-- ./ row -->
			 <hr/>
			 <div class="row">
				 
				<div class="col-md-12  "> 
					 <p style="font-size:16px;">  <b> Message Info : </b>
						Date:&nbsp;<span class="date bold"></span> &nbsp; -
						Preacher:&nbsp;<span class="preacher bold"></span> &nbsp; -
						Topic:&nbsp;<span class="topic bold"></span> &nbsp; -
						Note Title:&nbsp;<span class="note-title bold"></span>  
						
					 </p>
				</div><!-- ./ col-md-12 -->
			 </div><!-- ./ row -->
			 
			 
		  </div>
		  <div class="modal-footer bg-light">
			 
				<div class="col-md-6">
					<button type="button" class="btn btn-dark float-left" onclick="open_notes()">View All Notes  <i class="badge badge-success "><span class="total_notes">0</span> </i></button>
				</div>
				
				<div class="col-md-6"> &nbsp; &nbsp; 
				<button type="button" class="btn btn-secondary " data-dismiss="modal">Cancel &nbsp; <i class="fa fa-times"></i>&nbsp; </button>
				&nbsp; &nbsp; 
				<button type="button" class="btn btn-primary " onclick="save_message_draft()">Save & Continue &nbsp; <i class="fa fa-save"></i>&nbsp; </button>&nbsp; &nbsp;
				<button type="button" class="btn btn-success "  onclick="save_message_final()">Save & Finished &nbsp; <i class="fa fa-check"></i> &nbsp; </button>
				&nbsp; &nbsp; </div>
				
			</div>
			
		  
		</div>
	  </div>
	</div>  <!-- Ends Note Modal -->
	
	
	<div class="modal demo-modal" id="_note_preliminaries">
	  <div class="modal-dialog modal-md" >
		<div class="modal-content">
		  <div class="modal-header  bg-light">
			<h5 class="modal-title bold"> Message Informations </h5>
			<button type="button" class="close" data-dismiss="modal">
			  <span aria-hidden="true" class="text-danger">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			 <div class="row">
				<div class="col-md-12">
					<div class="form-group">
					<label class="control-label"> Date </label>
						<input type="text" class="form-control datepicker" value="<?php echo date('Y-m-d');?>" />
					</div>
				 
					<div class="form-group">
					<label class="control-label"> Preacher </label>
						<input type="text" class="form-control preacher"  value="Pastor " />
					</div>
				 
					<div class="form-group">
					<label class="control-label"> Topic </label>
						<input type="text" class="form-control topic"  value="" />
					</div>
				 
					<div class="form-group">
					<label class="control-label"> Note Title </label>
						<input type="text" class="form-control note-title"  value=""  />
					</div>
				</div><!-- ./ col-md-12 -->
			 </div><!-- ./ row -->
			  
			 
		  </div>
		  <div class="modal-footer  bg-light">
			  
				<button type="button" class="btn btn-light  " data-dismiss="modal">Cancel &nbsp;  <i class="fa fa-times"></i>  </button>
				&nbsp; &nbsp; 
				<button type="button" class="btn btn-info " onclick="addPreliminaries()"> Set Info  &nbsp; <i class="fa fa-info-circle"></i> </button>
				&nbsp; &nbsp; 
				
			</div> 
		  
		</div>
	  </div>
	</div>  <!-- Ends Note Modal -->