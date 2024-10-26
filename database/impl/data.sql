
INSERT INTO Room (name, amount) values ('Велика', 40);
INSERT INTO Room (name, amount) values ('Середня', 20);
INSERT INTO Room (name, amount) values ('Мала', 10);

INSERT INTO Reader (ticket, first_name, last_name, birthday, registration_date, phone, education, degree, room_id, password, password_reset_token, password_reset_expires_at)
    VALUES('T12345', 'Анатолій', 'Шевченко', '1976-01-08', '2023-01-01', '+380501561212', 'вище', false,
           (SELECT id FROM Room WHERE name = 'Мала'),
           '$2y$10$Vb8Z/YY3a.ew/ywZ9j.Dd.TuwuZ9PRJXeBMEwH5OuyOKddes/0TGi', NULL, NULL);

INSERT INTO Reader (ticket, first_name, last_name, birthday, registration_date, phone, education, degree, room_id, password, password_reset_token, password_reset_expires_at)
    VALUES('T12384', 'Василь', 'Петренко', '2007-01-08', '2023-01-01', '+380501231872', '', false,
           (SELECT id FROM Room WHERE name = 'Середня'),
           '$2y$10$Vb8Z/YY3a.ew/ywZ9j.Dd.TuwuZ9PRJXeBMEwH5OuyOKddes/0TGi', NULL, NULL);

INSERT INTO Reader (ticket, first_name, last_name, birthday, registration_date, phone, education, degree, room_id, password, password_reset_token, password_reset_expires_at)
    VALUES('T12035', 'Олеся', 'Костенко', '1982-12-03', '2023-01-01', '+380501234712', 'вище', false,
           (SELECT id FROM Room WHERE name = 'Велика'),
           '$2y$10$Vb8Z/YY3a.ew/ywZ9j.Dd.TuwuZ9PRJXeBMEwH5OuyOKddes/0TGi', NULL, NULL);

INSERT INTO Reader (ticket, first_name, last_name, birthday, registration_date, phone, education, degree, room_id, release_date, password, password_reset_token, password_reset_expires_at)
    VALUES('GFHHDJ', 'Степан', 'Костюченко', '2005-11-18', '2023-01-01', '+380591231212', 'середне', false,
           (SELECT id FROM Room WHERE name = 'Середня'),
           '2023-01-19',
           '$2y$10$Vb8Z/YY3a.ew/ywZ9j.Dd.TuwuZ9PRJXeBMEwH5OuyOKddes/0TGi', NULL, NULL);



INSERT INTO Author(first_name, last_name) values('Олексій', 'Толстой');
INSERT INTO Author(first_name, last_name) values('Карло', 'Колоді');
INSERT INTO Author(first_name, last_name) values('Григорій', 'Перельман');
INSERT INTO Author(first_name, last_name) values('Джоан', 'Роулінг');

INSERT INTO Publisher(name, city) values('Фолио', 'Харьков');

INSERT INTO Book (code, name) values ('A1B2', 'Золотой ключик');
INSERT INTO Book (code, name) values ('A1B3', 'Пригоди Піноккіо');
INSERT INTO Book (code, name, release_date) values ('A1B4', 'Основи математичного аналізу', '2020-01-01');
INSERT INTO Book (code, name) values ('A2B5', 'Гаррі Поттер та тайна кімната');

INSERT INTO publishedby (book_id, publisher_id, date) VALUES (
        (select id from Book where code = 'A1B2'),
        (select id from Publisher where name = 'Фолио'),
        '2020-01-01');
INSERT INTO publishedby (book_id, publisher_id, date) VALUES (
        (select id from Book where code = 'A1B3'),
        (select id from Publisher where name = 'Фолио'),
        '2020-01-01');
INSERT INTO publishedby (book_id, publisher_id, date) VALUES (
        (select id from Book where code = 'A1B4'),
        (select id from Publisher where name = 'Фолио'),
        '2020-01-01');
INSERT INTO publishedby (book_id, publisher_id, date) VALUES (
        (select id from Book where code = 'A2B5'),
        (select id from Publisher where name = 'Фолио'),
        '2020-01-01');

INSERT INTO writtenby (book_id, author_id) VALUES (
        (select id from Book where code = 'A1B2'),
        (select id from Author where first_name = 'Олексій'));
INSERT INTO writtenby (book_id, author_id) VALUES (
        (select id from Book where code = 'A1B3'),
        (select id from Author where first_name = 'Карло'));
INSERT INTO writtenby (book_id, author_id) VALUES (
        (select id from Book where code = 'A1B3'),
        (select id from Author where first_name = 'Григорій'));
INSERT INTO writtenby (book_id, author_id) VALUES (
        (select id from Book where code = 'A2B5'),
        (select id from Author where first_name = 'Джоан'));

INSERT INTO hasin (book_id, room_id, amount) VALUES (
        (select id from Book where code = 'A1B2'),
        (select id from Room where name = 'Мала'), 2);
INSERT INTO hasin (book_id, room_id, amount) VALUES (
        (select id from Book where code = 'A1B3'),
        (select id from Room where name = 'Середня'), 5);
INSERT INTO hasin (book_id, room_id, amount) VALUES (
        (select id from Book where code = 'A1B3'),
        (select id from Room where name = 'Мала'), 7);
INSERT INTO hasin (book_id, room_id, amount) VALUES (
        (select id from Book where code = 'A2B5'),
        (select id from Room where name = 'Мала'), 1);
INSERT INTO hasin (book_id, room_id, amount) VALUES (
        (select id from Book where code = 'A2B5'),
        (select id from Room where name = 'Велика'), 1);

INSERT INTO readby (book_id, reader_id, date) VALUES (
        (select id from Book where code = 'A1B2'),
        (select id from Reader where ticket = 'T12345'), '2023-01-20');
INSERT INTO readby (book_id, reader_id, date) VALUES (
        (select id from Book where code = 'A1B3'),
        (select id from Reader where ticket = 'T12384'), '2023-03-11');
INSERT INTO readby (book_id, reader_id, date) VALUES (
        (select id from Book where code = 'A1B4'),
        (select id from Reader where ticket = 'T12035'), '2023-01-25');
		
		-- Додавання нових книг до таблиці Book
INSERT INTO Book (code, name, release_date) VALUES ('TG1925', 'The Great Gatsby', '1925-01-01');
INSERT INTO Book (code, name, release_date) VALUES ('TKM1960', 'To Kill a Mockingbird', '1960-01-01');
INSERT INTO Book (code, name, release_date) VALUES ('N1984', '1984', '1949-01-01');
INSERT INTO Book (code, name, release_date) VALUES ('PP1813', 'Pride and Prejudice', '1813-01-01');
INSERT INTO Book (code, name, release_date) VALUES ('CIR1951', 'The Catcher in the Rye', '1951-01-01');
INSERT INTO Book (code, name, release_date) VALUES ('MD1851', 'Moby Dick', '1851-01-01');
INSERT INTO Book (code, name, release_date) VALUES ('WP1869', 'War and Peace', '1869-01-01');
INSERT INTO Book (code, name, release_date) VALUES ('O8BC', 'The Odyssey', '0800-01-01 BC');
INSERT INTO Book (code, name, release_date) VALUES ('CP1866', 'Crime and Punishment', '1866-01-01');
INSERT INTO Book (code, name, release_date) VALUES ('LOTR1954', 'The Lord of the Rings', '1954-01-01');

-- Додавання авторів (перевірте, чи ці автори вже існують)
INSERT INTO Author (first_name, last_name) VALUES ('F. Scott', 'Fitzgerald');
INSERT INTO Author (first_name, last_name) VALUES ('Harper', 'Lee');
INSERT INTO Author (first_name, last_name) VALUES ('George', 'Orwell');
INSERT INTO Author (first_name, last_name) VALUES ('Jane', 'Austen');
INSERT INTO Author (first_name, last_name) VALUES ('J.D.', 'Salinger');
INSERT INTO Author (first_name, last_name) VALUES ('Herman', 'Melville');
INSERT INTO Author (first_name, last_name) VALUES ('Leo', 'Tolstoy');
INSERT INTO Author (first_name, last_name) VALUES ('Homer', '');
INSERT INTO Author (first_name, last_name) VALUES ('Fyodor', 'Dostoevsky');
INSERT INTO Author (first_name, last_name) VALUES ('J.R.R.', 'Tolkien');

-- Додавання зв'язку між книгами та авторами
INSERT INTO WrittenBy (book_id, author_id) VALUES ((SELECT id FROM Book WHERE code = 'TG1925'), (SELECT id FROM Author WHERE last_name = 'Fitzgerald'));
INSERT INTO WrittenBy (book_id, author_id) VALUES ((SELECT id FROM Book WHERE code = 'TKM1960'), (SELECT id FROM Author WHERE last_name = 'Lee'));
INSERT INTO WrittenBy (book_id, author_id) VALUES ((SELECT id FROM Book WHERE code = 'N1984'), (SELECT id FROM Author WHERE last_name = 'Orwell'));
INSERT INTO WrittenBy (book_id, author_id) VALUES ((SELECT id FROM Book WHERE code = 'PP1813'), (SELECT id FROM Author WHERE last_name = 'Austen'));
INSERT INTO WrittenBy (book_id, author_id) VALUES ((SELECT id FROM Book WHERE code = 'CIR1951'), (SELECT id FROM Author WHERE last_name = 'Salinger'));
INSERT INTO WrittenBy (book_id, author_id) VALUES ((SELECT id FROM Book WHERE code = 'MD1851'), (SELECT id FROM Author WHERE last_name = 'Melville'));
INSERT INTO WrittenBy (book_id, author_id) VALUES ((SELECT id FROM Book WHERE code = 'WP1869'), (SELECT id FROM Author WHERE last_name = 'Tolstoy'));
INSERT INTO WrittenBy (book_id, author_id) VALUES ((SELECT id FROM Book WHERE code = 'O8BC'), (SELECT id FROM Author WHERE last_name = 'Homer'));
INSERT INTO WrittenBy (book_id, author_id) VALUES ((SELECT id FROM Book WHERE code = 'CP1866'), (SELECT id FROM Author WHERE last_name = 'Dostoevsky'));
INSERT INTO WrittenBy (book_id, author_id) VALUES ((SELECT id FROM Book WHERE code = 'LOTR1954'), (SELECT id FROM Author WHERE last_name = 'Tolkien'));

