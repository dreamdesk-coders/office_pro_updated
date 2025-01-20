$(document).ready(function() {

    $("#btn_f_customer_id").click(function() {
        get_lookup_data('customer', 'customer_id', 'customer_name', 'Customer ID', 'Customer Name', 'f_customer_id')
    });

    $("#btn_t_customer_id").click(function() {
        get_lookup_data('customer', 'customer_id', 'customer_name', 'Customer ID', 'Customer Name', 't_customer_id')
    });


    function get_customer() {
        $.ajax({
            url: "handler/master/customer/get_customer.php",
            type: "GET",
            cache: false,
            success: function(data) {
                $('#customer-table').html(data);
                $('#customer_list').DataTable();
            }
        });
    }



    active_route("mas_");
    list_template();
    get_customer();

    $('#save').on('click', function() {

        $("#save").attr("disabled", "disabled");

        var customer_id = $('#customer_id').val();
        var customer_name = $('#customer_name').val();
        var address = $('#address').val();
        var ph_no = $('#ph_no').val();
        var email = $('#email').val();
        var remark = $('#remark').val();

        var action = "create";

        if (customer_id != "" && customer_name != "") {
            $.ajax({
                url: "handler/master/customer/customer_handler.php",
                type: "POST",
                data: {

                    customer_id: customer_id,
                    customer_name: customer_name,
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

                            alert_('Success', 'New customer has been created.');

                            $('#customer_id').val('');
                            $('#customer_name').val('');
                            $('#address').val('');
                            $('#ph_no').val('');
                            $('#email').val('');
                            $('#remark').val('');

                            list_template();
                            get_customer();
                        } else if (dataResult.statusCode == 201) {
                            $("#save").removeAttr("disabled");

                            alert_('Fail', 'An error occurred while saving new customer.');

                            $('#customer_id').val('');
                            $('#customer_name').val('');
                            $('#address').val('');
                            $('#ph_no').val('');
                            $('#email').val('');
                            $('#remark').val('');
                            list_template();
                            get_customer();
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

        var customer_id = $('#u_customer_id').val();
        var customer_name = $('#u_customer_name').val();
        var address = $('#u_address').val();
        var ph_no = $('#u_ph_no').val();
        var email = $('#u_email').val();
        var remark = $('#u_remark').val();
        var action = "update";

        if (customer_id != "" && customer_name != "") {
            $.ajax({
                url: "handler/master/customer/customer_handler.php",
                type: "POST",
                data: {

                    customer_id: customer_id,
                    customer_name: customer_name,
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

                            alert_('Success', 'Customer updated successfully.');

                            $('#u_customer_id').val('');
                            $('#u_customer_name').val('');
                            $('#u_address').val('');
                            $('#u_ph_no').val('');
                            $('#u_email').val('');
                            $('#u_remark').val('');

                            list_template();
                            get_customer();
                        } else if (dataResult.statusCode == 201) {
                            $("#update").removeAttr("disabled");

                            alert_('Fail', 'Cannot update customer.');

                            $('#u_customer_id').val('');
                            $('#u_customer_name').val('');
                            $('#u_address').val('');
                            $('#u_ph_no').val('');
                            $('#u_email').val('');
                            $('#u_remark').val('');

                            list_template();
                            get_customer();
                        }
                    }
                }
            });
        } else {
            $("#update").removeAttr("disabled");
        }
    });

});

function get_customer_() {
    $.ajax({
        url: "handler/master/customer/get_customer.php",
        type: "GET",
        cache: false,
        success: function(data) {
            $('#customer-table').html(data);
            $('#customer_list').DataTable();
        }
    });
}

function delete_customer(customer_id) {
    var customer_id = customer_id;
    var action = "delete";
    if (customer_id != "") {
        $.ajax({
            url: "handler/master/customer/customer_handler.php",
            type: "POST",
            data: {
                customer_id: customer_id,
                action: action
            },
            cache: false,
            success: function(dataResult) {
                var dataResult = JSON.parse(dataResult);
                if (dataResult !== "") {
                    if (dataResult.statusCode == 200) {

                        alert_('Success', 'Customer has been deleted.');

                        get_customer_();

                    } else if (dataResult.statusCode == 201) {

                        alert_('Fail', 'Cannot delete customer.');

                        get_customer_();
                    }
                }
            }
        });
    }
}

function get_customer_filter(min, max) {
    var min = min;
    var mix = max;
    $.ajax({
        url: "handler/master/customer/get_customer.php",
        type: "POST",
        data: {
            min: min,
            max: max
        },
        cache: false,
        success: function(data) {
            $('#customer-table').html(data);
            $('#customer_list').DataTable();
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

    $('#u_customer_id').val(id);
    $('#u_customer_name').val(name);
    $('#u_address').val(address);
    $('#u_ph_no').val(ph_no);
    $('#u_email').val(email);
    $('#u_remark').val(remark);


}