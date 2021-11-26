--Types:

CREATE TYPE like_type AS ENUM ('BUMP_FIST', 'LIKE', 'FLEXING', 'WEIGHTS', 'EGG');

--Tables:

CREATE TABLE account(
    id INTEGER PRIMARY KEY,
    password_hash TEXT NOT NULL 
);


CREATE TABLE images(
    id INTEGER PRIMARY KEY,
    imageblob TEXT NOT NULL
);

CREATE TABLE users(
    id INTEGER REFERENCES account (id) PRIMARY KEY,
    name TEXT NOT NULL,
    birthday DATETIME,
    profile_picture INTEGER REFERENCES images(id),
    is_private_profile BOOLEAN NOT NULL
);


CREATE TABLE messages(
    id INTEGER PRIMARY KEY,
    idsender INTEGER REFERENCES account(id) PRIMARY KEY,
    idreceiver INTEGER REFERENCES acount(id) PRIMARY KEY,
    texts TEXT NOT NULL,
    dates DATETIME NOT NULL
);

CREATE TABLE moderator(
    id INTEGER REFERENCES account(id) PRIMARY KEY
);


CREATE TABLE administrator(
    id INTEGER REFERENCES account(id) PRIMARY KEY
);

CREATE TABLE relationship(
    id1 INTEGER REFERENCES account(id) PRIMARY KEY,
    id2 INTEGER REFERENCES account(id) PRIMARY KEY,
    friends BOOLEAN,
    user1_block BOOLEAN,
    user2_block BOOLEAN
);

CREATE TABLE friend_request( 
    id1 INTEGER REFERENCES account(id) PRIMARY KEY,
    id2 INTEGER REFERENCES account(id) PRIMARY KEY
);

CREATE TABLE groups(
    id INTEGER REFERENCES account(id) PRIMARY KEY,
    names TEXT NOT NULL,
    creationdate DATETIME,
    group_profile_picture INTEGER REFERENCES image(id),
    is_private_group BOOLEAN
);

CREATE TABLE groupmember(
    idgroup INTEGER REFERENCES groups(id) PRIMARY KEY,
    iduser INTEGER REFERENCES account(id) PRIMARY KEY
);

CREATE TABLE groupowner(
    idgroup INTEGER REFERENCES groups(id) PRIMARY KEY,
    iduser INTEGER REFERENCES account(id) PRIMARY KEY
);

CREATE TABLE post(
    id INTEGER PRIMARY KEY,
    idposter INTEGER REFERENCES account(id) NOT NULL,
    idgroup INTEGER  references groups(id),
    messages TEXT NOT NULL,
    dates DATETIME NOT NULL
);

CREATE TABLE comment(
    id INTEGER PRIMARY KEY,
    iduser INTEGER REFERENCES account(id) NOT NULL,
    reply_to INTEGER REFERENCES comment(id),
    messages TEXT NOT NULL,
    dates DATETIME
);


CREATE TABLE like_post(
    idpost INTEGER REFERENCES post(id) PRIMARY KEY,
    iduser INTEGER REFERENCES account(id) PRIMARY KEY
);

CREATE TABLE like_comment(
    idcomment INTEGER REFERENCES comment(id) PRIMARY KEY,
    iduser INTEGER REFERENCES account(id) PRIMARY KEY
)

CREATE TABLE comment_tag(
    idcomment INTEGER REFERENCES comment(id) PRIMARY KEY,
    iduser INTEGER REFERENCES account(id) PRIMARY KEY
)

CREATE TABLE notifications(
    id INTEGER PRIMARY KEY,
    iduser INTEGER REFERENCES account(id) NOT NULL,
    dates DATETIME
);

CREATE TABLE notification_comment(
    idnotification INTEGER REFERENCES notifications(id) PRIMARY KEY,
    idcomment INTEGER REFERENCES comment(id) NOT NULL
)

CREATE TABLE notification_like_post(
    idnotification INTEGER REFERENCES notifications(id) PRIMARY KEY,
    idpost INTEGER REFERENCES post(id) NOT NULL,
    iduser INTEGER REFERENCES account(id) NOT NULL
)

CREATE TABLE notification_like_comment(
    idnotification INTEGER REFERENCES notifications(id) PRIMARY KEY,
    idpost INTEGER REFERENCES comment(id) NOT NULL,
    iduser INTEGER REFERENCES account(id) NOT NULL
)

CREATE TABLE notification_post(
    idnotification INTEGER REFERENCES notifications(id) PRIMARY KEY,
    idpost INTEGER REFERENCES post(id) NOT NULL
)



