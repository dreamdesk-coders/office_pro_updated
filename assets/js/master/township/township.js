$(document).ready(function() {

	$("#btn_f_township_id").click(function() {
        get_lookup_data('township','township_id','township_name','Township ID','Township Name','f_township_id')
    });

   	$("#btn_t_township_id").click(function() {
        get_lookup_data('township','township_id','township_name','Township ID','Township Name','t_township_id')
    });
          
	function get_township(){
			$.ajax({
			url: "handler/master/township/get_township.php",
			type: "GET",
			cache: false,
			success: function (data) {
				$('#township-table').html(data);
				
				$('#township_list').DataTable();

			}
		});
	}


	active_route("mas_");
	list_template();

	get_township();
	
$('#save').on('click', function() {
		$("#save").attr("disabled", "disabled");
		var township_id = $('#township_id').val();
		var township_name = $('#township_name').val();
		var action = "create";
		if(township_id!="" && township_name!=""){
			$.ajax({
				url: "handler/master/township/township_handler.php",
				type: "POST",
				data: {
					township_id: township_id,
					township_name: township_name,
					action: action
				},
				cache: false,
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					console.log = dataResult.statusCode;
						if(dataResult !== ""){
							if(dataResult.statusCode==200){
							$("#save").removeAttr("disabled");

							alert_('Success','New township has been created.');

							$('#township_id').val('');
							$('#township_name').val('');
							
							
							list_template();
							get_township();						
						}
						else if(dataResult.statusCode==201){
						   $("#save").removeAttr("disabled");

						   	alert_('Fail','An error occurred while saving new township.');

							$('#township_id').val('');
							$('#township_name').val('');

							list_template();
							get_township();	
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
		var township_id = $('#u_township_id').val();
		var township_name = $('#u_township_name').val();
		var action = "update";
		if(township_id!="" && township_name!=""){
			$.ajax({
				url: "handler/master/township/township_handler.php",
				type: "POST",
				data: {
					township_id: township_id,
					township_name: township_name,
					action:action		
				},
				cache: false,
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					console.log = dataResult.statusCode;
						if(dataResult !== ""){
							if(dataResult.statusCode==200){
							$("#update").removeAttr("disabled");

							alert_('Success','Township updated successfully.');

							$('#u_township_id').val('');
							$('#u_township_name').val('');

							list_template();
							get_township();						
						}
						else if(dataResult.statusCode==201){
						   $("#update").removeAttr("disabled");

							alert_('Fail','Cannot update township.');

							$('#u_township_id').val('');
							$('#u_township_name').val('');

							list_template();
							get_township();	
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

function get_township_(){
	$.ajax({
		url: "handler/master/township/get_township.php",
		type: "GET",
		cache: false,
		success: function (data) {
			$('#township-table').html(data);
			
			$('#township_list').DataTable();
		}
	});
}

	function delete_township(township_id){
		var township_id = township_id;
		var action = "delete";
		if(township_id!=""){
			$.ajax({
				url: "handler/master/township/township_handler.php",
				type: "POST",
				data: {
					township_id: township_id,
					action:action				
				},
				cache: false,
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
						if(dataResult !== ""){
							if(dataResult.statusCode==200){

							alert_('Success','Township has been deleted.');

							get_township_();						
						}
						else if(dataResult.statusCode==201){

							alert_('Fail','Cannot delete township.');
							get_township_();	
						}
					}		
				}
			});
		}
	}


	function get_township_filter(min,max){
		var min = min;
		var mix = max;
		$.ajax({
		url: "handler/master/township/get_township.php",
		type: "POST",
		data: {
				min: min,
				max: max		
			},
		cache: false,
		success: function(data){
			$('#township-table').html(data);
			$('#township_list').DataTable();
		}
	});
}

	function update_datafill(township_id,township_name){
		
		update_template();

		var township_id = township_id;
		var township_name = township_name;
		$('#u_township_id').val(township_id);
		$('#u_township_name').val(township_name);
		
	}


