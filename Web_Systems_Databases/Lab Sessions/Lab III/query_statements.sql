CREATE TABLE IF NOT EXISTS country(
	country_id INT,
    name VARCHAR(80)
);

CREATE TABLE IF NOT EXISTS cities(
	city_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(80) UNIQUE NOT NULL,
    country_id INT
);


