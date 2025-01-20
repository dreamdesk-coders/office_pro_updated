$(document).ready(function() {

    $("#btn_f_stock_id").click(function() {
        get_lookup_data('stock', 'stock_id', 'stock_name', 'Stock ID', 'Stock Name', 'f_stock_id')
    });

    $("#btn_t_stock_id").click(function() {
        get_lookup_data('stock', 'stock_id', 'stock_name', 'Stock ID', 'Stock Name', 't_stock_id')
    });

    function get_stock() {
        $.ajax({
            url: "handler/master/stock/get_stock.php",
            type: "GET",
            cache: false,
            success: function(data) {
                $('#stock_table').html(data);

                $('#stock_list').DataTable();

            }
        });
    }


    active_route("mas_");

    get_stock();

    list_template();


    $('#save').on('click', function() {
        $("#save").attr("disabled", "disabled");
        var stock_id = $('#stock_id').val();
        var stock_name = $('#stock_name').val();
        var stocking_unit_id = $('#stocking_unit_id ').val();
        var category_id = $('#category_id').val();
        var rg_id = $('#rg_id').val();
        var action = "create";
        if (stock_id != "" && stock_name != "" && category_id !== "" && rg_id != "") {
            $.ajax({
                url: "handler/master/stock/stock_handler.php",
                type: "POST",
                data: {
                    stock_id: stock_id,
                    stock_name: stock_name,
                    stocking_unit_id: stocking_unit_id,
                    category_id: category_id,
                    rg_id: rg_id,
                    action: action
                },
                cache: false,
                success: function(dataResult) {
                    var dataResult = JSON.parse(dataResult);
                    console.log = dataResult.statusCode;
                    if (dataResult !== "") {
                        if (dataResult.statusCode == 200) {
                            $("#save").removeAttr("disabled");
                            // $('#fupForm').find('input:text').val('');

                            alert_('Success', 'New stock has been created.');

                            $('#stock_id').val('');
                            $('#stock_name').val('');
                            $('#stocking_unit_id').val('');
                            $('#category_id').val('');
                            $('#rg_id').val('');


                            list_template();
                            get_stock();
                        } else if (dataResult.statusCode == 201) {
                            $("#save").removeAttr("disabled");

                            alert_('Fail', 'An error occurred while saving new stock.');

                            $('#stock_id').val('');
                            $('#stock_name').val('');
                            $('#stocking_unit_id').val('');
                            $('#category_id').val('');
                            $('#rg_id').val('');
                            list_template();
                            get_stock();
                        }
                    }
                }
            });
        } else {
            $("#save").removeAttr("disabled");
        }
    });

    $('#update').on('click', function() {
        $("#update").attr("disabled", "disabled");
        var stock_id = $('#u_stock_id').val();
        var stock_name = $('#u_stock_name').val();
        var stocking_unit_id = $('#u_stocking_unit_id').val();
        var category_id = $('#u_category_id').val();
        var rg_id = $('#u_rg_id').val();
        var action = "update";
        if (stock_id != "" && stock_name != "" && category_id !== "" && rg_id != "") {
            $.ajax({
                url: "handler/master/stock/stock_handler.php",
                type: "POST",
                data: {
                    stock_id: stock_id,
                    stock_name: stock_name,
                    stocking_unit_id: stocking_unit_id,
                    category_id: category_id,
                    rg_id: rg_id,
                    action: action
                },
                cache: false,
                success: function(dataResult) {
                    var dataResult = JSON.parse(dataResult);
                    console.log = dataResult.statusCode;
                    if (dataResult !== "") {
                        if (dataResult.statusCode == 200) {
                            $("#update").removeAttr("disabled");

                            alert_('Success', 'Stock updated successfully.');

                            $('#u_stock_id').val('');
                            $('#u_stock_name').val('');
                            $('#u_stocking_unit_id').val('');
                            $('#u_category_id').val('');
                            $('#u_rg_id').val('');

                            list_template();
                            get_stock();
                        } else if (dataResult.statusCode == 201) {
                            $("#update").removeAttr("disabled");

                            alert_('Fail', 'Cannot update stock.');

                            $('#u_stock_id').val('');
                            $('#u_stock_name').val('');
                            $('#u_stocking_unit_id').val('');
                            $('#u_category_id').val('');
                            $('#u_rg_id').val('');

                            list_template();
                            get_stock();
                        }
                    }
                }
            });
        } else {
            $("#update").removeAttr("disabled");
        }
    });

});

function get_stock_() {
    $.ajax({
        url: "handler/master/stock/get_stock.php",
        type: "GET",
        cache: false,
        success: function(data) {
            $('#stock_table').html(data);

            $('#stock_list').DataTable();
        }
    });
}

function get_stock_filter(min, max) {
    var min = min;
    var max = max;
    $.ajax({
        url: "handler/master/stock/get_stock.php",
        type: "POST",
        data: {
            min: min,
            max: max
        },
        cache: false,
        success: function(data) {
            $('#stock_table').html(data);
            $('#stock_list').DataTable();
        }
    });
}

function delete_stock(stock_id) {
    var stock_id = stock_id;
    var action = "delete";
    if (stock_id != "") {
        $.ajax({
            url: "handler/master/stock/stock_handler.php",
            type: "POST",
            data: {
                stock_id: stock_id,
                action: action
            },
            cache: false,
            success: function(dataResult) {
                var dataResult = JSON.parse(dataResult);
                if (dataResult !== "") {
                    if (dataResult.statusCode == 200) {

                        alert_('Success', 'Stock has been deleted.');

                        get_stock_();
                    } else if (dataResult.statusCode == 201) {

                        alert_('Fail', 'Cannot delete stock.');

                        get_stock_();
                    }
                }
            }
        });
    }
}

function update_datafill(stock_id, stock_name, stocking_unit_id, category_id, rg_id) {

    update_template();

    var stock_id = stock_id;
    var stock_name = stock_name;
    var stocking_unit_id = stocking_unit_id;
    var category_id = category_id;
    var rg_id = rg_id;

    $('#u_stock_id').val(stock_id);
    $('#u_stock_name').val(stock_name);
    $('#u_stocking_unit_id').val(stocking_unit_id);
    $('#u_category_id').val(category_id);
    $('#u_rg_id').val(rg_id);

}