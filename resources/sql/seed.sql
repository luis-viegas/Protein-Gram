DROP SCHEMA IF EXISTS lbaw2141 CASCADE;
CREATE SCHEMA lbaw2141;
/*
DROP TABLE IF EXISTS lbaw2141.messages CASCADE;
DROP TABLE IF EXISTS lbaw2141.moderator CASCADE;
DROP TABLE IF EXISTS lbaw2141.administrator CASCADE;
DROP TABLE IF EXISTS lbaw2141.relationship CASCADE;
DROP TABLE IF EXISTS lbaw2141.friend_request CASCADE;
DROP TABLE IF EXISTS lbaw2141.groupmember CASCADE;
DROP TABLE IF EXISTS lbaw2141.groupowner CASCADE;
DROP TABLE IF EXISTS lbaw2141.like_post CASCADE;
DROP TABLE IF EXISTS lbaw2141.like_comment CASCADE;
DROP TABLE IF EXISTS lbaw2141.comment_tag CASCADE;
DROP TABLE IF EXISTS lbaw2141.notifications CASCADE;
DROP TABLE IF EXISTS lbaw2141.notification_like_post CASCADE;
DROP TABLE IF EXISTS lbaw2141.notification_like_comment CASCADE;
DROP TABLE IF EXISTS lbaw2141.notification_comment CASCADE;
DROP TABLE IF EXISTS lbaw2141.notification_post CASCADE;
DROP TABLE IF EXISTS lbaw2141.comment CASCADE;
DROP TABLE IF EXISTS lbaw2141.images CASCADE;
DROP TABLE IF EXISTS lbaw2141.groups CASCADE;
DROP TABLE IF EXISTS lbaw2141.post CASCADE;
DROP TABLE IF EXISTS lbaw2141.users CASCADE;
DROP TABLE IF EXISTS lbaw2141.account CASCADE;
*/
DROP TYPE IF EXISTS like_type CASCADE;
DROP FUNCTION IF EXISTS group_search_update CASCADE;
DROP FUNCTION IF EXISTS like_post_dup CASCADE;
DROP FUNCTION IF EXISTS add_like_post_notification CASCADE;
DROP FUNCTION IF EXISTS befriending CASCADE;
--Types:

CREATE TYPE like_type AS ENUM ('BUMP_FIST', 'LIKE', 'FLEXING', 'WEIGHTS', 'EGG');

--Tables:

CREATE TABLE lbaw2141.account(
    id SERIAL PRIMARY KEY,
    password_hash TEXT NOT NULL 
);


CREATE TABLE lbaw2141.images(
    id SERIAL PRIMARY KEY,
    imageblob TEXT NOT NULL
);

CREATE TABLE lbaw2141.users(
    id INTEGER REFERENCES account (id) PRIMARY KEY,
    name TEXT NOT NULL,
    birthday TIMESTAMP WITH TIME ZONE,
    profile_picture INTEGER REFERENCES images(id) ON UPDATE CASCADE,
    is_private_profile BOOLEAN NOT NULL
);


CREATE TABLE lbaw2141.messages(
    id SERIAL PRIMARY KEY,
    idsender INTEGER REFERENCES account(id) ON UPDATE CASCADE ,
    idreceiver INTEGER REFERENCES account(id) ON UPDATE CASCADE ,
    texts TEXT NOT NULL,
    dates TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);

CREATE TABLE lbaw2141.moderator(
    id INTEGER REFERENCES account(id) ON UPDATE CASCADE PRIMARY KEY
);


CREATE TABLE lbaw2141.administrator(
    id INTEGER REFERENCES account(id) ON UPDATE CASCADE PRIMARY KEY
);

CREATE TABLE lbaw2141.relationship(
    id1 INTEGER REFERENCES account(id) ON UPDATE CASCADE ,
    id2 INTEGER REFERENCES account(id) ON UPDATE CASCADE ,
    friends BOOLEAN,
    user1_block BOOLEAN,
    user2_block BOOLEAN,
	PRIMARY KEY (id1 , id2)
);

CREATE TABLE lbaw2141.friend_request( 
    id1 INTEGER REFERENCES account(id) ON UPDATE CASCADE ,
    id2 INTEGER REFERENCES account(id)ON UPDATE CASCADE ,
	PRIMARY KEY (id1 , id2)
);

CREATE TABLE lbaw2141.groups(
    id SERIAL PRIMARY KEY,
    names TEXT NOT NULL,
    creationdate TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    group_profile_picture INTEGER REFERENCES images(id) ON UPDATE CASCADE,
    is_private_group BOOLEAN
);

CREATE TABLE lbaw2141.groupmember(
    idgroup INTEGER REFERENCES groups(id) ON UPDATE CASCADE ,
    iduser INTEGER REFERENCES account(id) ON UPDATE CASCADE ,
	PRIMARY KEY (idgroup , iduser)
);

CREATE TABLE lbaw2141.groupowner(
    idgroup INTEGER REFERENCES groups(id) ON UPDATE CASCADE ,
    iduser INTEGER REFERENCES account(id) ON UPDATE CASCADE ,
	PRIMARY KEY ( idgroup , iduser)
);

CREATE TABLE lbaw2141.post(
    id SERIAL PRIMARY KEY,
    idposter INTEGER REFERENCES account(id) ON UPDATE CASCADE NOT NULL,
    idgroup INTEGER  REFERENCES groups(id),
    messages TEXT NOT NULL,
    dates TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);

CREATE TABLE lbaw2141.comment(
    id SERIAL PRIMARY KEY,
    iduser INTEGER REFERENCES account(id) ON UPDATE CASCADE NOT NULL,
    idpost INTEGER REFERENCES post(id) ON UPDATE CASCADE NOT NULL,
    reply_to INTEGER REFERENCES comment(id) ON UPDATE CASCADE,
    messages TEXT NOT NULL,
    dates TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);


CREATE TABLE lbaw2141.like_post(
    idpost INTEGER REFERENCES post(id) ON UPDATE CASCADE ,
    iduser INTEGER REFERENCES account(id) ON UPDATE CASCADE ,
    TYPE like_type NOT NULL,
	PRIMARY KEY ( idpost , iduser)
);

CREATE TABLE lbaw2141.like_comment(
    idcomment INTEGER REFERENCES comment(id) ON UPDATE CASCADE ,
    iduser INTEGER REFERENCES account(id) ON UPDATE CASCADE ,
    TYPE like_type NOT NULL,
	PRIMARY KEY ( idcomment , iduser)
);

CREATE TABLE lbaw2141.comment_tag(
    idcomment INTEGER REFERENCES comment(id) ON UPDATE CASCADE ,
    iduser INTEGER REFERENCES account(id) ON UPDATE CASCADE ,
	PRIMARY KEY ( idcomment , iduser)
);

CREATE TABLE lbaw2141.notifications(
    id SERIAL PRIMARY KEY,
    iduser INTEGER REFERENCES account(id) ON UPDATE CASCADE NOT NULL,
    dates TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);

CREATE TABLE lbaw2141.notification_comment(
    idnotification INTEGER REFERENCES notifications(id) ON UPDATE CASCADE PRIMARY KEY,
    idcomment INTEGER REFERENCES comment(id) ON UPDATE CASCADE NOT NULL
);

CREATE TABLE lbaw2141.notification_like_post(
    idnotification INTEGER REFERENCES notifications(id) ON UPDATE CASCADE PRIMARY KEY,
    idpost INTEGER REFERENCES post(id) ON UPDATE CASCADE NOT NULL,
    iduser INTEGER REFERENCES account(id) ON UPDATE CASCADE NOT NULL
);

CREATE TABLE lbaw2141.notification_like_comment(
    idnotification INTEGER REFERENCES notifications(id) ON UPDATE CASCADE PRIMARY KEY,
    idpost INTEGER REFERENCES comment(id) ON UPDATE CASCADE NOT NULL,
    iduser INTEGER REFERENCES account(id) ON UPDATE CASCADE NOT NULL
);

CREATE TABLE lbaw2141.notification_post(
    idnotification INTEGER REFERENCES notifications(id) ON UPDATE CASCADE PRIMARY KEY,
    idpost INTEGER REFERENCES post(id) ON UPDATE CASCADE NOT NULL
);



-- Indexes

CREATE INDEX user_post ON lbaw2141.post USING btree (idposter);
CLUSTER post USING user_post;

CREATE INDEX groups_with_user_idx ON lbaw2141.groupmember USING btree (iduser);

CREATE INDEX user_notifications ON lbaw2141.notifications USING btree (iduser);
CLUSTER notifications USING user_notifications;

ALTER TABLE lbaw2141.groups ADD COLUMN tsvectors TSVECTOR;

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
  BEFORE INSERT OR UPDATE ON lbaw2141.groups
  FOR EACH ROW
  EXECUTE PROCEDURE group_search_update();

CREATE INDEX search_group_idx ON lbaw2141.groups USING GIN (tsvectors);


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
    BEFORE INSERT OR UPDATE ON lbaw2141.like_post
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


