# TASK 1.c

# Q1. Which courses has Kayle registered for?
SELECT course_name FROM Course WHERE cid IN (SELECT cid FROM Enrolled WHERE sid = (SELECT sid FROM Student WHERE full_name='Kayle'));

# Q2.Who is the oldest student?
SELECT full_name as 'Oldest Student', age FROM Student WHERE age = (SELECT MAX(age) FROM Student);
