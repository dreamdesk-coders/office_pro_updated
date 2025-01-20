$(document).ready(function() {

	$("#btn_f_category_id").click(function() {
        get_lookup_data('category','category_id','category_name','Category ID','Category Name','f_category_id')
    });

   	$("#btn_t_category_id").click(function() {
        get_lookup_data('category','category_id','category_name','Category ID','Category Name','t_category_id')
    });
          
	function get_category() {
		$.ajax({
			url: "handler/master/category/get_category.php",
			type: "GET",
			cache: false,
			success: function (data) {
				$('#category-table').html(data);
				
				$('#category_list').DataTable();
			}
		});
	}

	active_route("mas_");

	get_category();

	list_template();


$('#save').on('click', function() {
		$("#save").attr("disabled", "disabled");
		var category_id = $('#category_id').val();
		var category_name = $('#category_name').val();
		var action = "create";
		if(category_id!="" && category_name!=""){
			$.ajax({
				url: "handler/master/category/category_handler.php",
				type: "POST",
				data: {
					category_id: category_id,
					category_name: category_name,
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

							alert_('Success','New category has been created.');

							$('#category_id').val('');
							$('#category_name').val('');
							
						
							list_template();
							get_category();						
						}
						else if(dataResult.statusCode==201){
						   $("#save").removeAttr("disabled");

							alert_('Fail','An error occurred while saving new category.');
							
							$('#category_id').val('');
							$('#category_name').val('');
							list_template();
							get_category();	
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
		var category_id = $('#u_category_id').val();
		var category_name = $('#u_category_name').val();
		var action = "update";
		if(category_id!="" && category_name!=""){
			$.ajax({
				url: "handler/master/category/category_handler.php",
				type: "POST",
				data: {
					category_id: category_id,
					category_name: category_name,
					action:action		
				},
				cache: false,
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
					console.log = dataResult.statusCode;
						if(dataResult !== ""){
							if(dataResult.statusCode==200){
							$("#update").removeAttr("disabled");

							alert_('Success','Category updated successfully.');

							$('#u_category_id').val('');
							$('#u_category_name').val('');
							list_template();
							get_category();						
						}
						else if(dataResult.statusCode==201){
						   $("#update").removeAttr("disabled");

							alert_('Fail','Cannot update category.');

							$('#u_category_id').val('');
							$('#u_category_name').val('');
							
							list_template();
							get_category();	
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

	function get_category_(){
		$.ajax({
			url: "handler/master/category/get_category.php",
			type: "GET",
			cache: false,
			success: function (data) {
				$('#category-table').html(data);
				
				$('#category_list').DataTable();
			}
		});
    }

    function get_category_filter(min,max){
    		var min = min;
			var mix = max;
            $.ajax({
            url: "handler/master/category/get_category.php",
            type: "POST",
            data: {
					min: min,
					max: max		
				},
            cache: false,
            success: function(data){
                $('#category-table').html(data);
                $('#category_list').DataTable();
            }
        });
    }

	function delete_category(category_id){
		var category_id = category_id;
		var action = "delete";
		if(category_id!=""){
			$.ajax({
				url: "handler/master/category/category_handler.php",
				type: "POST",
				data: {
					category_id: category_id,
					action:action				
				},
				cache: false,
				success: function(dataResult){
					var dataResult = JSON.parse(dataResult);
						if(dataResult !== ""){
							if(dataResult.statusCode==200){
							
							alert_('Success','Category has been deleted.');

							get_category_();						
						}
						else if(dataResult.statusCode==201){
							alert_('Fail','Cannot delete category.');
							get_category_();	
						}
					}		
				}
			});
		}
	}

	function update_datafill(category_id,category_name){

		update_template();

		var category_id = category_id;
		var category_name = category_name;

		$('#u_category_id').val(category_id);
		$('#u_category_name').val(category_name);
		
	}


