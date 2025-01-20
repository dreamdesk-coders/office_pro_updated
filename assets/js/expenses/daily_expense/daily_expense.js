var arrHead = new Array();
arrHead = ['No', 'Expense Master ID', 'Description', 'Amount', '']; // table headers.

function addNewRow() {

    var empTab = document.getElementById('_table');

    var rowCnt = empTab.rows.length; /* get the number of rows.*/
    var tr = empTab.insertRow(rowCnt); /* table row.*/

    for (var c = 0; c < arrHead.length; c++) {

        var td = document.createElement('td'); /* TABLE DEFINITION.*/
        td = tr.insertCell(c);

        if (c == 4) {

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
                get_expense_master(this.id);
            };

            ele.onchange = function() {
                check_expense_master(this.id);
            };

            div1.appendChild(button);
        } else if (c == 2) {

            var ele = document.createElement('label');

            ele.setAttribute('value', '');
            ele.required = true;
            td.appendChild(ele);

        } else if (c == 3) {

            var ele = document.createElement('input');

            ele.setAttribute('type', 'number');
            ele.setAttribute('value', '');
            ele.setAttribute('class', 'form-control');
            ele.required = true;
            td.appendChild(ele);

            ele.onchange = function() {
                sum_amounts();
            };
        }

        if (c == 1) { /*Expense Master ID*/

            ele.setAttribute('name', 'emid' + rownum);
            ele.setAttribute('id', 'emid' + rownum);
            button.setAttribute('id', rownum);

        }
        if (c == 2) { /*Description*/

            ele.setAttribute('name', 'desc' + rownum);
            ele.setAttribute('id', 'desc' + rownum);

        }
        if (c == 3) { /*Amount*/

            ele.setAttribute('name', 'amount' + rownum);
            ele.setAttribute('id', 'amount' + rownum);
            button.setAttribute('id', rownum);

        }

    }
}


function removeRow(oButton) {
    var grid = document.getElementById('_table');
    var rowCnt = grid.rows.length; /* get the number of rows.*/
    if (rowCnt == 2) {
        alert_("Info", "Cannot delete last row.");
    } else {
        var empTab = document.getElementById('_table');
        empTab.deleteRow(oButton.parentNode.parentNode.rowIndex);
        sum_amounts();
    }
}

function sum_amounts() {

    var rows = rownum;
    var total_amount = 0;


    for (var i = 1; i <= rows; i++) {

        var amount = "amount" + i;

        if (document.getElementById(amount)) {
            total_amount = parseInt(total_amount) + parseInt(document.getElementById(amount).value);
        }


    }


    document.getElementById("total_amount").value = total_amount;
}

/*Get data for stock ID and stock name*/
function get_expense_master(id) {
    var id = id;
    get_lookup_data_two_col('expense_master ', 'expense_id', 'description', 'Expense ID', 'Description', 'emid' + id, 'desc' + id);
}

/* Check Data exist for expense_master_id column*/
function check_expense_master(id) {
    var r_id = id;
    var id = id;
    id = id.replace(/[^\d.]/g, '');
    id = parseInt(id);
    var label = 'desc' + id;

    var val = document.getElementById(r_id).value;
    check_data_exist('expense_master', 'expense_id', val, r_id, label);

}

$(document).ready(function() {

    $("#daily-expense-table").DataTable();

    $("#btn_staff_id").click(function() {
        get_lookup_data_two_col('staff', 'staff_id', 'staff_name', 'Staff ID', 'Staff Name', 'staff_id', 'lbl_staff_id');
    });

    $("#btn_currency_id").click(function() {
        get_lookup_data_two_col('currency', 'currency_id', 'currency_name', 'Currency ID', 'Currency Name', 'currency_id', 'lbl_currency_id');
    });

    active_route("expenses_");



});