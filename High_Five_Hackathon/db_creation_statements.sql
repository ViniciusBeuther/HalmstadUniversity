CREATE DATABASE high_five_hackathon;
use high_five_hackathon;

## Hackathon - DB Creation Statements
CREATE TABLE User(
	user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    coins INT NOT NULL DEFAULT 0
	CHECK(coins >= 0)
);

CREATE TABLE Cycle(
	cycle_id INT AUTO_INCREMENT PRIMARY KEY,
    minutes INT NOT NULL
		CHECK(minutes > 0 AND minutes <= 60),
	break_minutes INT NOT NULL
		CHECK (break_minutes >= 0 AND break_minutes <= 60)
);

CREATE TABLE User_Cycle(
	user_id INT NOT NULL,
    cycle_id INT NOT NULL,
    registered_at DATE NOT NULL DEFAULT(current_date()),
    PRIMARY KEY(user_id, cycle_id),
    FOREIGN KEY(user_id) REFERENCES User(user_id)
		ON UPDATE CASCADE,
	FOREIGN KEY(cycle_id) REFERENCES Cycle(cycle_id)
		ON UPDATE CASCADE
);
ALTER TABLE User_Cycle DROP PRIMARY KEY ADD COLUMN User_cycle_id AUTO_INCREMENT PRIMARY KEY

CREATE TABLE Animal(
	animal_id INT AUTO_INCREMENT PRIMARY KEY,
    animal_name VARCHAR(50) NOT NULL UNIQUE,
    animal_price DECIMAL(5,2) NOT NULL
);

CREATE TABLE User_Animal(
	user_id INT NOT NULL,
    animal_id INT NOT NULL,
    bought_date DATE NOT NULL DEFAULT(current_date()),
    PRIMARY KEY(user_id, animal_id),
    FOREIGN KEY (user_id) REFERENCES User(user_id)
		ON UPDATE CASCADE,
    FOREIGN KEY(animal_id) REFERENCES Animal(animal_id)
		ON UPDATE CASCADE
);


CREATE TABLE Business(
	business_id INT AUTO_INCREMENT PRIMARY KEY,
    business_name VARCHAR(100) NOT NULL UNIQUE,
    registered_at DATE NOT NULL DEFAULT(current_date())
);

CREATE TABLE Coupon(
	coupon_id INT AUTO_INCREMENT PRIMARY KEY,
    discount_percentage DECIMAL(5,2) NOT NULL,
    coupon_description VARCHAR(250) NOT NULL,
    business_id INT NOT NULL,
    FOREIGN KEY(business_id) REFERENCES Business(business_id)
		ON UPDATE CASCADE
);

CREATE TABLE User_Coupon(
	user_coupon_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    coupon_id INT NOT NULL,
    use_date DATE NOT NULL DEFAULT(current_date()),
    FOREIGN KEY(user_id) REFERENCES User(user_id)
		ON UPDATE CASCADE,
    FOREIGN KEY(coupon_id) REFERENCES Coupon(coupon_id)
		ON UPDATE CASCADE
);

ALTER TABLE User 
ADD COLUMN selected_pet INT NOT NULL DEFAULT 1, 
ADD CONSTRAINT fk_selected_pet FOREIGN KEY (selected_pet) REFERENCES Animal(animal_id);