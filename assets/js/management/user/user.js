$(document).ready(function() {
          
	function get_user(){
			$.ajax({
			url: "handler/management/user/get_user.php",
			type: "GET",
			cache: false,
			success: function(data){
				// alert(data);
				$('#user-table').html(data);
				$('#user-list').DataTable();  
			}    
		});
	}

	active_route("manage_");

	get_user();

	list_template();


$('#save').on('click', function() {
		$("#save").attr("disabled", "disabled");
		var login_id = $('#login_id').val();
		var office_id = $('#office_id').val();
		var password = $('#password').val();
		var role = $('#login_role').val();
		var action = "create";
		if(login_id!="" && office_id!="" && password!==""){
			$.ajax({
				url: "handler/management/user/user_handler.php",
				type: "POST",
				data: {
					login_id: login_id,
					office_id: office_id,
					password: password,
					role:role,
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

							alert_('Success','New user has been created.');

							$('#login_id').val('');
							$('#office_id').val('');
							$('#password').val('');
							
						
							list_template();
							get_user();						
						}
						else if(dataResult.statusCode==201){
						   $("#save").removeAttr("disabled");

							alert_('Fail','User account already exists.');

							$('#login_id').val('');
							$('#office_id').val('');
							$('#password').val('');

							list_template();
							get_user();	
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
		var login_id = $('#u_login_id').val();
		var office_id = $('#u_office_id').val();
		var old_password = $('#old_password').val();
		var new_password = $('#new_password').val();
		var role = $('#u_login_role').val();

		var action = "update";
		if(login_id!="" && office_id!=""){
			$.ajax({
				url: "handler/management/user/user_handler.php",
				type: "POST",
				data: {
					login_id: login_id,
					office_id: office_id,
					old_password : old_password,
					new_password:new_password,
					role:role,
					action:action		
				},
				cache: false,
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					console.log = dataResult.statusCode;
						if(dataResult !== ""){
							if(dataResult.statusCode==200){
							$("#update").removeAttr("disabled");

							alert_('Success','User updated successfully.');

							$('#u_user_id').val('');
							$('#u_user_name').val('');
							list_template();
							get_user();						
						}
						else if(dataResult.statusCode==201){
						   $("#update").removeAttr("disabled");

							alert_('Success','Can not update user.');

							$('#u_login_id').val('');
							$('#u_office_id').val('');
							$('#old_password').val('');
							$('#new_password').val('');
							
							list_template();
							get_user();	
						}
						if(dataResult.statusCode==400){
							$("#update").removeAttr("disabled");
						   	
							alert_('Warning','Password is not correct.');

							$('#old_password').val('');
							$('#new_password').val('');
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

	function get_user_(){
            $.ajax({
            url: "handler/management/user/get_user.php",
            type: "GET",
            cache: false,
            success: function(data){
                $('#table').html(data); 
            }
        });
    }

	function delete_user(login_id){
		var login_id = login_id;
		var action = "delete";
		if(login_id!=""){
			$.ajax({
				url: "handler/management/user/user_handler.php",
				type: "POST",
				data: {
					login_id: login_id,
					action:action				
				},
				cache: false,
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
						if(dataResult !== ""){
							if(dataResult.statusCode==200){

							alert_('Success','User has been deleted.');
							get_user_();						
						}
						else if(dataResult.statusCode==201){
							alert_('Fail','Cannot delete user.');
							get_user_();	
						}
					}		
				}
			});
		}
	}

	function update_datafill(login_id,office_id,role){

		update_template();

		var login_id = login_id;
		var office_id = office_id;
		var role = role;

		$('#u_login_id').val(login_id);
		$('#u_office_id').val(office_id);

		if(role == "Staff"){
			$('#u_login_role').val("Staff");
		}
		else if(role == "Office Admin"){
			$('#u_login_role').val("Office Admin");
		}
		else if(role == "Management Admin"){
			$('#u_login_role').val("Management Admin");
		}
		
	}


