drop database if exists Ryoko;
create database Ryoko;
use Ryoko;

drop table if exists Booking;

drop table if exists Country;

drop table if exists Travel;

drop table if exists User;


/*------------------------------------------------------------*/
/* Table: Country
/*------------------------------------------------------------*/
CREATE TABLE Country(
	iso_code Varchar (3) NOT NULL,
    name     Varchar (64) NOT NULL,

	primary key(iso_code)
)ENGINE=InnoDB;


/*------------------------------------------------------------*/
/* Table: User
/*------------------------------------------------------------*/

CREATE TABLE User(
	email      Varchar (128) NOT NULL,
    password   Varchar (64) NOT NULL,
    name       Varchar (64) NOT NULL,
    first_name Varchar (64) NOT NULL,
    phone      Varchar (10) NOT NULL,
    city       Varchar (64) NOT NULL,
    zip_code   Varchar (16) NOT NULL,
    birth_date Date NOT NULL,
    country    Varchar (3) NOT NULL,

	primary key(email)
)ENGINE=InnoDB;


/*------------------------------------------------------------*/
/* Table: Travel
/*------------------------------------------------------------*/

CREATE TABLE Travel(
	id_travel     Int NOT NULL AUTO_INCREMENT,
    title         Varchar (64) NOT NULL,
    description   Text NOT NULL,
    duration      Int NOT NULL,
    cost          Float NOT NULL,
    img_directory Varchar (128) NOT NULL,
    country_code  Varchar (3) NOT NULL,

	primary key(id_travel)
)ENGINE=InnoDB;


/*------------------------------------------------------------*/
/* Table: Booking
/*------------------------------------------------------------*/
CREATE TABLE Booking (
	id_travel         Int NOT NULL,
    user_email        Varchar (128) NOT NULL,
    departure_date    Date NOT NULL,
    return_date       Date NOT NULL,
    total_cost        Float NOT NULL,
    validation_status Varchar (8) NOT NULL,

	primary key(id_travel, user_email)
)ENGINE=InnoDB;


ALTER TABLE User ADD CONSTRAINT FK_USER_COUNTRY FOREIGN KEY User(country)
	REFERENCES Country(iso_code) ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE Travel ADD CONSTRAINT FK_TRAVEL_COUNTRY FOREIGN KEY Travel(country_code)
	REFERENCES Country(iso_code) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE Booking ADD CONSTRAINT FK_BOOKING_TRAVEL FOREIGN KEY Booking(id_travel)
	REFERENCES Travel(id_travel) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE Booking ADD CONSTRAINT FK_BOOKING_USER FOREIGN KEY Booking(user_email)
	REFERENCES User(email) ON DELETE CASCADE ON UPDATE CASCADE;

drop user if exists 'Ryoko'@'localhost';
create user 'Ryoko'@'localhost' IDENTIFIED BY '#grp11@Ryoko!';
grant all privileges ON Ryoko.* TO 'Ryoko'@'localhost';
