# Lab 1 - Create and Insert in the tables
CREATE DATABASE HH_DB_Lab1;
USE HH_DB_Lab1;

CREATE TABLE Student(
  sid CHAR(2) NOT NULL,
  full_name TEXT NOT NULL,
  major VARCHAR(4),
  age INT NOT NULL,
  GPA DECIMAL(2,1),
  PRIMARY KEY(sid)
);

CREATE TABLE Course(
  cid INT NOT NULL,
  course_name TEXT NOT NULL,
  course_code VARCHAR(7) NOT NULL,
  credits FLOAT NOT NULL,
  PRIMARY KEY(cid)
);

CREATE TABLE Enrolled(
  sid CHAR(2) NOT NULL,
  cid INT NOT NULL,
  grade CHAR(1) NOT NULL,
  FOREIGN KEY (sid) REFERENCES Student(sid),
  FOREIGN KEY (cid) REFERENCES Course(cid)
);

INSERT INTO Student(sid, full_name, major, age, GPA) VALUES
('c1', 'Alice', 'CS', 21, 4.0),
('p2', 'Albert', 'PHY', 22, 3.9),
('e3', 'Tim', 'EE', 20, 3.9),
('m4', 'Kayle', 'MATH', 19, 3.8),
('p5', 'Yasuo', 'PHY', 19, 3.7);

INSERT INTO Course(cid, course_name, course_code, credits) VALUES
(11, 'Linear algebra', 'MATH105', 5),
(22, 'Algorithms', 'CS101', 5),
(33, 'Databases', 'DS001', 4.5),
(44, 'Physics I', 'PHY001', 6)
;

INSERT INTO Enrolled(sid, cid, grade) VALUES
('c1', 11, 'A'),
('c1', 33, 'A'),
('p2', 44, 'A'),
('p5', 44, 'B'),
('m4', 11, 'A'),
('p2', 22, 'B'),
('m4', 22, 'B'),
('p5', 33, 'C'),
('c1', 22, 'A');


