drop database if exists proefexamen;
create database proefexamen;
use proefexamen;

create table gebruikers (
    id int auto_increment,
    email varchar(255),
    gebruikersnaam varchar(255),
    wachtwoord varchar(255),
    registratiedatum timestamp default current_timestamp,
    is_verkiesbaar boolean default false,
    primary key(id)
);

insert into gebruikers (gebruikersnaam, wachtwoord) values ("misha", 123456);