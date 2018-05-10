create database eatclean;
use eatclean;

create table ugyfelek(
	id int not null auto_increment primary key,
	Nev varchar(60),
	telefonszam varchar(20),
	email varchar(20),
	cim varchar(50),
	testmagassag int,
	szuletesi_datum date,
	kivant_testsuly int,
	varhato_idotartam varchar(30)
);

insert into ugyfelek (Nev) values ('Bencze Istvan'), ('Anett'), ('Katinka'), ('Andras');