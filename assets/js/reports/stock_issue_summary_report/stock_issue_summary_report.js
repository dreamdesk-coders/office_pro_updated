
var group_by;
$(document).ready(function () {

    $('#f_date').val(getcurrentDate());
    $('#t_date').val(getcurrentDate());

    group_by = "currency_id";

    $("#btn_f_issue_id").click(function () {
        get_lookup_data('stock_issue', 'issue_id', 'issue_date', 'issue ID', 'issue Date', 'f_issue_id')
    });

    $("#btn_t_issue_id").click(function () {
        get_lookup_data('stock_issue', 'issue_id', 'issue_date', 'issue ID', 'issue Date', 't_issue_id')
    });



    $("#btn_f_currency_id").click(function () {
        get_lookup_data('currency', 'currency_id', 'currency_name', 'Currency ID', 'Currency Name', 'f_currency_id')
    });

    $("#btn_t_currency_id").click(function () {
        get_lookup_data('currency', 'currency_id', 'currency_name', 'Currency ID', 'Currency Name', 't_currency_id')
    });

    $("#btn_f_staff_id").click(function () {
        get_lookup_data('staff', 'staff_id', 'staff_name', 'Staff ID', 'Staff Name', 'f_staff_id')
    });

    $("#btn_t_staff_id").click(function () {
        get_lookup_data('staff', 'staff_id', 'staff_name', 'Staff ID', 'Staff Name', 't_staff_id')
    });

    $("#btn_f_office_id").click(function () {
        get_lookup_data('office', 'office_id', 'office_name', 'Office ID', 'Office Name', 'f_office_id')
    });

    $("#btn_t_office_id").click(function () {
        get_lookup_data('office', 'office_id', 'office_name', 'Office ID', 'Office Name', 't_office_id')
    });

    // group by

    $("#gb_currency").click(function () {
        group_by = "currency_id"
    });



});

function view_report() {
    window.open('?frm=stock_issue_summary_report_view&f_date=' + $('#f_date').val() + '&t_date=' + $('#t_date').val() + '&f_issue_id=' + $('#f_issue_id').val() + '&t_issue_id=' + $('#t_issue_id').val() + '&f_currency_id=' + $('#f_currency_id').val() + '&t_currency_id=' + $('#t_currency_id').val() + '&f_staff_id=' + $('#f_staff_id').val() + '&t_staff_id=' + $('#t_staff_id').val() + '&f_office_id=' + $('#f_office_id').val() + '&t_office_id=' + $('#t_office_id').val() + '&group_by=' + group_by);
}


