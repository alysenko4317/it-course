
INSERT INTO Room (name, amount) values ('Велика', 40);
INSERT INTO Room (name, amount) values ('Середня', 20);
INSERT INTO Room (name, amount) values ('Мала', 10);

INSERT INTO Reader (ticket, first_name, last_name, birthday, registration_date, phone, education, degree, room_id)
    VALUES('T12345', 'Анатолій', 'Шевченко', '1976-01-08', '2023-01-01', '+380501561212', ' вище', false,
           (select id from Room where name = 'Мала'));
INSERT INTO Reader (ticket, first_name, last_name, birthday, registration_date, phone, education, degree, room_id)
    VALUES('T12384', 'Василь', 'Петренко', '2007-01-08', '2023-01-01', '+380501231872', '', false,
           (select id from Room where name = 'Середня'));
INSERT INTO Reader (ticket, first_name, last_name, birthday, registration_date, phone, education, degree, room_id)
    VALUES('T12035', 'Олеся', 'Костенко', '1982-12-03', '2023-01-01', '+380501234712', ' вище', false,
           (select id from Room where name = 'Велика'));
INSERT INTO Reader (ticket, first_name, last_name, birthday, registration_date, phone, education, degree, room_id, release_date)
    VALUES('GFHHDJ', 'Степан', 'Костюченко', '2005-11-18', '2023-01-01', '+380591231212', ' середне', false,
           (select id from Room where name = 'Середня'), '2023-01-19');


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