# Year End Script

### for office pro
```sql
SET FOREIGN_KEY_CHECKS=0;

UPDATE sale 
SET status = 'new' 
WHERE invoice_date > '2024-01-31';

DELETE FROM sale 
WHERE invoice_date <= '2024-01-31';

DELETE FROM sale_details
WHERE invoice_id IN (
    SELECT invoice_id
    FROM sale
    WHERE invoice_date <= '2024-01-31'
);

UPDATE delivery 
SET status = 'new' 
WHERE invoice_date > '2024-01-31';

DELETE FROM delivery 
WHERE invoice_date <= '2024-01-31';

DELETE FROM delivery_details
WHERE invoice_id IN (
    SELECT invoice_id
    FROM delivery
    WHERE invoice_date <= '2024-01-31'
);

UPDATE purchase 
SET status = 'new' 
WHERE invoice_date > '2024-01-31';

DELETE FROM purchase 
WHERE invoice_date <= '2024-01-31';

DELETE FROM purchase_details
WHERE invoice_id IN (
    SELECT invoice_id
    FROM purchase
    WHERE invoice_date <= '2024-01-31'
);

DELETE FROM delivery_order;
DELETE FROM delivery_order_details;

DELETE FROM delivery_order;
DELETE FROM delivery_order_details;

DELETE FROM expenses 
WHERE expense_date <= '2024-01-31';

DELETE FROM expenses_details
WHERE expense_id IN (
    SELECT expense_id
    FROM expenses
    WHERE expense_date <= '2024-01-31'
);

DELETE FROM notifications;
DELETE FROM notifications_read;

DELETE FROM office_use 
WHERE use_date <= '2024-01-31';

DELETE FROM office_use_details
WHERE use_id IN (
    SELECT use_id
    FROM office_use
    WHERE use_date <= '2024-01-31'
);

DELETE FROM present 
WHERE present_date <= '2024-01-31';

DELETE FROM present_details
WHERE present_id IN (
    SELECT present_id
    FROM present
    WHERE present_date <= '2024-01-31'
);

DELETE FROM present 
WHERE present_date <= '2024-01-31';

DELETE FROM present_details
WHERE present_id IN (
    SELECT present_id
    FROM present
    WHERE present_date <= '2024-01-31'
);

DELETE FROM purchase_order;
DELETE FROM purchase_order_details;
DELETE FROM purchase_return;
DELETE FROM purchase_return_details;

DELETE FROM repacking 
WHERE slip_date > '2024-12-31';

DELETE FROM repacking_details
WHERE slip_id IN (
    SELECT slip_id
    FROM repacking
    WHERE slip_date <= '2024-01-31'
);

DELETE FROM sale_order;
DELETE FROM sale_order_details;

DELETE FROM sale_return 
WHERE invoice_date <= '2024-01-31';

DELETE FROM sale_return_details
WHERE invoice_id IN (
    SELECT invoice_id
    FROM sale_return
    WHERE invoice_date <= '2024-01-31'
);

DELETE FROM stock_damage 
WHERE damage_date <= '2024-01-31';

DELETE FROM stock_damage_details
WHERE damage_id IN (
    SELECT damage_id
    FROM stock_damage
    WHERE damage_date <= '2024-01-31'
);

DELETE FROM stock_issue 
WHERE issue_date <= '2024-01-31';

DELETE FROM stock_issue_details 
WHERE issue_id IN (
    SELECT issue_id
    FROM stock_issue
    WHERE issue_date <= '2024-01-31'
);

DELETE FROM stock_received 
WHERE received_date <= '2024-01-31';

DELETE FROM stock_received_details 
WHERE received_id IN (
    SELECT received_id
    FROM stock_received
    WHERE received_date <= '2024-01-31'
);

DELETE FROM stock_transfer 
WHERE transfer_date <= '2024-01-31';

DELETE FROM stock_transfer_details 
WHERE transfer_id IN (
    SELECT transfer_id
    FROM stock_transfer
    WHERE transfer_date <= '2024-01-31'
);

DELETE FROM transaction_log;
SET FOREIGN_KEY_CHECKS=1;

INSERT INTO `foundation` 
(`client_id`, `client_name`, `db_name`, `home_currency`, `num_of_offices`, `user_per_office`, `sub_start_date`, `sub_end_date`, `purchase_decimal`, `inventory_decimal`, `sale_decimal`, `inventory_module`, `sale_module`, `purchase_module`, `address`, `phone_no`, `announcement`, `yearend_date`) 
VALUES 
('YYK2025', 'Yin Yin Kyaw International Trading Co.,Ltd.(2025)', 'yinyinkyaw_2025_new', 'MMK', '5', '10', '2025-01-19', '2025-02-23', '4', '4', '4', '1', '1', '1', 'No.(476), East Gyogone Street(1), Insein Township, Yangon.', 'Phone. 09-965059040,09-955059040,09-685934961', '0', '2026-01-15');
