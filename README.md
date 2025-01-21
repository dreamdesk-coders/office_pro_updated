#Year End Query
SET FOREIGN_KEY_CHECKS=0;
#Sale
update sale set status = 'new' where invoice_date > '2024-01-31';
DELETE from sale where invoice_date <= '2024-01-31';
DELETE FROM sale_details
WHERE invoice_id IN (
    SELECT invoice_id
    FROM sale
    WHERE invoice_date <= '2024-01-31'
);

#Delivery
update delivery set status = 'new' where invoice_date > '2024-01-31';
DELETE from delivery where invoice_date <= '2024-01-31';
DELETE FROM delivery_details
WHERE invoice_id IN (
    SELECT invoice_id
    FROM delivery
    WHERE invoice_date <= '2024-01-31'
);

#Purchase
update purchase set status = 'new' where invoice_date > '2024-01-31';
DELETE from purchase where invoice_date <= '2024-01-31';
DELETE FROM purchase_details
WHERE invoice_id IN (
    SELECT invoice_id
    FROM purchase
    WHERE invoice_date <= '2024-01-31'
);

#Delivery Order
delete from delivery_order;
delete from delivery_order_details;

#Expense
delete from expenses WHERE  expense_date <= '2024-01-31';
DELETE FROM expenses_details
WHERE expense_id IN (
    SELECT expense_id
    FROM expenses
    WHERE expense_date <= '2024-01-31'
);

#Notification
delete from notifications;
delete from notifications_read;

#Office use
delete from office_use WHERE  use_date <= '2024-01-31';
DELETE FROM office_use_details
WHERE use_id IN (
    SELECT use_id
    FROM office_use
    WHERE use_date <= '2024-01-31'
);

#Present
delete from present WHERE  present_date <= '2024-01-31';
DELETE FROM present_details
WHERE present_id IN (
    SELECT present_id
    FROM present
    WHERE present_date <= '2024-01-31'
);

delete from purchase_order;
delete from purchase_order_details;
delete from purchase_return;
delete from purchase_return_details;

#Repacking
delete from repacking where slip_date > '2024-12-31';
DELETE FROM repacking_details
WHERE slip_id IN (
    SELECT slip_id
    FROM repacking
    WHERE slip_date <= '2024-01-31'
);

delete from sale_order;
delete from sale_order_details;

#Sale Return
delete from sale_return where invoice_date <= '2024-01-31';
DELETE FROM sale_return_details
WHERE invoice_id IN (
    SELECT invoice_id
    FROM sale_return
    WHERE invoice_date <= '2024-01-31'
);
#Damage
delete from stock_damage where damage_date <= '2024-01-31';
delete from stock_damage_details;
DELETE FROM stock_damage_details
WHERE damage_id IN (
    SELECT damage_id
    FROM stock_damage
    WHERE damage_date <= '2024-01-31'
);
#Stock Issue
DELETE FROM stock_issue WHERE issue_date <= '2024-01-31';
DELETE FROM stock_issue_details WHERE issue_id IN (
    SELECT issue_id
    FROM stock_issue
    WHERE issue_date <= '2024-01-31'
);
#Stock Received
DELETE FROM stock_received WHERE received_date <= '2024-01-31';
DELETE FROM stock_received_details WHERE received_id IN (
    SELECT received_id
    FROM stock_received
    WHERE received_date <= '2024-01-31'
);
#Stock Transfer
DELETE FROM stock_transfer WHERE transfer_date <= '2024-01-31';
DELETE FROM stock_transfer_details WHERE transfer_id IN (
    SELECT transfer_id
    FROM stock_transfer
    WHERE transfer_date <= '2024-01-31'
);
delete from transaction_log;
SET FOREIGN_KEY_CHECKS=1;

#To Run for master database
INSERT INTO `foundation` (`client_id`, `client_name`, `db_name`, `home_currency`, `num_of_offices`, `user_per_office`, `sub_start_date`, `sub_end_date`, `purchase_decimal`, `inventory_decimal`, `sale_decimal`, `inventory_module`, `sale_module`, `purchase_module`, `address`, `phone_no`, `announcement`, `yearend_date`) VALUES ('YYK2025', 'Yin Yin Kyaw International Trading Co.,Ltd.(2025)', 'yinyinkyaw_2025_new', 'MMK', '5', '10', '2025-01-19', '2025-02-23', '4', '4', '4', '1', '1', '1', 'No.(476), East Gyogone Street(1), Insein Township, Yangon.', 'Phone. 09-965059040,09-955059040,09-685934961', '0', '2026-01-15');
