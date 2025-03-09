# Task 3.1
SELECT c.title_id, t.primary_title, c.category, p.name 
FROM crew c
JOIN people AS p ON p.person_id = c.person_id
JOIN titles AS t ON t.title_id = c.title_id
WHERE t.primary_title = 'Top Gun'
AND p.name IS NOT 'Tom Cruise';

# Task 3.2
SELECT COUNT(DISTINCT c2.person_id) AS 'number_of_people_who_worked_with_TC' 
FROM crew c1
JOIN crew c2 ON c1.title_id = c2.title_id
WHERE c1.person_id = (SELECT person_id FROM people WHERE name = 'Tom Cruise' LIMIT 1)
AND c2.person_id != c1.person_id;