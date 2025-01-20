$(document).ready(function() {

    $("#btn_f_unit_id").click(function() {
        get_lookup_data('units_of_measurement', 'unit_id', 'description', 'Unit ID', 'Description', 'f_unit_id')
    });

    $("#btn_t_unit_id").click(function() {
        get_lookup_data('units_of_measurement', 'unit_id', 'description', 'Unit ID', 'Description', 't_unit_id')
    });

    function get_measurement() {
        $.ajax({
            url: "handler/master/measurement/get_measurement.php",
            type: "GET",
            cache: false,
            success: function(data) {
                $('#measurement-table').html(data);

                $('#measurement_list').DataTable();
            }
        });
    }

    active_route("mas_");

    get_measurement();

    list_template();


    $('#save').on('click', function() {
        $("#save").attr("disabled", "disabled");
        var unit_id = $('#unit_id').val();
        var description = $('#description').val();
        var action = "create";
        if (unit_id != "" && description != "") {
            $.ajax({
                url: "handler/master/measurement/measurement_handler.php",
                type: "POST",
                data: {
                    unit_id: unit_id,
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

                            alert_('Success', 'New measurement has been created.');

                            $('#unit_id').val('');
                            $('#description').val('');


                            list_template();
                            get_measurement();
                        } else if (dataResult.statusCode == 201) {
                            $("#save").removeAttr("disabled");

                            alert_('Fail', 'An error occurred while saving new measurement.');

                            $('#unit_id').val('');
                            $('#description').val('');
                            list_template();
                            get_measurement();
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
        var unit_id = $('#u_unit_id').val();
        var description = $('#u_description').val();
        var action = "update";
        if (unit_id != "" && description != "") {
            $.ajax({
                url: "handler/master/measurement/measurement_handler.php",
                type: "POST",
                data: {
                    unit_id: unit_id,
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

                            alert_('Success', 'Measurement updated successfully.');

                            $('#u_unit_id').val('');
                            $('#u_description').val('');
                            list_template();
                            get_measurement();
                        } else if (dataResult.statusCode == 201) {
                            $("#update").removeAttr("disabled");

                            alert_('Fail', 'Cannot update measurement.');

                            $('#u_unit_id').val('');
                            $('#u_description').val('');

                            list_template();
                            get_measurement();
                        }
                    }
                }
            });
        } else {
            $("#update").removeAttr("disabled");
        }
    });

});

function get_measurement_() {
    $.ajax({
        url: "handler/master/measurement/get_measurement.php",
        type: "GET",
        cache: false,
        success: function(data) {
            $('#measurement-table').html(data);

            $('#measurement_list').DataTable();
        }
    });
}

function get_measurement_filter(min, max) {
    var min = min;
    var mix = max;
    $.ajax({
        url: "handler/master/measurement/get_measurement.php",
        type: "POST",
        data: {
            min: min,
            max: max
        },
        cache: false,
        success: function(data) {
            $('#measurement-table').html(data);
            $('#measurement_list').DataTable();
        }
    });
}

function delete_measurement(unit_id) {
    var unit_id = unit_id;
    var action = "delete";
    if (unit_id != "") {
        $.ajax({
            url: "handler/master/measurement/measurement_handler.php",
            type: "POST",
            data: {
                unit_id: unit_id,
                action: action
            },
            cache: false,
            success: function(dataResult) {
                var dataResult = JSON.parse(dataResult);
                if (dataResult !== "") {
                    if (dataResult.statusCode == 200) {

                        alert_('Success', 'measurement has been deleted.');

                        get_measurement_();
                    } else if (dataResult.statusCode == 201) {
                        alert_('Fail', 'Cannot delete measurement.');
                        get_measurement_();
                    }
                }
            }
        });
    }
}

function update_datafill(unit_id, description) {

    update_template();

    var unit_id = unit_id;
    var description = description;

    $('#u_unit_id').val(unit_id);
    $('#u_description').val(description);

}