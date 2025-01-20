var sale_dec = getCookie("sale_decimal");
var step_string = getCookie("sale_step");


var active = true;

uncheck = () => {
    document.getElementById("checkdata").checked = false;
    formcheck();
}

formcheck = () => {

    const num = rownum;
    for (let j = 1; j <= num; j++) {

        var stock_id = "sid" + j;
        var stoc_id_btn = "sid_btn" + j;
        var unit_id = "unit_id" + j;
        var unit_id_btn = "unit_id_btn" + j;
        var quantity = "quantity" + j;
        var price = "price" + j;
        var amount = "amount" + j;
        var transaction_id = "invoice_id";

        var status = document.getElementById("checkdata").checked;
        switch (status) {
            case true:
                if (document.getElementById(quantity).value > 0) {
                    // get_stock_balance(quantity);
                    get_stock_balance_edit(quantity, transaction_id);
                }

                $("#save").prop('disabled', false);
                break;

            case false:
                if (document.getElementById(quantity).value > 0) {
                    // get_stock_balance(quantity);
                    get_stock_balance_edit(quantity, transaction_id);
                }
                $("#save").prop('disabled', true);
                break;
        }
        sum_amounts();
    }
}

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
                get_stock_price(this.id, "S");
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
                get_stock_balance(this.id);
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
        alert("Cannot delete last row.");
    } else {
        var empTab = document.getElementById('_table');
        empTab.deleteRow(oButton.parentNode.parentNode.rowIndex);
        sum_amounts();
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

            document.getElementById(amount).value = amt.toFixed(sale_dec);
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

            total_amount = parseFloat(total_amount) + parseFloat(amt);

        }
    }
    document.getElementById("total_amount").value = total_amount.toFixed(sale_dec);


    var tax = document.getElementById("tax").value;

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

    total_amount = parseFloat(total_amount) + parseFloat(tax);
    document.getElementById("total_amount").value = total_amount.toFixed(sale_dec);
}


$(document).ready(function() {

    $("#delivery-order-table").DataTable();
    $("#delivery-order-cancel-table").DataTable();

    $("#btn_staff_id").click(function() {
        get_lookup_data_two_col('staff', 'staff_id', 'staff_name', 'Staff ID', 'Staff Name', 'staff_id', 'lbl_staff_id');
    });

    $("#btn_currency_id").click(function() {
        get_lookup_data_two_col('currency', 'currency_id', 'currency_name', 'Currency ID', 'Currency Name', 'currency_id', 'lbl_currency_id');
    });

    $("#btn_customer_id").click(function() {
        get_lookup_data_two_col('customer', 'customer_id', 'customer_name', 'Customer ID', 'Customer Name', 'customer_id', 'lbl_customer_id');
    });

    active_route("sale_");

});