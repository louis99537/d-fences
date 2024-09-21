CREATE DATABASE CAA;

USE CAA;

-- Table pour les voyageurs
CREATE TABLE voyageurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    postnom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    sexe ENUM('Homme', 'Femme') NOT NULL,
    code VARCHAR(20) NOT NULL UNIQUE,
    date_naissance DATE NOT NULL,
    date_reservation DATE NOT NULL,
    lieux_voyage VARCHAR(100) NOT NULL,
    photo VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table pour les limites de réservation
CREATE TABLE limites_reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_reservation DATE NOT NULL,
    nombre_reservations INT DEFAULT 0
);


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
