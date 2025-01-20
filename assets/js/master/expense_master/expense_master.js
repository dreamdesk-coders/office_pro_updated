$(document).ready(function() {

	$("#btn_f_expense_id").click(function() {
        get_lookup_data('expense_master','expense_id','description','Epense ID','Description','f_expense_id')
    });

   	$("#btn_t_expense_id").click(function() {
        get_lookup_data('expense_master','expense_id','description','Expense ID','Description','t_expense_id')
    });
         
          
	function get_expense() {
		$.ajax({
			url: "handler/master/expense_master/get_expense.php",
			type: "GET",
			cache: false,
			success: function (data) {
				$('#expense_table').html(data);
				
				$('#expense_list').DataTable();
	

			}
		});
	}


	active_route("mas_");
	list_template();
	get_expense();
	
$('#save').on('click', function() {
		$("#save").attr("disabled", "disabled");
		var expense_id = $('#expense_id').val();
		var description = $('#description').val();
		var action = "create";
		if(expense_id!="" && description!=""){
			$.ajax({
				url: "handler/master/expense_master/expense_handler.php",
				type: "POST",
				data: {
					expense_id: expense_id,
					description: description,
					action: action
				},
				cache: false,
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					console.log = dataResult.statusCode;
						if(dataResult !== ""){
							if(dataResult.statusCode==200){
							$("#save").removeAttr("disabled");
							// $('#fupForm').find('input:text').val('');

							alert_('Success','New expense master has been created.');
							
							$('#expense_id').val('');
							$('#description').val('');
							
							list_template();

							get_expense();						
						}
						else if(dataResult.statusCode==201){
						   $("#save").removeAttr("disabled");

							alert_('Fail','An error occurred while saving new expense master.');

							$('#expense_id').val('');
							$('#description').val('');

							list_template();
							get_expense();	
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
		var expense_id = $('#u_expense_id').val();
		var description = $('#u_description').val();
		var action = "update";
		if(expense_id!="" && description!=""){
			$.ajax({
				url: "handler/master/expense_master/expense_handler.php",
				type: "POST",
				data: {
					expense_id: expense_id,
					description: description,
					action:action		
				},
				cache: false,
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					console.log = dataResult.statusCode;
						if(dataResult !== ""){
							if(dataResult.statusCode==200){
							$("#update").removeAttr("disabled");

							alert_('Success','Expense master updated successfully.');

							$('#u_expense_id').val('');
							$('#u_description').val('');

							list_template();
							get_expense();						
						}
						else if(dataResult.statusCode==201){
						   $("#update").removeAttr("disabled");

							alert_('Fail','Cannot update expense master.');

							$('#u_expense_id').val('');
							$('#u_description').val('');

							list_template();
							get_expense();	
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

function get_expense_(){
	$.ajax({
		url: "handler/master/expense_master/get_expense.php",
		type: "GET",
		cache: false,
		success: function (data) {
			$('#expense_table').html(data);
			
			$('#expense_list').DataTable();
		}
	});
}

function get_expense_filter(min,max){
		var min = min;
		var mix = max;
		$.ajax({
		url: "handler/master/expense_master/get_expense.php",
		type: "POST",
		data: {
				min: min,
				max: max		
			},
		cache: false,
		success: function(data){
			$('#expense_table').html(data);
			$('#expense_list').DataTable();
		}
	});
}

	function delete_expense(expense_id){
		var expense_id = expense_id;
		var action = "delete";
		if(expense_id!=""){
			$.ajax({
				url: "handler/master/expense_master/expense_handler.php",
				type: "POST",
				data: {
					expense_id: expense_id,
					action:action				
				},
				cache: false,
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
						if(dataResult !== ""){
							if(dataResult.statusCode==200){

							alert_('Success','Expense Master has been deleted.');

							get_expense_();						
						}
						else if(dataResult.statusCode==201){

							alert_('Fail','Cannot delete expense master.');

							get_expense_();	
						}
					}		
				}
			});
		}
	}

	function update_datafill(expense_id,description){

		update_template();
		var expense_id = expense_id;
		var description = description;

		$('#u_expense_id').val(expense_id);
		$('#u_description').val(description);
		
	}


