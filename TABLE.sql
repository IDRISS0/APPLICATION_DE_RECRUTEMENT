CREATE DATABASE cv_database;

USE cv_database;

CREATE TABLE cv (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    competences TEXT NOT NULL,
    score INT NOT NULL
);