<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/jasny-bootstrap.css">

<title>Categories</title>
<div class="container">
    <div class="row">
        <div class="under_line">
            <h3><i class="fa fa-plus"></i> Categories </h3>
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
                $result = $this->db->get_where('tbl_categories',array('id'=>$decode));
                $row = $result->row();                
          }else{
              $inserted_id = $this->session->flashdata('inserted_id');
              if (!empty($inserted_id)) {
                $result = $this->db->get_where('tbl_categories',array('id'=>$inserted_id));
                $row = $result->row();   
              }
          }
    ?>
    </div>
    <div class="row">
    	<div class="form form-horizontal">    		
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<div class="panel-title"><strong><i class='fa fa-plus'></i> <?php echo isset($row->id) ? "Update Categories" : "Add New Categories"; ?></i></strong></div>
    			</div>	
    			<div class="panel-body">
        <?php 
                    $arr = array('role'=>'form', 'id'=>'registration-form');
                    echo form_open_multipart('sale/categories_validate',$arr);    

        ?>   
    				<div class='form form-horizontal'>  
                        <div class="form-group ">
                            <label  for='fullname' class='control-label col-sm-3'>Name:</label>  
                            <div class='col-sm-5'>
                                <input type='text' name='fullname' value= "<?php echo isset($row->name) ? $row->name : set_value('fullname');?>" class='form-control' data-validation='required' >
                            </div>                          
                        </div>                          
                        <div class="form-group">
                            <label for="username" class="col-sm-3 control-label">Description:</label>
                            <div class="col-sm-5">
                                <textarea name='description' class="form-control"><?php echo isset($row->description) ? $row->description : set_value('description');?></textarea>                                
                            </div>
                        </div>
                        <div class='panel panel-default'>
                            <div class='panel-heading'>
                                Click save changes , if you want to save supplier to database.
                            </div>
                        </div>
                        <div class="form-group">
                           <div class="col-sm-offset-3 col-sm-5">
                                 <div class="fileinput fileinput-new" data-provides="fileinput">
                                  <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 240px;">
                                          <img src="<?php echo site_url();?>assets/images/<?php echo isset($row->img_url) ? ( empty($row->img_url) == true ? "unavailable.jpg" : $row->img_url) : "unavailable.jpg"; ?>" alt="..." style="width:200px;height:240px">
                                  </div>
                                  <div>
                                    <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="userfile"  ></span>
                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                  </div>
                                </div>
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
        </form>
    			</div>
    		</div>
    	</div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/jasny-bootstrap.js"></script>

<script type="text/javascript">175

     $.validate(); 

     $('#cancel').click(function(){
        parent.history.back();
        return false;
       });
</script>