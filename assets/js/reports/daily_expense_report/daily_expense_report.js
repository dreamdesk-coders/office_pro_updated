$(document).ready(function () {

    $('#f_date').val(getcurrentDate());
    $('#t_date').val(getcurrentDate());

    // $("#btn_f_expense_master_id").click(function () {
    //     get_lookup_data('expense_master', 'expense_id', 'description', 'Expense ID', 'Description', 'f_expense_master_id')
    // });

    // $("#btn_t_expense_master_id").click(function () {
    //     get_lookup_data('expense_master', 'expense_id', 'description', 'Expense ID', 'Description', 't_expense_master_id')
    // });

    $("#btn_f_expense_id").click(function () {
        get_lookup_data('expenses', 'expense_id', 'remark', 'Expense ID', 'Remark', 'f_expense_id')
    });

    $("#btn_t_expense_id").click(function () {
        get_lookup_data('expenses', 'expense_id', 'remark', 'Expense ID', 'Remark', 't_expense_id')
    });


    $("#btn_f_office_id").click(function () {
        get_lookup_data('office', 'office_id', 'office_name', 'Office ID', 'Office Name', 'f_office_id')
    });

    $("#btn_t_office_id").click(function () {
        get_lookup_data('office', 'office_id', 'office_name', 'Office ID', 'Office Name', 't_office_id')
    });

});

function view_report() {
    window.open('?frm=daily_expense_report_view&f_date=' + $('#f_date').val() + '&t_date=' + $('#t_date').val() + '&f_office_id=' + $('#f_office_id').val() + '&t_office_id=' + $('#t_office_id').val() + '&f_expense_id=' + $('#f_expense_id').val() + '&t_expense_id=' + $('#t_expense_id').val());
}


