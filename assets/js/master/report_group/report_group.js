$(document).ready(function() {

    $("#btn_f_rg_id").click(function() {
        get_lookup_data('report_group', 'rg_id', 'description', 'Report Group ID', 'Description', 'f_rg_id')
    });

    $("#btn_t_rg_id").click(function() {
        get_lookup_data('report_group', 'rg_id', 'description', 'Report Group ID', 'Description', 't_rg_id')
    });

    function get_report_group() {
        $.ajax({
            url: "handler/master/report_group/get_report_group.php",
            type: "GET",
            cache: false,
            success: function(data) {
                $('#report-group-table').html(data);

                $('#report_group_list').DataTable();
            }
        });
    }

    active_route("mas_");

    get_report_group();

    list_template();


    $('#save').on('click', function() {
        $("#save").attr("disabled", "disabled");
        var rg_id = $('#rg_id').val();
        var description = $('#description').val();
        var action = "create";
        if (rg_id != "" && description != "") {
            $.ajax({
                url: "handler/master/report_group/report_group_handler.php",
                type: "POST",
                data: {
                    rg_id: rg_id,
                    description: description,
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

                            alert_('Success', 'New report group has been created.');

                            $('#rg_id').val('');
                            $('#description').val('');


                            list_template();
                            get_report_group();
                        } else if (dataResult.statusCode == 201) {
                            $("#save").removeAttr("disabled");

                            alert_('Fail', 'An error occurred while saving new report group.');

                            $('#rg_id').val('');
                            $('#description').val('');
                            list_template();
                            get_report_group();
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
        var rg_id = $('#u_rg_id').val();
        var description = $('#u_description').val();
        var action = "update";
        if (rg_id != "" && description != "") {
            $.ajax({
                url: "handler/master/report_group/report_group_handler.php",
                type: "POST",
                data: {
                    rg_id: rg_id,
                    description: description,
                    action: action
                },
                cache: false,
                success: function(dataResult) {
                    var dataResult = JSON.parse(dataResult);
                    console.log = dataResult.statusCode;
                    if (dataResult !== "") {
                        if (dataResult.statusCode == 200) {
                            $("#update").removeAttr("disabled");

                            alert_('Success', 'Report group updated successfully.');

                            $('#u_rg_id').val('');
                            $('#u_description').val('');
                            list_template();
                            get_report_group();
                        } else if (dataResult.statusCode == 201) {
                            $("#update").removeAttr("disabled");

                            alert_('Fail', 'Cannot update report group.');

                            $('#u_rg_id').val('');
                            $('#u_description').val('');

                            list_template();
                            get_report_group();
                        }
                    }
                }
            });
        } else {
            $("#update").removeAttr("disabled");
        }
    });

});

function get_report_group_() {
    $.ajax({
        url: "handler/master/report_group/get_report_group.php",
        type: "GET",
        cache: false,
        success: function(data) {
            $('#report-group-table').html(data);

            $('#report_group_list').DataTable();
        }
    });
}

function get_report_group_filter(min, max) {
    var min = min;
    var mix = max;
    $.ajax({
        url: "handler/master/report_group/get_report_group.php",
        type: "POST",
        data: {
            min: min,
            max: max
        },
        cache: false,
        success: function(data) {
            $('#report-group-table').html(data);
            $('#report_group_list').DataTable();
        }
    });
}

function delete_report_group(rg_id) {
    var rg_id = rg_id;
    var action = "delete";
    if (rg_id != "") {
        $.ajax({
            url: "handler/master/report_group/report_group_handler.php",
            type: "POST",
            data: {
                rg_id: rg_id,
                action: action
            },
            cache: false,
            success: function(dataResult) {
                var dataResult = JSON.parse(dataResult);
                if (dataResult !== "") {
                    if (dataResult.statusCode == 200) {

                        alert_('Success', 'Report group has been deleted.');

                        get_report_group_();
                    } else if (dataResult.statusCode == 201) {
                        alert_('Fail', 'Cannot delete report group.');
                        get_report_group_();
                    }
                }
            }
        });
    }
}

function update_datafill(rg_id, description) {

    update_template();

    var rg_id = rg_id;
    var description = description;

    $('#u_rg_id').val(rg_id);
    $('#u_description').val(description);

}