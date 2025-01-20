$(document).ready(function() {

	$("#btn_f_currency_id").click(function() {
        get_lookup_data('currency','currency_id','currency_name','Currency ID','Currency Name','f_currency_id')
    });

   	$("#btn_t_currency_id").click(function() {
        get_lookup_data('currency','currency_id','currency_name','Currency ID','Currency Name','t_currency_id')
    });
          
	function get_currency(){
			$.ajax({
			url: "handler/master/currency/get_currency.php",
			type: "GET",
			cache: false,
			success: function (data) {
				$('#currency-table').html(data);
				
				$('#currency_list').DataTable();

			}
		});
	}


	active_route("mas_");
	list_template();

	get_currency();
	
$('#save').on('click', function() {
		$("#save").attr("disabled", "disabled");
		var currency_id = $('#currency_id').val();
		var currency_name = $('#currency_name').val();
		var action = "create";
		if(currency_id!="" && currency_name!=""){
			$.ajax({
				url: "handler/master/currency/currency_handler.php",
				type: "POST",
				data: {
					currency_id: currency_id,
					currency_name: currency_name,
					action: action
				},
				cache: false,
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					console.log = dataResult.statusCode;
						if(dataResult !== ""){
							if(dataResult.statusCode==200){
							$("#save").removeAttr("disabled");

							alert_('Success','New currency has been created.');

							$('#currency_id').val('');
							$('#currency_name').val('');
							
							
							list_template();
							get_currency();						
						}
						else if(dataResult.statusCode==201){
						   $("#save").removeAttr("disabled");

						   	alert_('Fail','An error occurred while saving new currency.');

							$('#currency_id').val('');
							$('#currency_name').val('');

							list_template();
							get_currency();	
						}
					}		
				}
			});
		}
		else{
			$("#save").removeAttr("disabled");
		}
	});

$('#update').on('click', function() {
		$("#update").attr("disabled", "disabled");
		var currency_id = $('#u_currency_id').val();
		var currency_name = $('#u_currency_name').val();
		var action = "update";
		if(currency_id!="" && currency_name!=""){
			$.ajax({
				url: "handler/master/currency/currency_handler.php",
				type: "POST",
				data: {
					currency_id: currency_id,
					currency_name: currency_name,
					action:action		
				},
				cache: false,
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					console.log = dataResult.statusCode;
						if(dataResult !== ""){
							if(dataResult.statusCode==200){
							$("#update").removeAttr("disabled");

							alert_('Success','Currency updated successfully.');

							$('#u_currency_id').val('');
							$('#u_currency_name').val('');

							list_template();
							get_currency();						
						}
						else if(dataResult.statusCode==201){
						   $("#update").removeAttr("disabled");

							alert_('Fail','Cannot update currency.');

							$('#u_currency_id').val('');
							$('#u_currency_name').val('');

							list_template();
							get_currency();	
						}
					}		
				}
			});
		}
		else{
			$("#update").removeAttr("disabled");
		}
	});

});

function get_currency_(){
	$.ajax({
		url: "handler/master/currency/get_currency.php",
		type: "GET",
		cache: false,
		success: function (data) {
			$('#currency-table').html(data);
			
			$('#currency_list').DataTable();
		}
	});
}

	function delete_currency(currency_id){
		var currency_id = currency_id;
		var action = "delete";
		if(currency_id!=""){
			$.ajax({
				url: "handler/master/currency/currency_handler.php",
				type: "POST",
				data: {
					currency_id: currency_id,
					action:action				
				},
				cache: false,
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
						if(dataResult !== ""){
							if(dataResult.statusCode==200){

							alert_('Success','Currency has been deleted.');

							get_currency_();						
						}
						else if(dataResult.statusCode==201){

							alert_('Fail','Cannot delete currency.');
							get_currency_();	
						}
					}		
				}
			});
		}
	}


	function get_currency_filter(min,max){
		var min = min;
		var mix = max;
		$.ajax({
		url: "handler/master/currency/get_currency.php",
		type: "POST",
		data: {
				min: min,
				max: max		
			},
		cache: false,
		success: function(data){
			$('#currency-table').html(data);
			$('#currency_list').DataTable();
		}
	});
}

	function update_datafill(currency_id,currency_name){
		
		update_template();

		var currency_id = currency_id;
		var currency_name = currency_name;
		$('#u_currency_id').val(currency_id);
		$('#u_currency_name').val(currency_name);
		
	}


