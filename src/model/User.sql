CREATE TABLE
   IF NOT EXISTS register_user (
      id INT SERIAL,
      name VARCHAR(255) NOT NULL,
      email VARCHAR(255) UNIQUE NOT NULL,
      password VARCHAR(255) NOT NULL,
      PRIMARY KEY (id)
   );