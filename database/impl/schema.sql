CREATE TABLE Book (
  id SERIAL PRIMARY KEY,
  code varchar(20) UNIQUE NOT NULL ,
  name varchar(200) NOT NULL,
  release_date date NULL
);

CREATE TABLE Room (
  id SERIAL PRIMARY KEY,
  name varchar(40) NOT NULL,
  amount int2 NOT NULL
);

CREATE TABLE Reader (
  id SERIAL PRIMARY KEY,
  ticket VARCHAR(20) UNIQUE NOT NULL,              -- Unique identifier for the reader (acts like a username)
  first_name VARCHAR(40) NOT NULL,                 -- Reader's first name
  last_name VARCHAR(40) NOT NULL,                  -- Reader's last name
  other_name VARCHAR(40),                          -- Middle or other name (optional)
  birthday DATE NOT NULL,                          -- Reader's date of birth
  registration_date DATE NOT NULL,                 -- Date of registration
  release_date DATE,                               -- Release date (optional)
  phone VARCHAR(15) NOT NULL,                      -- Phone number
  education VARCHAR(20),                           -- Level of education
  degree BOOLEAN,                                  -- Indicates if the reader holds a degree (true/false)
  room_id INTEGER REFERENCES Room(id) NOT NULL,    -- Foreign key to the Room table (association to a room)
  password VARCHAR(255) NOT NULL,                  -- Hashed password for authentication
  password_reset_token VARCHAR(255),               -- Token for password reset (optional)
  password_reset_expires_at TIMESTAMP,             -- Expiry time for the password reset token (optional)
  telegram_id VARCHAR(255) UNIQUE                  -- Telegram ID for linking the reader account (optional, unique)
);

CREATE TABLE Author(
    id SERIAL PRIMARY KEY,
    first_name varchar(40) NOT NULL,
    last_name varchar(40) NOT NULL,
    other_name varchar(40)
);

CREATE TABLE WrittenBy(
    book_id INTEGER REFERENCES Book(id) NOT NULL,
    author_id INTEGER REFERENCES Author(id) NOT NULL,
    PRIMARY KEY (book_id, author_id)
);

CREATE TABLE Publisher(
  id SERIAL PRIMARY KEY,
  name varchar(40) NOT NULL,
  city varchar(40) NOT NULL
);

CREATE TABLE PublishedBy(
  book_id INTEGER REFERENCES Book(id) NOT NULL,
  publisher_id INTEGER REFERENCES Publisher(id) NOT NULL,
  PRIMARY KEY (book_id, publisher_id),
  date date NOT NULL
);

CREATE TABLE HasIn(
  book_id INTEGER REFERENCES Book(id) NOT NULL,
  room_id INTEGER REFERENCES Room(id) NOT NULL,
  PRIMARY KEY (book_id, room_id),
  amount INTEGER NOT NULL
);

CREATE TABLE ReadBy(
  book_id INTEGER REFERENCES Book(id) NOT NULL,
  reader_id INTEGER REFERENCES Reader(id) NOT NULL,
  PRIMARY KEY (book_id, reader_id),
  date date NOT NULL
);

CREATE TABLE BindingTokens (
    id SERIAL PRIMARY KEY,                          -- Primary key for the binding token record
    telegram_id VARCHAR(255) NOT NULL,              -- Telegram ID of the user
    binding_token VARCHAR(255) UNIQUE NOT NULL,     -- Unique token for linking the user's account
    first_name VARCHAR(40),                         -- User's first name from Telegram (optional)
    last_name VARCHAR(40),                          -- User's last name from Telegram (optional)
    username VARCHAR(40),                           -- User's Telegram username (optional)
    phone VARCHAR(20),                              -- User's phone number if available (optional)
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),    -- The timestamp when the record was created
    expires_at TIMESTAMP                            -- The expiration timestamp for the binding token
);

-- Index to speed up queries by telegram_id, if needed for frequent lookups
CREATE INDEX idx_telegram_id ON BindingTokens (telegram_id);

-- Index to speed up queries by binding_token, used during user registration
CREATE INDEX idx_binding_token ON BindingTokens (binding_token);
