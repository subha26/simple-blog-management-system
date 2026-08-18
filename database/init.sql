CREATE DATABASE IF NOT EXISTS simple_blog;

USE simple_blog;


/*
|--------------------------------------------------------------------------
| Users Table
|--------------------------------------------------------------------------
|
| Stores administrator login and security recovery information.
|
*/

CREATE TABLE IF NOT EXISTS users (

    id INT AUTO_INCREMENT PRIMARY KEY,

    username VARCHAR(50) NOT NULL UNIQUE,

    password VARCHAR(255) NOT NULL,

    full_name VARCHAR(100) NOT NULL,

    security_question VARCHAR(255) NULL,

    security_answer VARCHAR(255) NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);


/*
|--------------------------------------------------------------------------
| Posts Table
|--------------------------------------------------------------------------
|
| Stores blog posts written by the administrator.
|
*/

CREATE TABLE IF NOT EXISTS posts (

    id INT AUTO_INCREMENT PRIMARY KEY,

    title VARCHAR(255) NOT NULL,

    slug VARCHAR(255) NOT NULL UNIQUE,

    content TEXT NOT NULL,

    author_id INT NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_posts_author

        FOREIGN KEY (author_id)

        REFERENCES users(id)

        ON DELETE CASCADE

);


/*
|--------------------------------------------------------------------------
| Comments Table
|--------------------------------------------------------------------------
|
| Each comment belongs to one blog post.
|
*/

CREATE TABLE IF NOT EXISTS comments (

    id INT AUTO_INCREMENT PRIMARY KEY,

    post_id INT NOT NULL,

    name VARCHAR(100) NOT NULL,

    email VARCHAR(150) NOT NULL,

    comment TEXT NOT NULL,

    status ENUM(
        'pending',
        'approved',
        'rejected'
    ) NOT NULL DEFAULT 'pending',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_comments_post

        FOREIGN KEY (post_id)

        REFERENCES posts(id)

        ON DELETE CASCADE

);