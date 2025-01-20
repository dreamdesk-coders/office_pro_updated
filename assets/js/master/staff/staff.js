$(document).ready(function() {
          
	function get_staff(){
			$.ajax({
			url: "handler/master/staff/get_staff.php",
			type: "GET",
			cache: false,
			success: function(data){
				// alert(data);
				$('#table').html(data); 
			}
		});
	}
	active_route("mas_");
	list_template();
	get_staff();
	
$('#save').on('click', function() {

		$("#save").attr("disabled", "disabled");

		var staff_id = $('#sid').val();
		var staff_name = $('#name').val();
		var dob = $('#dob').val();
		var father_name = $('#father_name').val();
		var nrc = $('#nrc').val();

		if($("#inlineRadio1:checked").val()){
			var gender = "Male";
		}
		else{
			var gender = "Female";
		}
		


		var position = $('#position').val();
		var ph_no = $('#ph_no').val();
		var email = $('#email').val();
		var address = $('#address').val();
		var action = "create";

		if(staff_id!="" && staff_name!="" && position!="" && ph_no!="" ){
			$.ajax({
				url: "handler/master/staff/staff_handler.php",
				type: "POST",
				data: {

					staff_id : staff_id,
					staff_name : staff_name,
					dob : dob,
					father_name : father_name,
					nrc : nrc,
					gender : gender,
					position : position,
					ph_no : ph_no,
					email : email,
					address : address,
					action : action
				},
				cache: false,
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					console.log = dataResult.statusCode;
						if(dataResult !== ""){
							if(dataResult.statusCode==200){
							$("#save").removeAttr("disabled");
							// $('#fupForm').find('input:text').val('');

							alert_('Success','New staff has been created.');

							$('#sid').val('');
							$('#name').val('');
							$('#dob').val('');
							$('#father_name').val('');
							$('#nrc').val('');	
							document.getElementById("inlineRadio1").checked = true;
							document.getElementById("inlineRadio2").checked = false;
							
							$('#position').val('');
							$('#ph_no').val('');
							$('#email').val('');
							$('#address').val('');

							list_template();

							get_staff();						
						}
						else if(dataResult.statusCode==201){
						   $("#save").removeAttr("disabled");

							alert_('Fail','An error occurred while saving new staff.');

							$('#sid').val('');
							$('#name').val('');
							$('#dob').val('');
							$('#father_name').val('');
							$('#nrc').val('');	
							document.getElementById("inlineRadio1").checked = true;
							document.getElementById("inlineRadio2").checked = false;
							
							$('#position').val('');
							$('#ph_no').val('');
							$('#email').val('');
							$('#address').val('');

							list_template();
							get_staff();	
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
		
		var staff_id = $('#u_sid').val();
		var staff_name = $('#u_name').val();
		var dob = $('#u_dob').val();
		var father_name = $('#u_father_name').val();
		var nrc = $('#u_nrc').val();

		if($("#u_inlineRadio1:checked").val()){
			var gender = "Male";
		}
		else{
			var gender = "Female";
		}
		
		var position = $('#u_position').val();
		var ph_no = $('#u_ph_no').val();
		var email = $('#u_email').val();
		var address = $('#u_address').val();
		var action = "update";

		if(staff_id!="" && staff_name!="" && position!="" && ph_no!="" ){
			$.ajax({
				url: "handler/master/staff/staff_handler.php",
				type: "POST",
				data: {

					staff_id : staff_id,
					staff_name : staff_name,
					dob : dob,
					father_name : father_name,
					nrc : nrc,
					gender : gender,
					position : position,
					ph_no : ph_no,
					email : email,
					address : address,
					action : action
				},
				cache: false,
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					console.log = dataResult.statusCode;
						if(dataResult !== ""){
							if(dataResult.statusCode==200){
							$("#update").removeAttr("disabled");

							alert_('Success','Staff updated successfully.');

							$('#u_sid').val('');
							$('#u_name').val('');
							$('#u_dob').val('');
							$('#u_father_name').val('');
							$('#u_nrc').val('');
							document.getElementById("u_inlineRadio1").checked = true;
							document.getElementById("u_inlineRadio2").checked = false;	
							$('#u_position').val('');
							$('#u_ph_no').val('');
							$('#u_email').val('');
							$('#u_address').val('');
							list_template();
							get_staff();						
						}
						else if(dataResult.statusCode==201){
						   $("#update").removeAttr("disabled");

							alert_('Fail','Cannot update staff.');

							$('#u_sid').val('');
							$('#u_name').val('');
							$('#u_dob').val('');
							$('#u_father_name').val('');
							$('#u_nrc').val('');
							document.getElementById("u_inlineRadio1").checked = true;
							document.getElementById("u_inlineRadio2").checked = false;	
							$('#u_position').val('');
							$('#u_ph_no').val('');
							$('#u_email').val('');
							$('#u_address').val('');

							list_template();
							get_staff();	
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

	function get_staff_(){
            $.ajax({
            url: "handler/master/staff/get_staff.php",
            type: "GET",
            cache: false,
            success: function(data){
                $('#table').html(data); 
            }
        });
    }

	function delete_staff(staff_id){
		var staff_id = staff_id;
		var action = "delete";
		if(staff_id!=""){
			$.ajax({
				url: "handler/master/staff/staff_handler.php",
				type: "POST",
				data: {
					staff_id: staff_id,
					action:action				
				},
				cache: false,
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
						if(dataResult !== ""){
							if(dataResult.statusCode==200){

								alert_('Success','Staff has been deleted.');

								get_staff_();						
						}
						else if(dataResult.statusCode==201){

								alert_('Success','Cannot delete staff.');

								get_staff_();	
						}
					}		
				}
			});
		}
	}

	function update_datafill(id,name,dob,f_name,nrc,position,gender,ph_no,email,address){
		
		update_template();
		
		var id = id;
		var name = name;
		var dob = dob;
		var f_name = f_name;
		var nrc = nrc;
		var position = position;
		var gender = gender;
		var ph_no = ph_no;
		var email = email;
		var address = address;

		$('#u_sid').val(id);
		$('#u_name').val(name);
		$('#u_dob').val(dob);
		$('#u_father_name').val(f_name);
		$('#u_nrc').val(nrc);
		$('#u_position').val(position);
		if(gender=="Male"){
			document.getElementById("u_inlineRadio1").checked = true;
			document.getElementById("u_inlineRadio2").checked = false;
		}
		else{
			document.getElementById("u_inlineRadio1").checked = false;
			document.getElementById("u_inlineRadio2").checked = true;
		}
		$('#u_ph_no').val(ph_no);
		$('#u_email').val(email);
		$('#u_address').val(address);	
		
	}


