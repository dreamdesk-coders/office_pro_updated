var inv_dec = getCookie("inventory_decimal");
var step_string = getCookie("inventory_step");

var arrHead = new Array();
arrHead = ['No', 'Stock ID', 'Stock Name', 'Unit ID', 'Good Quantity', 'Price', '']; // table headers.

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
        if (c == 4) { /*Good Quantity*/

            ele.setAttribute('name', 'gquantity' + rownum);
            ele.setAttribute('id', 'gquantity' + rownum);

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



function check_opening_office_id(id) {

    var table = "opening_stock_balance";
    var id = id;
    // var req_input = req_input;
    var req_value = document.getElementById(id).value;

    $.ajax({
        url: "handler/common/check_id_exist.php",
        type: "POST",
        data: {
            table: table,
            id: id,
            req_value: req_value
        },
        cache: false,
        success: function(dataResult) {
            var dataResult = JSON.parse(dataResult);
            if (dataResult !== "") {
                if (dataResult.data == 0) {
                    var common_form_route = getCookie("common_form_route");
                    var target = common_form_route + "?frm=opening_stock_update&id=" + req_value;
                    window.location.href = target;
                } else if (dataResult.data == 1) {

                }
            }
        }
    });


}



$(document).ready(function() {

    $("#btn_transaction_office_id").click(function() {
        get_lookup_data_two_col('office', 'office_id', 'office_name', 'Office ID', 'Office Name', 'transaction_office_id', 'lbl_transaction_office_id');
    });

    $("#btn_currency_id").click(function() {
        get_lookup_data_two_col('currency', 'currency_id', 'currency_name', 'Currency ID', 'Currency Name', 'currency_id', 'lbl_currency_id');
    });

    active_route("inventory_");

});