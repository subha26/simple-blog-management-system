CREATE DATABASE IF NOT EXISTS simple_blog;
USE simple_blog;


/*
|--------------------------------------------------------------------------
| Default Administrator
|--------------------------------------------------------------------------
|
| Development login credentials:
|
| Username: admin
| Password: admin123
| Security answer: hijli college
|
| The actual password is stored as a secure PHP password hash.
|
*/

INSERT INTO users (
    username,
    password,
    full_name,
    security_question,
    security_answer
)
VALUES (
    'admin',

    '$2y$10$ahmQta4o328jg5kwAQkpxu8I6hVD2f./JmI90q0JxW8B3vCv56Uxa',

    'Administrator',

    'What is the name of your first school?',

    '$2y$12$KpLx6SS4r9O7CgBxH/qQROU4ExckI1I2ogSh2oAX26Tupj1E8o8V.'
);


/*
|--------------------------------------------------------------------------
| Sample Blog Posts
|--------------------------------------------------------------------------
*/

INSERT INTO posts (
    title,
    slug,
    content,
    author_id
)
VALUES

(
    'Welcome to Simple Blog',

    'welcome-to-simple-blog',

    'Congratulations! Your Simple Blog application has been successfully installed. This is the first sample blog post stored in the MariaDB database.',

    1
),

(
    'Learning PHP',

    'learning-php',

    'PHP is one of the most widely used server-side scripting languages for web development. In this project we will build a complete blog using PHP and MariaDB.',

    1
);