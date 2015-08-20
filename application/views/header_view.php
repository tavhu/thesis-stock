<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('inflector');
?>
<!DOCTYPE html>
<html>
	<head>		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />		
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/bootstrap.css">					
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/font-awesome.css">	
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/menu-nav.css">
	   <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    </head>
	<body>	

	<?php 
            $session_data = $this->session->all_userdata();
		if ( isset($session_data['user']) && $session_data['user'] == TRUE ) {
			
		}else{
            redirect('','refresh');
        }

	 ?>	
	<!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top navtop" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header" >
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo site_url();?>home"  >
                    <img src="<?php echo base_url()?>assets/images/logo.png" alt="logo" width='150'>
                </a>
            </div>
             <ul class='nav navbar-nav navbar-right'>
                    <li class="dropdown" >
                        <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button"  id='white-color' aria-expanded="false"><i class='fa fa-user' ></i>&nbsp <?php echo humanize($this->session->userdata('real_name')); ?>&nbsp<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo site_url();?>user"><i class='fa fa-lock'></i>&nbsp Manage Profile</a></li>                            
                            <li class="divider"></li>
                            <li><a href="<?php echo site_url()?>user/logout"><i class="fa fa-power-off"></i> Logout</a></li>                      
                        </ul>                           
                    </li>
                </ul>
             <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="<?php echo site_url();?>home"><i class='fa fa-home'></i> Home</a>                        
                    </li>  
                     <li>
                        <a  href="<?php echo site_url();?>sale"><i class='fa fa-cart-plus'></i> Sale Product</a>                        
                    </li>          
                    <li class="dropdown" >
                        <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button"  id='white-color' aria-expanded="false"><i class='fa fa-cart-plus' ></i> Stock <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li>  <a href="<?php echo site_url();?>purchase_stock"><i class='fa fa-cart-plus'></i> Import Stock</a></li>    
                            <li>  <a href="<?php echo site_url()?>sale/manage_product"><i class="fa fa-cog"></i> View Stock </a></li> 
                            <li class="divider"></li>
                            <li> <a href="<?php echo site_url();?>sale/categories"><i class='fa fa-cart-plus'></i> Add Categories</a></li> 
                            <li> <a href="<?php echo site_url()?>sale/manage_categories"><i class="fa fa-cog"></i> Manage Categories</a></li> 
                        </ul>                           
                    </li>                    
                    <li class="dropdown " >
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class='fa fa-user-plus'></i> Supplier <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo base_url();?>supplier"><i class='fa fa-users'> Add Supplier </i></a></li>
                            <li><a href="<?php echo base_url();?>supplier/manage"><i class="fa fa-cog"> Manage Supplier</i></a></li>
                        </ul>                           
                    </li>
                    <li>
                        <li class="dropdown " >
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class='fa fa-user-book'></i> Report <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo base_url();?>report"><i class='fa fa-book'></i> Sale Report</a></li>
                            <li><a href="#"><i class="fa fa-book"> Stock Report</i></a></li>
                        </ul>                           
                    
                    <li class="dropdown " >
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class='fa fa-user-plus'></i> Employees <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo base_url();?>employee"><i class='fa fa-users'> Register Profile </i></a></li>
                            <li><a href="<?php echo base_url();?>employee/manage_employee"><i class="fa fa-cog"> Manage Emploayee</i></a></li>
                        </ul>                           
                    </li>
                     <li class="dropdown" >
                        <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button"  id='white-color' aria-expanded="false"><i class='fa fa-lock' ></i> Security<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo site_url();?>security"><i class='fa fa-users'></i>&nbsp Create User</a></li>                            
                            <li class="divider"></li>
                            <li><a href="<?php echo site_url()?>security/permission"><i class="fa fa-cog"></i> Manage User Permission</a></li>                      
                        </ul>                           
                    </li>
                </ul>               
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.form-validator.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/bootstrap.js"> </script>
