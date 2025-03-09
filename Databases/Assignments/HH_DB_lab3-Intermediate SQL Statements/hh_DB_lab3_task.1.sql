# Task 1.1
SELECT DISTINCT(type) 
FROM titles;

# Task 1.2
SELECT type, COUNT(1) 
FROM titles 
GROUP BY type 
ORDER BY type ASC;

# Task 1.3
SELECT MAX(runtime_minutes), primary_title, type 
FROM titles;

# Task 1.4
SELECT primary_title, type, MAX(runtime_minutes) 
FROM titles 
GROUP BY type 
ORDER BY primary_title ASC;

# Task 1.5
SELECT premiered, COUNT(1) 
FROM titles 
WHERE premiered NOT null 
GROUP BY premiered;

# Task 1.6
SELECT ((premiered/10) * 10), COUNT(1) 
FROM titles 
GROUP BY premiered/10;

# Task 1.7
SELECT
	(premiered / 10) * 10 AS decade,  
	COUNT(*) * 100.0 / (SELECT COUNT(*) FROM titles WHERE type = 'movie' AND premiered IS NOT NULL) AS percentage
FROM titles
WHERE type = 'movie' AND premiered IS NOT NULL
GROUP BY decade
ORDER BY decade;
