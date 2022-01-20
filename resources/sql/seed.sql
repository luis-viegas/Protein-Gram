DROP SCHEMA IF EXISTS lbaw2141 CASCADE;
CREATE SCHEMA lbaw2141;

DROP TYPE IF EXISTS like_type CASCADE;
DROP FUNCTION IF EXISTS group_search_update CASCADE;
DROP FUNCTION IF EXISTS post_likes_dup CASCADE;
DROP FUNCTION IF EXISTS add_post_like_notification CASCADE;
DROP FUNCTION IF EXISTS befriending CASCADE;
DROP FUNCTION IF EXISTS users_search_update CASCADE;

CREATE TYPE like_type AS ENUM ('BUMP_FIST', 'LIKE', 'FLEXING', 'WEIGHTS', 'EGG');
CREATE TYPE notification_type AS ENUM ('comment', 'post_like','comment_like','comment_tag','message','comment_reply');

CREATE TABLE users (
  id SERIAL PRIMARY KEY,
  name VARCHAR NOT NULL,
  email VARCHAR UNIQUE NOT NULL,
  password VARCHAR NOT NULL,
  birthday TIMESTAMP WITH TIME ZONE DEFAULT now(),
  is_private BOOLEAN DEFAULT FALSE NOT NULL,
  is_admin BOOLEAN DEFAULT FALSE NOT NULL,
  remember_token VARCHAR,
  image VARCHAR DEFAULT 'https://digimedia.web.ua.pt/wp-content/uploads/2017/05/default-user-image.png' NOT NULL,
  bio VARCHAR DEFAULT 'Write something about yourself'
);

CREATE TABLE posts (
  id SERIAL PRIMARY KEY,
  user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
  group_id INTEGER REFERENCES groups(id) ON DELETE CASCADE ON UPDATE CASCADE,
  text VARCHAR NOT NULL,
  created_at TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
  updated_at TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);

CREATE TABLE chats(
  id SERIAL PRIMARY KEY,
  created_at TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
  updated_at TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);


CREATE TABLE chat_user(
  chat_id INTEGER REFERENCES chats(id) ON UPDATE CASCADE ON DELETE CASCADE,
  user_id INTEGER REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
  PRIMARY KEY(chat_id, user_id)
);

CREATE TABLE messages(
  id SERIAL PRIMARY KEY,
  user_id INTEGER REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
  chat_id INTEGER REFERENCES chats(id) ON UPDATE CASCADE ON DELETE CASCADE,
  text TEXT NOT NULL,
  created_at TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
  updated_at TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);

CREATE TABLE relationships(
  id1 INTEGER REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
  id2 INTEGER REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
  friends BOOLEAN NOT NULL,
  blocked1 BOOLEAN DEFAULT FALSE NOT NULL,
  blocked2 BOOLEAN DEFAULT FALSE NOT NULL,
	PRIMARY KEY (id1 , id2),
  CONSTRAINT id_order CHECK (id1 < id2)
);

CREATE TABLE friend_requests( 
  id1 INTEGER REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
  id2 INTEGER REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY (id1 , id2),
  CONSTRAINT id_different CHECK (id1 <> id2)
);

CREATE TABLE groups(
  id SERIAL PRIMARY KEY,
  name TEXT NOT NULL,
  creationdate TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
  --group_profile_picture INTEGER REFERENCES images(id) ON UPDATE CASCADE,
  is_private_group BOOLEAN DEFAULT TRUE NOT NULL
);

CREATE TABLE group_members(
  group_id INTEGER REFERENCES groups(id) ON UPDATE CASCADE ON DELETE CASCADE,
  user_id INTEGER REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
	PRIMARY KEY (group_id , user_id)
);

CREATE TABLE group_owners(
  group_id INTEGER REFERENCES groups(id) ON UPDATE CASCADE ON DELETE CASCADE,
  user_id INTEGER REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
	PRIMARY KEY (group_id , user_id)
);

CREATE TABLE comments(
  id SERIAL PRIMARY KEY,
  user_id INTEGER REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
  post_id INTEGER REFERENCES posts(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
  reply_to INTEGER REFERENCES comments(id) ON UPDATE CASCADE ON DELETE CASCADE,
  message TEXT NOT NULL,
  created_at TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
  updated_at TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);

CREATE TABLE post_likes(
  user_id INTEGER REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
  post_id INTEGER REFERENCES posts(id) ON UPDATE CASCADE ON DELETE CASCADE,
  type like_type NOT NULL,
	PRIMARY KEY (post_id , user_id)
);

CREATE TABLE comment_likes(
  comment_id INTEGER REFERENCES comments(id) ON UPDATE CASCADE ON DELETE CASCADE,
  user_id INTEGER REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
  type like_type NOT NULL,
	PRIMARY KEY ( comment_id , user_id)
);

CREATE TABLE comment_tags(
  comment_id INTEGER REFERENCES comments(id) ON UPDATE CASCADE ON DELETE CASCADE,
  user_id INTEGER REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
	PRIMARY KEY ( comment_id , user_id)
);

CREATE TABLE notifications(
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(id) ON UPDATE CASCADE NOT NULL ON DELETE CASCADE,
    dates TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    type notification_type NOT NULL,
    consumed boolean NOT NULL DEFAULT false
);

CREATE TABLE notifications_comment(
    notification_id INTEGER REFERENCES notifications(id) ON UPDATE CASCADE ON DELETE CASCADE PRIMARY KEY,
    comment_id INTEGER REFERENCES comments(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL
);

CREATE TABLE notifications_post_like(
    notification_id INTEGER REFERENCES notifications(id) ON UPDATE CASCADE PRIMARY KEY,
    post_id INTEGER REFERENCES posts(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
    user_id INTEGER REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL
);

CREATE TABLE notifications_comment_like(
    notification_id INTEGER REFERENCES notifications(id) ON UPDATE CASCADE PRIMARY KEY,
    comment_id INTEGER REFERENCES comments(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL,
    user_id INTEGER REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL
);

CREATE TABLE notifications_comment_tag(
    notification_id INTEGER REFERENCES notifications(id) ON UPDATE CASCADE ON DELETE CASCADE PRIMARY KEY,
    comment_id INTEGER REFERENCES comments(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL
);

CREATE TABLE notifications_comment_reply(
    notification_id INTEGER REFERENCES notifications(id) ON UPDATE CASCADE ON DELETE CASCADE PRIMARY KEY,
    comment_id INTEGER REFERENCES comments(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL
);

CREATE TABLE notifications_message(
    notification_id INTEGER REFERENCES notifications(id) ON UPDATE CASCADE ON DELETE CASCADE PRIMARY KEY,
    message_id INTEGER REFERENCES messages(id) ON UPDATE CASCADE ON DELETE CASCADE NOT NULL
);



-- Indexes

CREATE INDEX user_posts ON posts USING btree (user_id);
CLUSTER posts USING user_posts;

CREATE INDEX groups_with_user_idx ON group_members USING btree (user_id);

CREATE INDEX user_notifications ON notifications USING btree (user_id);
CLUSTER notifications USING user_notifications;












-- Text Search

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

ALTER TABLE users ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION users_search_update() RETURNS TRIGGER AS $$
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

CREATE TRIGGER user_search_update
  BEFORE INSERT OR UPDATE ON users
  FOR EACH ROW
  EXECUTE PROCEDURE users_search_update();

CREATE INDEX users_search_idx ON users USING GIN (tsvectors);


-- Population 

INSERT INTO users VALUES (
  DEFAULT,
  'Luis Viegas',
  'lv@admin.com',
  '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W',
  DEFAULT,
  FALSE,
  TRUE
); -- Password is 1234. Generated using Hash::make('1234')
INSERT INTO users VALUES (
  DEFAULT,
  'Diogo Maia',
  'dm@admin.com',
  '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W',
  DEFAULT,
  FALSE,
  TRUE
); -- Password is 1234. Generated using Hash::make('1234')

/* TODO: 

CREATE TABLE images(
    id SERIAL PRIMARY KEY,
    imageblob TEXT NOT NULL
);
*/