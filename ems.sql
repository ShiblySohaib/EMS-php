-- Create the database
CREATE DATABASE ems;

-- Use the newly created database
USE ems;

-- Create users table
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL
);

-- Create tasks table
CREATE TABLE tasks (
    task_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL
);

-- Create depts table
CREATE TABLE depts (
    name VARCHAR(100) PRIMARY KEY
);

-- Create user_tasks table
CREATE TABLE user_tasks (
    user_id INT,
    task_id INT,
    dept_name VARCHAR(100),
    PRIMARY KEY (user_id, task_id, dept_name),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (task_id) REFERENCES tasks(task_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (dept_name) REFERENCES depts(name) ON DELETE CASCADE ON UPDATE CASCADE
);