-- Primary key constraint in the Movie Table on the id  attribute
-- Check year < 3000
CREATE TABLE Movie(id INT,
                  title VARCHAR(100),
                  year INT,
                  rating VARCHAR(10),
                  company VARCHAR(50),
                  PRIMARY KEY(id),
                  CHECK(year < 3000 AND year > 1500)) ENGINE=INNODB;

-- Primary key constraint in the Actor Table on the id attribute
CREATE TABLE Actor(id INT,
                  last VARCHAR(20),
                  first VARCHAR(20),
                  sex VARCHAR(6),
                  dob DATE,
                  dod DATE,
                  PRIMARY KEY(id)) ENGINE=INNODB;

-- Foreign key constraint in the Sales Table on the mid attribute to the Movie table id attribute
-- Check ticketsSold greater that or equal to 0
CREATE TABLE Sales(mid INT,
                  ticketsSold INT,
                  totalIncome INT,
                  FOREIGN KEY(mid) references Movie(id),
                  CHECK(ticketsSold >= 0)) ENGINE=INNODB;

-- Primary key constraint in the Director Table on the id  attribute
CREATE TABLE Director(id INT,
                      last VARCHAR(20),
                      first VARCHAR(20),
                      dob DATE,
                      dod DATE,
                      PRIMARY KEY(id)) ENGINE=INNODB;

-- Foreign key constraint in the MovieGenre Table on the mid attribute to the Movie table id attribute
CREATE TABLE MovieGenre(mid INT,
                        genre VARCHAR(20),
                        FOREIGN KEY(mid) references Movie(id)) ENGINE=INNODB;

-- Foreign key constraint in the MovieDirector Table on the mid attribute to the Movie table id attribute
-- Foreign key constraint in the MovieDirector Table on the did attribute to the Director table id attribute
CREATE TABLE MovieDirector(mid INT,
                          did INT,
                          FOREIGN KEY(mid) references Movie(id),
                          FOREIGN KEY(did) references Director(id)) ENGINE=INNODB;

-- Foreign key constraint in the MovieActor Table on the mid attribute to the Movie table id attribute
-- Foreign key constraint in the MovieActor Table on the aid attribute to the Actor table id attribute
CREATE TABLE MovieActor(mid INT,
                        aid INT,
                        role VARCHAR(50),
                        FOREIGN KEY(mid) references Movie(id),
                        FOREIGN KEY(aid) references Actor(id)) ENGINE=INNODB;

-- Foreign key constraint in the MovieRating Table on the mid attribute to the Movie table id attribute
-- CHECK that imdb and rot score are between 1 and 100
CREATE TABLE MovieRating(mid INT,
                        imdb INT,
                        rot INT,
                        FOREIGN KEY(mid) references Movie(id),
                        CHECK(imdb < 101 AND imdb > 0),
                        CHECK(rot < 101 AND rot > 0)) ENGINE=INNODB;

CREATE TABLE Review(name VARCHAR(20),
                    time TIMESTAMP,
                    mid INT,
                    rating INT,
                    comment VARCHAR(500)) ENGINE=INNODB;

CREATE TABLE MaxPersonID(id INT) ENGINE=INNODB;
CREATE TABLE MaxMovieID(id INT) ENGINE=INNODB;
