create schema if not exists lbaw2141;

DROP TABLE IF EXISTS lbaw2141.users CASCADE;
DROP TABLE IF EXISTS lbaw2141.posts CASCADE;
DROP TABLE IF EXISTS lbaw2141.cards CASCADE;
DROP TABLE IF EXISTS lbaw2141.items CASCADE;

DROP FUNCTION IF EXISTS users_search_update CASCADE;

CREATE TABLE users (
  id SERIAL PRIMARY KEY,
  name VARCHAR NOT NULL,
  email VARCHAR UNIQUE NOT NULL,
  password VARCHAR NOT NULL,
  birthday TIMESTAMP WITH TIME ZONE DEFAULT now(),
  is_private BOOLEAN DEFAULT FALSE,
  is_admin BOOLEAN DEFAULT FALSE,
  remember_token VARCHAR,
  image VARCHAR DEFAULT 'https://digimedia.web.ua.pt/wp-content/uploads/2017/05/default-user-image.png',
  bio VARCHAR DEFAULT 'Write something about yourself'
);

CREATE TABLE posts (
  id SERIAL PRIMARY KEY,
  user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  text VARCHAR NOT NULL,
  created_at TIMESTAMP WITH TIME ZONE,
  updated_at TIMESTAMP WITH TIME ZONE
);


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


