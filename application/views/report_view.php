<link rel="stylesheet" href="<?php echo base_url()?>assets/css/jquery-ui.css">
<script src="<?php echo base_url()?>assets/js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/jasny-bootstrap.css">
<title>Report</title>
<div class="container" id='container'>
    <div class="row">
        <div class="under_line">
            <h3><i class="fa fa-book"></i> View Report </h3>
        </div>
    </div>
    <div class="row" id='printableArea'>

    	<div class="form form-horizontal">    		
    		<div class="panel panel-default">
    			<div class="panel-heading">

    				<div class="panel-title"><strong><i class='fa fa-book'></i> Sale Report </strong></div>

    			</div>	
    			<div class="panel-body">    	
          		 <div class="panel panel-default">
                    <div class="panel-heading">
                     From <input type='text' id="datepickerfrom" name='datepickerfrom' > to <input type='text' id="datepickerto" name='datepickerto'> <input type='submit' id='search' > <input type='button' value='print' >
                    </div>
               </div>
               <div class="col-sm-12" id='recieve'>


               </div>
    			</div>

    		</div>
    	</div>

    </div>
</div>
<script src="<?php echo base_url();?>assets/js/kendo.all.min.js"></script>
<script src="<?php echo base_url();?>assets/js/printdiv.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jasny-bootstrap.js"></script>
<script type="text/javascript">

$.validate(); 
  $('#cancel').click(function(){    
        parent.history.back();
        return false;
       });
</script>

<script type="text/javascript">
  
   $(function() {
 $('#datepickerfrom').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  $('#datepickerto').datepicker({ dateFormat: 'yy-mm-dd' }).val();

  });


$("#search").click(
    function(){
    var datepickerfrom  = $("#datepickerfrom").val();
    var datepickerto = $("#datepickerto").val();
   
    var post_data = {
                    'datepickerto' : datepickerto,
                    'datepickerfrom': datepickerfrom, // post method name search_data is the value of textbox filter
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                };

                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>report/sale_report",
                    data: post_data,                 
                    success: function(data) {
                        // return success                      
                        if (data.length > 0) {       
                            $('#recieve').html(data);   
                            $("#recieve").printThis();                                                  
                        }
                    }
                });
    }
  );



</script>