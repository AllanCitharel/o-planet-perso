-- SQL command to create a new waste type and replace all dumps with waste id 4 by waste id 7
insert into waste (`name`, `created_at`) values ('test', CURRENT_DATE);
update dump_waste
set waste_id = 7
where waste_id = 4;


/* insert into user_removal X number of combinations */
-- get max user id 
SELECT @max_user_id := MAX(`id`) FROM `user`;

-- get max removal id
SELECT @max_removal_id := MAX(`id`) FROM `removal`;

SELECT @user_id := ROUND( RAND() * @max_user_id ) + 1 ;
SELECT @removal_id := ROUND( RAND() * @max_removal_id ) + 1 ;
INSERT INTO `user_removal` VALUES (@user_id, @removal_id) ;

/* insert into user_removal X number of combinations */


