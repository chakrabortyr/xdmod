-- Create the public user if it doesn't already exist
INSERT INTO Users(username, email_address, first_name, last_name, time_created, time_last_updated, account_is_active, person_id, organization_id, field_of_science, user_type)
SELECT inc.*
FROM (
     SELECT
        'Public User' AS username,
        'public@ccr.xdmod.org' AS email_address,
        'Public' AS first_name,
        'User'   AS last_name,
        NOW()    AS time_created,
        NOW()    AS time_last_updated,
        TRUE     AS account_is_active,
        -1       AS person_id,
        0        AS organization_id,
        0        AS field_of_science,
        ut.id    AS user_type
    FROM UserTypes ut
    WHERE ut.type = 'Internal'
) inc
LEFT JOIN Users cur
     ON cur.username = inc.username AND
        cur.email_address = inc.email_address
WHERE cur.id IS NULL;

-- Create the association between the public user and the public acl.
INSERT INTO user_acls(user_id, acl_id)
SELECT inc.*
FROM (
     SELECT
        u.id     AS user_id,
        a.acl_id AS acl_id
     FROM Users u, acls a
     WHERE u.username = 'Public User' AND
           a.name = 'pub'
) inc
LEFT JOIN user_acls cur
     ON cur.user_id = inc.user_id AND
        cur.acl_id  = inc.acl_id
WHERE cur.user_acl_id IS NULL;

