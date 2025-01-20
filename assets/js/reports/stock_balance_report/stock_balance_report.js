var group_by;
$(document).ready(function () {

    $('#f_date').val(getcurrentDate());
    $('#t_date').val(getcurrentDate());
    $('.ft_stock').show();
    $('.ft_category').hide();
    $('.ft_rg').hide();
    group_by = "stock";

    $("#btn_f_stock_id").click(function () {
        get_lookup_data('stock', 'stock_id', 'stock_name', 'Stock ID', 'Stock Name', 'f_stock_id')
    });

    $("#btn_t_stock_id").click(function () {
        get_lookup_data('stock', 'stock_id', 'stock_name', 'Stock ID', 'Stock Name', 't_stock_id')
    });

    $("#btn_f_category_id").click(function () {
        get_lookup_data('category', 'category_id', 'category_name', 'Category ID', 'Category Name', 'f_category_id')
    });

    $("#btn_t_category_id").click(function () {
        get_lookup_data('category', 'category_id', 'category_name', 'Category ID', 'Category Name', 't_category_id')
    });

    $("#btn_f_rg_id").click(function () {
        get_lookup_data('report_group', 'rg_id', 'description', 'Report Group ID', 'Report Group Name', 'f_rg_id')
    });

    $("#btn_t_rg_id").click(function () {
        get_lookup_data('report_group', 'rg_id', 'description', 'Report Group ID', 'Report Group Name', 't_rg_id')
    });

    $("#btn_f_office_id").click(function () {
        get_lookup_data('office', 'office_id', 'office_name', 'Office ID', 'Office Name', 'f_office_id')
    });
    
    $("#btn_t_office_id").click(function () {
        get_lookup_data('office', 'office_id', 'office_name', 'Office ID', 'Office Name', 't_office_id')
    });

    $("#gb_stock").click(function () {
        $('.ft_stock').show();
        $('.ft_category').hide();
        $('.ft_rg').hide();
        group_by = "stock"
    });

    $("#gb_category").click(function () {
        $('.ft_category').show();
        $('.ft_stock').hide();
        $('.ft_rg').hide();
        group_by = "category"
    });

    $("#gb_rg").click(function () {
        $('.ft_rg').show();
        $('.ft_stock').hide();
        $('.ft_category').hide();
        group_by="report_group"
    });

});

function view_report() {
    window.open('?frm=stock_balance_report_view&f_date=' + $('#f_date').val() + '&t_date=' + $('#t_date').val() + '&f_stock_id=' + $('#f_stock_id').val() + '&t_stock_id=' + $('#t_stock_id').val() + '&f_category_id=' + $('#f_category_id').val() + '&t_category_id=' + $('#t_category_id').val() + '&f_rg_id=' + $('#f_rg_id').val() + '&t_rg_id=' + $('#t_rg_id').val() +'&f_office_id=' + $('#f_office_id').val() + '&t_office_id=' + $('#t_office_id').val() + '&group_by=' + group_by);
}


