# EBD

## A4:

### 4.1 Class Diagram

> The following figure contains the representation of our project in a UML presentation. It shows the main objects, it's atributes and the associations that makes the program we have in mind work.

![](https://i.imgur.com/ChD08zJ.jpg)
<center> Figure 1 - UML diagram of ProteinGram </center>

### 4.2 Additional Business Rules

>BR01 - A post and a comment can only identify at most 5 users.
>BR02 - A user can only like once a comment or post


## A5: 

### 5.1 Relational Schema

| Table | |
| --  | --|
| R01 | account(__id__, email UK NN, password_hash NN) |
| R02 | users(__id__->account, name NN, birthday, profile_picture->image, is_private_profile NN ) |
|R03| message(idsender->account, idreceiver->account, __id__ , text, datetime NN)|
|R04| moderator(__id__->account)|
|R05| administrator(__id__->account)|
|R06| relationship(__id1__->account, __id2__->account, friends, user1_block, user2_block)|
|R07| friend_request(__id1__->account, __id2__->account, datetime NN)
|R08| groups(__id__, name NN, creationdate, group_profile_picture->image, is_private_group)|
|R09| groupmember(__idgroup__->group, __iduser__->account)|
|R10| groupowner(__idgroup__->group, __idowner__->account)|
|R11| post(__id__, idposter->account FK NN, idgroup->group FK, message, datetime NN)|
|R12| like_post(__idpost__->post, __iduser__->account, type)|
|R13| like_comment(__idcomment__->comment, __iduser__->account)|
|R14| comment(__id__, iduser->account FK NN, reply_to->comment FK, message, datetime)|
|R15| comment_tag(__idcomment__->comment, __iduser__->account)|
|R16| notification(__id__, iduser->account FK NN, datetime, [delivered/read ?])
|R17| notification_comment(__idnotification__->notification, idcomment->comment FK NN)
|R18| notification_like_post(__idnotification__->notification, idpost->post FK NN, iduser->account FK NN)
|R19| notification_like_comment(__idnotification__->notification, idcomment->comment FK NN, iduser->account FK NN)
|R20| notification_post(__idnotification__->notification, idpost->post FK NN)
|R21| image(__id__, imageblob)|

### 5.2 Domains

>The next table specifies all the domains we cover in our project

| Domain's Name | Specifications            |
| ------------- | ------------------------- |
| Like's Type   | ENUM(BUMP_FIST,LIKE, FLEXING,WEIGHTS, EGG) |
| now()        | DATE DEFAULT CURRENT_DATE |


### 5.3 Schema Validation

>The following tables specify on each relation's keys, functional dependencies and form. 

| Table R01 (account) |
| ------------------- |
| __Keys:__ {id} {email}  |
| __Functional Dependencies__|
| FD0101 => {id} ->{email, password_hash}|
| FD0102 => {email} ->{id, password_hash}|
| __Normal Form__ -> BCNF|

| Table R02 (user) |
| ------------------- |
| __Keys:__ {id}   |
| __Functional Dependencies__|
| FD0201 => {id} ->{name, birthday, profile_picture, is_private_profile}|
| __Normal Form__ -> BCNF|

| Table R03 (message) |
| ------------------- |
| __Keys:__ {id} |
| __Functional Dependencies__|
| FD0301 => {id} ->{idsender,idreceiver, text, datetime}|
| __Normal Form__ -> BCNF|

| Table R04 (moderator) |
| ------------------- |
| __Keys:__ {id} |
| __Functional Dependencies__|
| None|
| __Normal Form__ -> BCNF|

| Table R05 (administrator) |
| ------------------- |
| __Keys:__ {id}  |
| __Functional Dependencies__|
| None|
| __Normal Form__ -> BCNF|

| Table R06 (relationship) |
| ------------------- |
| __Keys:__ {id1, id2}|
| __Functional Dependencies__|
| FD0601 => {id1,id2} ->{friends, usr1_block, usr2_block}|
| __Normal Form__ -> BCNF|

| Table R07 (friend_request) |
| ------------------- |
| __Keys:__ {id1,id2}  |
| __Functional Dependencies__|
| FD0701 => {id1,id2} ->{datetime}|
| __Normal Form__ -> BCNF|

| Table R08 (group) |
| ------------------- |
| __Keys:__ {id}  |
| __Functional Dependencies__|
| FD0801 => {id} ->{ name, creationdate, group_profile_picture, is_private_group}|
| __Normal Form__ -> BCNF|

| Table R09 (groupmember) |
| ------------------- |
| __Keys:__ {idgroup, iduser}  |
| __Functional Dependencies__|
|None|
| __Normal Form__ -> BCNF|

| Table R10 (groupowner) |
| ------------------- |
| __Keys:__ {idgroup, idownerr}  |
| __Functional Dependencies__|
|None|
| __Normal Form__ -> BCNF|

|Table R11 (post)|
|-------------------|
| __Keys:__ {id}|
| __Function Dependencies__|
| FD1101 => {id} -> {idpost, idgroup, message, datetime}|
|__Normal Form__ -> BCNF|

|Table R12 (like_post)|
|-------------------|
| __Keys:__ {idpost, iduser}|
| __Function Dependencies__|
| FD1201 => {idpost, iduser} -> {type}|
|__Normal Form__ -> BCNF|

|Table R13 (like_comment)|
|-------------------|
| __Keys:__ {idpost, iduser}|
| __Function Dependencies__|
| FD1301 => {idcomment, iduser} -> {type}|
|__Normal Form__ -> BCNF|

|Table R14 (comment)|
|-------------------|
| __Keys:__ {id}|
| __Function Dependencies__|
| FD1401 => {id} -> {iduser, reply_to, message, datetime}|
|__Normal Form__ -> BCNF|

|Table R15 (comment_tag)|
|-------------------|
| __Keys:__ {idcomment, iduser}|
| __Function Dependencies__|
| None|
|__Normal Form__ -> BCNF|

|Table R16 (notification)|
|-------------------|
| __Keys:__ {id}|
| __Function Dependencies__|
| FD1601 => {id} -> { iduser, datetime}|
|__Normal Form__ -> BCNF|

|Table R17 (notification_comment)|
|-------------------|
| __Keys:__ {idnotification}|
| __Function Dependencies__|
| FD1701 => {idnotification} -> {idcomment}|
|__Normal Form__ -> BCNF|

|Table R18 (notification_like_post)|
|-------------------|
| __Keys:__ {idnotification}|
| __Function Dependencies__|
| FD1801 => {idnotification} -> {idpost, iduser}|
|__Normal Form__ -> BCNF|

|Table R19 (notification_like_comment)|
|-------------------|
| __Keys:__ {idnotification}|
| __Function Dependencies__|
| FD1901 => {idnotification} -> {idcomment, iduser}|
|__Normal Form__ -> BCNF|

|Table R20 (notification_post)|
|-------------------|
| __Keys:__ {idnotification}|
| __Function Dependencies__|
| FD2001 => {idnotification} -> {idpost}|
|__Normal Form__ -> BCNF|

|Table R21 (image)|
|-------------------|
| __Keys:__ {id}|
| __Function Dependencies__|
| FD2101 => {id} -> {image_blob}|
|__Normal Form__ -> BCNF|

## A6

### 6.1 Database Workload



| Relation | Relation Name| Order of Magnitude | Estimated Growth |
| -------- | -------- | -------- | -------- |
| R01     | account    | 10k (tens of thousands)     | 10 (tens)/day |
| R02     | user     | 10k (tens of thousands)     | 10 (tens)/day |
| R03     | message     | 1M (millions)     | 100k (hundreds of thousands)/day |
| R04     | moderator     | 100 (hundreds)     | 1/month |
| R05     | administrator     | 10 (tens)     | 1/year |
| R06     | relationship     | 1M (millions)     | 1k (thousands)/day |
| R08     | group     | 100 (hundreds)  | 1/day |
| R09     | groupmember     | 10 (tens)     | 1/week |
| R10     | groupowner     | 1     | 1/month |
| R11     | post     | 100k (hundreds of thousands)     | 1k (thousands)/day |
| R12     | like_post     | 100    | 10 |
| R13     | like_comment     | 100     | 10 |
| R14     | comment     |  1k  | 100|
| R15     | comment_tag     | 10    | 1 |
| R16     | notification     | 10k     | 10 |
| R17     | notification_comment     | 1k    | 100 |
| R18     | notification_like_post     | 1k     | 100 |
| R19     | notification_like_comment     | 1k    | 100 |
| R20     | notification_post     | 1k     | 100 |
| R21     | image     | 10k    | 1k |



### 6.2 Proposed Indexes

#### Performance Indexes

| Category | Value |
| -------- | ------|
| Index | IDX01 |
| Index relation | groupmembers |
| Index atributes | idgroup |
| Index type | Hash |
| Cardinality | Medium |
| Clustering | No |
| Justification | The query that gets the members of a group is executed many times so it should be fast. It does not need range support , ID's are matched by equality so hash type seems to be the better suited. Since people will often join and leave groups update frequency is expected to be reasonable so no clustering will be done. |

**SQL CODE:**
```
CREATE INDEX group_members_idx ON groupmember USING hash (idgroup);
```

| Category | Value |
| -------- | ------|
| Index | IDX02 |
| Index relation | post |
| Index atributes | idposter |
| Index type | B-tree |
| Cardinality | Medium |
| Clustering | Yes |
| Justification | The query that gets the posts of a user is executed many times so it should be fast. It does not need range support , ID's are matched by equality , however , hash type wont be used because we want to cluster based on idposter. |
**SQL CODE:**
```
CREATE INDEX user_post ON post USING btree (idposter);
CLUSTER poster USING user_post;
```

| Category | Value |
| -------- | ------|
| Index | IDX03 |
| Index relation | notifications |
| Index atributes | iduser |
| Index type | B-tree |
| Cardinality | Medium |
| Clustering | Yes |
| Justification | The query that gets the notifications of a user is executed many times so it should be fast. It does not need range support , ID's are matched by equality , however , hash type wont be used because we want to cluster based on iduser. |
**SQL CODE:**
```
CREATE INDEX user_notifications ON notifications USING btree (iduser);
CLUSTER notifications USING user_notifications;
```

#### Full-text Search Indexes
| Category | Value |
| -------- | ------|
| Index | IDX00 |
| Index realation | group |
| Index atributes | name |
| Index type | GIN |
| Cardinality | Medium |
| Clustering | No |
| Justification | To improve the performance of full-text searches while searching for groups by name. We are not using index type GiST because group names are not expected to change very often , so we decided to use GIN index type. |

**SQL CODE:**
```
ALTER TABLE user ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION group_search_update() RETURNS TRIGGER AS $$
BEGIN
  IF TG_OP = 'INSERT' THEN
    NEW.tsvectors = (
      setweight(to_tsvector('simple', NEW.name), 'A')
    );
  END IF;
  IF TG_OP = 'UPDATE' THEN
      IF (NEW.name <> OLD.name) THEN
        NEW.tsvectors = (
          setweight(to_tsvector('simple', NEW.name), 'A')
        );
      END IF;
  END IF;
  RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER group_search_update
  BEFORE INSERT OR UPDATE ON group
  FOR EACH ROW
  EXECUTE PROCEDURE group_search_update();

CREATE INDEX search_group_idx ON group USING GIN (tsvectors);
```

<br>

### 6.3 Triggers


| Trigger -> TRIGGER01 | 
| -------- | 
| __Description__ -> An user can only like a post/comment once|
 
 __SQL Code__ :
 
```
CREATE FUNCTION like_post_dup() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM like_post WHERE NEW.idpost = idpost AND NEW.iduser = iduser) THEN
        RAISE EXCEPTION 'Cannot like a post more than once.';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql

CREATE TRIGGER like_post_dup()
    BEFORE INSERT OR UPDATE ON like_post
    FOR EACH ROW
    EXECUTE PROCEDURE like_post_dup(); 
```

* Note: This trigger is only for posts. There is a similar one that works for comments
<br>

| Trigger -> TRIGGER02 | 
| -------- | 
| __Description__ -> User receives the notifications noticing his post has received a like|

 __SQL Code__ :
```
CREATE FUNCTION add_like_post_notification() RETURNS TRIGGER AS
$BODY

    INSERT INTO notifications VALUES(
    SELECT post.idposter FROM post JOIN like_post ON post.id = like_post.idpos
    WHERE post.idpost = NEW.idpost;);

    INSERT INTO notification_like_post VALUES (SELECT MAX(id) FROM notifications,
    NEW.idpost, NEW.iduser);

$BODY
LANGUAGE plpgsql;

CREATE TRIGGER add_like_post_notification
    AFTER INSERT ON like_post
    EXECUTE PROCEDURE add_like_post_notification();
```

* Note: This trigger is only for liking posts, but there will be one for each notification type. 
 <br>


| Trigger -> TRIGGER03 | 
| -------- | 
| __Description__ -> Accepting friend requests|

```
CREATE FUNCTION befriending() RETURNS TRIGGER AS
$BODY
BEGIN
    IF EXISTS(SELECT * FROM friend_request WHERE NEW.id1 = id2 AND NEW.id2 = id1) 
    THEN
        INSERT INTO relationship VALUES (NEW.id1, NEW.id2, TRUE, FALSE, FALSE);
        DELETE FROM friend_request WHERE id1 = NEW.id2 AND id2 = NEW.id1;
        DELETE FROM friend_request WHERE id1 = NEW.id1 AND id2 = NEW.id2;
    END IF;
    RETURN NEW;


$BODY
LANGUAGE plpgsql;

CREATE befriending
    AFTER INSERT friend_request
    FOR EACH ROW
    EXECUTE PROCEDURE befriending();
```
<br>

### 6.4 Transactions



| Transaction | TRANS01| 
| -------- | -------- | 
| __Description__    | Get certain group member's list (owners are there too) |
| __Justification__ | The insertion of new rowns in the group members can occur, which can change the information retrived in the selects. The isolation level is READ ONLY since we are only reading the status.|
|__Isolation Level__| SERIALIZABLE READ ONLY|

__SQL Code:__
```
BEGIN TRANSACTION

SET TRANSACTION ISOLATION LEVEL SERIALIZABLE READ ONLY;

--Quantity of members
SELECT COUNT(*)
FROM 
    (
    SELECT iduser FROM groupmember WHERE idgroup = $idgroup
    UNION
    SELECT iduser FROM groupmember WHERE idgroup = $idgroup;
    );

--All users that interact with the group
SELECT groupmember.iduser, name FROM groupmember INNER JOIN users ON groupmember.iduser = users.id 
WHERE groupmember.idgroup = $idgroup
UNION
SELECT groupowner.iduser, name FROM groupmember INNER JOIN users ON groupmember.iduser = users.id 
WHERE groupowner.idgroup = $idgroup;

END TRANSACTION;
```

<br>

| Transaction | TRANS02| 
| -------- | -------- | 
| __Description__    | Create new group |
| __Justification__ | For us to maintain a solid and consistent database, we need to ensure the creation of a new group comes with no errors or mistakes. If it happens, a ROLBACK is issued. The isolation level is Repeatable-Read because a change to the group id could happen due to an insert in such table, and wrong data could be stored. |
|__Isolation Level__| REPEATABLE READ|

__SQL Code:__
```
BEGIN TRANSACTION

SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;

--Insert group
INSERT INTO groups (names, creationdate, group_profile_picture,is_private_group)
    VALUES ($names, $creationdate, $group_profile_picture, $is_private_group);

--Insert groupOwner
INSERT INTO groupOwner (idgroup, iduser)
    VALUES (currval ('groups_id_seq'), $iduser );

END TRANSACTION;
```
<br>

| Transaction | TRANS03| 
| -------- | -------- | 
| __Description__    | Get photos of user|
| __Justification__ | The insertion of new rowns in the user can occur, which can change the information retrived in the selects. The isolation level is READ ONLY since we are only reading the status.|
|__Isolation Level__| SERIALIZABLE READ ONLY|

__SQL Code:__
```
BEGIN TRANSACTION

SET TRANSACTION ISOLATION LEVEL SERIALIZABLE READ ONLY;

SELECT images.imageblob
FROM users INNER JOIN images
ON users.profile_picture = images.id
WHERE user.name = $username;

END TRANSACTION;
```


## ANNEX A.1 - Complete SQL code
```
--Drop old schema


DROP TABLE IF EXISTS messages CASCADE;
DROP TABLE IF EXISTS moderator CASCADE;
DROP TABLE IF EXISTS administrator CASCADE;
DROP TABLE IF EXISTS relationship CASCADE;
DROP TABLE IF EXISTS friend_request CASCADE;
DROP TABLE IF EXISTS groupmember CASCADE;
DROP TABLE IF EXISTS groupowner CASCADE;
DROP TABLE IF EXISTS like_post CASCADE;
DROP TABLE IF EXISTS like_comment CASCADE;
DROP TABLE IF EXISTS comment_tag CASCADE;
DROP TABLE IF EXISTS notifications CASCADE;
DROP TABLE IF EXISTS notification_like_post CASCADE;
DROP TABLE IF EXISTS notification_like_comment CASCADE;
DROP TABLE IF EXISTS notification_comment CASCADE;
DROP TABLE IF EXISTS notification_post CASCADE;
DROP TABLE IF EXISTS comment CASCADE;
DROP TABLE IF EXISTS images CASCADE;
DROP TABLE IF EXISTS groups CASCADE;
DROP TABLE IF EXISTS post CASCADE;
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS account CASCADE;
DROP TYPE IF EXISTS like_type CASCADE;

DROP FUNCTION IF EXISTS group_search_update CASCADE;
DROP FUNCTION IF EXISTS like_post_dup CASCADE;
DROP FUNCTION IF EXISTS add_like_post_notification CASCADE;
DROP FUNCTION IF EXISTS befriending CASCADE;
--Types:

CREATE TYPE like_type AS ENUM ('BUMP_FIST', 'LIKE', 'FLEXING', 'WEIGHTS', 'EGG');

--Tables:

CREATE TABLE account(
    id SERIAL PRIMARY KEY,
    password_hash TEXT NOT NULL 
);


CREATE TABLE images(
    id SERIAL PRIMARY KEY,
    imageblob TEXT NOT NULL
);

CREATE TABLE users(
    id INTEGER REFERENCES account (id) PRIMARY KEY,
    name TEXT NOT NULL,
    birthday TIMESTAMP WITH TIME ZONE,
    profile_picture INTEGER REFERENCES images(id) ON UPDATE CASCADE,
    is_private_profile BOOLEAN NOT NULL
);


CREATE TABLE messages(
    id SERIAL PRIMARY KEY,
    idsender INTEGER REFERENCES account(id) ON UPDATE CASCADE ,
    idreceiver INTEGER REFERENCES account(id) ON UPDATE CASCADE ,
    texts TEXT NOT NULL,
    dates TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);

CREATE TABLE moderator(
    id INTEGER REFERENCES account(id) ON UPDATE CASCADE PRIMARY KEY
);


CREATE TABLE administrator(
    id INTEGER REFERENCES account(id) ON UPDATE CASCADE PRIMARY KEY
);

CREATE TABLE relationship(
    id1 INTEGER REFERENCES account(id) ON UPDATE CASCADE ,
    id2 INTEGER REFERENCES account(id) ON UPDATE CASCADE ,
    friends BOOLEAN,
    user1_block BOOLEAN,
    user2_block BOOLEAN,
	PRIMARY KEY (id1 , id2)
);

CREATE TABLE friend_request( 
    id1 INTEGER REFERENCES account(id) ON UPDATE CASCADE ,
    id2 INTEGER REFERENCES account(id)ON UPDATE CASCADE ,
	PRIMARY KEY (id1 , id2)
);

CREATE TABLE groups(
    id SERIAL PRIMARY KEY,
    names TEXT NOT NULL,
    creationdate TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    group_profile_picture INTEGER REFERENCES images(id) ON UPDATE CASCADE,
    is_private_group BOOLEAN
);

CREATE TABLE groupmember(
    idgroup INTEGER REFERENCES groups(id) ON UPDATE CASCADE ,
    iduser INTEGER REFERENCES account(id) ON UPDATE CASCADE ,
	PRIMARY KEY (idgroup , iduser)
);

CREATE TABLE groupowner(
    idgroup INTEGER REFERENCES groups(id) ON UPDATE CASCADE ,
    iduser INTEGER REFERENCES account(id) ON UPDATE CASCADE ,
	PRIMARY KEY ( idgroup , iduser)
);

CREATE TABLE post(
    id SERIAL PRIMARY KEY,
    idposter INTEGER REFERENCES account(id) ON UPDATE CASCADE NOT NULL,
    idgroup INTEGER  REFERENCES groups(id),
    messages TEXT NOT NULL,
    dates TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);

CREATE TABLE comment(
    id SERIAL PRIMARY KEY,
    iduser INTEGER REFERENCES account(id) ON UPDATE CASCADE NOT NULL,
    idpost INTEGER REFERENCES post(id) ON UPDATE CASCADE NOT NULL,
    reply_to INTEGER REFERENCES comment(id) ON UPDATE CASCADE,
    messages TEXT NOT NULL,
    dates TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);


CREATE TABLE like_post(
    idpost INTEGER REFERENCES post(id) ON UPDATE CASCADE ,
    iduser INTEGER REFERENCES account(id) ON UPDATE CASCADE ,
    TYPE like_type NOT NULL,
	PRIMARY KEY ( idpost , iduser)
);

CREATE TABLE like_comment(
    idcomment INTEGER REFERENCES comment(id) ON UPDATE CASCADE ,
    iduser INTEGER REFERENCES account(id) ON UPDATE CASCADE ,
    TYPE like_type NOT NULL,
	PRIMARY KEY ( idcomment , iduser)
);

CREATE TABLE comment_tag(
    idcomment INTEGER REFERENCES comment(id) ON UPDATE CASCADE ,
    iduser INTEGER REFERENCES account(id) ON UPDATE CASCADE ,
	PRIMARY KEY ( idcomment , iduser)
);

CREATE TABLE notifications(
    id SERIAL PRIMARY KEY,
    iduser INTEGER REFERENCES account(id) ON UPDATE CASCADE NOT NULL,
    dates TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);

CREATE TABLE notification_comment(
    idnotification INTEGER REFERENCES notifications(id) ON UPDATE CASCADE PRIMARY KEY,
    idcomment INTEGER REFERENCES comment(id) ON UPDATE CASCADE NOT NULL
);

CREATE TABLE notification_like_post(
    idnotification INTEGER REFERENCES notifications(id) ON UPDATE CASCADE PRIMARY KEY,
    idpost INTEGER REFERENCES post(id) ON UPDATE CASCADE NOT NULL,
    iduser INTEGER REFERENCES account(id) ON UPDATE CASCADE NOT NULL
);

CREATE TABLE notification_like_comment(
    idnotification INTEGER REFERENCES notifications(id) ON UPDATE CASCADE PRIMARY KEY,
    idpost INTEGER REFERENCES comment(id) ON UPDATE CASCADE NOT NULL,
    iduser INTEGER REFERENCES account(id) ON UPDATE CASCADE NOT NULL
);

CREATE TABLE notification_post(
    idnotification INTEGER REFERENCES notifications(id) ON UPDATE CASCADE PRIMARY KEY,
    idpost INTEGER REFERENCES post(id) ON UPDATE CASCADE NOT NULL
);



-- Indexes

CREATE INDEX user_post ON post USING btree (idposter);
CLUSTER post USING user_post;

CREATE INDEX group_members_idx ON groupmember USING hash (idgroup);

CREATE INDEX user_notifications ON notifications USING btree (iduser);
CLUSTER notifications USING user_notifications;

ALTER TABLE groups ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION group_search_update() RETURNS TRIGGER AS $$
BEGIN
  IF TG_OP = 'INSERT' THEN
    NEW.tsvectors = (
      setweight(to_tsvector('simple', NEW.name), 'A')
    );
  END IF;
  IF TG_OP = 'UPDATE' THEN
      IF (NEW.name <> OLD.name) THEN
        NEW.tsvectors = (
          setweight(to_tsvector('simple', NEW.name), 'A')
        );
      END IF;
  END IF;
  RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER group_search_update
  BEFORE INSERT OR UPDATE ON groups
  FOR EACH ROW
  EXECUTE PROCEDURE group_search_update();

CREATE INDEX search_group_idx ON groups USING GIN (tsvectors);


------- Triggers

CREATE FUNCTION like_post_dup() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM like_post WHERE NEW.idpost = idpost AND NEW.iduser = iduser) THEN
        RAISE EXCEPTION 'Cannot like a post more than once.';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER like_post_dup
    BEFORE INSERT OR UPDATE ON like_post
    FOR EACH ROW
    EXECUTE PROCEDURE like_post_dup();


CREATE FUNCTION add_like_post_notification() RETURNS TRIGGER AS
$BODY$

BEGIN
    INSERT INTO notifications(iduser)
	SELECT post.idposter FROM post INNER JOIN like_post ON post.id = like_post.idpost
    WHERE post.idpost = NEW.idpost;

    INSERT INTO notification_like_post 
	SELECT MAX(id) FROM notifications,
    NEW.idpost, NEW.iduser;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER add_like_post_notification
    AFTER INSERT ON like_post
    EXECUTE PROCEDURE add_like_post_notification();


CREATE FUNCTION befriending() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS(SELECT * FROM friend_request WHERE NEW.id1 = id2 AND NEW.id2 = id1) 
    THEN
        INSERT INTO relationship VALUES (NEW.id1, NEW.id2, TRUE, FALSE, FALSE);
        DELETE FROM friend_request WHERE id1 = NEW.id2 AND id2 = NEW.id1;
        DELETE FROM friend_request WHERE id1 = NEW.id1 AND id2 = NEW.id2;
    END IF;
    RETURN NEW;

END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER befriending
    AFTER INSERT ON friend_request
    FOR EACH ROW
    EXECUTE PROCEDURE befriending();



```





## ANNEX A.2 - Database Population
```
INSERT INTO account (password_hash) VALUES('cmowvmvwjov');
INSERT INTO account  (password_hash) VALUES('cmowvmvwddv');
INSERT INTO account  (password_hash) VALUES('cmowfcewoev');
INSERT INTO account  (password_hash) VALUES('ecreamvwjov');
INSERT INTO account  (password_hash) VALUES('cqdwcvbwjov');
INSERT INTO account  (password_hash) VALUES('cmoewceejov');
INSERT INTO account  (password_hash) VALUES('cmowaavvjov');



INSERT INTO images (imageblob) VALUES("cscacsacascsc");
INSERT INTO images (imageblob) VALUES("cececsacascsc");
INSERT INTO images (imageblob) VALUES("cscavrebdvr2bcsacascsc");
INSERT INTO images (imageblob) VALUES("cscacsacascscsqwdw");
INSERT INTO images (imageblob) VALUES("cscacsacascswqxsxsc");
INSERT INTO images (imageblob) VALUES("cscacsacascgtrbbtrbsc");


INSERT INTO users (id,name,birthday, profile_picture, is_private_profile) VALUES (1,'maia', 1123112, 2, FALSE);
INSERT INTO users (id,name,birthday, profile_picture, is_private_profile) VALUES (2,'viegas', 1122112, 2, TRUE);
INSERT INTO users (id,name,birthday, profile_picture, is_private_profile) VALUES (3,'pedro', 1113112, 2, TRUE);
INSERT INTO users (id,name,birthday, profile_picture, is_private_profile) VALUES (4,'lara', 1123132, 2, FALSE);

INSERT INTO messages (idsender, idreceiver, texts) VALUES (1 , 2 , 'aei galera');
INSERT INTO messages (idsender, idreceiver, texts) VALUES (2 , 2 , 'moodlçe galera');
INSERT INTO messages (idsender, idreceiver, texts) VALUES (3 , 1 , 'trabalhei muito!');
INSERT INTO messages (idsender, idreceiver, texts) VALUES (1 , 2 , 'gosto de gostos');

INSERT INTO moderator (id) VALUES (5);
INSERT INTO moderator (id) VALUES (6);
INSERT INTO moderator (id) VALUES (7);

INSERT INTO admininstrator (id) VALUES (8);

INSERT INTO relationship(id1, id2, friends, user1_block, user2_block) VALUES (1,2,TRUE, FALSE, FALSE);
INSERT INTO relationship(id1, id2, friends, user1_block, user2_block) VALUES (1,3,TRUE, FALSE, TRUE);

INSERT INTO friend_request(id1,id2) VALUES (4, 1);
INSERT INTO friend_request(id1,id2) VALUES (4, 2);

INSERT INTO groups(names, creationdate, group_profile_picture, is_private_group)
VALUES ('festa da abacate', 122121352, 3, TRUE);
INSERT INTO groups(names, creationdate, group_profile_picture, is_private_group)
VALUES ('legião do ferro', 1221232352, 1, FALSE);
INSERT INTO groups(names, creationdate, group_profile_picture, is_private_group)
VALUES ('chicken leg day', 122121352, 4, TRUE);

INSERT INTO groupmember(idgroup, iduser) VALUES (2,3);
INSERT INTO groupmember(idgroup, iduser) VALUES (1,3);
INSERT INTO groupmember(idgroup, iduser) VALUES (3,3);
INSERT INTO groupmember(idgroup, iduser) VALUES (3,2);
INSERT INTO groupmember(idgroup, iduser) VALUES (1,4);

INSERT INTO groupowner (idgroup,iduser) VALUES (1,2);
INSERT INTO groupowner (idgroup,iduser) VALUES (4,2);
INSERT INTO groupowner (idgroup,iduser) VALUES (2,2);
INSERT INTO groupowner(idgroup, iduser) VALUES (3,1);

INSERT INTO post(idposter, idgroup, messages, dates) VALUES (2,NULL, 'gosto de LBAW',3231);
INSERT INTO post(idposter, idgroup, messages, dates) VALUES (3,3, 'KFC is kool',1231);
INSERT INTO post(idposter, idgroup, messages, dates) VALUES (1,NULL, 'LBAW é fixe',1221);

INSERT INTO comment(iduser, idpost, reply_to, messages, dates)
VALUES (1,2,NULL, 'eieieiei', 134212);
INSERT INTO comment(iduser, idpost, reply_to, messages, dates)
VALUES (2,3,NULL, 'eieiei', 134212);
INSERT INTO comment(iduser, idpost, reply_to, messages, dates)
VALUES (1,2,1, 'ieii', 134212);

INSERT INTO notifications( iduser, dates) VALUES (2,143221);
INSERT INTO notifications( iduser, dates) VALUES (1,143221);
INSERT INTO notifications( iduser, dates) VALUES (3,143221);
INSERT INTO notifications( iduser, dates) VALUES (4,43143221);
```



***
10/11/2021

* Lara Médicis, up201806762@fe.up.pt 
* Diogo Maia, up201904974@fe.up.pt 
* Luís Viegas, up201904979@fe.up.pt
* Pedro Lima, up201605125@fe.up.pt 
