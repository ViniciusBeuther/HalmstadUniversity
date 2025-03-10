USE HH_DB_Final_Project;

INSERT INTO Countries (country_name) VALUES 
('Sweden'),
('Germany'),
('Brazil'),
('USA');

-- Insert Cities
INSERT INTO Cities (city_name, country_id) VALUES 
('Stockholm', 1),
('Berlin', 2),
('São Paulo', 3),
('New York', 4);

-- Insert Streets
INSERT INTO Streets (street_name) VALUES 
('Main Street'),
('Central Avenue'),
('Broadway'),
('Avenida Paulista');

-- Insert Addresses
INSERT INTO Addresses (city_id, street_id, number, postal_code) VALUES 
(1, 1, 101, '11111'),
(2, 2, 202, '22222'),
(3, 3, 303, '33333'),
(4, 4, 404, '44444');

-- Insert Stadiums
INSERT INTO Stadiums (address_id, built_date, building_company) VALUES 
(1, '2000-05-15', 'BuildCo AB'),
(2, '1998-08-20', 'Bau GmbH'),
(3, '2010-02-10', 'Construtora XYZ'),
(4, '1995-12-12', 'Big Builders Inc.');

-- Insert Sponsors
INSERT INTO Sponsors (company_name) VALUES 
('Nike'),
('Adidas'),
('Puma'),
('Under Armour');


-- Insert Persons (Players and Coaches)
INSERT INTO Person (salary, first_name, last_name, birth_date) VALUES 
(50000, 'John', 'Doe', '1985-07-12'),
(60000, 'Michael', 'Schmidt', '1982-04-25'),
(70000, 'Carlos', 'Silva', '1990-09-18'),
(80000, 'James', 'Brown', '1988-06-30');

-- Insert Coaches (Linked to Person)
INSERT INTO Coaches (coach_id, address_id) VALUES 
(1, 1),
(2, 2),
(3, 3),
(4, 4);

select * from stadiums;

-- Insert Teams
INSERT INTO Teams (name, stadium_id, coach_id, creation_date) VALUES 
('Stockholm FC', 1, 1, '1995-06-01'),
('Berlin United', 2, 2, '2000-09-10'),
('São Paulo Warriors', 3, 3, '2015-03-20'),
('NY Strikers', 4, 4, '1987-11-05');


-- Insert Players (Linked to Person)
INSERT INTO Players (player_id, playing_number, team_id, address_id) VALUES 
(1, 10, 1, 1),
(2, 7, 2, 2),
(3, 9, 3, 3),
(4, 11, 4, 4);

-- Insert Contracts
INSERT INTO Contracts (sponsor_id, team_id, amount, start_date, end_date) VALUES 
(1, 1, 1000000, '2023-01-01', '2026-12-31'),
(2, 2, 1200000, '2022-07-01', '2025-06-30'),
(3, 3, 950000, '2024-03-01', '2027-02-28'),
(4, 4, 1100000, '2021-09-15', '2024-08-14');

-- Insert Matches
INSERT INTO Matches (local_team_id, visitor_team_id, stadium_id, goals_local, goals_visitor, date) VALUES 
(1, 2, 1, 2, 1, '2024-05-12'),
(3, 4, 3, 3, 3, '2024-06-15'),
(2, 3, 2, 1, 2, '2024-07-22'),
(4, 1, 4, 0, 4, '2024-08-30');


# Find all teams and their coaches' names
SELECT t.name AS team_name, p.first_name, p.last_name 
FROM Teams t
JOIN Coaches c ON t.coach_id = c.coach_id
JOIN Person p ON c.coach_id = p.person_id;

# List all players in a specific team (e.g., 'Stockholm FC') with their playing numbers
SELECT p.first_name, p.last_name, pl.playing_number 
FROM Players pl
JOIN Person p ON pl.player_id = p.person_id
JOIN Teams t ON pl.team_id = t.team_id
WHERE t.name = 'Stockholm FC';

# Show all matches with team names instead of IDs
SELECT m.match_id, 
       t1.name AS local_team, 
       t2.name AS visitor_team, 
       m.goals_local, 
       m.goals_visitor, 
       m.date 
FROM Matches m
JOIN Teams t1 ON m.local_team_id = t1.team_id
JOIN Teams t2 ON m.visitor_team_id = t2.team_id;

# Find teams that have sponsorship deals over $1,000,000
SELECT t.name AS team_name, s.company_name, c.amount 
FROM Contracts c
JOIN Teams t ON c.team_id = t.team_id
JOIN Sponsors s ON c.sponsor_id = s.sponsor_id
WHERE c.amount > 1000000;


# List players along with their addresses (street, city, country)
SELECT p.first_name, p.last_name, s.street_name, c.city_name, co.country_name 
FROM Players pl
JOIN Person p ON pl.player_id = p.person_id
JOIN Addresses a ON pl.address_id = a.address_id
JOIN Streets s ON a.street_id = s.street_id
JOIN Cities c ON a.city_id = c.city_id
JOIN Countries co ON c.country_id = co.country_id;
