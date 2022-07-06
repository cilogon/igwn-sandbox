CREATE DATABASE grouper;
CREATE USER grouper@'%' IDENTIFIED BY 'password';
GRANT ALL ON grouper.* TO 'grouper'@'%';
