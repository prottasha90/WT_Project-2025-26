-- Database Creation
CREATE DATABASE IF NOT EXISTS beyond_orbit_db;
USE beyond_orbit_db;

-- FLUSH Tables (Optional: Drop tables if they exist to ensure clean slate)
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS supply_requests;
DROP TABLE IF EXISTS mission_logs;
DROP TABLE IF EXISTS assignments;
DROP TABLE IF EXISTS missions;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

-- 1. Users Table (Stores both Directors and Astronauts)  
-- User Story: "Director can securely log in... Astronaut can log in... Both users can manage profiles"
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('director', 'astronaut') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Missions Table
-- User Story: "Director can create, update, and delete space missions"
CREATE TABLE missions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    launch_date DATE,
    status ENUM('planned', 'in-progress', 'completed', 'aborted') DEFAULT 'planned',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Assignments Table
-- User Story: "Director can... assign astronauts to missions"
CREATE TABLE assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mission_id INT NOT NULL,
    astronaut_id INT NOT NULL,
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (mission_id) REFERENCES missions(id) ON DELETE CASCADE,
    FOREIGN KEY (astronaut_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 4. Mission Logs Table
-- User Story: "Astronaut can... submit mission logs describing mission progress"
CREATE TABLE mission_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mission_id INT NOT NULL,
    astronaut_id INT NOT NULL,
    log_content TEXT NOT NULL,
    log_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (mission_id) REFERENCES missions(id) ON DELETE CASCADE,
    FOREIGN KEY (astronaut_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 5. Supply Requests Table
-- User Story: "Astronaut can... request required mission supplies while tracking approval status"
CREATE TABLE supply_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mission_id INT NOT NULL,
    astronaut_id INT NOT NULL,
    item_name VARCHAR(150) NOT NULL,
    quantity INT DEFAULT 1,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    request_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (mission_id) REFERENCES missions(id) ON DELETE CASCADE,
    FOREIGN KEY (astronaut_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Initial Data Seeding
-- Director User: email='director@beyondorbit.com', password='password123'
-- Hash generated via password_hash('password123', PASSWORD_DEFAULT)
INSERT INTO users (full_name, email, password_hash, role) VALUES 
('Commander Shepherd', 'director@beyondorbit.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'director');

-- Sample Mission
INSERT INTO missions (title, description, launch_date, status) VALUES 
('Operation Skyfall', 'Deploy satellite network to outer rim.', '2026-05-15', 'planned');
