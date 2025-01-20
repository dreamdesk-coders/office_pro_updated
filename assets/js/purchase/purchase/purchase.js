var pur_dec = getCookie("purchase_decimal");
var step_string = getCookie("purchase_step");

var arrHead = new Array();
arrHead = ['No', 'Stock ID', 'Stock Name', 'Unit', 'Quantity', 'Price', 'Amount', '']; // table headers.

function addNewRow() {

    var empTab = document.getElementById('_table');

    var rowCnt = empTab.rows.length; /* get the number of rows.*/
    var tr = empTab.insertRow(rowCnt); /* table row.*/

    for (var c = 0; c < arrHead.length; c++) {

        var td = document.createElement('td'); /* TABLE DEFINITION.*/

        td = tr.insertCell(c);

        if (c == 7) {

            var button = document.createElement('input');

            button.setAttribute('type', 'button');
            button.setAttribute('value', 'Remove');
            button.setAttribute('class', 'btn btn-danger');
            button.setAttribute('onclick', 'removeRow(this)');

            td.appendChild(button);
        } else if (c == 0) { /*For Label*/

            var ele = document.createElement('li');

            td.appendChild(ele);
            rownum = parseInt(rownum) + 1;
            document.getElementById('rownum').value = rownum;
        } else if (c == 1) {

            var div = document.createElement('div');

            div.setAttribute('class', 'input-group mb-3');
            td.appendChild(div);

            var ele = document.createElement('input');

            ele.setAttribute('type', 'text');
            ele.setAttribute('value', '');
            ele.setAttribute('class', 'form-control');
            ele.required = true;
            div.appendChild(ele);

            var div1 = document.createElement('div');

            div1.setAttribute('class', 'input-group-append');
            div.appendChild(div1);

            var button = document.createElement('input');

            button.setAttribute('type', 'button');
            button.setAttribute('class', 'btn btn-outline-secondary lookup-btn');

            button.onclick = function() {
                get_parent_stock(this.id);
            };

            ele.onchange = function() {
                check_parent_stock(this.id);
            };

            div1.appendChild(button);
        } else if (c == 3) {

            var div = document.createElement('div');

            div.setAttribute('class', 'input-group mb-3');
            td.appendChild(div);

            var ele = document.createElement('input');

            ele.setAttribute('type', 'text');
            ele.setAttribute('value', '');
            ele.setAttribute('class', 'form-control');
            ele.required = true;
            div.appendChild(ele);

            var div1 = document.createElement('div');

            div1.setAttribute('class', 'input-group-append');
            div.appendChild(div1);

            var button = document.createElement('input');

            button.setAttribute('type', 'button');
            button.setAttribute('class', 'btn btn-outline-secondary lookup-btn');

            button.onclick = function() {
                get_child_su(this.id);
            };

            ele.onchange = function() {
                check_child_su(this.id);
                get_stock_price(this.id, "P");
                reset_qty_on_unit_change(this.id);
                sum_amounts();
            };

            div1.appendChild(button);
        } else if (c == 2) {

            var ele = document.createElement('label');

            ele.setAttribute('value', '');
            ele.required = true;
            td.appendChild(ele);

        } else {

            var ele = document.createElement('input');

            ele.setAttribute('type', 'number');
            ele.setAttribute('value', '');
            ele.setAttribute('class', 'form-control');
            ele.required = true;
            td.appendChild(ele);

        }

        if (c == 1) { /*Stock ID*/

            ele.setAttribute('name', 'sid' + rownum);
            ele.setAttribute('id', 'sid' + rownum);
            button.setAttribute('id', rownum);

        }
        if (c == 2) { /*Stock Name*/

            ele.setAttribute('name', 's_name' + rownum);
            ele.setAttribute('id', 's_name' + rownum);

        }
        if (c == 3) { /*Unit ID*/

            ele.setAttribute('name', 'unit_id' + rownum);
            ele.setAttribute('id', 'unit_id' + rownum);
            button.setAttribute('id', rownum);



        }
        if (c == 4) { /*Quantity*/

            ele.setAttribute('name', 'quantity' + rownum);
            ele.setAttribute('id', 'quantity' + rownum);

            ele.onchange = function() {
                sum_amounts();
            }

        }
        if (c == 5) { /*Price*/

            ele.setAttribute('name', 'price' + rownum);
            ele.setAttribute('id', 'price' + rownum);
            ele.setAttribute('step', step_string);

            ele.onchange = function() {
                sum_amounts();
            }

        }
        if (c == 6) { /*Amount*/

            ele.setAttribute('name', 'amount' + rownum);
            ele.setAttribute('id', 'amount' + rownum);
            ele.setAttribute('step', step_string);

        }
    }
}

function removeRow(oButton) {
    var grid = document.getElementById('_table');
    var rowCnt = grid.rows.length; /* get the number of rows.*/
    if (rowCnt == 2) {
        alert_('Info', 'Cannot delete last row.');
    } else {
        var empTab = document.getElementById('_table');
        empTab.deleteRow(oButton.parentNode.parentNode.rowIndex);
        sum_amounts();
    }
}

/** function to calculate discount */
function discount_() {
    var discount = parseFloat(document.getElementById("discount").value);
    var discount_percent = parseFloat(document.getElementById("discount_percent").value);
    var total_amount = parseFloat(document.getElementById("total_amount").value);


    if (discount_percent >= 0 && discount_percent <= 100) {
        discount = (total_amount * ((discount_percent) / 100)).toFixed(pur_dec);
        $("#discount").val(discount);
    }



}

/** function to calculate discount percent */
function discount_percent_() {

    var discount = parseFloat(document.getElementById("discount").value);
    var discount_percent = parseFloat(document.getElementById("discount_percent").value);
    var total_amount = parseFloat(document.getElementById("total_amount").value);

    if (discount >= 0 && discount <= total_amount) {

        discount_percent = ((discount / total_amount) * 100).toFixed(pur_dec);
        $("#discount_percent").val(discount_percent);

    } else {
        discount = 0;
    }

}

function sum_amounts() {

    var rows = rownum;

    for (var i = 1; i <= rows; i++) {

        var quantity = "quantity" + i;
        var price = "price" + i;
        var amount = "amount" + i;
        var total_amount = 0;

        if (document.getElementById(quantity)) {

            var qty = document.getElementById(quantity).value;
            var pri = document.getElementById(price).value;
        } else {
            var qty = 0;
            var pri = 0;

        }


        if (qty !== 0 && pri !== 0) {

            var amt = qty * pri;

            document.getElementById(amount).value = amt.toFixed(pur_dec);
        }
    }


    for (var x = 1; x <= rows; x++) {

        var amount = "amount" + x;
        if (document.getElementById(amount)) {
            var amt = document.getElementById(amount).value;
        } else {
            var amt = 0;
        }

        if (amt) {

            total_amount = (parseFloat(total_amount) + parseFloat(amt)).toFixed(pur_dec);

        }
    }
    document.getElementById("total_amount").value = total_amount;
    document.getElementById("grand_total").value = total_amount;

    var paid_amount = parseFloat(document.getElementById("paid_amount").value);
    var discount = parseFloat(document.getElementById("discount").value);
    var discount_percent = parseFloat(document.getElementById("discount_percent").value);
    var tax = parseFloat(document.getElementById("tax").value);
    var expense = parseFloat(document.getElementById("expense").value);
    var net_amount = parseFloat(document.getElementById("net_amount").value);
    var grand_total = parseFloat(document.getElementById("grand_total").value);

    if (paid_amount == 0 || paid_amount == null) {

        paid_amount = 0;

    } else if (paid_amount < 0) {

        alert_("Info", "Paid amount cannot be less than 0.");
        localStorage.setItem("focus", "paid_amount");
        paid_amount = 0;
        $("#paid_amount").focus().val("");

    } else if (!$.isNumeric($('#paid_amount').val())) {

        alert_("Info", "Only numeric characters are allowed.");
        localStorage.setItem("focus", "paid_amount");
        paid_amount = 0;
        $("#paid_amount").focus().val("");

    }

    if (discount == 0 || discount == null) {

        discount = 0;

    } else if (discount < 0) {

        alert_("Info", "Discount amount cannot be less than 0.");
        localStorage.setItem("focus", "discount");
        discount = 0;
        $("#discount").focus().val(0);

    } else if (discount > total_amount) {

        alert_("Info", "Discount amount cannot be greater than total amount.");
        localStorage.setItem("focus", "discount");
        discount = 0;
        $("#discount").focus().val(0);
        $("#discount_percent").focus().val(0);


    } else if (!$.isNumeric($('#discount').val())) {

        alert_("Info", "Only numeric characters are allowed.");
        localStorage.setItem("focus", "discount");
        discount = 0;
        $("#discount").focus().val(0);

    }

    if (discount_percent == 0 || discount_percent == null) {

        discount_percent = 0;

    } else if (discount_percent < 0) {

        alert_("Info", "Discount percent cannot be less than 0.");
        localStorage.setItem("focus", "discount");
        discount_percent = 0;
        $("#discount_percent").focus().val(0);

    } else if (discount_percent > 100) {

        alert_("Info", "Discount percent cannot be greater than 100.");
        localStorage.setItem("focus", "discount");
        discount_percent = 0;
        $("#discount_percent").focus().val(0);

    } else if (!$.isNumeric($('#discount_percent').val())) {

        alert_("Info", "Only numeric characters are allowed.");
        localStorage.setItem("focus", "discount_percent");
        discount_percent = 0;
        $("#discount_percent").focus().val(0);

    }

    if (tax == 0 || tax == null) {

        tax = 0;

    } else if (tax < 0) {

        alert_("Info", "Tax amount cannot be less than 0.");
        localStorage.setItem("focus", "tax");
        tax = 0;
        $("#tax").focus().val("");

    } else if (!$.isNumeric($('#tax').val())) {

        alert_("Info", "Only numeric characters are allowed.");
        localStorage.setItem("focus", "tax");
        tax = 0;
        $("#tax").focus().val("");

    }

    if (expense == 0 || expense == null) {

        expense = 0;

    } else if (expense < 0) {

        alert_("Info", "Expense amount cannot be less than 0.");
        localStorage.setItem("focus", "expense");
        expense = 0;
        $("#expense").focus().val("");

    } else if (!$.isNumeric($('#expense').val())) {

        alert_("Info", "Only numeric characters are allowed.");
        localStorage.setItem("focus", "expense");
        expense = 0;
        $("#expense").focus().val("");

    }

    if (net_amount == 0 || net_amount == null) {

        net_amount = 0;

    }

    grand_total = parseFloat(grand_total) + parseFloat(tax) + parseFloat(expense) - parseFloat(discount);

    document.getElementById("grand_total").value = grand_total.toFixed(pur_dec);


    if (paid_amount > grand_total) {

        alert_("Info", "Paid amount cannot be greater than total amount.");
        localStorage.setItem("focus", "paid_amount");
        paid_amount = 0;
        $("#paid_amount").focus().val("");

    }

    net_amount = parseFloat(grand_total) - parseFloat(paid_amount);

    // $('#net_amount').val(net_amount);
    document.getElementById("net_amount").value = net_amount.toFixed(pur_dec);
}
/*** Update for filter function */
function filter_purchase_list() {
    var selectBox = document.getElementById("selectBox")
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    window.location.href = selectedValue;
   }
$(document).ready(function() {

    $("#purchase-table").DataTable();

    $("#btn_staff_id").click(function() {
        get_lookup_data_two_col('staff', 'staff_id', 'staff_name', 'Staff ID', 'Staff Name', 'staff_id', 'lbl_staff_id');
    });

    $("#btn_currency_id").click(function() {
        get_lookup_data_two_col('currency', 'currency_id', 'currency_name', 'Currency ID', 'Currency Name', 'currency_id', 'lbl_currency_id');
    });

    $("#btn_supplier_id").click(function() {
        get_lookup_data_two_col('supplier', 'supplier_id', 'supplier_name', 'Supplier ID', 'Supplier Name', 'supplier_id', 'lbl_supplier_id');
    });

    active_route("purchase_");


});