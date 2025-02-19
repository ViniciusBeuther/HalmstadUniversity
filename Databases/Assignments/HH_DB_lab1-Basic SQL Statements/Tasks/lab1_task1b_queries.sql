# TASK 1.b
USE HH_DB_LAB1;

# Q1. Select all students above the age of 20; 
SELECT * FROM Student WHERE age > 20;

# Q2. Who is the oldest student?
SELECT * FROM Student WHERE age = (SELECT MAX(age) FROM Student);

# Q3. Count the number of students with age below 20; 
SELECT COUNT(age) as 'Number of Students with Age < 20' FROM Student WHERE age < 20;

# Q4. How many types of majors were these students admitted to? 
SELECT COUNT(DISTINCT major) FROM Student;

# Q5. What is the average GPA of students with age above 20?
SELECT AVG(GPA) FROM Student WHERE age > 20;

# Q6. What is the average GPA of students studying the Physics major? 
SELECT AVG(GPA) FROM Student WHERE major = ‘PHY’;

# Q7. What is the average age of students who took Linear algebra courses?
SELECT AVG(age) FROM Student WHERE sid IN (SELECT sid FROM Enrolled WHERE cid = (SELECT cid FROM Course WHERE course_name = 'Linear algebra'));

# Q8. How many courses has Alice registered for?
SELECT COUNT(*) as 'Courses Registered' FROM Enrolled WHERE sid = (SELECT sid FROM Student WHERE full_name='Alice
');

# Q9. How many credits has Alice registered?
SELECT SUM(credits) FROM Course WHERE cid IN (SELECT cid FROM Enrolled WHERE sid = (SELECT sid FROM Student WHERE
 full_name='Alice'));

# Q10. How many credits have students with ages below 20 registered to? 
SELECT SUM(credits) as 'Credits Registered for Students < 20' FROM Course WHERE cid IN (SELECT cid FROM Enrolled WHERE sid IN (SELECT sid FROM Student WHERE age < 20));


