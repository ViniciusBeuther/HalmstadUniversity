# Task 2.1
SELECT title_id, primary_title 
FROM titles 
WHERE primary_title = 'Top Gun';

# Task 2.2a - Show all dubbed languages for the movie Top Gun
SELECT DISTINCT a.language, a.title, t.primary_title, t.title_id
FROM akas AS a
JOIN titles AS t ON a.title_id = t.title_id
WHERE t.primary_title = 'Top Gun'
AND a.language IS NOT null
AND a.title IS NOT null
ORDER BY a.title ASC;

# Task2.2b - Query to count how many Top Gun it has:
SELECT COUNT(DISTINCT a.language) AS dubbed_quantity
FROM akas a
JOIN titles t ON a.title_id = t.title_id
WHERE t.primary_title = 'Top Gun'
AND a.language IS NOT null
AND a.title IS NOT null

# Task 2.3
SELECT a.title_id, t.primary_title, COUNT(1) AS counter
FROM akas AS a
JOIN titles AS t ON t.title_id = a.title_id
GROUP BY a.title_id
ORDER BY counter DESC
LIMIT 10;