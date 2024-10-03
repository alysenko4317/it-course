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
  ticket varchar(20) UNIQUE NOT NULL,
  first_name varchar(40) NOT NULL,
  last_name varchar(40) NOT NULL,
  other_name varchar(40),
  birthday date NOT NULL,
  registration_date date NOT NULL,
  release_date date,
  phone varchar(15) NOT NULL,
  education varchar(20) NOT NULL,
  degree bool NOT NULL,
  room_id INTEGER REFERENCES Room(id) NOT NULL
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