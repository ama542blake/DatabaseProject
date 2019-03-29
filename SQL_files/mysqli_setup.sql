/* this VIEW syntax is not for MySQL but phpMyAdmin
CREATE VIEW view_artist_album_song AS
SELECT `artist_album`.`artist_id`, `artist`.`artist_name`, `artist_album`.`album_id`, `album`.`album_name`, `album_song`.`song_id`, `song`.`song_name`, `album_song`.`song_track_number` FROM `artist_album`
JOIN `album_song` ON `artist_album`.`album_id` = `album_song`.`album_id`
JOIN `artist` ON `artist_album`.`artist_id` = `artist`.`artist_id`
JOIN `album` ON `artist_album`.`album_id` = `album`.`album_id`
JOIN `song` ON `album_song`.`song_id` = `song`.`song_id`
ORDER BY `album_song`.`song_track_number` */

CREATE DATABASE music_site;
USE music_site;

CREATE TABLE user (
	user_id SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	user_username VARCHAR(25) NOT NULL UNIQUE,
	user_email VARCHAR(100) NOT NULL UNIQUE,
	user_pword VARCHAR(30) NOT NULL,
	user_is_admin TINYINT(1) DEFAULT 0
);

-- need to update this in phpMyAdmin
CREATE TABLE artist (
	artist_id SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	artist_name VARCHAR(75) NOT NULL,
	artist_is_band TINYINT(1),
	artist_update_user SMALLINT UNSIGNED,
	artist_update_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(artist_update_user) REFERENCES user(user_id) ON DELETE CASCADE
);

CREATE TABLE artwork_artist (
	artwork_artist_id SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	artwork_artist_name VARCHAR(75) NOT NULL UNIQUE
);

-- need to update this in phpMyAdmin
CREATE TABLE album (
	album_id SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	album_name VARCHAR(75) NOT NULL,
    album_released_year YEAR(4),
	album_artwork_artist SMALLINT UNSIGNED,
    album_update_user SMALLINT UNSIGNED,
	album_update_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY(album_artwork_artist) REFERENCES artwork_artist(artwork_artist_id) ON DELETE CASCADE,
    FOREIGN KEY(album_update_user) REFERENCES user(user_id) ON DELETE CASCADE

);

CREATE TABLE producer (
	producer_id SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	producer_name VARCHAR(75) NOT NULL UNIQUE
);

CREATE TABLE genre (
	genre_id SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	genre_name VARCHAR(30) NOT NULL UNIQUE
);

-- need to update this in phpMyAdmin
CREATE TABLE song (
	song_id SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	song_name VARCHAR(75) NOT NULL,
	song_genre SMALLINT UNSIGNED,
	song_producer SMALLINT UNSIGNED,
    song_update_user SMALLINT UNSIGNED,
	song_update_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY(song_genre) REFERENCES genre(genre_id) ON DELETE CASCADE,
	FOREIGN KEY(song_producer) REFERENCES producer(producer_id) ON DELETE CASCADE,
    FOREIGN KEY(song_update_user) REFERENCES user(user_id) ON DELETE CASCADE
);

CREATE TABLE artist_album (
	artist_id SMALLINT UNSIGNED,
	album_id SMALLINT UNSIGNED,
	PRIMARY KEY(artist_id, album_id),
	FOREIGN KEY(artist_id) REFERENCES artist(artist_id) ON DELETE CASCADE,
	FOREIGN KEY(album_id) REFERENCES album(album_id) ON DELETE CASCADE
);

CREATE TABLE album_song (
	album_id SMALLINT UNSIGNED,
	song_id SMALLINT UNSIGNED,
    song_track_number TINYINT UNSIGNED,
	PRIMARY KEY(album_id, song_id),
	FOREIGN KEY(album_id) REFERENCES album(album_id),
	FOREIGN KEY(song_id) REFERENCES song(song_id)
);

CREATE TABLE artist_song (
	artist_id SMALLINT UNSIGNED,
	song_id SMALLINT UNSIGNED,
	PRIMARY KEY(artist_id, song_id),
	FOREIGN KEY(artist_id) REFERENCES artist(artist_id),
	FOREIGN KEY(song_id) REFERENCES song(song_id)
);

CREATE TABLE band_membership (
	band_id SMALLINT UNSIGNED,
	solo_id SMALLINT UNSIGNED,
	PRIMARY KEY(band_id, solo_id),
	FOREIGN KEY(band_id) REFERENCES artist(artist_id) ON DELETE CASCADE,
	FOREIGN KEY(solo_id) REFERENCES artist(artist_id) ON DELETE CASCADE
);
