<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class report extends CI_Controller {

	function index(){	

		$this->load->view('header_view');
		$this->load->view('report_view');
		$this->load->view('footer_view');

	}

 	function sale_report(){

 		$datepickerto = $this->input->post('datepickerto');
 		$datepickerfrom = $this->input->post('datepickerfrom');
 		$this->db->select('invoice_id');
 		$this->db->distinct();
 		$this->db->where('date_time <=', $datepickerto);
		$this->db->where('date_time >=', $datepickerfrom);
		$result =  $this->db->get('sale_invoice');

		?> 

		<div class="class-col-sm-12" id="printf">

<?php 

	foreach ($result->result() as $row) {
			
			 $this->db->where('invoice_id',  $row->invoice_id );
			 $recorde = $this->db->order_by('id','desc')->limit(1)->get('sale_invoice');
			 $rav = $recorde->row(); 
?>
		
			<table  width="100%">
				<tr> <td width="20%"> <label>Invoice ID</label> </td><td width="80%"><?php echo $rav->invoice_id; ?></td> </tr>
				<tr> <td width="20%"> <label>Employee Name</label></td><td width="80%"><?php echo $rav->employee_name; ?></td> </tr>
				<tr> <td width="20%"> <label>Date</label> </td><td width="80%"><?php echo $rav->date_time; ?></td> </tr>
			</table>			

			<table class='table table-bordered' style="text-align:center">
				<thead>
					<tr>
						<th>#</th>
						<th>Product Code</th>
						<th>Product Name</th>
						<th>Quantity</th>
						<th>Unit_price</th>
						<th>Total</th>
					</tr>

				</thead>
				<tbody>
<?php
			 $res = $this->db->get_where('sale_invoice', array('invoice_id' => $rav->invoice_id));
			 $count = 1;
			 foreach ($res->result() as $key) {			 
?>
					<tr>
						<td><?php echo $count; ?></td>
						<td><?php echo $key->productcode; ?></td>
						<td><?php echo $key->productname; ?></td>
						<td><?php echo $key->qty; ?></td>
						<td><?php echo $key->unit_price; ?></td>
						<td><?php echo $key->total; ?></td>
					</tr>

<?php
			$count ++;
			 }

?>
				<tr> 
					   <td colspan="5" style="text-align:right"> Sub Total  </td>
					   <td><?php echo $rav->subtotal; ?></td> 
				</tr>
				<tr> 
						<td colspan="5" style="text-align:right" > Discount </td>
						<td><?php echo $rav->discount; ?></td> 
				</tr>
				<tr> 
						<td colspan="5" style="text-align:right" > Paid Price </td>
						<td><?php echo $rav->paid; ?></td> 
				</tr>
				</tbody>

			</table>

			

<?php

		}

 ?>

		</div>


		<script type="text/javascript">

			
		function printdiv(printdivname)
		{
		  var printContents = document.getElementById(printdivname).innerHTML;
		  var popupWin = window.open('', '_blank', 'width=300,height=300');
		  popupWin.document.open();
		  popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/bootstrap.css; ?>" /></head><body onload="window.print()">' + printContents + '</html>');
		  popupWin.document.close();
		}

		</script>
		<?php 


 	}

}