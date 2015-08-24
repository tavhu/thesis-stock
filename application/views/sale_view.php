<script type="text/javascript" src="<?php echo base_url()?>assets/js/angular.min.js"> </script>

<title>Supplier</title>
<div class="container" ng-app="myAppSale"  ng-init='ajaxurl = "<?php echo base_url().'sale/insert_sale'; ?>" ; csrfValue = "<?php echo $this->security->get_csrf_hash(); ?>"'  ng-controller="userCtrl">
    <div class="row">
        <div class="under_line">
            <h3><i class="fa fa-user"></i> Sale Products </h3>
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
    	<div class="form form-horizontal">    		
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<div class="panel-title"><strong><i class='fa fa-user'></i> Sale Form</strong></div>
    			</div>	
    			<div class="panel-body">
    				<div class='form form-horizontal'>  
                        <div class="form-group ">
                            <label  for='fullname' class='control-label col-sm-2'>Customer:</label>  
                            <div class='col-sm-5'>
                                <select class='form-control'ng-model='customer' ng-init='customer = "Regular Customer"'>
                                    <option>Regular Customer</option>
                                </select>
                            </div>      

                        </div>
                         <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Employee Name:</label>
                            <div class="col-sm-5">
                                    <input type='text' ng-model='employee_name'  ng-init="employee_name = '<?php echo humanize($this->session->userdata('real_name')); ?>'" disabled name='employee_name1'   class='disabled form-control'>
                                    <input type='text' ng-model='employee_name'  ng-init="employee_name = '<?php echo humanize($this->session->userdata('real_name')); ?>'"  name='employee_name'   class='hidden form-control'>
                            </div>                         
                        </div>  
                        <div class="form-group">
                            <label for="username" class="col-sm-2 control-label">Date:</label>
                            <div class="col-sm-5">
                                <input type='text' name='date_tim1'​ ng-model='date_time' ng-init=" date_time = '<?php echo date('Y-m-d');?>'" disabled  class='disabled form-control'>
                                                <input type='text' name='date_time'​ ng-model='date_time' ng-init=" date_time = '<?php echo date('Y-m-d');?>'"   class=' hidden form-control'>
                            </div>
                        </div>
                        <div class='panel panel-default'>
                            <div class='panel-heading'>
                                Click save changes , if you want to save sale information to database.
                            </div>
                        </div>

                        <div class='panel panel-default'>
                            <div class='panel-heading' >
                               <div class="form-group" class='row'  style='margin-bottom:0px'>
                                    <div class="col-sm-3">
                                        <label for="concept" class="col-sm-5 control-label">Item Code: </label>
                                        <div class="col-sm-7">                                        
                                             <input type='text' class='form-control  autocomplete '  id='productcode' name='productcode' ng-model='productcode' ng-init='productcode =  "<?php echo isset($row->product_id) ? $row->product_id : set_value('descriptions');?>" '>
                                        </div>
                                    </div>                                    
                                    <div class="col-sm-3">
                                        <div class='form-group'  style='margin-bottom:0px'  >
                                            <label for="concept" class="col-sm-2 control-label">Name:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="productname" name="productname"  ng-model='productname'  value='name'>
                                            </div>
                                        </div>
                                    </div>    
                                    <div class="col-sm-2">
                                         <label class='col-sm-4 control-label'>Price:</label>
                                         <div class="col-sm-8">
                                            <input class="form-control" type='text' id='price' ng-model='price' value='{{price = unit_price}}'>
                                             <input class="form-control hidden" type='text' id='unit_price' ng-model='unit_price' >
                                        </div>                                         
                                    </div> 
                                    <div class="col-sm-2">
                                        <div class='form-group'  style='margin-bottom:0px'  >
                                            <label for="concept" class="col-sm-5 control-label">Qty: </label>
                                            <div class="col-sm-7">
                                                <input type="number" class="form-control" ng-model='qty' ng-init='qty = 1' min='1' id="password" name="password" data-validation='length' data-validation-length='min10'>
                                            </div>
                                        </div>
                                    </div>            
                                  <div class="col-sm-2">
                                        <div class='form-group'  style='margin-bottom:0px'>
                                            <label for="concept" class="col-sm-3 control-label">Total:</label>
                                            <div class="col-sm-9">
                                                <input type="text"  class="form-control" value='{{total = qty * unit_price}}' id="total" name="total" ng-model='total' >
                                            </div>
                                        </div>
                                  </div>                                      
                                </div>   
                            </div> 
                            <div class='col-sm-offset-2 col-sm-10' style="margin-top:10px">
                                  <div class="form-group">
                                        <div class='col-sm-12'>
                                            <input type='button' class="btn btn-primary" value="{{buttonName}}" ng-click='addproduct(employee_name , date_time , productcode , productname , qty , total , customer, unit_price ,  paid , discount , subtotal )'>
                                        </div>
                                      
                                  </div>   
                            </div> 
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table id='example' class='table table-borderd'>
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Product Code</th>
                                                    <th>Product Name</th>
                                                    <th>Unit price</th>
                                                    <th>Quantity</th>                                                  
                                                    <th>Total</th>    
                                                                                
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="name in names">
                                                    <td><i class='btn btn-default' ng-click='editRow($index)'>Edit</i>  <i class='btn btn-default' ng-click='deleteRow($index)'>Delete</i></td>
                                                    <td>{{name.productcode}}</td>
                                                    <td>{{name.productname}}</td>
                                                    <td>{{name.unit_price}}</td>
                                                    <td>{{name.qty}}</td>                                                    
                                                    <td>{{name.total}}</td>                                                                  
                                                </tr>                                   
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>                           
                        </div>

                           <div  id='printableArea' class='hidden'>  
                            <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/bootstrap.css">                 
                            <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/font-awesome.css">  
                            <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style.css">
                            <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/menu-nav.css">
                           <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">                  
                             <img src="<?php echo base_url()?>assets/images/logo.png" alt="logo" width='250'>

                             <br> <br>
                             <div class="col-sm-12" align='center'>
                                <h2>Invoice</h2>
                             </div>
                             <hr>

                              <div class="row">
                                <div class="col-sm-12">   
                                    <div >
                                        <table width='100%'  class='t'>                                           
                                            <tbody>
                                                <tr>       
                                                                                           
                                                    <td width='25%'></td>
                                                    <td width='15%'></td>
                                                    <td width='5%'></td>
                                                    <td width='20%' style='font-weight:bold'>Invoice ID</td>                                                    
                                                    <td width='35%'>{{Invoice_id}}</td>                   
                                                </tr> 
                                                 <tr>       
                                                                                             
                                                    <td width='25%'></td>
                                                    <td width='25%'></td>
                                                    <td width='5%'></td>
                                                    <td width='20%'style='font-weight:bold'>Invoice Date</td>                                                    
                                                    <td width='35%'>{{date_time}}</td>                   
                                                </tr> 
                                                <tr>       
                                                                                             
                                                    <td width='25%'></td>
                                                    <td width='25%'></td>
                                                    <td width='5%'></td>
                                                    <td width='20%'style='font-weight:bold'>Seller</td>                                                    
                                                    <td width='35%'>{{employee_name}}</td>                   
                                                </tr>  
                                                                                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-sm-12" >   
                                    <div >
                                        <table width='100%'  class='table table-borderd'>
                                            <thead style='text-align:center'>
                                                <tr>
                                                    <th width='5%'>#</th>
                                                    <th width='25%'>Product Code</th>
                                                    <th width='25%'>Product Name</th>
                                                    <th width='20%'>Unit price</th>
                                                    <th width='10%'>Quantity</th>                                                  
                                                    <th width='20%'>Total</th>    
                                                                                
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="name in names">       
                                                    <td width='5%'>{{name.id}}</td>                                           
                                                    <td width='25%'>{{name.productcode}}</td>
                                                    <td width='25%'>{{name.productname}}</td>
                                                    <td width='20%'>${{name.unit_price}}</td>
                                                    <td width='10%'>{{name.qty}}</td>                                                    
                                                    <td width='20%'>${{name.total}}</td>                   
                                                </tr>                                   
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-sm-12">   
                                    <div >
                                        <table width='100%'  class=''>                                           
                                            <tbody>
                                                <tr>       
                                                                                           
                                                    <td width='25%'></td>
                                                    <td width='25%'></td>
                                                    <td width='5%'></td>
                                                    <td width='20%' style='font-weight:bold'>Sub Total </td>                                                    
                                                    <td width='35%'>${{subtotal}}</td>                   
                                                </tr> 
                                                 <tr>       
                                                                                             
                                                    <td width='25%'></td>
                                                    <td width='25%'></td>
                                                    <td width='5%'></td>
                                                    <td width='20%'style='font-weight:bold'>discount</td>                                                    
                                                    <td width='35%'>${{discount}}</td>                   
                                                </tr> 
                                                <tr>       
                                                                                             
                                                    <td width='25%'></td>
                                                    <td width='25%'></td>
                                                    <td width='5%'></td>
                                                    <td width='20%'style='font-weight:bold'>Paid</td>                                                    
                                                    <td width='35%'>${{paid}}</td>                   
                                                </tr>  
                                                                                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div> 
                            <hr>
                            <div class="col-sm-12" align='center'>
                               ផ្ទះលេខ៣៦ ផ្លូវ ២៧១​សង្កាត់ទឹកថ្លា ខ័ន្ឌសែនសុខ រាជធានីភ្នំពេញ លេខទូរស័ព្ទ៖​ ០១២ ៩១ ៥៥ ៦៥
                            </div>                          
                        </div>                        
                          </div>
                          <br><br>

                        <div class="form-group">
                            <label for="concept" class="col-sm-2 control-label">Sub Total: </label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control"  id="subtotal"  ng-model='subtotal'  value='{{subtotal}}' name="subtotal" ng-init='subtotal = 0'>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="concept" class="col-sm-2 control-label">Discount: </label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control"  id="discount" name="discount" ng-model='discount' ng-init='discount = 0'>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="concept" class="col-sm-2 control-label">Paid: </label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control"  id="paid" name="paid" ng-model='paid' value='{{paid = subtotal - discount}}'>
                            </div>

                        </div>                                               
                        <hr>    
                        <div class='form-group'>
                            <div class='col-sm-3'></div>    
                            <div class='col-sm-6'>
                                <input type='submit' value='{{btnSubmit}}' ng-click='saveProducts(sd)' ng-init='btnSubmit = "Submit"' class='btn btn-primary'  >                                  
                                <input type='button' value='Cancel'  class='btn btn-default' id="cancel">                               
                            </div>                                               
                        </div>
                        
                </div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/productlist.js"> </script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/jquery-ui.css">
<script src="<?php echo base_url()?>assets/js/jquery-ui.js"></script>
<script src="<?php echo base_url();?>assets/js/printdiv.js"></script>

<script type="text/javascript">
<?php 


  $result = $this->db->get("tbl_product");
    $String = "";
    foreach ($result->result() as $row){
      $String .= $row->product_id."  ";
    }

?>
    var data = "<?php echo $String?>".split("  ");
    $(".autocomplete").autocomplete({source: data});


 $("#productcode").focusout(function(e){
       Get_product_ID();
       Get_product_Price();
       $("#productcode").trigger('input');

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

      function Get_product_Price (){

         // $("#productcode").val('');
          var input_data = $("#productcode").val();    
          var post_data = {
                    'productname': $.trim(input_data), // post method name search_data is the value of textbox filter
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                };

                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>purchase_stock/get_product_price",
                    data: post_data,                 
                    success: function(data) {
                        // return success                      
                        if (data.length > 0) {      

                             var input = $('#unit_price');
                             input.val(String(data));
                             input.trigger('input');
                        }
                    }
                });
    }

</script>