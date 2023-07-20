drop database if exists task_force;
create database task_force
    default character set utf8
    default collate utf8_general_ci;

use task_force;

drop table if exists users;
create table users (
    id bigint primary key not null auto_increment,
    email varchar(255) not null,
    name varchar(255) not null,
    city_id int(11) unsigned not null,
    password char(64) not null,
    reg_date datetime not null default current_timestamp,
    birthday datetime,
    bio text,
    tel varchar(255),
    skype varchar(255),
    telegram varchar(255),
    avatar varchar(255),
    is_performer boolean default true
);

drop table if exists categories;
create table categories(
    id bigint not null primary key auto_increment,
    name varchar(64) not null,
    icon varchar(64) not null
);

drop table if exists cities;
create table cities (
    id bigint not null primary key auto_increment,
    name varchar(255) not null,
    lat varchar(50) not null,
    `long` varchar(50) not null
);

drop table if exists performer_categories;
create table performer_categories (
    id bigint primary key not null auto_increment,
    performer_id int not null,
    category_id int not null
);

drop table if exists files;
create table files (
  id bigint primary key auto_increment not null,
  task_id bigint not null,
  name varchar(50),
  path varchar(256) not null,
  date_add datetime not null default current_timestamp
);

drop table if exists responses;
create table responses (
    id bigint primary key auto_increment not null,
    date_add datetime not null default current_timestamp,
    task_id bigint not null,
    performer_id bigint not null,
    price int not null,
    description text not null,
    rejected boolean not null
);

drop table if exists reviews;
create table reviews (
    id bigint primary key auto_increment not null,
    date_add datetime not null default current_timestamp,
    task_id bigint not null,
    author_id bigint not null,
    score int not null,
    text text not null,
    user_id int not null
);

drop table if exists tasks;
create table tasks (
    id bigint primary key not null auto_increment,
    date_add datetime not null default current_timestamp,
    status_id int not null,
    customer_id int not null,
    title varchar(255) not null,
    description text not null,
    location varchar(64),
    end_date datetime not null,
    price int default null,
    category_id int,
    performer_id int default null
);


