$(document).ready(function() {
    var disable_save = localStorage.getItem("disable_save");
    if(disable_save == "1"){
        $("#save").hide();
    }
    function greetings() {
        var greeting = "";
        var today = new Date();

        var time = today.getHours();

        switch (time) {
            case 1:
                greeting = "Good Morning 🌃";
                break;

            case 2:
                greeting = "Good Morning 🌃";
                break;

            case 3:
                greeting = "Good Morning 🌃";
                break;

            case 4:
                greeting = "Good Morning 🌃";
                break;

            case 5:
                greeting = "Good Morning 🌃";
                break;

            case 6:
                greeting = "Good Morning 🌄";
                break;

            case 7:
                greeting = "Good Morning 🌄";
                break;

            case 8:
                greeting = "Good Morning 🌄";
                break;

            case 9:
                greeting = "Good Morning 🌄";
                break;

            case 10:
                greeting = "Good Morning 🌄";
                break;

            case 11:
                greeting = "Good Morning 🌄";
                break;

            case 12:
                greeting = "Good Afternoon 🕛";
                break;

            case 13:
                greeting = "Good Afternoon ☀";
                break;

            case 14:
                greeting = "Good Afternoon ☀";
                break;

            case 15:
                greeting = "Good Afternoon ☀";
                break;

            case 16:
                greeting = "Good Evening ☀";
                break;

            case 17:
                greeting = "Good Evening ☀";
                break;

            case 18:
                greeting = "Good Evening 🌃";
                break;

            case 19:
                greeting = "Good Evening 🌃";
                break;

            case 20:
                greeting = "Good Evening 🌃";
                break;

            case 21:
                greeting = "Good Evening 🌃";
                break;

            case 22:
                greeting = "Good Evening 🌃";
                break;

            case 23:
                greeting = "Good Evening 🌃";
                break;

            case 24:
                greeting = "Good Evening 🌃";
                break;

            default:
                greeting = "Good Day";
                break;
        }

        $('#greet').text(greeting);

    }

    greetings();

    function get_notifications() {
        $.ajax({
            url: "handler/common/get_noti_count.php",
            type: "GET",
            cache: false,
            success: function(data) {
                $('#noti').html(data);
                $('#noti_side').html(data);
            }
        });
    }
    get_notifications();

    function nav_control() {
        var control = localStorage.getItem("nav-control");

        switch (control) {
            case "open":
                $("#side-menu").css("width", "250px");
                $(".main-content").css("padding-left", "250px");
                break;
            case "close":
                $("#side-menu").css("width", "0px");
                $(".main-content").css("padding-left", "0px");
                break;
            default:
                /* $("#side-menu").css("width", "0px"); */
        }

    }

    nav_control();

    $("#nav-close").click(function() {
        $("#side-menu").animate({ left: '-250px' });
        $(".main-content").animate({ paddingLeft: '0px' });
        localStorage.setItem("nav-control", "close");

    });

    $("#nav-open").click(function() {
        $("#side-menu").animate({ left: '0px' });
        $(".main-content").animate({ paddingLeft: '250px' });
        localStorage.setItem("nav-control", "open");
        nav_control();

    });

    $('textarea').each(function() {
        $(this).val($(this).val().trim());
    });

    $('body').on('keydown', 'input, select', function(e) {
        if (e.key === "Enter") {
            var self = $(this),
                form = self.parents('form:eq(0)'),
                focusable, next;
            focusable = form.find('input,a,select,button,textarea').filter(':visible');
            next = focusable.eq(focusable.index(this) + 1);
            if (next.length) {
                next.focus();
            } else {
                /*form.submit();*/
            }
            return false;
        }
    });


});


function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function check_data_exist(table, id, req_input, input_id, label) {
    var table = table;
    var id = id;
    var req_input = req_input;
    var input_id = input_id;
    var label = label;

    $.ajax({
        url: "handler/common/check_data_exist.php",
        type: "POST",
        data: {
            table: table,
            id: id,
            req_input: req_input
        },
        cache: false,
        success: function(dataResult) {
            var dataResult = JSON.parse(dataResult);
            console.log = dataResult.statusCode;
            if (dataResult !== "") {
                if (dataResult.statusCode == 200) {
                    var desc = dataResult.desc;

                    document.getElementById(label).innerHTML = desc;

                    var id = input_id;
                    id = id.replace(/[^\d.]/g, '');
                    id = parseInt(id);
                    var unit_id = 'unit_id' + id;
                    /*For Unit in Grid*/

                    if (document.getElementById(unit_id)) {
                        document.getElementById(unit_id).value = "";
                    }


                } else if (dataResult.statusCode == 201) {

                    alert_('Info', 'This ID does not exist!');
                    localStorage.setItem("focus", input_id);
                    /*Use to clear text fields*/
                    document.getElementById(input_id).value = "";
                    document.getElementById(input_id).focus();

                    document.getElementById(label).innerHTML = "";

                    var id = input_id;
                    id = id.replace(/[^\d.]/g, '');
                    id = parseInt(id);
                    var s_name = 's_name' + id;
                    var unit_id = 'unit_id' + id;

                    /* For Grid*/
                    if (document.getElementById(s_name)) {
                        document.getElementById(s_name).innerHTML = "";
                        document.getElementById(unit_id).value = "";
                    }

                    /*End*/
                }

            }
        }
    });

}

function check_data_exist_child(table, parent_id, used_parent_id, child_id, used_child_id, input_id) {

    var table = table;
    var parent_id = parent_id;
    var used_parent_id = used_parent_id;
    var child_id = child_id;
    var used_child_id = used_child_id;
    var input_id = input_id;

    $.ajax({
        url: "handler/common/check_data_exist_child.php",
        type: "POST",
        data: {
            table: table,
            parent_id: parent_id,
            used_parent_id: used_parent_id,
            child_id: child_id,
            used_child_id: used_child_id
        },
        cache: false,
        success: function(dataResult) {
            var dataResult = JSON.parse(dataResult);
            console.log = dataResult.statusCode;
            if (dataResult !== "") {
                if (dataResult.statusCode == 200) {

                } else if (dataResult.statusCode == 201) {
                    alert_('Info', 'This ID does not exist!');
                    localStorage.setItem("focus", input_id);
                    document.getElementById(input_id).value = "";
                    document.getElementById(input_id).focus();
                }
            }
        }
    });

}

function list_template() {

    $('#list_').show();
    $('#create_').hide();
    $('#update_').hide();

}

function create_template() {

    $('#list_').hide();
    $('#create_').show();
    $('#update_').hide();

}

function update_template() {

    $('#list_').hide();
    $('#create_').hide();
    $('#update_').show();

}

/* Functions for lookup */

function get_lookup_data(table, id, name, display_id, display_name, req_input) {
    $('#lookup-table').html('<div class="ajax-loading"><div class="spinner-border" role="status"><span class="sr-only"> Loading... </span></div></div>');
    $('#look').css('transform', 'scale(1)');

    var table = table;
    var id = id;
    var name = name;
    var display_id = display_id;
    var display_name = display_name;
    var req_input = req_input;
    $.ajax({
        url: "handler/common/get_lookup_data.php",
        type: "POST",
        data: {
            table: table,
            id: id,
            name: name,
            display_id: display_id,
            display_name: display_name,
            req_input: req_input
        },
        cache: false,
        success: function(data) {
            $('#lookup-table').html(data);
            $('#lookup-list').DataTable({ "pageLength": 5, "bLengthChange": false });
        }
    });
}

function get_lookup_data_two_col(table, id, name, display_id, display_name, req_input, req_label) {

    $('#look').css('transform', 'scale(1)');
    $('#lookup-table').html('<div class="ajax-loading"><div class="spinner-border" role="status"><span class="sr-only"> Loading... </span></div></div>');
    var table = table;
    var id = id;
    var name = name;
    var display_id = display_id;
    var display_name = display_name;
    var req_input = req_input;
    var req_label = req_label;
    $.ajax({
        url: "handler/common/get_lookup_data.php",
        type: "POST",
        data: {
            table: table,
            id: id,
            name: name,
            display_id: display_id,
            display_name: display_name,
            req_input: req_input,
            req_label: req_label
        },
        cache: false,
        success: function(data) {
            $('#lookup-table').html(data);
            $('#lookup-list').DataTable({ "pageLength": 5, "bLengthChange": false });
        }
    });
}

function get_lookup_data_child(table, parent_id, used_parent_id, id, desc, req_id, req_desc) {

    $('#look').css('transform', 'scale(1)');
    $('#lookup-table').html('<div class="ajax-loading"><div class="spinner-border" role="status"><span class="sr-only"> Loading... </span></div></div>');

    var table = table; /* Table to get data*/
    var parent_id = parent_id; /* ID used in the grid(Stock_id is parent id for Unit_id)*/
    var used_parent_id = used_parent_id; /*used parent id in grid system*/
    var id = id; /* ID Column in the requested table*/
    var desc = desc; /* Description or name column in the requested table*/
    var req_id = req_id; /*ID request lookup input*/

    $.ajax({
        url: "handler/common/get_lookup_data_child.php",
        type: "POST",
        data: {
            table: table,
            parent_id: parent_id,
            used_parent_id: used_parent_id,
            id: id,
            desc: desc,
            req_id: req_id
        },
        cache: false,
        success: function(data) {
            $('#lookup-table').html(data);
            $('#lookup-list').DataTable({ "pageLength": 5, "bLengthChange": false });
        }
    });

    if (table === "stock_unit") {
        reset_qty_on_unit_change(req_id);
    }
}

function check_child_su(id) {
    var id = id;
    var val = id;
    val = val.replace(/[^\d.]/g, '');
    val = parseInt(val);
    var sid = 'sid' + val;
    var sid_val = document.getElementById(sid).value;
    var unit_id = document.getElementById(id).value;
    check_data_exist_child('stock_unit', 'stock_id', sid_val, 'unit_id', unit_id, id);

}

function get_child_su(id) {
    var id = id;
    var val = id;
    val = val.replace(/[^\d.]/g, '');
    val = parseInt(val);
    var used_parent_id = 'sid' + val;
    var parent = document.getElementById(used_parent_id).value;
    get_lookup_data_child('stock_unit', 'stock_id', parent, 'unit_id', 'stock_unit_id', 'unit_id' + id);

}

function close_lookup() {

    $('#look').css('transform', 'scale(0)');
}

close_lookup();

function fill_lookup_data(req_input, id) {
    var input = req_input;
    var id = id;
    document.getElementById(input).value = id;
    close_lookup();
}

function fill_lookup_data_two_col(req_input, req_label, id, desc) {
    var req_input = req_input;
    var req_label = req_label;
    var id = id;
    var desc = desc;
    document.getElementById(req_input).value = id;
    document.getElementById(req_label).innerHTML = desc;
    document.getElementById(req_label).value = desc;

    /* For grid*/
    var uid = req_input;
    uid = uid.replace(/[^\d.]/g, '');
    uid = parseInt(uid);
    var unit_id = 'unit_id' + uid;

    if (document.getElementById(unit_id)) {
        document.getElementById(unit_id).value = "";
    }
    close_lookup();
}

function active_route(route) {
    var route = document.getElementById(route);

    route.classList.add("active-route");

}

function alert_(header, body) {
    var header = header;
    var body = body;

    $('#alert').css('transform', 'scale(1)');
    $("#alert-dialog-header").html(header);
    $("#alert-dialog-msg").html(body);

    $(document).keydown(function(e) {
        if (e.keyCode == 9 || e.keyCode == 13) {
            e.preventDefault();
        }
    });

}

/* Check Data exist for stock id column*/
function check_parent_stock(id) {
    var r_id = id;
    var id = id;
    id = id.replace(/[^\d.]/g, '');
    id = parseInt(id);
    var s_name = 's_name' + id;

    var val = document.getElementById(r_id).value;
    check_data_exist('stock', 'stock_id', val, r_id, s_name);

}
/*Get data for stock ID and stock name*/
function get_parent_stock(id) {
    var id = id;
    get_lookup_data_two_col('stock', 'stock_id', 'stock_name', 'Stock ID', 'Stock Name', 'sid' + id, 's_name' + id);
}

function check_id_exist(table, id, req_input) {

    var table = table;
    var id = id;
    var req_input = req_input;
    var req_value = document.getElementById(req_input).value;

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

                } else if (dataResult.data == 1) {
                    alert_('Info', 'ID already exist!');
                    document.getElementById(req_input).value = "";
                    document.getElementById(req_input).focus();
                    localStorage.setItem("focus", req_input);
                }
            }
        }
    });


}


function get_stock_quantity(stock_id, unit_id, req_qty, req_input, transaction_id = "") {
    var stock_id = stock_id;
    var unit_id = unit_id;
    var req_qty = req_qty;
    var req_input = req_input;
    var transaction_id = transaction_id;

    // alert(transaction_id);
    $.ajax({
        url: "handler/common/get_stock_quantity.php",
        type: "POST",
        data: {
            stock_id: stock_id,
            unit_id: unit_id,
            req_qty: req_qty,
            transaction_id: transaction_id
        },
        cache: false,
        success: function(dataResult) {
            var dataResult = JSON.parse(dataResult);
            console.log = dataResult.statusCode;
            if (dataResult !== "") {
                if (dataResult.statusCode == 200) {
                    // alert(dataResult.balance);

                } else if (dataResult.statusCode == 201) {
                    alert_('Info', 'Insufficient Quantity!!!!.');
                    localStorage.setItem("focus", req_input);
                    document.getElementById(req_input).value = "";
                    document.getElementById(req_input).focus();
                }

            }
        }
    });

}

function get_stock_balance(id, transaction_id = "") { /** call get stock quantity */
    var id = id;
    var num = id;
    num = num.replace(/[^\d.]/g, '');
    num = parseInt(num);

    var sid = 'sid' + num;
    var stock_id = document.getElementById(sid).value;
    var uid = 'unit_id' + num;
    var unit_id = document.getElementById(uid).value;
    var req_qty = document.getElementById(id).value;
    var transaction_id = transaction_id;

    get_stock_quantity(stock_id, unit_id, req_qty, id, transaction_id);

}

function get_stock_balance_edit(id, old_qty) {
    var id = id;
    var num = id;
    num = num.replace(/[^\d.]/g, '');
    num = parseInt(num);

    var sid = 'sid' + num;
    var stock_id = document.getElementById(sid).value;
    var uid = 'unit_id' + num;
    var unit_id = document.getElementById(uid).value;
    var req_qty = document.getElementById(id).value;
    var old_qty = old_qty;

    if (parseInt(req_qty) > parseInt(old_qty)) {
        req_qty = parseInt(req_qty) - parseInt(old_qty);
        get_stock_quantity(stock_id, unit_id, req_qty, id);
    }
}
/** For stock repacing from quantity*/
function get_stock_balance_fq(stock_id, unit_id, req_qty, old_qty, id) {

    var stock_id = stock_id;
    var unit_id = unit_id;
    var req_qty = req_qty;
    var old_qty = old_qty;
    var id = id;

    if (parseInt(req_qty) > parseInt(old_qty)) {
        req_qty = parseInt(req_qty) - parseInt(old_qty);
        get_stock_quantity(stock_id, unit_id, req_qty, id);
    }
}

function getcurrentDate() {
    var d = new Date();

    var month = d.getMonth() + 1;
    var day = d.getDate();

    var output = d.getFullYear() + '-' +
        (month < 10 ? '0' : '') + month + '-' +
        (day < 10 ? '0' : '') + day;

    return output;
}

function get_stock_price(id, type) {

    var id = id;
    var num = id;
    num = num.replace(/[^\d.]/g, '');
    num = parseInt(num);

    var sid = "sid" + num;
    sid = document.getElementById(sid).value;
    var uid = "unit_id" + num;
    uid = document.getElementById(uid).value;
    var req_input = "price" + num;
    req_input = document.getElementById(req_input);
    var type = type;

    $.ajax({
        url: "handler/common/get_stock_price.php",
        type: "POST",
        data: {
            sid: sid,
            uid: uid,
            type: type
        },
        cache: false,
        success: function(dataResult) {
            var dataResult = JSON.parse(dataResult);
            req_input.value = dataResult.price;

        }
    });


}

// common print preview function
function printPreview(from_id, to_id, route) {
    window.open('?frm=' + route + '&f_id=' + from_id + '&t_id=' + to_id);
}

function reset_qty_on_unit_change(id) {

    var num = id;
    num = num.replace(/[^\d.]/g, '');
    num = parseInt(num);
    var qty = "quantity" + num;

    document.getElementById(qty).value = "";
}

function close_modal(id) {
    $('#' + id).css('transform', 'scale(0)');
}

function set_cookie(c_name, c_value) {
    document.cookie = c_name + "=" + c_value;
}


$(document).ready(function() {
    $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myList div").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    
/******** Scripts update for Office Pro 2.0 */

/*** Profile Card Open Function */

    $("#profile").click(function() {
        $("#menu-account").show();    
    
    });
/*** Profile Card Close Function */
    $("#account-close").click(function() {
        $("#menu-account").hide();    
    
    });

});






