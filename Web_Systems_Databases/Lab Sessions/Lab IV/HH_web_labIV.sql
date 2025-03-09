CREATE DATABASE HH_Web_lab;
USE HH_Web_lab;

# Task 1 – Data Definition
CREATE TABLE IF NOT EXISTS Country(
	country_id INT UNIQUE NOT NULL PRIMARY KEY AUTO_INCREMENT,
    country_name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS City(
	city_id INT AUTO_INCREMENT NOT NULL UNIQUE PRIMARY KEY,
    city_name VARCHAR(100) NOT NULL UNIQUE,
    country_id INT NOT NULL,
    FOREIGN KEY(country_id) REFERENCES Country(country_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS Street(
	street_name VARCHAR(80) NOT NULL,
    street_id INT AUTO_INCREMENT UNIQUE NOT NULL PRIMARY KEY,
    city_id INT NOT NULL,
    FOREIGN KEY(city_id) REFERENCES City(city_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS Address(
	address_id INT AUTO_INCREMENT UNIQUE NOT NULL PRIMARY KEY,
    street_id INT NOT NULL,
    postal_code VARCHAR(16) NOT NULL,
    FOREIGN KEY(street_id) REFERENCES Street(street_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE,
    number SMALLINT NOT NULL
);

CREATE TABLE IF NOT EXISTS Heating_Method(
	heating_method_id INT AUTO_INCREMENT NOT NULL UNIQUE PRIMARY KEY,
    method_name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS Appliance(
	appliance_id INT AUTO_INCREMENT NOT NULL UNIQUE PRIMARY KEY,
    appliance_name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS Furniture(
	furniture_id INT AUTO_INCREMENT NOT NULL UNIQUE PRIMARY KEY,
    furniture_name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS Room_Type(
	room_type_id INT AUTO_INCREMENT NOT NULL UNIQUE PRIMARY KEY,
    room_type VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS Property_Type(
	type_id INT AUTO_INCREMENT NOT NULL UNIQUE PRIMARY KEY,
    type_name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS Person(
	person_id INT AUTO_INCREMENT NOT NULL UNIQUE PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    document_number VARCHAR(12) NOT NULL UNIQUE,
    telephone VARCHAR(12) NOT NULL,
    email VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS Owner(
	owner_id INT NOT NULL UNIQUE PRIMARY KEY,
    address_id INT NOT NULL,
    FOREIGN KEY(address_id) REFERENCES Address(address_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE,
    FOREIGN KEY(owner_id) REFERENCES Person(person_id)
);

CREATE TABLE IF NOT EXISTS O_Address_Complement(
	owner_id INT NOT NULL UNIQUE PRIMARY KEY,
    o_address_complement VARCHAR(12) NOT NULL,
    FOREIGN KEY(owner_id) REFERENCES Owner(owner_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE
);


CREATE TABLE IF NOT EXISTS Property(
	property_id INT AUTO_INCREMENT NOT NULL UNIQUE PRIMARY KEY,
    type_id INT NOT NULL,
    address_id INT NOT NULL,
    owner_id INT NOT NULL,
    created_at DATE NOT NULL DEFAULT(CURRENT_TIMESTAMP),
    FOREIGN KEY(type_id) REFERENCES Property_Type(type_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE,
    FOREIGN KEY(address_id) REFERENCES Address(address_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE,
    FOREIGN KEY(owner_id) REFERENCES Owner(owner_id)
		ON DELETE RESTRICT
		ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS Property_Description(
	property_id INT NOT NULL UNIQUE PRIMARY KEY,
    description TEXT,
    FOREIGN KEY(property_id) REFERENCES Property(property_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS Photo(
	photo_id INT AUTO_INCREMENT NOT NULL UNIQUE PRIMARY KEY,
    property_id INT NOT NULL,
    image_path VARCHAR(300),
    FOREIGN KEY(property_id) REFERENCES Property(property_id)
		ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS Special_Features(
	special_feature_id INT AUTO_INCREMENT NOT NULL UNIQUE PRIMARY KEY,
    special_feature VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS Property_Special_Features(
	special_feature_id INT NOT NULL,
    property_id INT NOT NULL,
    quantity SMALLINT NOT NULL 
		CHECK(quantity >= 0),
	PRIMARY KEY(special_feature_id, property_id),
    FOREIGN KEY(special_feature_id) REFERENCES Special_Features(special_feature_id)
		ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY(property_id) REFERENCES Property(property_id)
		ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS Room(
	room_id INT AUTO_INCREMENT NOT NULL UNIQUE PRIMARY KEY,
    room_type_id INT NOT NULL,
    property_id INT NOT NULL,
    width DECIMAL(8,2) NOT NULL,
    height DECIMAL(8,2) NOT NULL,
    FOREIGN KEY(room_type_id) REFERENCES Room_Type(room_type_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE,
	FOREIGN KEY(property_id) REFERENCES Property(property_id)
		ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS Room_Furniture(
		quantity INT NOT NULL
			CHECK(quantity >= 0),
        room_id INT NOT NULL,
        furniture_id INT NOT NULL,
        PRIMARY KEY(room_id, furniture_id),
        FOREIGN KEY(furniture_id) REFERENCES Furniture(furniture_id)
			ON DELETE RESTRICT
            ON UPDATE CASCADE,
		FOREIGN KEY(room_id) REFERENCES Room(room_id)
			ON DELETE CASCADE
            ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS Room_Heating(
	room_id INT NOT NULL, 
    heating_method_id INT NOT NULL,
    quantity INT NOT NULL
		CHECK(quantity >= 0),
	PRIMARY KEY(room_id, heating_method_id),
    FOREIGN KEY(room_id) REFERENCES Room(room_id)
		ON DELETE CASCADE
        ON UPDATE CASCADE,
	FOREIGN KEY(heating_method_id) REFERENCES Heating_Method(heating_method_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS Room_Appliance(
	quantity INT NOT NULL 
		CHECK(quantity >= 0),
    room_id INT NOT NULL,
    appliance_id INT NOT NULL,
    PRIMARY KEY(room_id, appliance_id),
    FOREIGN KEY(room_id) REFERENCES Room(room_id)
		ON DELETE CASCADE
        ON UPDATE CASCADE,
	FOREIGN KEY(appliance_id) REFERENCES Appliance(appliance_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS Tenant(
tenant_id INT NOT NULL PRIMARY KEY,
FOREIGN KEY(tenant_id) REFERENCES Person(person_id)
	ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS Tenancy_Agreement(
		tenancy_agreement_id INT AUTO_INCREMENT NOT NULL UNIQUE PRIMARY KEY,
        tenant_id INT NOT NULL,
        property_id INT NOT NULL,
        rent_amount DECIMAL(10,2) NOT NULL,
        end_date DATE NOT NULL,
        start_date DATE NOT NULL,
        FOREIGN KEY(tenant_id) REFERENCES Tenant(tenant_id)
			ON DELETE RESTRICT
            ON UPDATE CASCADE,
		FOREIGN KEY(property_id) REFERENCES Property(property_id)
			ON DELETE RESTRICT 
			ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS P_Address_Complement(
	property_id INT NOT NULL UNIQUE PRIMARY KEY,
    p_address_complement VARCHAR(12) NOT NULL,
	FOREIGN KEY(property_id) REFERENCES Property(property_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE
    );
    

#
# Task 2 – Data Definition
INSERT INTO Country(country_name) VALUES
('Sweden'),
('Brazil'),
('United States of America'),
('Germany'),
('Italy');

INSERT INTO City(city_name, country_id) VALUES
('Gothenburg', (SELECT country_id FROM Country WHERE country_name = 'Sweden')),
('Joinville', (SELECT country_id FROM Country WHERE country_name = 'Brazil')),
('Milan', (SELECT country_id FROM Country WHERE country_name = 'Italy')),
('Dallas', (SELECT country_id FROM Country WHERE country_name = 'United States of America')),
('Berlin', (SELECT country_id FROM Country WHERE country_name = 'Sweden'));

INSERT INTO Street(street_name, city_id) VALUES
('Aschebergsgatan', (SELECT city_id FROM City WHERE city_name = 'Gothenburg')),
('Rua das Palmeiras', (SELECT city_id FROM City WHERE city_name = 'Joinville')),
('Via Manzoni', (SELECT city_id FROM City WHERE city_name = 'Milan')),
('Miles Rd', (SELECT city_id FROM City WHERE city_name = 'Dallas')),
('Kurfürstendamm', (SELECT city_id FROM City WHERE city_name = 'Berlin'));

INSERT INTO Address(street_id, postal_code, number) VALUES
((SELECT street_id FROM Street WHERE street_name = 'Aschebergsgatan'), '411 33', '576'),
((SELECT street_id FROM Street WHERE street_name = 'Rua das Palmeiras'), '89232-610', '7'),
((SELECT street_id FROM Street WHERE street_name = 'Via Manzoni'), '20121', '500'),
((SELECT street_id FROM Street WHERE street_name = 'Miles Rd'), '28034', '921'),
((SELECT street_id FROM Street WHERE street_name = 'Kurfürstendamm'), '10585', '276');

INSERT INTO Person(first_name, last_name, document_number, telephone, email) VALUES
('Lukas', 'Müller', '123456789001', '4915123456789', 'lukas.muller@example.de'),
('Isabella', 'Rossi', '987654321002', '390612345678', 'isabella.rossi@example.it'),
('Émile', 'Dubois', '456789123003', '33612345678', 'emile.dubois@example.fr'),
('Sofia', 'Andersson', '321654987004', '46701234567', 'sofia.andersson@example.se'),      
('Mateo', 'García', '654987321005', '34961234567', 'mateo.garcia@example.es'),
('Anna', 'Nowak', '789123456006', '48123456789', 'anna.nowak@example.pl'),            
('Pedro', 'Silva', '147258369007', '5521998765432', 'pedro.silva@example.com');