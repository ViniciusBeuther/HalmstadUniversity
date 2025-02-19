# TASK 3.b - Queries on SQLite
# In addition to the the queries above, propose two or more queries of your interesting.

# Q1. Which series have the biggest amount of seasons?
SELECT t.title_id, t.primary_title, e.season_number FROM Titles as t
JOIN Episodes as e
ON t.title_id = e.episode_title_id
WHERE e.season_number = (SELECT MAX(season_number) FROM Episodes);

# Q2. What is the movie where the oldest actor acted? Also, show his age and name.
SELECT t.primary_title, p.name, MAX(p.died - p.born) FROM people p, titles t, crew c WHERE c.title_id = t.title_id and p.person_id = c.person_id;
