-- Remove all data except the admin user --
DELETE FROM `users` WHERE `users`.`username` != 'admin';
DELETE FROM `hadiths`;
DELETE FROM `sections`;
DELETE FROM `chapters`;
DELETE FROM `books`;