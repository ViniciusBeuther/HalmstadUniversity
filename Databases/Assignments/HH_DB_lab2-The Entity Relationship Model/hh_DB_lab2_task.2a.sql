CREATE DATABASE hh_db_lab2;
USE hh_db_lab2;

# Lab 02

# Task 2

# Creating Board Game Cafe Facilities table
CREATE TABLE BGC_Facilities (
    id_board_cafe INT AUTO_INCREMENT PRIMARY key not null UNIQUE,
    address VARCHAR(255) NOT NULL,
    city VARCHAR(100) NOT NULL,
    name VARCHAR(150) NOT NULL
);

# Inserting dummy data into BGC_Facilities
INSERT INTO BGC_Facilities (address, city, name) VALUES
('123 Main St', 'New York', 'Board Cafe A'),
('456 Maple Ave', 'Los Angeles', 'Board Cafe B'),
('789 Oak St', 'Chicago', 'Board Cafe C');

# Creating Customers table
CREATE TABLE Customers (
    id_customer INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE
);

# Inserting dummy data into Customers
INSERT INTO Customers (name, email) VALUES
('Alice Johnson', 'alice@example.com'),
('Bob Smith', 'bob@example.com'),
('Charlie Brown', 'charlie@example.com');

# Creating Memberships table (Many-to-Many relationship between BGC_Facilities and Customers)
CREATE TABLE Memberships (
    id_board_cafe INT NOT NULL,
    id_customer INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE,
    PRIMARY KEY (id_board_cafe, id_customer),
    FOREIGN KEY (id_board_cafe) REFERENCES BGC_Facilities(id_board_cafe) ON DELETE CASCADE,
    FOREIGN KEY (id_customer) REFERENCES Customers(id_customer) ON DELETE CASCADE
);

# Inserting dummy data into Memberships with start and end dates
INSERT INTO Memberships (id_board_cafe, id_customer, start_date, end_date) VALUES
((SELECT id_board_cafe FROM BGC_Facilities WHERE name = 'Board Cafe A'), 
 (SELECT id_customer FROM Customers WHERE name = 'Alice Johnson'), '2025-01-01', '2025-12-31'),
((SELECT id_board_cafe FROM BGC_Facilities WHERE name = 'Board Cafe B'), 
 (SELECT id_customer FROM Customers WHERE name = 'Bob Smith'), '2025-02-01', '2025-11-30');

# Creating Registers table (Tracks customer registrations to cafes)
CREATE TABLE Registers (
    id_board_cafe INT NOT NULL,
    id_customer INT NOT NULL,
    PRIMARY KEY (id_board_cafe, id_customer),
    FOREIGN KEY (id_board_cafe) REFERENCES BGC_Facilities(id_board_cafe) ON DELETE CASCADE,
    FOREIGN KEY (id_customer) REFERENCES Customers(id_customer) ON DELETE CASCADE
);

# Inserting dummy data into Registers
INSERT INTO Registers (id_board_cafe, id_customer) VALUES
((SELECT id_board_cafe FROM BGC_Facilities WHERE name = 'Board Cafe A'), 
 (SELECT id_customer FROM Customers WHERE name = 'Charlie Brown'));

# Creating Accesses table (Tracks customer access periods to cafes)
CREATE TABLE Accesses (
    access_id INT AUTO_INCREMENT PRIMARY KEY,
    id_board_cafe INT NOT NULL,
    id_customer INT NOT NULL,
    period_start DATE NOT NULL,
    period_end DATE NOT NULL,
    FOREIGN KEY (id_board_cafe) REFERENCES BGC_Facilities(id_board_cafe) ON DELETE CASCADE,
    FOREIGN KEY (id_customer) REFERENCES Customers(id_customer) ON DELETE CASCADE
);

# Inserting dummy data into Accesses
INSERT INTO Accesses (id_board_cafe, id_customer, period_start, period_end) VALUES
((SELECT id_board_cafe FROM BGC_Facilities WHERE name = 'Board Cafe C'), 
 (SELECT id_customer FROM Customers WHERE name = 'Alice Johnson'), '2024-01-01', '2024-12-31');
