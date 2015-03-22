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

DROP TABLE IF EXISTS Elections;

CREATE TABLE Elections (
  id int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  description longtext,
  PRIMARY KEY (id)
);

CREATE TABLE Users (
  id int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  lastname varchar(100) DEFAULT NULL,
  fbid varchar(100) DEFAULT NULL,
  email varchar(100) DEFAULT NULL,
  role varchar(45) DEFAULT 'user',
  PRIMARY KEY (id),
  UNIQUE KEY fbid_UNIQUE (fbid)
);
