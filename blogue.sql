CREATE TABLE usager
(
	id int unsigned PRIMARY KEY AUTO_INCREMENT,
	nom varchar(30) NOT NULL,
	motdepasse varchar(255) NOT NULL
	
);

INSERT INTO usager(nom, motdepasse) 
VALUES ("Olga", "$2y$10$93n2XKk5.HG//pdGeAiQRuGpGF7kbzGytRF99y42eDlb6ixH7btQa"),
	("Steve", "$2y$10$5OVDqB9b7IrWKy.B6Eh09.q1xwM9emnWZWPPBKVIJC0dfIEpQkZRW");

ALTER TABLE usager CONVERT to character SET utf8 collate utf8_bin;

CREATE TABLE motcle
(
	id int unsigned PRIMARY KEY AUTO_INCREMENT,
	mot varchar(50) NOT NULL
	
);

INSERT INTO motcle(mot) VALUES
("Lorem"),
("Ipsum"),
("article"),
("nouvelle");

CREATE TABLE article
(
	id int unsigned PRIMARY KEY AUTO_INCREMENT,
	titre varchar(50) NOT NULL,
	contenu text NOT NULL,
    idauteur int unsigned,
    FOREIGN KEY(idauteur) references usager(id)
);


INSERT INTO article(id, titre, contenu, idauteur) VALUES
	(1, "Animal sauvage", "Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression.", 1),
	(2, "LA-la-la", "Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression.", 2 ),
	(3, "Go-go!", "Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression.", 2);


CREATE TABLE motclearticle
(
	idmotcle int unsigned,
	idarticle int unsigned,
	FOREIGN KEY(idarticle) references article(id),
	FOREIGN KEY(idmotcle) references motcle(id),
	PRIMARY KEY (idmotcle, idarticle)
);

INSERT INTO motclearticle VALUES
(2,1),
(3,1),
(1,2),
(4,2),
(3,3),
(1,3),
(2,3),
(2,2);


	