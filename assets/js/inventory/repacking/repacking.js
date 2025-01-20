var inv_dec = getCookie("inventory_decimal");
var step_string = getCookie("inventory_step");

var arrHead = new Array();
arrHead = ['No', 'To Stock ID', 'Stock Name', 'To Unit ID', 'From Quantity', 'Price', '']; // table headers.

function addNewRow() {

    var empTab = document.getElementById('_table');

    var rowCnt = empTab.rows.length; /* get the number of rows.*/
    var tr = empTab.insertRow(rowCnt); /* table row.*/

    for (var c = 0; c < arrHead.length; c++) {

        var td = document.createElement('td'); /* TABLE DEFINITION.*/

        td = tr.insertCell(c);

        if (c == 6) {

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

        }
        if (c == 5) { /*Price*/

            ele.setAttribute('name', 'price' + rownum);
            ele.setAttribute('id', 'price' + rownum);
            ele.setAttribute('step', step_string);

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
    }
}

$(document).ready(function() {

    $("#repacking-table").DataTable();

    $("#btn_staff_id").click(function() {
        get_lookup_data_two_col('staff', 'staff_id', 'staff_name', 'Staff ID', 'Staff Name', 'staff_id', 'lbl_staff_id');
    });

    $("#btn_from_stock_id").click(function() {
        get_lookup_data_two_col('stock', 'stock_id', 'stock_name', 'Stock ID', 'Stock Name', 'from_stock_id', 'lbl_from_stock_id');
    });

    $("#btn_from_unit_id").click(function() {
        get_lookup_data_child('stock_unit', 'stock_id', $("#from_stock_id").val(), 'unit_id', 'stock_unit_id', 'from_unit_id');
    });

    $("#from_quantity").change(function() {
        // get_stock_quantity($("#from_stock_id").val(), $("#from_unit_id").val(), $("#from_quantity").val(), this.id);
    });

    active_route("inventory_");

});