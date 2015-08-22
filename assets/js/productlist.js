angular.module('myApp',[]).controller('userCtrl',function($scope){
$scope.ArrID = 0;
$scope.currentIndex = '';
$scope.names = [];
$scope.buttonName = 'Add Product';
$scope.OperationStatus = "insert";
$scope.product_qty_check;

$scope.deleteRow = function(e){
	 $scope.names.splice(e, 1);
}
$scope.editRow = function(Row){
	$scope.currentIndex = Row;
	$scope.productname = $scope.names[Row]['Productname']
	$scope.model = $scope.names[Row]['Model']
	$scope.descriptions = $scope.names[Row]['Descriptions']
	$scope.cost = $scope.names[Row]['Cost']
	$scope.quantity = $scope.names[Row]['Quantity']
	$scope.categories = $scope.names[Row]['Categories']
	$scope.supplier_id = $scope.names[Row]['Supplier_id']
	$scope.buttonName = "Update Product";	
	$scope.OperationStatus  = "edit";
}
$scope.saveProducts = function(Row){
		input_data = $scope.names;
		crsfVal = $scope.csrfValue;
	    post_data = {       
                          'post_data': input_data, // post method name search_data is the value of textbox filter
                          'csrf_test_name' : crsfVal
                      };

                      jQuery.ajax({
                          type: "POST",
                          url: $scope.ajaxurl,
                          data: post_data,                 
                          success: function(data) {
                              // return success  
                          }
                      });
            
}
$scope.addproduct = function(productname , model , descriptions , cost , quantity , categories , supplier_id){
	 
	if ($scope.OperationStatus  == "edit") {

		$scope.names[$scope.currentIndex]['Productname'] = productname;
		$scope.names[$scope.currentIndex]['Descriptions'] = descriptions;
		$scope.names[$scope.currentIndex]['Model'] = model;
		$scope.names[$scope.currentIndex]['Cost'] = cost;
		$scope.names[$scope.currentIndex]['Quantity'] = quantity;
		$scope.names[$scope.currentIndex]['Categories'] = categories;
		$scope.names[$scope.currentIndex]['Supplier_id'] = supplier_id;
		$scope.productname = null;
		$scope.model =null;
		$scope.descriptions = null;
		$scope.cost = null;
		$scope.quantity = null;
		$scope.categories = null;


	}else if ($scope.OperationStatus  == "insert") {
			var text = "Please choose ";
			var g = 0 ;
			if (supplier_id == "" || supplier_id == null) {
			 	text += 'supplier_id ';
			 	g = 1;
			 }
			 if (categories == ""  || categories == null ) {			 	
			 	
				if (g == 1) {
					text +="and categories";
				}else{
					text += "categories";				
				}
			 }

			 if (g == 1){
			 	alert(text);
			 };
			 
			
			if (productname != null && model != null && supplier_id != null && categories != null) {

				var count = 0;
				var insert = true;
				angular.forEach($scope.names,
				 	function(item){

				 		if (item['Model'] === $scope.model){
				 			$scope.names[count]['Productname'] = productname;
				 			$scope.names[count]['Descriptions'] = descriptions;
				 			$scope.names[count]['Model'] = model;
				 			$scope.names[count]['Cost'] = cost;
				 			$scope.names[count]['Quantity'] = $scope.names[count]['Quantity'] + quantity;
				 			$scope.names[count]['Categories'] = categories;
				 			$scope.names[count]['Supplier_id'] = supplier_id;	
				 			insert =  false;
				 		};

				 		count = count + 1;
				 	} 
			 	);
				if (insert === true ) {
					$scope.names.push({ id : $scope.ArrID+=1,
										Productname : productname,
										Model : model, 
										Descriptions : descriptions, 
										Cost : cost,
										Quantity : quantity,
										Categories : categories,
										Supplier_id : supplier_id
									});
				};
				$scope.productname = null;
				$scope.model =null;
				$scope.descriptions = null;
				$scope.cost = null;
				$scope.quantity = null;
				$scope.categories = null;

			}else{

				productname = null;
				model =null;
				descriptions = null;
				cost = null;
				quantity = null;
				categories = null;
			}

	

	};
				$scope.re_productname = productname;	
				$scope.re_model = model;
				$scope.re_descriptions = descriptions;
				$scope.re_cost = cost;
				$scope.re_quantity = quantity;
				$scope.re_categories = categories;	
				$scope.OperationStatus  = "insert";
				$scope.buttonName = "Add Product";	

}

});


















//-----------------------------------------------------------------------------------------------------------------------------------

angular.module('myAppSale',[]).controller('userCtrl',function($scope){
$scope.ArrID = 0;
$scope.currentIndex = '';
$scope.names = [];
$scope.buttonName = 'Add Product';
$scope.OperationStatus = "insert";
$scope.subtotal = 0;
$scope.Invoice_id = ""; 
$scope.deleteRow = function(e){
	 $scope.names.splice(e, 1);
}
$scope.editRow = function(Row){
	$scope.currentIndex = Row;
	$scope.employee_name = $scope.names[Row]['employee_name']
	$scope.date_time = $scope.names[Row]['date_time']
	$scope.productcode = $scope.names[Row]['productcode']
	$scope.productname = $scope.names[Row]['productname']
	$scope.qty = $scope.names[Row]['qty']
	$scope.total = $scope.names[Row]['total']
	$scope.unit_price = $scope.names[Row]['unit_price']
	$scope.buttonName = "Update Product";	
	$scope.OperationStatus  = "edit";
}



$scope.saveProducts = function(Row){


		input_data = $scope.names;
		crsfVal = $scope.csrfValue;
	    post_data = {       
                          'post_data': input_data, // post method name search_data is the value of textbox filter
                          'csrf_test_name' : crsfVal
                      };

                      jQuery.ajax({
                          type: "POST",
                          url: $scope.ajaxurl,
                          data: post_data,                 
                          success: function(data) {
                              // return success 
                             $scope.Invoice_id = data;   
                             alert('successfull');

                          }
                      });
            
}

$scope.printDiv = function(divName) {
  var printContents = document.getElementById(divName).innerHTML;
  var popupWin = window.open('', '_blank', 'width=300,height=300');
  popupWin.document.open()
  popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="<?php <?php echo base_url();?>assets/css/bootstrap.css; ?>" /></head><body onload="window.print()">' + printContents + '</html>');
  popupWin.document.close();
} 


$scope.addproduct = function(employee_name , date_time , productcode , productname , qty , total , customer, unit_price , paid , discount , subtotal ){
	 
	if ($scope.OperationStatus  == "edit") {

		$scope.names[$scope.currentIndex]['employee_name'] = employee_name;
		$scope.names[$scope.currentIndex]['date_time'] = date_time;
		$scope.names[$scope.currentIndex]['productcode'] = productcode;
		$scope.names[$scope.currentIndex]['productname'] = productname;
		$scope.names[$scope.currentIndex]['qty'] = qty;
		$scope.names[$scope.currentIndex]['total'] = total;
		$scope.names[$scope.currentIndex]['customer'] = customer;
		$scope.names[$scope.currentIndex]['unit_price'] = unit_price;
		$scope.names[$scope.currentIndex]['paid'] = paid;
		$scope.names[$scope.currentIndex]['discount'] = discount;
		$scope.names[$scope.currentIndex]['subtotal'] = subtotal;		

	}else if ($scope.OperationStatus  == "insert"){	

		if ($scope.productcode == null || $scope.productcode == ""  ) {

			alert("Please select select product ");

		}else{
				if ($scope.qty > 0 && $scope.unit_price != null && $scope.unit_price != ""){
					var count = 0;
					var insert = true;
					angular.forEach($scope.names,
					 	function(item){

					 		if (item['productcode'] === productcode){
					 			$scope.names[count]['employee_name'] = employee_name;
					 			$scope.names[count]['date_time'] = date_time;
					 			$scope.names[count]['productcode'] = productcode;
					 			$scope.names[count]['unit_price'] = unit_price;	
					 			$scope.names[count]['qty'] = $scope.names[count]['qty'] +  qty;
					 			$scope.names[count]['total'] = $scope.names[count]['unit_price'] *  $scope.names[count]['qty'];
					 			$scope.names[count]['customer'] = customer;
					 			$scope.names[count]['paid'] = paid;
					 			$scope.names[count]['discount'] = discount;
					 			$scope.names[count]['subtotal'] = subtotal;
					 			
					 			insert =  false;
					 		};					 		
					 		count = count + 1;
					 	} 
				 	);
					if (insert === true){
					$scope.names.push({ id : $scope.ArrID+=1,
										employee_name : employee_name,
										date_time : date_time, 
										productcode : productcode, 
										productname : productname,
										qty : qty,
										total : total,
										customer : customer,
										unit_price : unit_price ,
										paid : paid ,
										discount : discount ,
										subtotal : subtotal

									});
					
				}
				
			}else{
				if ($scope.qty == 0 ) {
					alert('Prouct out of stock!');
				};				
				if ($scope.unit_price == null || $scope.unit_price == "") {
					alert('Product not found!');
				};
			}
		}
	}
						
				$scope.productcode = null ;	
				$scope.productname = null;				
				$scope.total = null;
				$scope.qty = 1 ;	
				$scope.productname = null;				
				$scope.unit_price = null;	
				$scope.OperationStatus  = "insert";
				$scope.buttonName = "Add Product";	

					var count1 = 0;					
					$scope.subtotal = 0;
					angular.forEach($scope.names,
					 	function(item){					 		
					 			$scope.subtotal =  $scope.subtotal + item['total'];					 						 		
					 			count1 = count1 + 1;
					 	} 
				 	);
				
}

});