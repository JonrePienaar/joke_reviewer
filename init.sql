CREATE DATABASE jokes_db;
                USE jokes_db;
        CREATE TABLE login_users (
                        login_id INT AUTO_INCREMENT, 
                        email VARCHAR(85) NOT NULL DEFAULT 'undefined',
                        login_password VARCHAR(85) NOT NULL DEFAULT 'undefined',
                        PRIMARY KEY(login_id)
                        );

                        -- default user
                    INSERT INTO login_users (email, login_password)
                        VALUES ('bruce', 'batman');


                    CREATE TABLE jokes (
                        joke_id INT AUTO_INCREMENT, 
                        setup VARCHAR(85) NOT NULL DEFAULT 'undefined',
                        punchline VARCHAR(85) NOT NULL DEFAULT 'undefined',
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        PRIMARY KEY(joke_id)
                    );

                    CREATE TABLE reviews (
                        review_id INT AUTO_INCREMENT,
                        rating INT(11) NOT NULL DEFAULT 0,
                        countz INT(11) NOT NULL DEFAULT 1,
                        total FLOAT NOT NULL, 
                        login_id int NOT NULL,
                        joke_id int NOT NULL,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        PRIMARY KEY(review_id),

                        FOREIGN KEY(login_id) REFERENCES login_users(login_id),
                        FOREIGN KEY(joke_id) REFERENCES jokes(joke_id)
                    );