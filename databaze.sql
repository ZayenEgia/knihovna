CREATE DATABASE knihovna COLLATE utf8_czech_ci;

CREATE TABLE knihy (
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	nazev TEXT,
	spisovatel_jmeno TEXT,
	spisovatel_prijmeni TEXT,
	zanr_id INT UNSIGNED,
	popis TEXT,
	umisteni_id INT UNSIGNED);

CREATE TABLE umisteni (
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	misto TEXT)

CREATE TABLE zanr (
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	druh TEXT)

INSERT INTO zanr (id, druh) VALUES
(1, "fantasy"),
(2, "horor"),
(3, "manga"),
(4, "young adult"),
(5, "kuchařka"),
(6, "mytologie"),
(7, "učebnice"),
(8, "krimi"),
(9, "thriller"),
(10, "slovník"),
(11, "cestování"),
(12, "magie"),
(13, "hobby"),
(14, "román"),
(15, "povídky"),
(16, "e-kniha");

INSERT INTO umisteni (id, misto) VALUES
(1, "1. polička"),
(2, "2. polička"),
(3, "3. polička"),
(4, "4. polička"),
(5, "5. polička"),
(6, "skříňka"),
(7, "šuplík"),
(8, "počítač");

