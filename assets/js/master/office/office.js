$(document).ready(function() {

    function get_office() {
        $.ajax({
            url: "handler/master/office/get_office.php",
            type: "GET",
            cache: false,
            success: function(data) {

                $('#table').html(data);
            }
        });
    }
    active_route("mas_");

    get_office();

    list_template();


    $('#save').on('click', function() {
        $("#save").attr("disabled", "disabled");
        var office_id = $('#office_id').val();
        var office_name = $('#office_name').val();
        var admin = $('#admin').val();
        var color = $('#color').val();
        var address = $('#address').val();
        var action = "create";
        if (office_id != "" && office_name != "" && admin !== "" && color !== "" && address !== "") {
            $.ajax({
                url: "handler/master/office/office_handler.php",
                type: "POST",
                data: {
                    office_id: office_id,
                    office_name: office_name,
                    admin: admin,
                    color: color,
                    address: address,
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

                            alert_('Success', 'New office has been created.');

                            $('#office_id').val('');
                            $('#office_name').val('');
                            $('#admin').val('');
                            $('#color').val('');
                            $('#address').val('');


                            list_template();
                            get_office();
                            get_notifications();
                        } else if (dataResult.statusCode == 201) {
                            $("#save").removeAttr("disabled");

                            alert_('Fail', 'An error occurred while saving new office.');

                            $('#office_id').val('');
                            $('#office_name').val('');
                            $('#admin').val('');
                            $('#color').val('');
                            $('#address').val('');

                            list_template();
                            get_office();
                        }
                    }
                }
            });
        } else {
            $("#save").removeAttr("disabled");
        }
    });

    function get_notifications() {
        $.ajax({
            url: "handler/common/get_noti_count.php",
            type: "GET",
            cache: false,
            success: function(data) {
                $('#noti').html(data);
                $('#noti_side').html(data);
            }
        });
    }

    $('#update').on('click', function() {
        $("#update").attr("disabled", "disabled");
        var office_id = $('#u_office_id').val();
        var office_name = $('#u_office_name').val();
        var admin = $('#u_admin').val();
        var color = $('#u_color').val();
        var address = $('#u_address').val();
        var action = "update";
        if (office_id != "" && office_name != "" && admin !== "" && color !== "" && address !== "") {
            $.ajax({
                url: "handler/master/office/office_handler.php",
                type: "POST",
                data: {
                    office_id: office_id,
                    office_name: office_name,
                    admin: admin,
                    color: color,
                    address: address,
                    action: action
                },
                cache: false,
                success: function(dataResult) {
                    var dataResult = JSON.parse(dataResult);
                    console.log = dataResult.statusCode;
                    if (dataResult !== "") {
                        if (dataResult.statusCode == 200) {
                            $("#update").removeAttr("disabled");

                            alert_('Success', 'Office updated successfully.');

                            $('#u_office_id').val('');
                            $('#u_office_name').val('');
                            $('#u_admin').val('');
                            $('#u_color').val('');
                            $('#u_address').val('');

                            list_template();
                            get_office();
                        } else if (dataResult.statusCode == 201) {
                            $("#update").removeAttr("disabled");

                            alert_('Fail', 'Cannot update office.');

                            $('#u_office_id').val('');
                            $('#u_office_name').val('');
                            $('#u_admin').val('');
                            $('#u_color').val('');
                            $('#u_address').val('');

                            list_template();
                            get_office();
                        }
                    }
                }
            });
        } else {
            $("#update").removeAttr("disabled");
        }
    });

});

function get_office_() {
    $.ajax({
        url: "handler/master/office/get_office.php",
        type: "GET",
        cache: false,
        success: function(data) {
            $('#table').html(data);
        }
    });
}

function delete_office(office_id) {
    var office_id = office_id;
    var action = "delete";
    if (office_id != "") {
        $.ajax({
            url: "handler/master/office/office_handler.php",
            type: "POST",
            data: {
                office_id: office_id,
                action: action
            },
            cache: false,
            success: function(dataResult) {
                var dataResult = JSON.parse(dataResult);
                if (dataResult !== "") {
                    if (dataResult.statusCode == 200) {

                        alert_('Success', 'Office has been deleted.');

                        get_office_();
                    } else if (dataResult.statusCode == 201) {

                        alert_('Fail', 'Cannot delete office.');

                        get_office_();
                    }
                }
            }
        });
    }
}

function update_datafill(office_id, office_name, admin, color, address) {

    update_template();

    var office_id = office_id;
    var office_name = office_name;
    var admin = admin;
    var color = color;
    var address = address;

    $('#u_office_id').val(office_id);
    $('#u_office_name').val(office_name);
    $('#u_admin').val(admin);
    $('#u_color').val(color);
    $('#u_address').val(address);


}