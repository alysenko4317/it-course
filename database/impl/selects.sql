select b.name, r.first_name, r.last_name, rb.date from book b, reader r, readby rb
where rb.book_id = b.id and rb.reader_id = r.id and r.ticket = 'T12345';

select name from book where code = 'A1B3';

select code, name from book where name like '%Поттер%';

select b.name, r.first_name, r.last_name, rb.date from book b, reader r, readby rb
where rb.book_id = b.id and rb.reader_id = r.id and r.ticket = 'T12345' and b.code = 'A1B2'

select r.first_name, r.last_name, rb.date from reader r, readby rb
where rb.reader_id = r.id and rb.date <= current_date - interval '1 month';

select max(b.name), sum(h.amount) from Book b, Room r, hasin h
where h.book_id = b.id and h.room_id = r.id
group by b.code having sum(h.amount) <= 2

select count(id) from reader where release_date is null;

select count(id) from reader where release_date is null and now() - birthday <= interval '20 years'









