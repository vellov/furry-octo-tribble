
DROP TABLE IF EXISTS Candidates;

CREATE TABLE Candidates (
  id int(11) NOT NULL,
  firstname varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  lastname varchar(100) NOT NULL,
  description longtext CHARACTER SET utf8 COLLATE utf8_estonian_ci NOT NULL,
  votecount int(11) NOT NULL DEFAULT '0',
  election_id int(11) DEFAULT NULL,
  PRIMARY KEY (id)
);

INSERT INTO Candidates VALUES (3,'Malle','Matas','Tulihingeline looduse fann, armastab autosid',69,1);
INSERT INTO Candidates VALUES (4,'Jaana','Lind','Lubab, et muneb 3 muna korraga!',12,1);
INSERT INTO Candidates VALUES (5,'Heli','Kopter','Tema ei oska midagi lubada!',15,1);
INSERT INTO Candidates VALUES (6,'Juhan','Tuha','Ah, mis sa jutustad',12,1);
INSERT INTO Candidates VALUES (7,'Ott','Komp','Kaotame poe moosid',1,1);
INSERT INTO Candidates VALUES (8,'Maisi','Pulgad','Iga kuu uus pulk!',0,1);
DROP TABLE IF EXISTS Elections;

CREATE TABLE Elections (
  id int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  description longtext,
  PRIMARY KEY (id)
);


INSERT INTO Elections VALUES (1,'Parim lubadus 2015','Parima lubaduse valimine aastal 2015');
INSERT INTO Elections VALUES (3,'Mingi valimine','Keegi ei tea, mida siin valitakse');

