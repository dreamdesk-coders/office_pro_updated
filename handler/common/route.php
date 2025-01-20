<?php
    // Developer -> Pyae Phyoe Aung
    // Date -> 01/06/2020 12:03AM
    // Description -> Route Master/Master Layout

    if (isset($_GET['frm'])) {

        $frm = $_GET['frm'];
    } else {

        $frm = "";
    }



    switch ($frm) {

            //Help 

        case "help":
            include_once("forms/common/help.php");
            break;

            // Module Activate
        case "not_activated":
            include_once("forms/common/not_activated.php");
            break;

            // Auth Section

        case "login":
            include_once("forms/master/login.php");
            break;

        case "logout":
            include_once("handler/common/logout.php");
            break;

            // End of Auth Section

            // Dashboard Section
        case "dashboard":
            if ($_SESSION['role'] == "Management Admin") {
                include_once("forms/management/dashboard.php");
            } else {
                include_once("forms/management/office_dashboard.php");
            }
            break;

        case "user";

            if ($_SESSION['role'] == "Management Admin") {
                include_once("forms/management/user.php");
            } else {
                include_once("forms/common/no_permission.php");
            }

            break;

            // End of dashboard section

            // Management Section
        case "management_master";

            if ($_SESSION['role'] == "Management Admin") {
                include_once("forms/management/master.php");
            } else {
                include_once("forms/common/no_permission.php");
            }

            break;

            // End of management Section

            // Master Forms Section
        case "master":
            include_once("forms/master/master.php");
            break;

        case "category":
            include_once("forms/master/category.php");
            break;

        case "category_view":
            include_once("forms/master/print_preview/category_view.php");
            break;

        case "currency":
            include_once("forms/master/currency.php");
            break;

        case "currency_view":
            include_once("forms/master/print_preview/currency_view.php");
            break;
        
        case "township":
            include_once("forms/master/township.php");
            break;
        
        case "township_view":
            include_once("forms/master/print_preview/township_view.php");
            break;

        case "customer";
            include_once("forms/master/customer.php");
            break;

        case "customer_view";
            include_once("forms/master/print_preview/customer_view.php");
            break;

        case "expense_master";
            include_once("forms/master/expense_master.php");
            break;

        case "expense_master_view";
            include_once("forms/master/print_preview/expense_master_view.php");
            break;

        case "office":
            include_once("forms/master/office.php");
            break;

        case "report_group":
            include_once("forms/master/report_group.php");
            break;

        case "report_group_view":
            include_once("forms/master/print_preview/report_group_view.php");
            break;


        case "staff":
            include_once("forms/master/staff.php");
            break;

        case "stock":
            include_once("forms/master/stock.php");
            break;

        case "stock_view":
            include_once("forms/master/print_preview/stock_view.php");
            break;

        case "stock_unit":
            include_once("forms/master/stock_unit.php");
            break;

        case "stock_unit_view":
            include_once("forms/master/print_preview/stock_unit_view.php");
            break;

        case "supplier":
            include_once("forms/master/supplier.php");
            break;

        case "supplier_view":
            include_once("forms/master/print_preview/supplier_view.php");
            break;

        case "units_of_measurement":
            include_once("forms/master/units_of_measurement.php");
            break;

        case "units_of_measurement_view":
            include_once("forms/master/print_preview/units_of_measurement_view.php");
            break;

            // End of Master forms section

            // Purchase Transaction Forms Section

        case "purchase_master":
            include_once("forms/purchase/master.php");
            break;

        case "purchase_add":
            include_once("forms/purchase/purchase/purchase_add.php");
            break;

        case "purchase_list":
            include_once("forms/purchase/purchase/purchase_list.php");
            break;

        case "purchase_update":
            include_once("forms/purchase/purchase/purchase_update.php");
            break;

        case "purchase_voucher":
            include_once("forms/purchase/purchase/purchase_voucher.php");
            break;

        case "purchase_order_add":
            include_once("forms/purchase/purchase_order/purchase_order_add.php");
            break;

        case "purchase_order_list":
            include_once("forms/purchase/purchase_order/purchase_order_list.php");
            break;

        case "purchase_order_update":
            include_once("forms/purchase/purchase_order/purchase_order_update.php");
            break;

        case "purchase_order_voucher":
            include_once("forms/purchase/purchase_order/purchase_order_voucher.php");
            break;

        case "po_purchase_add":
            include_once("forms/purchase/po_purchase/po_purchase_add.php");
            break;

        case "po_purchase_update":
            include_once("forms/purchase/po_purchase/po_purchase_update.php");
            break;

        case "po_purchase_voucher":
            include_once("forms/purchase/po_purchase/po_purchase_voucher.php");
            break;

        case "purchase_order_cancel_list":
            include_once("forms/purchase/purchase_order_cancel/purchase_order_cancel_list.php");
            break;

        case "purchase_order_cancel_view":
            include_once("forms/purchase/purchase_order_cancel/purchase_order_cancel_view.php");
            break;

        case "purchase_order_cancel_voucher":
            include_once("forms/purchase/purchase_order_cancel/purchase_order_cancel_voucher.php");
            break;

        case "purchase_return_list":
            include_once("forms/purchase/purchase_return/purchase_return_list.php");
            break;

        case "purchase_return_add":
            include_once("forms/purchase/purchase_return/purchase_return_add.php");
            break;

        case "purchase_return_update":
            include_once("forms/purchase/purchase_return/purchase_return_update.php");
            break;

        case "purchase_return_voucher":
            include_once("forms/purchase/purchase_return/purchase_return_voucher.php");
            break;
            // End of Purchase Transaction Sectioon

            // Inventory Control Transaction Section
        case "inventory_master":
            include_once("forms/inventory/master.php");
            break;

        case "stock_issue_add":
            include_once("forms/inventory/stock_issue/stock_issue_add.php");
            break;

        case "stock_issue_list":
            include_once("forms/inventory/stock_issue/stock_issue_list.php");
            break;

        case "stock_issue_update":
            include_once("forms/inventory/stock_issue/stock_issue_update.php");
            break;

        case "stock_issue_voucher":
            include_once("forms/inventory/stock_issue/stock_issue_voucher.php");
            break;

            // stock received

        case "stock_received_add":
            include_once("forms/inventory/stock_received/stock_received_add.php");
            break;

        case "stock_received_list":
            include_once("forms/inventory/stock_received/stock_received_list.php");
            break;

        case "stock_received_update":
            include_once("forms/inventory/stock_received/stock_received_update.php");
            break;

        case "stock_received_voucher":
            include_once("forms/inventory/stock_received/stock_received_voucher.php");
            break;

            // stock transfer
        case "stock_transfer_add":
            include_once("forms/inventory/stock_transfer/stock_transfer_add.php");
            break;

        case "stock_transfer_list":
            include_once("forms/inventory/stock_transfer/stock_transfer_list.php");
            break;

        case "stock_transfer_update":
            include_once("forms/inventory/stock_transfer/stock_transfer_update.php");
            break;

        case "stock_transfer_voucher":
            include_once("forms/inventory/stock_transfer/stock_transfer_voucher.php");
            break;

        case "st_stock_received_add":
            include_once("forms/inventory/st_stock_received/st_stock_received_add.php");
            break;

        case "st_stock_received_update":
            include_once("forms/inventory/st_stock_received/st_stock_received_update.php");
            break;

            //repacking    

        case "repacking_list":
            include_once("forms/inventory/repacking/repacking_list.php");
            break;

        case "repacking_add":
            include_once("forms/inventory/repacking/repacking_add.php");
            break;


        case "repacking_update":
            include_once("forms/inventory/repacking/repacking_update.php");
            break;

        case "repacking_voucher":
            include_once("forms/inventory/repacking/repacking_voucher.php");
            break;

            // stock damage

        case "stock_damage_add":
            include_once("forms/inventory/stock_damage/stock_damage_add.php");
            break;

        case "stock_damage_list":
            include_once("forms/inventory/stock_damage/stock_damage_list.php");
            break;

        case "stock_damage_update":
            include_once("forms/inventory/stock_damage/stock_damage_update.php");
            break;

        case "stock_damage_voucher":
            include_once("forms/inventory/stock_damage/stock_damage_voucher.php");
            break;

            //office use
        case "office_use_list":
            include_once("forms/inventory/office_use/office_use_list.php");
            break;

        case "office_use_add":
            include_once("forms/inventory/office_use/office_use_add.php");
            break;

        case "office_use_update":
            include_once("forms/inventory/office_use/office_use_update.php");
            break;

        case "office_use_voucher":
            include_once("forms/inventory/office_use/office_use_voucher.php");
            break;

        case "present_list":
            include_once("forms/inventory/present/present_list.php");
            break;

        case "present_add":
            include_once("forms/inventory/present/present_add.php");
            break;

        case "present_update":
            include_once("forms/inventory/present/present_update.php");
            break;

        case "present_voucher":
            include_once("forms/inventory/present/present_voucher.php");
            break;

            // Opening Stock Balance

        case "opening_stock_list":
            include_once("forms/inventory/opening_stock/opening_stock_list.php");
            break;

        case "opening_stock_manage":
            include_once("forms/inventory/opening_stock/opening_stock_manage.php");
            break;

            // End of Inventory control transaction section

            // Sale Transaction Section
        case "sale_master":
            include_once("forms/sale/master.php");
            break;

        case "sale_list":
            include_once("forms/sale/sale/sale_list.php");
            break;

        case "sale_add":
            include_once("forms/sale/sale/sale_add.php");
            break;

        case "sale_update":
            include_once("forms/sale/sale/sale_update.php");
            break;

        case "sale_voucher":
            include_once("forms/sale/sale/sale_voucher.php");
            break;

            //sale return        

        case "sale_return_list":
            include_once("forms/sale/sale_return/sale_return_list.php");
            break;

        case "sale_return_add":
            include_once("forms/sale/sale_return/sale_return_add.php");
            break;

        case "sale_return_update":
            include_once("forms/sale/sale_return/sale_return_update.php");
            break;

        case "sale_return_voucher":
            include_once("forms/sale/sale_return/sale_return_voucher.php");
            break;

        case "sale_order_list":
            include_once("forms/sale/sale_order/sale_order_list.php");
            break;

        case "sale_order_add":
            include_once("forms/sale/sale_order/sale_order_add.php");
            break;

        case "sale_order_update":
            include_once("forms/sale/sale_order/sale_order_update.php");
            break;

        case "sale_order_voucher":
            include_once("forms/sale/sale_order/sale_order_voucher.php");
            break;

        case "sale_order_cancel_list":
            include_once("forms/sale/sale_order_cancel/sale_order_cancel_list.php");
            break;

        case "sale_order_cancel_view":
            include_once("forms/sale/sale_order_cancel/sale_order_cancel_view.php");
            break;

        case "sale_order_cancel_voucher":
            include_once("forms/sale/sale_order_cancel/sale_order_cancel_voucher.php");
            break;

        case "delivery_order_list":
            include_once("forms/sale/delivery_order/delivery_order_list.php");
            break;

        case "delivery_order_add":
            include_once("forms/sale/delivery_order/delivery_order_add.php");
            break;

        case "delivery_order_update":
            include_once("forms/sale/delivery_order/delivery_order_update.php");
            break;

        case "delivery_order_voucher":
            include_once("forms/sale/delivery_order/delivery_order_voucher.php");
            break;

        case "delivery_order_cancel_list":
            include_once("forms/sale/delivery_order_cancel/delivery_order_cancel_list.php");
            break;

        case "delivery_order_cancel_view":
            include_once("forms/sale/delivery_order_cancel/delivery_order_cancel_view.php");
            break;

        case "delivery_order_cancel_voucher":
            include_once("forms/sale/delivery_order_cancel/delivery_order_cancel_voucher.php");
            break;

        case "delivery_list":
            include_once("forms/sale/delivery/delivery_list.php");
            break;

        case "delivery_add":
            include_once("forms/sale/delivery/delivery_add.php");
            break;

        case "delivery_update":
            include_once("forms/sale/delivery/delivery_update.php");
            break;


        case "delivery_voucher":
            include_once("forms/sale/delivery/delivery_voucher.php");
            break;

        case "do_delivery_add":
            include_once("forms/sale/do_delivery/do_delivery_add.php");
            break;

        case "do_delivery_update":
            include_once("forms/sale/do_delivery/do_delivery_update.php");
            break;

        case "do_delivery_voucher":
            include_once("forms/sale/do_delivery/do_delivery_voucher.php");
            break;

        case "so_sale_add":
            include_once("forms/sale/so_sale/so_sale_add.php");
            break;

        case "so_sale_update":
            include_once("forms/sale/so_sale/so_sale_update.php");
            break;

            // End of Sale Transaction Section

            //Expense Transaction

        case "expenses_master":
            include_once("forms/expenses/master.php");
            break;

        case "daily_expense_list":
            include_once("forms/expenses/daily_expense/daily_expense_list.php");
            break;

        case "daily_expense_add":
            include_once("forms/expenses/daily_expense/daily_expense_add.php");
            break;

        case "daily_expense_update":
            include_once("forms/expenses/daily_expense/daily_expense_update.php");
            break;

        case "daily_expense_voucher":
            include_once("forms/expenses/daily_expense/daily_expense_voucher.php");
            break;

            // End of expense transactions

            // Notifications Section
        case "notifications":
            include_once("forms/notifications/notifications.php");
            break;

        case "notification_view":
            include_once("forms/notifications/notification_view.php");
            break;

            // End of notifications Section

            // Settings Section

        case "settings":
            include_once("forms/settings/settings.php");
            break;

            // End of Settings Section
            // Settings Section

            // Reports Section
        case "reports":
            include_once("forms/reports/master.php");
            break;

            // General
        case "cash_balance_report":
            include_once("forms/reports/cash_balance_report/cash_balance_report.php");
            break;

        case "cash_balance_report_view":
            include_once("forms/reports/cash_balance_report/cash_balance_report_view.php");
            break;

        case "stock_balance_report":
            include_once("forms/reports/stock_balance_report/stock_balance_report.php");
            break;

 case "profit_and_loss_report":
                include_once("forms/reports/profit_and_loss_report/profit_and_loss_report.php");
                break;

                case "profit_and_loss_report_view":
                    include_once("forms/reports/profit_and_loss_report/profit_and_loss_report_view.php");
                    break;
                    
        case "stock_balance_report_view":
            include_once("forms/reports/stock_balance_report/stock_balance_report_view.php");
            break;

        case "delivery_pending_report":
            include_once("forms/reports/delivery_pending_report/delivery_pending_report.php");
            break;

        case "delivery_pending_report_view":
            include_once("forms/reports/delivery_pending_report/delivery_pending_report_view.php");
            break;

        case "daily_expense_report":
            include_once("forms/reports/daily_expense_report/daily_expense_report.php");
            break;

        case "daily_expense_report_view":
            include_once("forms/reports/daily_expense_report/daily_expense_report_view.php");
            break;
            
            case "expense_detail_report":
        include_once "forms/reports/expense_detail_report/expense_detail_report.php";
        break;

    case "expense_detail_report_view":
        include_once "forms/reports/expense_detail_report/expense_detail_report_view.php";
        break;

            // Inventroy

        case "stock_received_summary_report":
            include_once("forms/reports/stock_received_summary_report/stock_received_summary_report.php");
            break;

        case "stock_received_summary_report_view":
            include_once("forms/reports/stock_received_summary_report/stock_received_summary_report_view.php");
            break;

        case "stock_issue_summary_report":
            include_once("forms/reports/stock_issue_summary_report/stock_issue_summary_report.php");
            break;

        case "stock_issue_summary_report_view":
            include_once("forms/reports/stock_issue_summary_report/stock_issue_summary_report_view.php");
            break;

        case "stock_transfer_summary_report":
            include_once("forms/reports/stock_transfer_summary_report/stock_transfer_summary_report.php");
            break;

        case "stock_transfer_summary_report_view":
            include_once("forms/reports/stock_transfer_summary_report/stock_transfer_summary_report_view.php");
            break;

        case "office_use_summary_report":
            include_once("forms/reports/office_use_summary_report/office_use_summary_report.php");
            break;

        case "office_use_summary_report_view":
            include_once("forms/reports/office_use_summary_report/office_use_summary_report_view.php");
            break;

        case "stock_repacking_summary_report":
            include_once("forms/reports/stock_repacking_summary_report/stock_repacking_summary_report.php");
            break;

        case "stock_repacking_summary_report_view":
            include_once("forms/reports/stock_repacking_summary_report/stock_repacking_summary_report_view.php");
            break;

        case "damage_summary_report":
            include_once("forms/reports/damage_summary_report/damage_summary_report.php");
            break;

        case "damage_summary_report_view":
            include_once("forms/reports/damage_summary_report/damage_summary_report_view.php");
            break;

        case "present_summary_report":
            include_once("forms/reports/present_summary_report/present_summary_report.php");
            break;

        case "present_summary_report_view":
            include_once("forms/reports/present_summary_report/present_summary_report_view.php");
            break;

            // Sale
        case "sale_summary_report":
            include_once("forms/reports/sale_summary_report/sale_summary_report.php");
            break;

        case "sale_summary_report_view":
            include_once("forms/reports/sale_summary_report/sale_summary_report_view.php");
            break;

        case "sale_summary_report_view_all":
            include_once("forms/reports/sale_summary_report/sale_summary_report_view_all.php");
            break;

        case "sale_return_summary_report":
            include_once("forms/reports/sale_return_summary_report/sale_return_summary_report.php");
            break;

        case "sale_return_summary_report_view":
            include_once("forms/reports/sale_return_summary_report/sale_return_summary_report_view.php");
            break;

        case "sale_order_summary_report":
            include_once("forms/reports/sale_order_summary_report/sale_order_summary_report.php");
            break;

        case "sale_order_summary_report_view":
            include_once("forms/reports/sale_order_summary_report/sale_order_summary_report_view.php");
            break;

        case "sale_order_cancel_summary_report":
            include_once("forms/reports/sale_order_cancel_summary_report/sale_order_cancel_summary_report.php");
            break;

        case "sale_order_cancel_summary_report_view":
            include_once("forms/reports/sale_order_cancel_summary_report/sale_order_cancel_summary_report_view.php");
            break;

        case "delivery_order_summary_report":
            include_once("forms/reports/delivery_order_summary_report/delivery_order_summary_report.php");
            break;

        case "delivery_order_summary_report_view":
            include_once("forms/reports/delivery_order_summary_report/delivery_order_summary_report_view.php");
            break;

        case "delivery_order_cancel_summary_report":
            include_once("forms/reports/delivery_order_cancel_summary_report/delivery_order_cancel_summary_report.php");
            break;

        case "delivery_order_cancel_summary_report_view":
            include_once("forms/reports/delivery_order_cancel_summary_report/delivery_order_cancel_summary_report_view.php");
            break;


        case "top_sale_report":
            include_once("forms/reports/top_sale_report/top_sale_report.php");
            break;

        case "top_sale_report_view":
            include_once("forms/reports/top_sale_report/top_sale_report_view.php");
            break;

        case "top_sale_report_view_all":
            include_once("forms/reports/top_sale_report/top_sale_report_view_all.php");
            break;

        case "top_customer_report":
            include_once("forms/reports/top_customer_report/top_customer_report.php");
            break;

        case "top_customer_report_view":
            include_once("forms/reports/top_customer_report/top_customer_report_view.php");
            break;

        case "top_customer_report_view_all":
            include_once("forms/reports/top_customer_report/top_customer_report_view_all.php");
            break;

        case "not_sale_report":
            include_once("forms/reports/not_sale_report/not_sale_report.php");
            break;

        case "not_sale_report_view":
            include_once("forms/reports/not_sale_report/not_sale_report_view.php");
            break;

        case "customer_credit_report":
            include_once("forms/reports/customer_credit_report/customer_credit_report.php");
            break;

        case "customer_credit_report_view":
            include_once("forms/reports/customer_credit_report/customer_credit_report_view.php");
            break;

        case "customer_credit_report_view_all":
            include_once("forms/reports/customer_credit_report/customer_credit_report_view_all.php");
            break;

        case "not_sale_report":
            include_once("forms/reports/not_sale_report/not_sale_report.php");
            break;

        case "not_sale_report_view":
            include_once("forms/reports/not_sale_report/not_sale_report_view.php");
            break;


            // Purchase
        case "purchase_summary_report":
            include_once("forms/reports/purchase_summary_report/purchase_summary_report.php");
            break;

        case "purchase_summary_report_view":
            include_once("forms/reports/purchase_summary_report/purchase_summary_report_view.php");
            break;

        case "purchase_return_summary_report":
            include_once("forms/reports/purchase_return_summary_report/purchase_return_summary_report.php");
            break;

        case "purchase_return_summary_report_view":
            include_once("forms/reports/purchase_return_summary_report/purchase_return_summary_report_view.php");
            break;

        case "purchase_order_summary_report":
            include_once("forms/reports/purchase_order_summary_report/purchase_order_summary_report.php");
            break;

        case "purchase_order_summary_report_view":
            include_once("forms/reports/purchase_order_summary_report/purchase_order_summary_report_view.php");
            break;

        case "purchase_order_cancel_summary_report":
            include_once("forms/reports/purchase_order_cancel_summary_report/purchase_order_cancel_summary_report.php");
            break;

        case "purchase_order_cancel_summary_report_view":
            include_once("forms/reports/purchase_order_cancel_summary_report/purchase_order_cancel_summary_report_view.php");
            break;

        case "top_purchase_report":
            include_once("forms/reports/top_purchase_report/top_purchase_report.php");
            break;

        case "top_purchase_report_view":
            include_once("forms/reports/top_purchase_report/top_purchase_report_view.php");
            break;

        case "top_supplier_report":
            include_once("forms/reports/top_supplier_report/top_supplier_report.php");
            break;

        case "top_supplier_report_view":
            include_once("forms/reports/top_supplier_report/top_supplier_report_view.php");
            break;

        case "supplier_credit_report":
            include_once("forms/reports/supplier_credit_report/supplier_credit_report.php");
            break;

        case "supplier_credit_report_view":
            include_once("forms/reports/supplier_credit_report/supplier_credit_report_view.php");
            break;



            // End of Report Section

            //Permission
        case "no_permission":
            include_once("forms/common/no_permission.php");
            break;


            //Documents
        case "document_manage":
            include_once("forms/document_center/document_manage.php");
            break;

        case "document_upload":
            include_once("forms/document_center/document_upload.php");
            break;

        // Updates for Office Pro Infinity

        case "features/my_tasks":
            include_once("forms/features/my_tasks/my_tasks.php");
            break;


        default:
            include_once("forms/master/login.php");
            break;
    }


        // Functions