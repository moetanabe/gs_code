INSERT INTO gs_an_table
(name,email,naiyo,indate)
VALUES
('織田信長','test1@test.jp','メモ',sysdate())
-- オラクルにはsysdateしかないので、このほうが汎用性が高い

INSERT INTO gs_an_table
(name,email,naiyo,indate)
VALUES
('デンゼルワシントン','test3@test.jp','メモ2',sysdate())

SELECT name,email FROM gs_an_table

SELECT COUNT(*) FROM gs_an_table 
-- データの個数を数える

SELECT * FROM gs_an_table WHERE name='織田信長'

SELECT * FROM gs_an_table WHERE id>=1 AND id<=3

-- 条件をつけたい時は必ずWHEREがつく

SELECT * FROM gs_an_table WHERE name LIKE '%1%'
-- %は曖昧部分を指す。↑だと、前後についているので、名前のどこかに１が入っているもの、という意味

SELECT * FROM gs_an_table ORDER BY indate DESC LIMIT 3;
-- DESCは数字の大きい順、ということ

