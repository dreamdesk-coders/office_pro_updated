
var group_by;
$(document).ready(function () {

    $('#f_date').val(getcurrentDate());
    $('#t_date').val(getcurrentDate());

    group_by = "from_unit_id";

    $("#btn_f_slip_id").click(function () {
        get_lookup_data('repacking', 'slip_id', 'slip_date', 'repacking ID', 'repacking Date', 'f_slip_id')
    });

    $("#btn_t_slip_id").click(function () {
        get_lookup_data('repacking', 'slip_id', 'slip_date', 'repacking ID', 'repacking Date', 't_slip_id')
    });

    $("#btn_f_unit_id").click(function () {
        get_lookup_data_child('stock_unit', 'stock_id', $("#f_stock_id").val(), 'unit_id', 'stock_unit_id', 'f_unit_id');
    });

    $("#btn_t_unit_id").click(function () {
        get_lookup_data_child('stock_unit', 'stock_id', $("#t_stock_id").val(), 'unit_id', 'stock_unit_id', 't_unit_id');
    });

    $("#btn_f_stock_id").click(function () {
        get_lookup_data('stock', 'stock_id', 'stock_name', 'stock ID', 'stock Name', 'f_stock_id')
    });

    $("#btn_t_stock_id").click(function () {
        get_lookup_data('stock', 'stock_id', 'stock_name', 'stock ID', 'stock Name', 't_stock_id')
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

    $("#gb_unit").click(function () {
        group_by = "from_unit_id"
    });

    $("#gb_stock").click(function () {
        group_by = "from_stock_id"
    });




});

function view_report() {
    window.open('?frm=stock_repacking_summary_report_view&f_date=' + $('#f_date').val() + '&t_date=' + $('#t_date').val() + '&f_slip_id=' + $('#f_slip_id').val() + '&t_slip_id=' + $('#t_slip_id').val() + '&f_unit_id=' + $('#f_unit_id').val() + '&t_unit_id=' + $('#t_unit_id').val() + '&f_stock_id=' + $('#f_stock_id').val() + '&t_stock_id=' + $('#t_stock_id').val() + '&f_staff_id=' + $('#f_staff_id').val() + '&t_staff_id=' + $('#t_staff_id').val() + '&f_office_id=' + $('#f_office_id').val() + '&t_office_id=' + $('#t_office_id').val() + '&group_by=' + group_by);
}


