# INSERT INTO Role(role_name) VALUES("administrators"), ("incident reporters"), ("incident responders");
# INSERT INTO Role(role_name) VALUES("user");

#INSERT INTO Permission(permission_name) VALUES
#	("User Management"), ## adm
#    ("Report Incidents"), ## all
#    ("See Reported Incidents"), ## all
#    ("Add Comments"), ## all
#    ("Add Evidences"), ## all
#    ("Website Statistics"), ## adm
#    ("Log Reports"); ## adm




INSERT INTO Role_Permission(permission_id, role_id) VALUES
	((SELECT permission_id FROM Permission WHERE permission_name = "User Management"), (SELECT role_id FROM Role WHERE role_name = "administrators")),
    ((SELECT permission_id FROM Permission WHERE permission_name = "Report Incidents"), (SELECT role_id FROM Role WHERE role_name = "administrators")),
    ((SELECT permission_id FROM Permission WHERE permission_name = "Report Incidents"), (SELECT role_id FROM Role WHERE role_name = "incident reporters")),
    ((SELECT permission_id FROM Permission WHERE permission_name = "Report Incidents"), (SELECT role_id FROM Role WHERE role_name = "incident responders")),
    ((SELECT permission_id FROM Permission WHERE permission_name = "See Reported Incidents"), (SELECT role_id FROM Role WHERE role_name = "administrators")),
    ((SELECT permission_id FROM Permission WHERE permission_name = "See Reported Incidents"), (SELECT role_id FROM Role WHERE role_name = "incident reporters")),
    ((SELECT permission_id FROM Permission WHERE permission_name = "See Reported Incidents"), (SELECT role_id FROM Role WHERE role_name = "incident responders")),
    ((SELECT permission_id FROM Permission WHERE permission_name = "Add Comments"), (SELECT role_id FROM Role WHERE role_name = "administrators")),
    ((SELECT permission_id FROM Permission WHERE permission_name = "Add Comments"), (SELECT role_id FROM Role WHERE role_name = "incident reporters")),
    ((SELECT permission_id FROM Permission WHERE permission_name = "Add Comments"), (SELECT role_id FROM Role WHERE role_name = "incident responders")),
    ((SELECT permission_id FROM Permission WHERE permission_name = "Add Evidences"), (SELECT role_id FROM Role WHERE role_name = "administrators")),
    ((SELECT permission_id FROM Permission WHERE permission_name = "Add Evidences"), (SELECT role_id FROM Role WHERE role_name = "incident reporters")),
    ((SELECT permission_id FROM Permission WHERE permission_name = "Add Evidences"), (SELECT role_id FROM Role WHERE role_name = "incident responders")),
    ((SELECT permission_id FROM Permission WHERE permission_name = "Website Statistics"), (SELECT role_id FROM Role WHERE role_name = "administrators")),
    ((SELECT permission_id FROM Permission WHERE permission_name = "Log Reports"), (SELECT role_id FROM Role WHERE role_name = "administrators"));

select * from Permission ORDER BY permission_id;
select * from Role ORDER BY role_id;