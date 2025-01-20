$(document).ready(function() {

    $("#btn_f_stock_unit_id").click(function() {
        get_lookup_data('stock_unit', 'stock_unit_id', 'stock_id', 'Stock Unit ID', 'Stock ID', 'f_stock_unit_id')
    });

    $("#btn_t_stock_unit_id").click(function() {
        get_lookup_data('stock_unit', 'stock_unit_id', 'stock_id', 'Stock Unit ID', 'Stock ID', 't_stock_unit_id')
    });

    function get_stock_unit() {
        $.ajax({
            url: "handler/master/stock_unit/get_stock_unit.php",
            type: "GET",
            cache: false,
            success: function(data) {
                $('#stock_unit_table').html(data);

                $('#stock_unit_list').DataTable();


            }
        });
    }


    active_route("mas_");

    get_stock_unit();

    list_template();


    $('#save').on('click', function() {
        $("#save").attr("disabled", "disabled");
        var stock_unit_id = $('#stock_unit_id').val();
        var unit_id = $('#unit_id').val();
        var stock_id = $('#stock_id').val();
        var quantity = $('#quantity').val();
        var pprice = $('#pprice').val();
        var sprice = $('#sprice').val();
        var action = "create";
        if (stock_unit_id != "" && unit_id != "" && stock_id !== "" && quantity !== "") {
            $.ajax({
                url: "handler/master/stock_unit/stock_unit_handler.php",
                type: "POST",
                data: {
                    stock_unit_id: stock_unit_id,
                    unit_id: unit_id,
                    stock_id: stock_id,
                    quantity: quantity,
                    pprice: pprice,
                    sprice: sprice,
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

                            alert_('Success', 'New unit has been created.');

                            $('#stock_unit_id').val('');
                            $('#unit_id').val('');
                            $('#stock_id').val('');
                            $('#quantity').val('');
                            $('#pprice').val('');
                            $('#sprice').val('');


                            list_template();
                            get_stock_unit();
                        } else if (dataResult.statusCode == 201) {
                            $("#save").removeAttr("disabled");

                            alert_('Fail', 'An error occurred while saving new unit.');

                            $('#stock_unit_id').val('');
                            $('#unit_id').val('');
                            $('#stock_id').val('');
                            $('#quantity').val('');
                            $('#pprice').val('');
                            $('#sprice').val('');
                            list_template();
                            get_stock_unit();
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
        var stock_unit_id = $('#u_stock_unit_id').val();
        var unit_id = $('#u_unit_id').val();
        var stock_id = $('#u_stock_id').val();
        var quantity = $('#u_quantity').val();
        var pprice = $('#u_pprice').val();
        var sprice = $('#u_sprice').val();
        var action = "update";
        if (stock_unit_id != "" && unit_id != "" && stock_id != "") {
            $.ajax({
                url: "handler/master/stock_unit/stock_unit_handler.php",
                type: "POST",
                data: {
                    stock_unit_id: stock_unit_id,
                    unit_id: unit_id,
                    stock_id: stock_id,
                    quantity: quantity,
                    pprice: pprice,
                    sprice: sprice,
                    action: action
                },
                cache: false,
                success: function(dataResult) {
                    var dataResult = JSON.parse(dataResult);
                    console.log = dataResult.statusCode;
                    if (dataResult !== "") {
                        if (dataResult.statusCode == 200) {
                            $("#update").removeAttr("disabled");

                            alert_('Success', 'Stock unit updated successfully.');
                            $('#u_stock_unit_id').val('');
                            $('#u_unit_id').val('');
                            $('#u_stock_id').val('');
                            $('#u_quantity').val('');
                            $('#u_pprice').val('');
                            $('#u_sprice').val('');
                            list_template();
                            get_stock_unit();
                        } else if (dataResult.statusCode == 201) {
                            $("#update").removeAttr("disabled");

                            alert_('Fail', 'Cannot update stock unit.');
                            $('#u_stock_unit_id').val('');
                            $('#u_unit_id').val('');
                            $('#u_stock_id').val('');
                            $('#u_quantity').val('');
                            $('#u_pprice').val('');
                            $('#u_sprice').val('');

                            list_template();
                            get_stock_unit();
                        }
                    }
                }
            });
        } else {
            $("#update").removeAttr("disabled");
        }
    });

});

function get_stock_unit_() {
    $.ajax({
        url: "handler/master/stock_unit/get_stock_unit.php",
        type: "GET",
        cache: false,
        success: function(data) {
            $('#stock_unit_table').html(data);

            $('#stock_unit_list').DataTable();
        }
    });
}

function get_stock_unit_filter(min, max) {
    var min = min;
    var max = max;
    $.ajax({
        url: "handler/master/stock_unit/get_stock_unit.php",
        type: "POST",
        data: {
            min: min,
            max: max
        },
        cache: false,
        success: function(data) {
            $('#stock_unit_table').html(data);
            $('#stock_unit_list').DataTable();
        }
    });
}

function delete_stock_unit(stock_unit_id) {
    var stock_unit_id = stock_unit_id;
    var action = "delete";
    if (unit_id != "") {
        $.ajax({
            url: "handler/master/stock_unit/stock_unit_handler.php",
            type: "POST",
            data: {
                stock_unit_id: stock_unit_id,
                action: action
            },
            cache: false,
            success: function(dataResult) {
                var dataResult = JSON.parse(dataResult);
                if (dataResult !== "") {
                    if (dataResult.statusCode == 200) {

                        alert_('Success', 'Stock unit has been deleted.');

                        get_stock_unit_();
                    } else if (dataResult.statusCode == 201) {

                        alert_('Fail', 'Cannot delete stock unit.');

                        get_stock_unit_();
                    }
                }
            }
        });
    }
}

function update_datafill(stock_unit_id, unit_id, stock_id, quantity, pprice, sprice) {

    update_template();
    var stock_unit_id = stock_unit_id;
    var unit_id = unit_id;
    var stock_id = stock_id;
    var quantity = quantity;
    var price = price;
    $('#u_stock_unit_id').val(stock_unit_id);
    $('#u_unit_id').val(unit_id);
    $('#u_stock_id').val(stock_id);
    $('#u_quantity').val(quantity);
    $('#u_pprice').val(pprice);
    $('#u_sprice').val(sprice);

}