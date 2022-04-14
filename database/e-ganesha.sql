show databases;

create database e_ganesha;

use e_ganesha;

show create database e_ganesha;

show tables;

show create table users;

select * from users;

select * from permissions;

select * from model_has_roles;
	
select * from roles;

select * from model_has_permissions;

select * from genders;

select * from teachers;

select * from students;

select * from class_years;

select * from activity_log;

select * from babs;

select * from teacher_courses;

select * from courses;

select * from upload_answers;

alter table users
rename column name to nama;
