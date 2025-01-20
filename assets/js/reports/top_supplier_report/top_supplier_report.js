var purchase_type;
var group_by;
$(document).ready(function () {

    $('#f_date').val(getcurrentDate());
    $('#t_date').val(getcurrentDate());
    purchase_type = "all";
    group_by = "currency_id";


    $("#btn_f_currency_id").click(function() {
        get_lookup_data('currency','currency_id','currency_name','Currency ID','Currency Name','f_currency_id')
    });
    
       $("#btn_t_currency_id").click(function() {
        get_lookup_data('currency','currency_id','currency_name','Currency ID','Currency Name','t_currency_id')
    });


    $("#btn_f_office_id").click(function () {
        get_lookup_data('office', 'office_id', 'office_name', 'Office ID', 'Office Name', 'f_office_id')
    });

    $("#btn_t_office_id").click(function () {
        get_lookup_data('office', 'office_id', 'office_name', 'Office ID', 'Office Name', 't_office_id')
    });

    $("#st_all").click(function () {
        purchase_type = "all"
    });

    $("#st_cash").click(function () {
        purchase_type = "cash"
    });

    $("#st_credit").click(function () {
        purchase_type = "credit"
    });

    $("#st_advance").click(function () {
        purchase_type = "advance"
    });

    //group by

    $("#gb_currency").click(function () {
        group_by = "currency_id"
    });



});

function view_report() {
    window.open('?frm=top_supplier_report_view&f_date=' + $('#f_date').val() + '&t_date=' + $('#t_date').val() + '&f_currency_id=' + $('#f_currency_id').val() + '&t_currency_id=' + $('#t_currency_id').val() + '&f_office_id=' + $('#f_office_id').val() + '&t_office_id=' + $('#t_office_id').val() + '&purchase_type=' + purchase_type + '&group_by=' + group_by + '&limit=' + $('#range').val());
}


