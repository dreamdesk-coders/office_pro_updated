$(document).ready(function() {

    $("#btn_f_supplier_id").click(function() {
        get_lookup_data('supplier', 'supplier_id', 'supplier_name', 'supplier ID', 'supplier Name', 'f_supplier_id')
    });

    $("#btn_t_supplier_id").click(function() {
        get_lookup_data('supplier', 'supplier_id', 'supplier_name', 'supplier ID', 'supplier Name', 't_supplier_id')
    });


    function get_supplier() {
        $.ajax({
            url: "handler/master/supplier/get_supplier.php",
            type: "GET",
            cache: false,
            success: function(data) {
                $('#supplier-table').html(data);
                $('#supplier_list').DataTable();
            }
        });
    }



    active_route("mas_");
    list_template();
    get_supplier();

    $('#save').on('click', function() {

        $("#save").attr("disabled", "disabled");

        var supplier_id = $('#supplier_id').val();
        var supplier_name = $('#supplier_name').val();
        var address = $('#address').val();
        var ph_no = $('#ph_no').val();
        var email = $('#email').val();
        var remark = $('#remark').val();

        var action = "create";

        if (supplier_id != "" && supplier_name != "") {
            $.ajax({
                url: "handler/master/supplier/supplier_handler.php",
                type: "POST",
                data: {

                    supplier_id: supplier_id,
                    supplier_name: supplier_name,
                    address: address,
                    ph_no: ph_no,
                    email: email,
                    remark: remark,
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

                            alert_('Success', 'New supplier has been created.');

                            $('#supplier_id').val('');
                            $('#supplier_name').val('');
                            $('#address').val('');
                            $('#ph_no').val('');
                            $('#email').val('');
                            $('#remark').val('');

                            list_template();
                            get_supplier();
                        } else if (dataResult.statusCode == 201) {
                            $("#save").removeAttr("disabled");

                            alert_('Fail', 'An error occurred while saving new supplier.');

                            $('#supplier_id').val('');
                            $('#supplier_name').val('');
                            $('#address').val('');
                            $('#ph_no').val('');
                            $('#email').val('');
                            $('#remark').val('');
                            list_template();
                            get_supplier();
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

        var supplier_id = $('#u_supplier_id').val();
        var supplier_name = $('#u_supplier_name').val();
        var address = $('#u_address').val();
        var ph_no = $('#u_ph_no').val();
        var email = $('#u_email').val();
        var remark = $('#u_remark').val();
        var action = "update";

        if (supplier_id != "" && supplier_name != "") {
            $.ajax({
                url: "handler/master/supplier/supplier_handler.php",
                type: "POST",
                data: {

                    supplier_id: supplier_id,
                    supplier_name: supplier_name,
                    address: address,
                    ph_no: ph_no,
                    email: email,
                    remark: remark,
                    action: action
                },
                cache: false,
                success: function(dataResult) {
                    var dataResult = JSON.parse(dataResult);
                    console.log = dataResult.statusCode;
                    if (dataResult !== "") {
                        if (dataResult.statusCode == 200) {
                            $("#update").removeAttr("disabled");

                            alert_('Success', 'supplier updated successfully.');

                            $('#u_supplier_id').val('');
                            $('#u_supplier_name').val('');
                            $('#u_address').val('');
                            $('#u_ph_no').val('');
                            $('#u_email').val('');
                            $('#u_remark').val('');

                            list_template();
                            get_supplier();
                        } else if (dataResult.statusCode == 201) {
                            $("#update").removeAttr("disabled");

                            alert_('Fail', 'Cannot update supplier.');

                            $('#u_supplier_id').val('');
                            $('#u_supplier_name').val('');
                            $('#u_address').val('');
                            $('#u_ph_no').val('');
                            $('#u_email').val('');
                            $('#u_remark').val('');

                            list_template();
                            get_supplier();
                        }
                    }
                }
            });
        } else {
            $("#update").removeAttr("disabled");
        }
    });

});

function get_supplier_() {
    $.ajax({
        url: "handler/master/supplier/get_supplier.php",
        type: "GET",
        cache: false,
        success: function(data) {
            $('#supplier-table').html(data);
            $('#supplier_list').DataTable();
        }
    });
}

function delete_supplier(supplier_id) {
    var supplier_id = supplier_id;
    var action = "delete";
    if (supplier_id != "") {
        $.ajax({
            url: "handler/master/supplier/supplier_handler.php",
            type: "POST",
            data: {
                supplier_id: supplier_id,
                action: action
            },
            cache: false,
            success: function(dataResult) {
                var dataResult = JSON.parse(dataResult);
                if (dataResult !== "") {
                    if (dataResult.statusCode == 200) {

                        alert_('Success', 'supplier has been deleted.');

                        get_supplier_();

                    } else if (dataResult.statusCode == 201) {

                        alert_('Fail', 'Cannot delete supplier.');

                        get_supplier_();
                    }
                }
            }
        });
    }
}

function get_supplier_filter(min, max) {
    var min = min;
    var mix = max;
    $.ajax({
        url: "handler/master/supplier/get_supplier.php",
        type: "POST",
        data: {
            min: min,
            max: max
        },
        cache: false,
        success: function(data) {
            $('#supplier-table').html(data);
            $('#supplier_list').DataTable();
        }
    });
}

function update_datafill(id, name, address, ph_no, email, remark) {

    update_template();
    var id = id;
    var name = name;
    var ph_no = ph_no;
    var email = email;
    var address = address;
    var remark = remark;

    $('#u_supplier_id').val(id);
    $('#u_supplier_name').val(name);
    $('#u_address').val(address);
    $('#u_ph_no').val(ph_no);
    $('#u_email').val(email);
    $('#u_remark').val(remark);


}