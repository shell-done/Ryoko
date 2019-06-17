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
   ID_BOOKING           int not null,
   ID_TRAVEL            int not null,
   ID_USER              int not null,
   DEPARTURE_DATE       date,
   ARRIVAL_DATE         date,
   TOTAL_COST           decimal,
   VALIDATION           varchar(8),
   primary key (ID_BOOKING)
);

/*==============================================================*/
/* Table : COUNTRY                                              */
/*==============================================================*/
create table COUNTRY
(
   ID_COUNTRY           int not null,
   NAME                 varchar(64) not null,
   primary key (ID_COUNTRY)
);

/*==============================================================*/
/* Table : TRAVEL                                               */
/*==============================================================*/
create table TRAVEL
(
   ID_TRAVEL            int not null,
   ID_COUNTRY           int not null,
   TITLE                char(64) not null,
   DESCRIPTION          text,
   DURATION             int,
   COST                 decimal,
   ADULT_COST           decimal,
   CHILD_COST           decimal,
   primary key (ID_TRAVEL)
);

/*==============================================================*/
/* Table : USER                                                 */
/*==============================================================*/
create table USER
(
   ID_USER              int not null,
   PASSWORD             char(64) not null,
   NAME                 varchar(64) not null,
   FIRST_NAME           varchar(64) not null,
   EMAIL                varchar(64) not null,
   PHONE                varchar(10) not null,
   COUNTRY              char(64),
   CITY                 char(64),
   POSTAL_CODE          char(16),
   BIRTH_DATE           date,
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
