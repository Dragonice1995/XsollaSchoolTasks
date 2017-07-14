SELECT DISTINCT game
FROM users INNER JOIN payments ON users.id = payments.user_id
GROUP BY user_id
HAVING SUM(amount) > 100 and level > 10;