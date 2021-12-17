DROP SCHEMA IF EXISTS lbaw2141 CASCADE;
CREATE SCHEMA lbaw2141;
/*
DROP TABLE IF EXISTS lbaw2141.messages CASCADE;
DROP TABLE IF EXISTS lbaw2141.moderators CASCADE;
DROP TABLE IF EXISTS lbaw2141.administrators CASCADE;
DROP TABLE IF EXISTS lbaw2141.relationships CASCADE;
DROP TABLE IF EXISTS lbaw2141.friend_requests CASCADE;
DROP TABLE IF EXISTS lbaw2141.group_members CASCADE;
DROP TABLE IF EXISTS lbaw2141.group_owners CASCADE;
DROP TABLE IF EXISTS lbaw2141.post_likes CASCADE;
DROP TABLE IF EXISTS lbaw2141.comment_likes CASCADE;
DROP TABLE IF EXISTS lbaw2141.comment_tags CASCADE;
DROP TABLE IF EXISTS lbaw2141.notifications CASCADE;
DROP TABLE IF EXISTS lbaw2141.notifications_post_like CASCADE;
DROP TABLE IF EXISTS lbaw2141.notifications_comment_like CASCADE;
DROP TABLE IF EXISTS lbaw2141.notifications_comment CASCADE;
DROP TABLE IF EXISTS lbaw2141.notifications_post CASCADE;
DROP TABLE IF EXISTS lbaw2141.comments CASCADE;
DROP TABLE IF EXISTS lbaw2141.images CASCADE;
DROP TABLE IF EXISTS lbaw2141.groups CASCADE;
DROP TABLE IF EXISTS lbaw2141.posts CASCADE;
DROP TABLE IF EXISTS lbaw2141.users CASCADE;
DROP TABLE IF EXISTS lbaw2141.accounts CASCADE;
*/
DROP TYPE IF EXISTS like_type CASCADE;
DROP FUNCTION IF EXISTS group_search_update CASCADE;
DROP FUNCTION IF EXISTS post_likes_dup CASCADE;
DROP FUNCTION IF EXISTS add_post_like_notification CASCADE;
DROP FUNCTION IF EXISTS befriending CASCADE;
--Types:

CREATE TYPE like_type AS ENUM ('BUMP_FIST', 'LIKE', 'FLEXING', 'WEIGHTS', 'EGG');

--Tables:

CREATE TABLE lbaw2141.accounts(
    id SERIAL PRIMARY KEY,
    password_hash TEXT NOT NULL -- Binary format?
);


CREATE TABLE lbaw2141.images(
    id SERIAL PRIMARY KEY,
    imageblob TEXT NOT NULL
);

CREATE TABLE lbaw2141.users(
    id INTEGER REFERENCES accounts (id) PRIMARY KEY,
    name TEXT NOT NULL,
    birthday TIMESTAMP WITH TIME ZONE, -- date?
    profile_picture INTEGER REFERENCES images(id) ON UPDATE CASCADE,
    is_private_profile BOOLEAN NOT NULL
);


CREATE TABLE lbaw2141.messages(
    id SERIAL PRIMARY KEY,
    idsender INTEGER REFERENCES accounts(id) ON UPDATE CASCADE ,
    idreceiver INTEGER REFERENCES accounts(id) ON UPDATE CASCADE ,
    messagetext TEXT NOT NULL,
    dates TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);

CREATE TABLE lbaw2141.moderators(
    id INTEGER REFERENCES accounts(id) ON UPDATE CASCADE PRIMARY KEY
);


CREATE TABLE lbaw2141.administrators(
    id INTEGER REFERENCES accounts(id) ON UPDATE CASCADE PRIMARY KEY
);

CREATE TABLE lbaw2141.relationships(
    id1 INTEGER REFERENCES accounts(id) ON UPDATE CASCADE ,
    id2 INTEGER REFERENCES accounts(id) ON UPDATE CASCADE ,
    friends BOOLEAN, -- TODO: trigger to make the id2,id1 entry the same on update.
    blocked BOOLEAN DEFAULT FALSE,
	PRIMARY KEY (id1 , id2)
);

CREATE TABLE lbaw2141.friend_requests( 
    id1 INTEGER REFERENCES accounts(id) ON UPDATE CASCADE ,
    id2 INTEGER REFERENCES accounts(id) ON UPDATE CASCADE ,
	PRIMARY KEY (id1 , id2)
);

CREATE TABLE lbaw2141.groups(
    id SERIAL PRIMARY KEY,
    names TEXT NOT NULL,
    creationdate TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    group_profile_picture INTEGER REFERENCES images(id) ON UPDATE CASCADE,
    is_private_group BOOLEAN
);

CREATE TABLE lbaw2141.group_members(
    idgroup INTEGER REFERENCES groups(id) ON UPDATE CASCADE ,
    iduser INTEGER REFERENCES accounts(id) ON UPDATE CASCADE ,
	PRIMARY KEY (idgroup , iduser)
);

CREATE TABLE lbaw2141.group_owners(
    idgroup INTEGER REFERENCES groups(id) ON UPDATE CASCADE ,
    iduser INTEGER REFERENCES accounts(id) ON UPDATE CASCADE ,
	PRIMARY KEY ( idgroup , iduser)
);

CREATE TABLE lbaw2141.posts(
    id SERIAL PRIMARY KEY,
    idposter INTEGER REFERENCES accounts(id) ON UPDATE CASCADE NOT NULL,
    idgroup INTEGER  REFERENCES groups(id),
    messages TEXT NOT NULL,
    dates TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);

CREATE TABLE lbaw2141.comments(
    id SERIAL PRIMARY KEY,
    iduser INTEGER REFERENCES accounts(id) ON UPDATE CASCADE NOT NULL,
    idpost INTEGER REFERENCES posts(id) ON UPDATE CASCADE NOT NULL,
    reply_to INTEGER REFERENCES comments(id) ON UPDATE CASCADE,
    messages TEXT NOT NULL,
    dates TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);


CREATE TABLE lbaw2141.post_likes(
    idpost INTEGER REFERENCES posts(id) ON UPDATE CASCADE ,
    iduser INTEGER REFERENCES accounts(id) ON UPDATE CASCADE ,
    TYPE like_type NOT NULL,
	PRIMARY KEY ( idpost , iduser)
);

CREATE TABLE lbaw2141.comment_likes(
    idcomment INTEGER REFERENCES comments(id) ON UPDATE CASCADE ,
    iduser INTEGER REFERENCES accounts(id) ON UPDATE CASCADE ,
    TYPE like_type NOT NULL,
	PRIMARY KEY ( idcomment , iduser)
);

CREATE TABLE lbaw2141.comment_tags(
    idcomment INTEGER REFERENCES comments(id) ON UPDATE CASCADE ,
    iduser INTEGER REFERENCES accounts(id) ON UPDATE CASCADE ,
	PRIMARY KEY ( idcomment , iduser)
);

CREATE TABLE lbaw2141.notifications(
    id SERIAL PRIMARY KEY,
    iduser INTEGER REFERENCES accounts(id) ON UPDATE CASCADE NOT NULL,
    dates TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);

CREATE TABLE lbaw2141.notifications_comment(
    idnotification INTEGER REFERENCES notifications(id) ON UPDATE CASCADE PRIMARY KEY,
    idcomment INTEGER REFERENCES comments(id) ON UPDATE CASCADE NOT NULL
);

CREATE TABLE lbaw2141.notifications_post_like(
    idnotification INTEGER REFERENCES notifications(id) ON UPDATE CASCADE PRIMARY KEY,
    idpost INTEGER REFERENCES posts(id) ON UPDATE CASCADE NOT NULL,
    iduser INTEGER REFERENCES accounts(id) ON UPDATE CASCADE NOT NULL
);

CREATE TABLE lbaw2141.notifications_comment_like(
    idnotification INTEGER REFERENCES notifications(id) ON UPDATE CASCADE PRIMARY KEY,
    idcomment INTEGER REFERENCES comments(id) ON UPDATE CASCADE NOT NULL,
    iduser INTEGER REFERENCES accounts(id) ON UPDATE CASCADE NOT NULL
);

CREATE TABLE lbaw2141.notifications_post(
    idnotification INTEGER REFERENCES notifications(id) ON UPDATE CASCADE PRIMARY KEY,
    idpost INTEGER REFERENCES posts(id) ON UPDATE CASCADE NOT NULL
);



-- Indexes

CREATE INDEX user_posts ON lbaw2141.posts USING btree (idposter);
CLUSTER posts USING user_posts;

CREATE INDEX groups_with_user_idx ON lbaw2141.group_members USING btree (iduser);

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

CREATE FUNCTION post_likes_dup() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM post_likes WHERE NEW.idpost = idpost AND NEW.iduser = iduser) THEN
        RAISE EXCEPTION 'Cannot like a post more than once.';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER post_likes_dup
    BEFORE INSERT OR UPDATE ON lbaw2141.post_likes
    FOR EACH ROW
    EXECUTE PROCEDURE post_likes_dup();


CREATE FUNCTION add_post_like_notification() RETURNS TRIGGER AS
$BODY$

BEGIN
    INSERT INTO notifications(iduser)
	SELECT posts.idposter FROM posts INNER JOIN post_likes ON posts.id = post_likes.idpost
    WHERE posts.idpost = NEW.idpost;

    INSERT INTO notifications_post_like 
	SELECT MAX(id) FROM notifications,
    NEW.idpost, NEW.iduser;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER add_post_like_notification
    AFTER INSERT ON post_likes
    EXECUTE PROCEDURE add_post_like_notification();


CREATE FUNCTION befriending() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS(SELECT * FROM friend_requests WHERE NEW.id1 = id2 AND NEW.id2 = id1) 
    THEN
        INSERT INTO relationships VALUES (NEW.id1, NEW.id2, TRUE, FALSE, FALSE);
        DELETE FROM friend_requests WHERE id1 = NEW.id2 AND id2 = NEW.id1;
        DELETE FROM friend_requests WHERE id1 = NEW.id1 AND id2 = NEW.id2;
    END IF;
    RETURN NEW;

END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER befriending
    AFTER INSERT ON friend_requests
    FOR EACH ROW
    EXECUTE PROCEDURE befriending();


