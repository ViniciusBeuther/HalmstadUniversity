# TASK 3.a - SQLite Queries

# Q1. How many movies have the highest rating?
SELECT COUNT(rating) FROM Ratings WHERE rating = (SELECT MAX(rating) FROM Ratings);

# Q2. What are the most common genres in this database?
SELECT genres, count(title_id) as n FROM titles GROUP BY genres ORDER BY n DESC limit 1;

# Q3. Which movie is the longest?
SELECT primary_title, MAX(runtime_minutes) FROM Titles;
