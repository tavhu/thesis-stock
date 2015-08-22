<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/jasny-bootstrap.css">
<title>Employee Profile</title>
<div class="container">
    <div class="row">
        <div class="under_line">
            <h3><i class='fa fa-user-plus'></i> Employee Profile </h3>
        </div>
    </div>
   <?php   
          echo validation_errors();
          $error = $this->session->flashdata('error');
          if (! empty($error) ) {
            echo $error;
          }     
          if (isset($success) ) {
               echo $success;
             }   
             $row = "";
          if ($this->uri->segment(3) == true) {
                $decode = $this->myencryption->decode($this->uri->segment(3));              
                $result = $this->db->get_where('employee',array('id'=>$decode));
                $row = $result->row();                
          }else{
              $inserted_id = $this->session->flashdata('inserted_id');
              if (!empty($inserted_id)) {
                $result = $this->db->get_where('employee',array('id'=>$inserted_id));
                $row = $result->row();   
              }
          }
    ?>
    <div class="row">    
        <div class="panel panel-default">
    		<div class='panel-heading'>
    			<h3 class='panel-title'><strong> <i class='fa fa-user'></i> <?php echo isset($row->id) ? "Edit Profile" : "Registeration"; ?></strong></h3>
    		</div>       	 	
    		<div class="panel-body">   
        <?php 
            $arr = array('role'=>'form', 'id'=>'registration-form');
            echo form_open_multipart('employee/create_employee_validation',$arr);    

        ?>       
    			<div class='form form-horizontal'>  
    					<div class="row">
                <div class="col-sm-9">
                  <div class='row'>
                      <div class='col-sm-6'>
                          <div class="form-group" style='border:1px'>
                                <label  for='fullname' class='control-label col-sm-4'>Full Name</label>  
                                <div class='col-sm-8'>
                                    <input type='text' name='fullname' value= "<?php echo isset($row->name) ? $row->name : set_value('fullname');?>" class='form-control' data-validation='required' >
                                </div>      
                          </div>
                      </div>
                      <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class='control-label col-sm-3'>Nick Name</label>
                                <div class='col-sm-8'>
                                   <input type='text' name='nickname' value= "<?php echo isset($row->nickname) ? $row->nickname : set_value('nickname');?>" class='form-control' data-validation='required' >
                                </div>  
                          </div>
                      </div>
                  </div>   
                   <div class="row">
                          <div class="col-sm-6">
                               <div class="form-group">
                                      <label for="email" class="col-sm-4 control-label">Email</label>
                                      <div class="col-sm-8">
                                          <input type="text" class="form-control" value ="<?php echo isset($row->email) ? $row->email : set_value('email');?>" name="email"  data-validation='email' >
                                      </div>                         
                              </div>
                          </div>
                          <div class="col-sm-6">
                                <div class="form-group">
                                      <label class='control-label col-sm-3'>Nationality</label>
                                      <div class="col-sm-8">
                                          <input type='text' name='nationality' value='<?php echo isset($row->nationality) ? $row->nationality : set_value('nationality');?>' class='form-control' >
                                      </div>
                                </div>  
                          </div>                          
                  </div>  
                  <div class="row">
                          <div class="col-sm-6">
                              <div class="form-group">
                                      <label for="username" class="col-sm-4 control-label">Gender</label>
                                      <div class="col-sm-8">  
                                          <label> <input type='radio' name='gender'  value='male' <?php  echo isset($row->gender) ? ($row->gender == 'male' ? 'checked' : '') : "";?>  > Male </label>                                       
                                          <label style='padding-left:25px;'> <input type='radio' name='gender' <?php echo isset($row->gender) ?  ($row->gender == 'female' ? 'checked' : '') : "";?> value='female'> Female </label>                             
                                      </div>
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="form-group">
                                   <label for="" class='control-label col-sm-3'>Date of Birth</label>
                                   <div class="col-sm-8">
                                        <div class='input-group date'>
                                            <input type='text' name="dateofbirth" id='dateofbirth' value='<?php echo isset($row->date_of_birth) ? $row->date_of_birth : set_value('dateofbirth');?>' class="form-control input-sm datepicker" />
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div> 
                                   </div>                           
                              </div>
                          </div>
                         
                  </div>                     
                  <div class="row">
                          <div class="col-sm-6">
                               <div class="form-group">
                                   <label for="" class='control-label col-sm-4'>Start Working</label>
                                   <div class="col-sm-8">
                                        <div class='input-group date' >
                                            <input type='text'  name="startworkingdate" value="<?php echo  isset($row->start_service_date) ? $row->start_service_date : set_value('startworkingdate');?>" class="form-control input-sm datepicker" />
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div> 
                                   </div>                           
                              </div>
                          </div>  
                          
                            <div class="col-sm-6">
                                <div class="form-group">
                                      <label class='control-label col-sm-3'>SSN</label>
                                      <div class="col-sm-8">
                                          <input type='text' name='ssnnumber' value="<?php echo isset($row->ssn_number) ? $row->ssn_number : set_value('ssnnumber'); ?>" class='form-control' >
                                      </div>
                                </div>  
                          </div>                                                                         
                  </div>
                      
                          
                               <div class="form-group">
                                      <label for="email" class="col-sm-2 control-label">Telephone</label>
                                      <div class="col-sm-10">
                                          <input type="number" name='telephone1' value='<?php echo isset($row->telephone1) ? $row->telephone1 : set_value('telephone1');?>' class="form-control" >
                                      </div>                         
                              </div>
                          
                                                  
                  <div class="form-group">
                          <label for="concept" class="col-sm-2 control-label">Place of Birth</label>
                          <div class="col-sm-10">
                              <input type="text"  name='placeofbirth' value="<?php echo isset($row->place_of_birth) ? $row->place_of_birth : set_value('placeofbirth'); ?>" class="form-control" >
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="concept" class="col-sm-2 control-label">Current Address</label>
                          <div class="col-sm-10">
                              <input type="text" name='currentaddress' value="<?php echo isset($row->current_address) ? $row->current_address : set_value('currentaddress'); ?>" class="form-control" >
                          </div>
                      </div>  
                      <hr>  
                      <div class='form-group'>
                        <div class='col-sm-2'></div>  
                        <div class='col-sm-6'>
                          <input type='hidden' name='uid' value='<?php echo $this->uri->segment(3);?>' class='hidden'>
                          <input type='hidden' name='secret' value='<?php echo isset($row->id) ? "EDIT" : "INSERT"; ?>' class='hidden'>
                          <input type='submit' value='<?php echo isset($row->id) ? "Update" : "Save changes";  ?>' class='btn btn-primary'>                            
                          <input type='button' value='Cancel'  class='btn btn-default' id="cancel">
                        </div>                                                    
                      </div>                      
                </div><!-- end colume right-->
                <!-- Profile Column-->               
                <div class="col-sm-3">
                    <div class="row">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                          <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 240px;">
                                  <img src="<?php echo site_url();?>assets/images/<?php echo isset($row->picture) ? ( empty($row->picture) == true ? "unavailable.jpg" : $row->picture) : "unavailable.jpg"; ?>" alt="..." style="width:200px;height:240px">
                          </div>
                          <div>
                            <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="userfile"  ></span>
                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                          </div>
                        </div>
                    </div>                   
                </div>
              </div>	                    
    			</div>
    		</form>
    		</div>	
    	</div>
    </div>  
</div>
<!--Message Box-->
      <div class="modal fade" id="myModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Add More Position</h4>
            </div>
            <div class="modal-body">
              <input type='text' class='form-control' id='position_name' placeholder='Add Position'>
            </div>
            <div class="modal-footer">
              <div id='msgerror'> </div>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              <button type="submit" id="deleteButton" onclick="ajaxInsert()"; class="btn btn-primary">Ok</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
<script src="<?php echo base_url();?>assets/js/kendo.all.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jasny-bootstrap.js"></script>
<script type="text/javascript">
  
    $.validate(); 
    function showModal(){ 
      $("#myModal").modal('show'); 
    }
    function ajaxInsert() {
         
            var input_data = $('#position_name').val();              
                
                var post_data = {
                    'position_name': new FormData(this), // post method name search_data is the value of textbox filter
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                };

                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>employee/do_upload",
                    data: post_data,                 
                    success: function(data) {
                        // return success                      
                        if (data.length > 0) {       

                            $('#msgerror').html(data);
                               
                        }
                    }
                });

                var post_data = {
                    'position_name': input_data, // post method name search_data is the value of textbox filter
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                };

                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>security/read_position",
                    data: post_data,                 
                    success: function(data) {
                        // return success                      
                        if (data.length > 0) {       

                            $('#refresh').html(data);
                               
                        }
                    }
                });
        }

 $(function(){ 
  $(".input-group-addon").click(function(){
    $(this).prev().focus();
  });
  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    startDate: 'now',    
})
   var v = true;   
      $('#cancel').click(function(){
        parent.history.back();
        return false;
       });
 });
</script>
