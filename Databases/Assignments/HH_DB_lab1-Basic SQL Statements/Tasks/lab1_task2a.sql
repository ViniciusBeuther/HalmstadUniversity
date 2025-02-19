-- 1 sql_inventory
select * from products p order by unit_price desc;

-- 2 sql_inventory
SELECT SUM(unit_price * quantity_in_stock) AS total_price FROM products p;

-- 3 sql_hr
select o.address, o.city, o.state , count(e.employee_id) as employees
from offices o, employees e 
where o.office_id = e.office_id 
group by o.office_id 
order by employees desc;

-- 4 sql_hr
select e.first_name, e.last_name, e.job_title, o.address, o.city, o.state
from employees e, offices o 
where e.office_id = o.office_id 
and o.office_id in (select office_id 
					from employees e 
					group by office_id 
					having count(employee_id) = 1);
					
-- 5 sql_invoicing
select pm.name, count(*) as amount
from payments p, payment_methods pm 
where p.payment_method = pm.payment_method_id 
group by p.payment_method 
order by amount desc;

-- 6 sql_invoicing (number 5 has the most ammount of invoices linked to his name)
select client_id, count(*) as invoices_no 
from invoices i 
group by client_id;

-- 7 sql_store
select sum(unit_price) 
from orders o, order_items oi 
where o.order_id = oi.order_id 
and o.order_id = 2
order by unit_price desc; 


-- 8 sql_store
select c.first_name, c.last_name, os.name 
from orders o, customers c, order_statuses os
where o.customer_id = c.customer_id 
and os.order_status_id = o.status 
and o.status = 2;