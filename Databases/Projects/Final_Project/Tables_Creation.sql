CREATE DATABASE HH_DB_Final_Project;
USE HH_DB_Final_Project;

CREATE TABLE Countries(
	country_name VARCHAR(100) NOT NULL UNIQUE,
    country_id INT UNIQUE NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (country_name, country_id)
);

CREATE TABLE Cities(
	city_id INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    city_name VARCHAR(100) NOT NULL,
    country_id INT NOT NULL,
    FOREIGN KEY(country_id) REFERENCES Countries(country_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE TABLE Streets(
	street_id INT NOT NULL UNIQUE AUTO_INCREMENT,
    street_name VARCHAR(100) NOT NULL,
    PRIMARY KEY(street_id, street_name)
);

CREATE TABLE Addresses(
	address_id INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    city_id INT NOT NULL,
    street_id INT NOT NULL,
    number INT NOT NULL,
    postal_code VARCHAR(12) NOT NULL,
    FOREIGN KEY(city_id) REFERENCES Cities(city_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE,
	FOREIGN KEY(street_id) REFERENCES Streets(street_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE
);	

CREATE TABLE Stadiums(
	stadium_id INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    address_id INT NOT NULL,
    built_date DATE NOT NULL,
    building_company VARCHAR(100) NOT NULL,
    FOREIGN KEY(address_id) REFERENCES Addresses(address_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE TABLE Sponsors(
	sponsor_id INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE Person(
	person_id INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    salary DECIMAL(11,2) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    birth_date DATE NOT NULL
);

CREATE TABLE Coaches(
	coach_id INT NOT NULL UNIQUE PRIMARY KEY,
    address_id INT NOT NULL,
    FOREIGN KEY(coach_id) REFERENCES Person(person_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE,
	FOREIGN KEY(address_id) REFERENCES Addresses(address_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE
);


CREATE TABLE Teams(
	team_id INT NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL UNIQUE,
    stadium_id INT NOT NULL UNIQUE,
    coach_id INT NOT NULL,
    creation_date DATE NOT NULL,
    PRIMARY KEY(team_id, name),
    FOREIGN KEY(stadium_id) REFERENCES Stadiums(stadium_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE,
	FOREIGN KEY(coach_id) REFERENCES Coaches(coach_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE TABLE Players(
	player_id INT NOT NULL UNIQUE PRIMARY KEY,
    playing_number SMALLINT NOT NULL,
    team_id INT NOT NULL,
    address_id INT NOT NULL,
    FOREIGN KEY(player_id) REFERENCES Person(person_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE,
	FOREIGN KEY(address_id) REFERENCES Addresses(address_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE TABLE Contracts(
	sponsor_id INT NOT NULL,
    team_id INT NOT NULL,
    amount DECIMAL(13,2) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
		CHECK(end_date > start_date),
    FOREIGN KEY(sponsor_id) REFERENCES Sponsors(sponsor_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE,
	FOREIGN KEY(team_id) REFERENCES Teams(team_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE TABLE Matches(
	match_id INT NOT NULL UNIQUE AUTO_INCREMENT,
    local_team_id INT NOT NULL,
    visitor_team_id INT NOT NULL,
    stadium_id INT NOT NULL,
    goals_local TINYINT NOT NULL,
		CHECK(goals_local >= 0),
    goals_visitor TINYINT NOT NULL,
		CHECK(goals_visitor >= 0),
    date DATE NOT NULL,
    FOREIGN KEY(local_team_id) REFERENCES Teams(team_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE,
	FOREIGN KEY(visitor_team_id) REFERENCES Teams(team_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE,
	FOREIGN KEY(stadium_id) REFERENCES Stadiums(stadium_id)
		ON DELETE RESTRICT
        ON UPDATE CASCADE
);