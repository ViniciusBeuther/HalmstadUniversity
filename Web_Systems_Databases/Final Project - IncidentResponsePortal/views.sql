CREATE VIEW v_role_permissions AS 
    SELECT r.role_id, r.role_name, perm.permission_name FROM
    Role r
    INNER JOIN Role_Permission rp
    ON r.role_id = rp.role_id
    INNER JOIN Permission AS perm
    ON perm.permission_id = rp.permission_id
    ORDER BY r.role_name;
    