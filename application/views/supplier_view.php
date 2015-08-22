

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/jasny-bootstrap.css">
<title>Supplier</title>
<div class="container">
    <div class="row">
        <div class="under_line">
            <h3><i class="fa fa-user"></i> Supplier </h3>
        </div>
    </div>
    <div class="row">

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
                $result = $this->db->get_where('tbl_supplier',array('id'=>$decode));
                $row = $result->row();                
          }else{
              $inserted_id = $this->session->flashdata('inserted_id');
              if (!empty($inserted_id)) {
                $result = $this->db->get_where('tbl_supplier',array('id'=>$inserted_id));
                $row = $result->row();   
              }
          }
    ?>


<?php 

          
            $arr = array('role'=>'form', 'id'=>'registration-form');
            echo form_open_multipart('supplier/insert_validate',$arr);    

    

 ?>
    	<div class="form form-horizontal">    		
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<div class="panel-title"><strong><i class='fa fa-user'></i> <?php echo isset($row->id) ? "Edit Supplier" : "Register"; ?></strong></div>
    			</div>	
    			<div class="panel-body">
    				<div class='form form-horizontal'>  
                         <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Company Name: </label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control"  id="companyname" name="companyname" value= "<?php echo isset($row->company_name) ? $row->company_name : set_value('companyname');?>" data-validation='required' >
                            </div>
                        </div>
                        <div class="form-group ">
                            <label  for='fullname' class='control-label col-sm-3'>Full Name:</label>  
                            <div class='col-sm-5'>
                                <input type='text' name='fullname' value= "<?php echo isset($row->name) ? $row->name : set_value('fullname');?>"  class='form-control' data-validation='required' >
                            </div>                          
                        </div>
                         <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">Telephone 1:</label>
                            <div class="col-sm-5">
                                <input type="number" class="form-control" value= "<?php echo isset($row->tel1) ? $row->tel1 : set_value('telephone1');?>"  id="telephone1" name="telephone1"  data-validation='required'>
                            </div>                         
                        </div>  
                        <div class="form-group">
                            <label for="username" class="col-sm-3 control-label">Telephone 2 :</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control"value= "<?php echo isset($row->tel2) ? $row->tel2 : set_value('telephone2');?>"  name="telephone2"  data-validation='length' data-validation-length='max12'>
                            </div>
                        </div>
                        <div class='panel panel-default'>
                            <div class='panel-heading'>
                                Click save changes , if you want to save supplier to database.
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Address:</label>
                            <div class="col-sm-5">                                
                                <textarea class="form-control"  id="address" name="address"><?php echo isset($row->address) ? $row->address : set_value('address');?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Note:</label>
                            <div class="col-sm-5">                              
                                <textarea  class="form-control" name='note'><?php echo isset($row->note) ? $row->note : set_value('note');?></textarea>
                            </div>              
                        </div>  
                        <hr>    
                        <div class='form-group'>
                            <div class='col-sm-3'></div>    
                            <div class='col-sm-6'>
                                 <input type='hidden' name='uid' value='<?php echo $this->uri->segment(3);?>' class='hidden'>
                                 <input type='hidden' name='secret' value='<?php echo isset($row->id) ? "EDIT" : "INSERT"; ?>' class='hidden'>
                                 <input type='submit' value='<?php echo isset($row->id) ? "Update" : "Save changes";  ?>' class='btn btn-primary'>                              
                                <input type='button' value='Cancel'  class='btn btn-default' id="cancel">
                            </div>                                                              
                        </div>
                        
                </div>
    			</div>
    		</div>
    	</div>
</form>
    </div>
</div>
<script src="<?php echo base_url();?>assets/js/kendo.all.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jasny-bootstrap.js"></script>
<script type="text/javascript">

$.validate(); 
  $('#cancel').click(function(){
        parent.history.back();
        return false;
       });
</script>