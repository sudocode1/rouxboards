CREATE DATABASE board;

USE board;

CREATE TABLE posts (
    postId int NOT NULL UNIQUE,
    postTitle text NOT NULL UNIQUE,
    board text NOT NULL,
    userId int NOT NULL,
    likes int,
    postText text NOT NULL
);

CREATE TABLE users (
    userId int NOT NULL UNIQUE,
    descrip text NOT NULL,
    postCount int,
    verified boolean DEFAULT 0 NOT NULL,
    staff boolean DEFAULT 0 NOT NULL,
    ip text NOT NULL UNIQUE,
    suspended boolean DEFAULT 0

);

CREATE TABLE boards (
    boardName text NOT NULL UNIQUE,
    topic text NOT NULL UNIQUE,
    closed boolean DEFAULT 0 NOT NULL,
    posts int DEFAULT 0 NOT NULL,
    restricted boolean DEFAULT 0 NOT NULL,
    nsfw boolean DEFAULT 0 NOT NULL
);

CREATE TABLE comments (
    postId int NOT NULL,
    userId text NOT NULL,
    commentText text NOT NULL,
    commentId int NOT NULL UNIQUE
);