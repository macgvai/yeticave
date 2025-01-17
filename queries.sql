USE yeticave;

insert into users (email,password,name, contacts)
VALUES ('vasya@mail.ru', 777, 'Vasya', 'Khimki');
insert into users (email,password,name, contacts)
VALUES ('victor@mail.ru', 888, 'Viktor', 'Khimki');

INSERT INTO categories SET
    category_code = 'boards',
    category_name = 'Доски и лыжи';
INSERT INTO categories SET
    category_code = 'attachment',
    category_name = 'Крепления';
INSERT INTO categories SET
    category_code = 'boots',
    category_name = 'Ботинки';
INSERT INTO categories SET
    category_code =  'clothing',
    category_name = 'Одежда';
INSERT INTO categories SET
    category_code = 'tools',
    category_name = 'Инструменты';
INSERT INTO categories SET
    category_code = 'other',
    category_name = 'Разное';

SELECT * FROM lots;

INSERT INTO lots SET
    image = 'img/lot-1.jpg',
    title = '2014 Rossignol District Snowboard',
    category_id = 1,
    user_id = 1,
    cost = '10999',
    time_create = '2024-08-02',
    time_expired = '2024-09-02';

INSERT INTO lots SET
    image = 'img/lot-2.jpg',
    title = 'DC Ply Mens 2016/2017 Snowboard',
    category_id = 1,
    user_id = 1,
    cost = '15999',
    time_create = '2024-08-15',
    time_expired = '2024-09-02';


INSERT INTO lots SET
    image = 'img/lot-3.jpg',
    title = 'Крепления Union Contact Pro 2015 года размер L/XL',
    category_id = 2,
    user_id = 1,
    cost = '8000',
    time_create = '2024-08-14',
    time_expired = '2024-09-02';

INSERT INTO lots SET
    image = 'img/lot-4.jpg',
    title = 'Ботинки для сноуборда DC Mutiny Charocal',
    category_id = 3,
    user_id = 1,
    cost = '10999',
    time_create = '2024-08-13',
    time_expired = '2024-09-02';

INSERT INTO lots SET
    image = 'img/lot-5.jpg',
    title = 'Куртка для сноуборда DC Mutiny Charocal',
    category_id = 4,
    user_id = 1,
    cost = '7500',
    time_create = '2024-07-03',
    time_expired = '2024-09-02';

INSERT INTO lots SET
    image = 'img/lot-6.jpg',
    title = 'Маска Oakley Canopy',
    category_id = 6,
    user_id = 1,
    cost = '5400',
    time_create = '2024-08-22',
    time_expired = '2024-09-02';

INSERT INTO bets
(price_bet, user_id, lots_id)
VALUES
    (8500, 1, 1);
INSERT INTO bets
(price_bet, user_id, lots_id)
VALUES
    (9000, 1, 4);

SELECT * FROM bets;

SELECT title, cost, image, category_name FROM lots
JOIN categories c on c.id = lots.category_id
WHERE time_expired IS NULL
ORDER BY time_create ASC;

SELECT c.category_name FROM lots
JOIN categories c on c.id = lots.category_id
WHERE lots.id = 1;

# UPDATE lots SET title = 'new title'
# WHERE id = 1;

SELECT u.name, b.price_bet, b.date_bet, lots.title FROM lots
JOIN yeticave.users u on lots.user_id = u.id
JOIN bets b on b.lots_id  =  lots.id
WHERE b.lots_id = 4
ORDER BY b.date_bet DESC ;

CREATE FULLTEXT INDEX lot_ft_search ON lots(title, description);
