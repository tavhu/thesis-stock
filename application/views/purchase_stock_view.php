<title>Home</title>
<?php 

    $row = null;
          if ($this->uri->segment(3) == true) {
                $decode = $this->myencryption->decode($this->uri->segment(3));              
                $result = $this->db->get_where('tbl_product',array('id'=>$decode));
                $row = $result->row();        
                echo  $this->myencryption->decode($this->uri->segment(3));


          }else{
              $inserted_id = $this->session->flashdata('inserted_id');
              if (!empty($inserted_id)) {
                $result = $this->db->get_where('tbl_product',array('id'=>$inserted_id));
                $row = $result->row();   
              }
          }


 ?>

<script type="text/javascript" src="<?php echo base_url()?>assets/js/angular.min.js"> </script>

<div class="container" ng-app="myApp" ng-init='ajaxurl = "<?php echo base_url().'purchase_stock/saveProducts'; ?>" ; csrfValue = "<?php echo $this->security->get_csrf_hash(); ?>"' ng-controller="userCtrl">
    <div class="row">
        <div class="under_line">
            <h3><i class='fa fa-cart-plus'></i> Purchase </h3>   
            <?php echo $this->session->userdata('remember_me');   ?>             
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
         
    ?>

    <div class="row" >
    	<div class="panel panel-default">
    		<div class="panel-heading">
    				<div class="panel-title"><strong><i class='fa fa-cart-plus'></i><?php echo isset($row->id) ? " Edit Product" : " Add Products"; ?> </strong></div>
    		</div>
    		<div class="panel-body">
    <?php 
                 $arr = array('role'=>'form', 'id'=>'registration-form','name'=>'myForm','novalidate'=>null);
                 echo form_open('purchase_stock/validation',$arr);
     ?>
    			
                <div class="form form-horizontal">
    				<div class="row">    					
    						<div class="col-sm-6">
    							<div class="form-group">
	    							<label class="col-sm-3 control-label">Supplier</label>
	    							<div class="col-sm-9">
                                        <select class='form-control' ng-model='supplier_id'  ng-init='supplier_id = "<?php echo isset($row->supplier_id) ? $row->supplier_id : set_value('descriptions');?>" ' >
                                        
	<?php 
                                         

                                            $result =  $this->db->get('tbl_supplier');

                                            foreach ($result->result() as $rows) {
                                                $name = $rows->name;
                                                $id = $this->myencryption->encode($rows->id);
                                                echo "<option value='$id'>$name</option>";
                                            }

     ?>
                                        </select>
	    							</div>
	    						</div>
    						</div> 
    						<div class='col-sm-6'>
    							<div class="row">	
    								<div class="col-sm-6">
    									<div class="form-group">
		    								<label class='col-sm-3 control-label'>Date</label>
		    								<div class="col-sm-9">
		    									<input type='text' name='date_tim1'​ ng-model='date_time' ng-init=" date_time = '<?php echo unix_to_human(now());?>'" disabled  class='disabled form-control'>
                                                <input type='text' name='date_time'​ ng-model='date_time' ng-init=" date_time = '<?php echo unix_to_human(now());?>'"   class=' hidden form-control'>
		    								</div>
		    							</div>
    								</div>
    								<div class="col-sm-6">
    									<div class="form-group">
		    								<label class='col-sm-3 control-label'>User</label>
		    								<div class="col-sm-9">
		    									<input type='text' ng-model='employee_name'  ng-init="employee_name = '<?php echo humanize($this->session->userdata('real_name')); ?>'" disabled name='employee_name1'   class='disabled form-control'>
		    								    <input type='text' ng-model='employee_name'  ng-init="employee_name = '<?php echo humanize($this->session->userdata('real_name')); ?>'"  name='employee_name'   class='hidden form-control'>
                                            </div>
		    							</div>
    								</div>
    							</div>
    						</div>   					
    				</div>
    				<div style='border-bottom:1px solid #eee'></div>
    				<br>

    				<div class="row">    					
    					<div class="col-sm-6">                           
                            <div class="form-group">
                                <label class='col-sm-3 control-label'>Product Code</label>
                                <div class="col-sm-9">
                                    <input type='text' class='form-control autocomplete' id='productcode' name='productcode' ng-model='model' ng-init='model =  "<?php echo isset($row->product_id) ? $row->product_id : set_value('descriptions');?>" '>                        
                                </div>
                            </div>

    						<div class="form-group">
    							<label class='col-sm-3 control-label'>Product Name</label>
    							<div class='col-sm-9'>
    								<input type='text' class='form-control' id="productname" ng-model='productname' name='productname' ng-init='productname = "<?php echo isset($row->name) ? $row->name : set_value('descriptions');?>" '>
                                    <span style="color:red" ng-show="myForm.productname.$dirty && myForm.productname.$invalid">
                                    <span ng-show="myForm.productname.$error.required">Username is required.</span>                                  
    							</div>
    						</div>    						
    						<div class="form-group">
    							<label class='col-sm-3 control-label'>Description</label>
    							<div class="col-sm-9">
    								<textarea type='text'  class='form-control'  ng-model='descriptions' name='descriptions'  ng-init='descriptions = "<?php echo isset($row->description) ? $row->description : set_value('descriptions');?>" ' style='resize:none'>
    								</textarea>
    							</div>
    						</div>
    						<div class="form-group">
    							<label class='col-sm-3 control-label'>Cost Price / USD</label>
    							<div class="col-sm-9">
    								<input type='number' value='{{cost}}' class='form-control' ng-model='cost' name='cost' ng-init='cost = <?php echo isset($row->unit_price) ? $row->unit_price : set_value('descriptions');?> ' >    								
    							</div>
    						</div>
    						<div class="form-group">
    							<label class='col-sm-3 control-label'>Quantity</label>
    							<div class="col-sm-9">
    								<input type='number' value='{{quantity}}' class='form-control' ng-model='quantity'  name='quantity'  ng-init='quantity = <?php echo isset($row->quantity) ? $row->quantity : set_value('descriptions');?> ' >    								
    							</div>
    						</div>
    						<div class="form-group">
    							<label class='col-sm-3 control-label'>Categories</label>
    							<div class="col-sm-9">
    								
                                    <select class='form-control' ng-model='categories' name='categories' ng-init='categories = "<?php echo isset($row->catagories_id) ? $row->catagories_id : set_value('descriptions');?>" ' >
                                  
<?php 
                                       $result =  $this->db->get('tbl_categories');                                     
                                       foreach ($result->result() as  $rows){     
                                            $cname = $rows->name;   
                                            $ids = $this->myencryption->encode($rows->id); 
                                            if (isset($rows->name)) {                                                   
                                                  
                                                if ($cname == $row->catagories_id) {
                                                    echo "<option  value='$cname'>$cname</option>";
                                                }else{
                                                    echo "<option value='$cname'>$cname</option>";
                                                }
                                            }
                                           

                                       }                                        
                                
 ?>                                  </select>								
    							</div>
    						</div>
    						<hr>
    						<div class='form-group'>    							
    								<div class="col-sm-3"></div>
    								<div class="col-sm-9">
<?php 

                                        if (isset($row->id)){
                                           $row->name;
 ?> 
                                          <input type='hidden' name='uid' value='<?php echo $this->uri->segment(3);?>' class='hidden'>
                                          <input type='hidden' name='secret' value='<?php echo isset($row->id) ? "EDIT" : "INSERT"; ?>' class='hidden'>
                                          <input type='submit' value='<?php echo isset($row->id) ? "Update" : "Save changes";  ?>' class='btn btn-primary'>                            
                                          <input type='button' value='Cancel'  class='btn btn-default' id="cancel">        
<?php 
                                        }else{

 ?>                      
    									<input type='button' value='{{buttonName}}' id='addproductbtn' ng-disabled="myForm.productname.$dirty && myForm.productname.$invalid " ng-click='addproduct(productname,model,descriptions , cost , quantity , categories , supplier_id)' class='btn btn-default'>
    								    <input type='button' value='Save Product' ng-click="saveProducts(sd)" class='btn btn-primary'>
<?php 
                                        }
 ?> 
                                    </div>
    						</div>
    					</div> 
    					<!--detail-->
    					<div class="col-sm-6">
    						<div class='panel panel-default'>
    							<div class="panel-heading">
    								<div class="panel-title">
    									<strong>Recent Product Detail</strong>
    								</div>
    							</div>
    							<div class="panel-body">
    								<div class="col-sm-12">    									
    									<div class="table-responsive">
    										<table width='100%' class='table table-hover'>    											
    												<tbody >
    													<tr>
	    													<td width='50%'>Product Name</td><td>{{re_productname}}</td>	    												
	    												</tr>
	    												<tr>
	    													<td width='50%'>Model</td><td>{{re_model}}</td>	    												
	    												</tr>
	    												<tr>
	    													<td width='50%'>Description</td><td>{{re_descriptions}}</td>	    												
	    												</tr>
	    												<tr>
	    													<td width='50%'>Cost Price</td><td>{{re_cost}}</td>	    												
	    												</tr>
	    												<tr>
	    													<td width='50%'>Quantity</td><td>{{re_quantity}}</td>	    												
	    												</tr>
	    												<tr>
	    													<td width='50%'>Categories</td><td>{{re_categories}}</td>	    												
	    												</tr>
    												</tbody>    											
    										</table>
    									</div>
    								</div> 
    							</div>
    						</div>
    					</div>
    				</div>
    			</div>	   
    <?php 
                echo form_close();
     ?>  			
	    	</div>
	    	<div style='border:1px solid #eee'></div>
	    	<br>
	    	<div class="row">
	    			<div class="col-sm-12">
	    				<div class="table-responsive">
	    					<table id='example' class='table table-hover'>
	    						<thead>
	    							<tr>
	    								<th>Action</th>
	    								<th>Product Name</th>
	    								<th>Model</th>
	    								<th>Cost Price</th>
	    								<th>Quantity</th>
	    								<th>Categories</th>	   
	    								<th>Decription</th> 								
	    							</tr>
	    						</thead>
	    						<tbody>
	    							<tr ng-repeat="name in names">
	    								<td><i class='btn btn-default' ng-click='editRow($index)'>Edit</i>  <i class='btn btn-default' ng-click='deleteRow($index)'>Delete</i></td>
	    								<td>{{name.Productname}}</td>
	    								<td>{{name.Model}}</td>
	    								<td>{{name.Cost}}</td>
	    								<td>{{name.Quantity}}</td>
	    								<td>{{name.Categories}}</td>
	    								<td>{{name.Descriptions}}</td>
	    							</tr>	    							
	    						</tbody>
	    					</table>
	    				</div>
	    			</div>
	    		</div>
	    	<div class="panel-footer">
	    		
	    	</div>	
    	</div>
    </div>
</div>
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/jquery-ui.css">
<script src="<?php echo base_url()?>assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/productlist.js"> </script>
<script type="text/javascript">

$(function(){


<?php 

    if ( ! isset($row->id)){    
 ?>
    
    var input = $('#date_time');
        input.val(String(data));
        input.trigger('input');

   $("#productcode").focusout(function(e){
       Get_product_ID();
       var input = $('#productcode');       
        input.trigger('input');
    });


    function Get_product_ID (){

         // $("#productcode").val('');
          var input_data = $("#productcode").val();    
          var post_data = {
                    'productname': $.trim(input_data), // post method name search_data is the value of textbox filter
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                };

                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>purchase_stock/get_product_code",
                    data: post_data,                 
                    success: function(data) {
                        // return success                      
                        if (data.length > 0) {       


                             var input = $('#productname');
                             input.val(String(data));
                             input.trigger('input');

                               
                        }
                    }
                });
    }

    <?php 


    
    $result = $this->db->get("tbl_product");
    $String = "";
    foreach ($result->result() as $row) {
      $String .= $row->product_id."  ";
    }

     ?>
    var data = "<?php echo $String?>".split("  ");
    $(".autocomplete").autocomplete({source: data});

<?php 

}

 ?>

});

</script>