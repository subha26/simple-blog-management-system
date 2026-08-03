-- ===========================================
-- Simple Blog Database
-- ===========================================

CREATE DATABASE IF NOT EXISTS simple_blog;

USE simple_blog;

-- ===========================================
-- USERS TABLE
-- ===========================================

CREATE TABLE users (

    id INT AUTO_INCREMENT PRIMARY KEY,

    username VARCHAR(50) NOT NULL UNIQUE,

    password VARCHAR(255) NOT NULL,

    full_name VARCHAR(100) NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

-- ===========================================
-- POSTS TABLE
-- ===========================================

CREATE TABLE posts (

    id INT AUTO_INCREMENT PRIMARY KEY,

    title VARCHAR(255) NOT NULL,

    slug VARCHAR(255) NOT NULL UNIQUE,

    content TEXT NOT NULL,

    author_id INT NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_post_author
        FOREIGN KEY(author_id)
        REFERENCES users(id)
        ON DELETE CASCADE

);

-- ===========================================
-- COMMENTS TABLE
-- ===========================================

CREATE TABLE comments (

    id INT AUTO_INCREMENT PRIMARY KEY,

    post_id INT NOT NULL,

    name VARCHAR(100) NOT NULL,

    email VARCHAR(150),

    comment TEXT NOT NULL,

    status ENUM('pending','approved','rejected')
        DEFAULT 'approved',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_comment_post
        FOREIGN KEY(post_id)
        REFERENCES posts(id)
        ON DELETE CASCADE

);
