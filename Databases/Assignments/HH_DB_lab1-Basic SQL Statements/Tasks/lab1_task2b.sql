-- sql_inventory - items that are more expensive than 50
select * 
from products p 
where quantity_in_stock > 50;

-- sql_inventory - how many items in total in stock
select sum(quantity_in_stock) from products p; 


-- sql_hr - information about employees and their cities/addresses
select e.first_name, e.last_name, e.job_title, o.city AS office_city, o.address AS office_address
from employees e
join offices o on e.office_id = o.office_id
order by o.city, e.last_name, e.first_name;

-- sql_hr - highest salary in each office
select o.city as office_city,
       o.address as office_address,
       MAX(e.salary) as highest_salary
from employees e
join offices o on e.office_id = o.office_id
group by o.office_id, o.city, o.address
order by highest_salary desc;

-- sql_invoicing - clients who have unpaid invoices
select distinct c.client_id, c.name, c.address, c.city, c.state, c.phone
from clients c
join invoices i on c.client_id = i.client_id
where i.invoice_total > i.payment_total;

-- sql_invoicing - total payments by payment method
select pm.name as payment_method, SUM(p.amount) as total_amount
from payments p
join payment_methods pm on p.payment_method = pm.payment_method_id
group by pm.name
order by total_amount desc;

-- sql_store - products that have been ordered less than 50 times
select p.product_id,
       p.name AS product_name,
       SUM(oi.quantity) as total_ordered_quantity
from products p
left join order_items oi on p.product_id = oi.product_id
group by p.product_id, p.name
having total_ordered_quantity < 50 or total_ordered_quantity is null
order by total_ordered_quantity asc;


-- sql_store - customer details and total amount for each order
select o.order_id,
       CONCAT(c.first_name, ' ', c.last_name) as customer_name,
       o.order_date,
       SUM(oi.quantity * oi.unit_price) as total_amount
from orders o
join customers c on o.customer_id = c.customer_id
JOIN order_items oi on o.order_id = oi.order_id
group by o.order_id, customer_name, o.order_date
order by o.order_date desc;
