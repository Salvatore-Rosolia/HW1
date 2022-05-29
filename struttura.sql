

CREATE DATABASE sociale;

use sociale;

CREATE TABLE profilo (
id integer primary key auto_increment,
username VARCHAR(16) not null UNIQUE,
password varchar(255) not null,
email varchar(255) not null,
nome varchar(255) not null,
cognome varchar(255) not null,
image VARCHAR(255),
time timestamp not null default CURRENT_TIMESTAMP,
nposts integer default 0)  Engine = InnoDB;


CREATE TABLE posts (
    id integer primary key auto_increment,
    user integer not null,
    time timestamp not null default current_timestamp,
    nlikes integer default 0,
    ncomments integer default 0,
    items json,
    foreign key(user) references profilo(id) on delete cascade on update cascade
) Engine = InnoDB;

CREATE TABLE likes (
    user integer not null,
    post integer not null,
    index xuser(user),
    index xpost(post),
    foreign key(user) references profilo(id) on delete cascade on update cascade,
    foreign key(post) references posts(id) on delete cascade on update cascade,
    primary key(user, post)
) Engine = InnoDB;

CREATE TABLE comments (
    id integer primary key auto_increment,
    user integer not null,
    post integer not null,
    time timestamp not null default current_timestamp,
    text varchar(255),
    index xuser(user),
    index xpost(post),
    foreign key(user) references profilo(id) on delete cascade on update cascade,
    foreign key(post) references posts(id) on delete cascade on update cascade
) Engine = InnoDB;


create TABLE chats (
id integer PRIMARY key auto_increment, 
user1 integer not null,
user2 integer not null, 
index xxuser(user1),
index xxxuser(user2),
foreign key(user1) references profilo(id) on delete cascade on update cascade,
foreign key(user2) references profilo(id) on delete cascade on update cascade
) Engine = InnoDB;

create table messages (
id integer primary key auto_increment, 
idchat integer not null, 
iduser integer not null, 
time timestamp not null default CURRENT_TIMESTAMP,
text varchar(255),
foreign key(idchat) references chats(id) on delete cascade on update cascade,
foreign key(iduser) references profilo(id) on delete cascade on update cascade
) Engine = InnoDB;




DELIMITER //
CREATE TRIGGER likes_trigger
AFTER INSERT ON likes
FOR EACH ROW
BEGIN
UPDATE posts 
SET nlikes = nlikes + 1
WHERE id = new.post;
END //
DELIMITER ;


DELIMITER //
CREATE TRIGGER unlikes_trigger
AFTER DELETE ON likes
FOR EACH ROW
BEGIN
UPDATE posts 
SET nlikes = nlikes - 1
WHERE id = old.post;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER comments_trigger
AFTER INSERT ON comments
FOR EACH ROW
BEGIN
UPDATE posts 
SET ncomments = ncomments + 1
WHERE id = new.post;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER uncomments_trigger
AFTER DELETE ON comments
FOR EACH ROW
BEGIN
UPDATE posts 
SET ncomments = ncomments - 1
WHERE id = old.post;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER posts_trigger
AFTER INSERT ON posts
FOR EACH ROW
BEGIN
UPDATE profilo 
SET nposts = nposts + 1
WHERE id = new.user;
END //
DELIMITER ;


