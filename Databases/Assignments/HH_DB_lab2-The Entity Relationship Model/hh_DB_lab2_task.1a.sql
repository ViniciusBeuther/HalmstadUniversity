CREATE DATABASE hh_db_lab2;
USE hh_db_lab2;

# Lab 02

# Task 01a
# Creating Company's table
CREATE TABLE IF NOT EXISTS Company(
	company_id INT AUTO_INCREMENT NOT NULL UNIQUE,
    company_name VARCHAR(80) NOT NULL UNIQUE,
    PRIMARY KEY(company_id)
);

# Inserting dummy data
INSERT INTO Company(company_name) VALUES
('Oxford'),
('Condor'),
('Tuper');

# # Creating Department's table
CREATE TABLE IF NOT EXISTS Department(
	department_id INT AUTO_INCREMENT NOT NULL UNIQUE,
    department_name VARCHAR(50),
    company_id INT NOT NULL,
    PRIMARY KEY(department_id),
    FOREIGN KEY(company_id) REFERENCES Company(company_id)
);

# Inserting dummy data
INSERT INTO Department(department_name, company_id) VALUES
('Reception', (SELECT company_id FROM Company WHERE company_name = 'Oxford')),
('Package', (SELECT company_id FROM Company WHERE company_name = 'Condor')),
('CNC', (SELECT company_id FROM Company WHERE company_name = 'Tuper'))
;

# Creating Employee's table
CREATE TABLE IF NOT EXISTS Employee(
	employee_id INT AUTO_INCREMENT NOT NULL UNIQUE,
    employee_name VARCHAR(70) NOT NULL,
    department_id INT NOT NULL,
    PRIMARY KEY(employee_id),
    FOREIGN KEY(department_id) REFERENCES Department(department_id)
);

# Inserting dummy data
INSERT INTO Employee(employee_name, department_id) VALUES
('Elsio', 
	(SELECT department_id FROM Department 
	WHERE department_name = 'Packing'
    AND 
    company_id = (SELECT company_id FROM Company WHERE company_name = 'Oxford')
    )
);

# Creating Manager's table
CREATE TABLE IF NOT EXISTS Manager(
	manager_id INT NOT NULL AUTO_INCREMENT UNIQUE,
    special_title VARCHAR(80) NOT NULL,
    FOREIGN KEY(manager_id) REFERENCES Manager(manager_id),
    PRIMARY KEY(manager_id)
);

# Inserting dummy data in Manager's table
INSERT INTO Manager() VALUES(
	(SELECT employee_id FROM Employee WHERE employee_name = 'Vinicius'),
    'Packing Supervisor'
);

# Creating Supervises' table
CREATE TABLE IF NOT EXISTS Supervise(
	manager_id INT NOT NULL,
    employee_id INT NOT NULL,
    PRIMARY KEY(manager_id, employee_id),
    FOREIGN KEY(manager_id) REFERENCES Manager(manager_id),
    FOREIGN KEY(employee_id) REFERENCES Employee(employee_id)
);

# Inserting dummy data
INSERT INTO Supervise(manager_id, employee_id) VALUES(
	(SELECT m.manager_id 
		FROM Manager as m
		JOIN Employee as e
        ON m.manager_id = e.employee_id
        WHERE e.employee_name = 'Vinicius'
    ),
    (SELECT e.employee_id FROM Employee e WHERE e.employee_name = 'Felipe')
);

# Creating Company's car table
CREATE TABLE IF NOT EXISTS Company_Car(
	car_plate VARCHAR(8) UNIQUE NOT NULL PRIMARY KEY,
    model VARCHAR(20) NOT NULL
);

# Inserting dummy data
INSERT INTO Company_Car(car_plate, model) VALUES
('ICK-1901','Omega'),
('MAE-1420', 'Kadett')
;

# Creating Inventory's table
CREATE TABLE IF NOT EXISTS Inventory(
	car_plate VARCHAR(8) NOT NULL,
    manager_id INT NOT NULL,
    start_period TIMESTAMP DEFAULT(CURRENT_TIMESTAMP),
    end_period TIMESTAMP NOT NULL,
	PRIMARY KEY(car_plate, start_period, end_period),
    FOREIGN KEY(car_plate) REFERENCES Company_Car(car_plate),
    FOREIGN KEY(manager_id) REFERENCES Manager(manager_id)
);

# Inserting dummy data
INSERT INTO Inventory(car_plate, manager_id, end_period) VALUES(
	(SELECT car_plate FROM Company_Car WHERE model = 'Omega'),
    2,
    '2025-02-20'
);


