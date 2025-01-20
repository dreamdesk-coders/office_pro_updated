var sale_type;
var group_by;
var transaction_type;
$(document).ready(function () {

    $('#f_date').val(getcurrentDate());
    $('#t_date').val(getcurrentDate());
    sale_type = "all";
    transaction_type = "all";
    group_by = "currency_id";

    $("#btn_f_invoice_id").click(function () {
        get_lookup_data('sale', 'invoice_id', 'invoice_date', 'Invoice ID', 'Invoice Date', 'f_invoice_id')
    });

    $("#btn_t_invoice_id").click(function () {
        get_lookup_data('sale', 'invoice_id', 'invoice_date', 'Invoice ID', 'Invoice Date', 't_invoice_id')
    });

    $("#btn_f_delivery_invoice_id").click(function () {
        get_lookup_data('delivery', 'invoice_id', 'invoice_date', 'Invoice ID', 'Invoice Date', 'f_delivery_invoice_id')
    });

    $("#btn_t_delivery_invoice_id").click(function () {
        get_lookup_data('delivery', 'invoice_id', 'invoice_date', 'Invoice ID', 'Invoice Date', 't_delivery_invoice_id')
    });


    $("#btn_f_customer_id").click(function () {
        get_lookup_data('customer', 'customer_id', 'customer_name', 'Customer ID', 'Customer Name', 'f_customer_id')
    });

    $("#btn_t_customer_id").click(function () {
        get_lookup_data('customer', 'customer_id', 'customer_name', 'Customer ID', 'Customer Name', 't_customer_id')
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


    //sale type

    $("#st_all").click(function () {
        sale_type = "all"
    });

    $("#st_cash").click(function () {
        sale_type = "cash"
    });

    $("#st_credit").click(function () {
        sale_type = "credit"
    });

    $("#st_advance").click(function () {
        sale_type = "advance"
    });

    // transaction type

    $("#tt_all").click(function () {
        transaction_type = "all"; 
        $('.ft_delivery_invoice').show();
        $('.ft_sale_invoice').show();
    });

    $("#tt_sale").click(function () {
        transaction_type = "sale"; 
        $('.ft_delivery_invoice').hide();
        $('.ft_sale_invoice').show();
    });

    $("#tt_delivery").click(function () {
        transaction_type = "delivery";
        $('.ft_sale_invoice').hide();
        $('.ft_delivery_invoice').show();
    });

    // group by

    $("#gb_customer").click(function () {
        group_by = "customer_id"
    });

    $("#gb_currency").click(function () {
        group_by = "currency_id"
    });


});

function view_report() {
    if (transaction_type == "sale") {
        window.open('?frm=sale_summary_report_view&f_date=' + $('#f_date').val() + '&t_date=' + $('#t_date').val() + '&f_invoice_id=' + $('#f_invoice_id').val() + '&t_invoice_id=' + $('#t_invoice_id').val() + '&f_customer_id=' + $('#f_customer_id').val() + '&t_customer_id=' + $('#t_customer_id').val() + '&f_currency_id=' + $('#f_currency_id').val() + '&t_currency_id=' + $('#t_currency_id').val() + '&f_staff_id=' + $('#f_staff_id').val() + '&t_staff_id=' + $('#t_staff_id').val() + '&f_office_id=' + $('#f_office_id').val() + '&t_office_id=' + $('#t_office_id').val() + '&sale_type=' + sale_type + '&transaction_type=' + transaction_type + '&group_by=' + group_by);
    } else if(transaction_type == "delivery") {
        window.open('?frm=sale_summary_report_view&f_date=' + $('#f_date').val() + '&t_date=' + $('#t_date').val() + '&f_invoice_id=' + $('#f_delivery_invoice_id').val() + '&t_invoice_id=' + $('#t_delivery_invoice_id').val() + '&f_customer_id=' + $('#f_customer_id').val() + '&t_customer_id=' + $('#t_customer_id').val() + '&f_currency_id=' + $('#f_currency_id').val() + '&t_currency_id=' + $('#t_currency_id').val() + '&f_staff_id=' + $('#f_staff_id').val() + '&t_staff_id=' + $('#t_staff_id').val() + '&f_office_id=' + $('#f_office_id').val() + '&t_office_id=' + $('#t_office_id').val() + '&sale_type=' + sale_type + '&transaction_type=' + transaction_type + '&group_by=' + group_by);
    }else{
        window.open('?frm=sale_summary_report_view_all&f_date=' + $('#f_date').val() + '&t_date=' + $('#t_date').val() + '&f_invoice_id_sale=' + $('#f_invoice_id').val() + '&t_invoice_id_sale=' + $('#t_invoice_id').val() +  '&f_invoice_id_delivery=' + $('#f_delivery_invoice_id').val() + '&t_invoice_id_delivery=' + $('#t_delivery_invoice_id').val() + '&f_customer_id=' + $('#f_customer_id').val() + '&t_customer_id=' + $('#t_customer_id').val() + '&f_currency_id=' + $('#f_currency_id').val() + '&t_currency_id=' + $('#t_currency_id').val() + '&f_staff_id=' + $('#f_staff_id').val() + '&t_staff_id=' + $('#t_staff_id').val() + '&f_office_id=' + $('#f_office_id').val() + '&t_office_id=' + $('#t_office_id').val() + '&sale_type=' + sale_type +  '&group_by=' + group_by);
    }
}


