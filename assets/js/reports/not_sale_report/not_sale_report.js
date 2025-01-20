
var group_by;
$(document).ready(function () {

    $('#f_date').val(getcurrentDate());
    $('#t_date').val(getcurrentDate());
    group_by = "customer_id";


    $("#btn_f_customer_id").click(function () {
        get_lookup_data('customer', 'customer_id', 'customer_name', 'Customer ID', 'Customer Name', 'f_customer_id')
    });

    $("#btn_f_office_id").click(function () {
        get_lookup_data('office', 'office_id', 'office_name', 'Office ID', 'Office Name', 'f_office_id')
    });

    $("#btn_t_office_id").click(function () {
        get_lookup_data('office', 'office_id', 'office_name', 'Office ID', 'Office Name', 't_office_id')
    });


    // group by

    $("#gb_customer").click(function () {
        group_by = "customer_id"
    });



});

function view_report() {
        window.open('?frm=not_sale_report_view&f_date=' + $('#f_date').val() + '&t_date=' + $('#t_date').val() + '&f_customer_id=' + $('#f_customer_id').val() + '&f_office_id=' + $('#f_office_id').val() + '&t_office_id=' + $('#t_office_id').val() + '&group_by=' + group_by);
}


