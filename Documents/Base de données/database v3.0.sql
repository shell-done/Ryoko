drop database if exists Ryoko;
create database Ryoko;
use Ryoko;

drop table if exists BOOKING;

drop table if exists COUNTRY;

drop table if exists TRAVEL;

drop table if exists USER;

/*==============================================================*/
/* Table : BOOKING                                              */
/*==============================================================*/
create table BOOKING
(
   ID_BOOKING           int not null auto_increment,
   ID_TRAVEL            int not null,
   ID_USER              int not null,
   DEPARTURE_DATE       date not null,
   ARRIVAL_DATE         date not null,
   TOTAL_COST           decimal not null,
   VALIDATION           varchar(8) not null,
   primary key (ID_BOOKING)
);

/*==============================================================*/
/* Table : COUNTRY                                              */
/*==============================================================*/
create table COUNTRY
(
   ID_COUNTRY           int not null auto_increment,
   ISO_CODE             char(2) not null,
   NAME                 varchar(64) not null,
   primary key (ID_COUNTRY)
);

/*==============================================================*/
/* Table : TRAVEL                                               */
/*==============================================================*/
create table TRAVEL
(
   ID_TRAVEL            int not null auto_increment,
   ID_COUNTRY           int not null,
   TITLE                char(64) not null,
   DESCRIPTION          text not null,
   DURATION             int not null,
   COST                 decimal not null,
   primary key (ID_TRAVEL)
);

/*==============================================================*/
/* Table : USER                                                 */
/*==============================================================*/
create table USER
(
   ID_USER              int not null auto_increment,
   PASSWORD             char(64) not null,
   NAME                 varchar(64) not null,
   FIRST_NAME           varchar(64) not null,
   EMAIL                varchar(64) not null,
   PHONE                varchar(10) not null,
   COUNTRY              char(64) not null,
   CITY                 char(64) not null,
   POSTAL_CODE          char(16) not null,
   BIRTH_DATE           date not null,
   primary key (ID_USER)
);

alter table BOOKING add constraint FK_BOOK foreign key (ID_USER)
      references USER (ID_USER) on delete restrict on update restrict;

alter table BOOKING add constraint FK_OF foreign key (ID_TRAVEL)
      references TRAVEL (ID_TRAVEL) on delete restrict on update restrict;

alter table TRAVEL add constraint FK_IS_IN foreign key (ID_COUNTRY)
      references COUNTRY (ID_COUNTRY) on delete restrict on update restrict;

drop user if exists 'Ryoko'@'localhost';
create user 'Ryoko'@'localhost' IDENTIFIED BY '#grp11@Ryoko!';
grant all privileges ON Ryoko.* TO 'Ryoko'@'localhost';
