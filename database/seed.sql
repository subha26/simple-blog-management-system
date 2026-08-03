USE simple_blog;

INSERT INTO users
(username,password,full_name)

VALUES
(
'admin',

'$2y$10$1N6fM5Q4PcbJQmKnJf0e2OsVxS2Jjv7sX4tJtA8mVbq2zL6l0P4Qe',

'Administrator'
);

INSERT INTO posts
(title,slug,content,author_id)

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
