DROP TABLE IF EXISTS Wejscie_zawodnika;
DROP TABLE IF EXISTS Zawodnik;
DROP TABLE IF EXISTS Sety; 
DROP TABLE IF EXISTS Mecz; 
DROP TABLE IF EXISTS Druzyna; 


CREATE TABLE Druzyna (
id_druzyny SERIAL NOT NULL,
nazwa varchar(40) NOT NULL,
PRIMARY KEY (id_druzyny)
);


CREATE TABLE Mecz (
id_meczu SERIAL NOT NULL,
data timestamp NOT NULL,
druzyna1_id int NOT NULL,
druzyna2_id int NOT NULL,
wynik int NULL,
PRIMARY KEY (id_meczu),
FOREIGN KEY (druzyna1_id) REFERENCES Druzyna (id_druzyny),
FOREIGN KEY (druzyna2_id) REFERENCES Druzyna (id_druzyny) 
);


CREATE TABLE Sety (
id_meczu int NOT NULL,
nr_seta int NOT NULL,
wynik int NULL,
PRIMARY KEY (id_meczu,nr_seta),
FOREIGN KEY (id_meczu) REFERENCES Mecz (id_meczu)
);


CREATE TABLE Zawodnik (
id_zawodnika SERIAL NOT NULL,
imie varchar(30) NOT NULL,
nazwisko varchar(30) NOT NULL,
id_druzyny int NOT NULL,
PRIMARY KEY (id_zawodnika),
FOREIGN KEY (id_druzyny) REFERENCES Druzyna (id_druzyny)
);


CREATE TABLE Wejscie_zawodnika (
id_zawodnika int NOT NULL,
id_meczu int NOT NULL,
PRIMARY KEY (id_zawodnika,id_meczu),
FOREIGN KEY (id_zawodnika) REFERENCES Zawodnik (id_zawodnika),
FOREIGN KEY (id_meczu) REFERENCES Mecz (id_meczu)
);


ALTER SEQUENCE Druzyna_id_druzyny_seq RESTART WITH 1;
ALTER SEQUENCE Mecz_id_meczu_seq RESTART WITH 1;
ALTER SEQUENCE Zawodnik_id_zawodnika_seq RESTART WITH 1;



create or replace function spr_poprawnosc_setow() returns trigger as $$ 
declare 
maks integer:=0;

begin
SELECT MAX(nr_seta) into maks FROM Sety WHERE id_meczu = new.id_meczu;

if maks >= 5 then 
raise exception 'W meczu nie może być więcej niż 5 setów !'; 
else return new; 
end if; 

end; 
$$ language plpgsql; 
create trigger poprawnosc_setow 
before insert or update on Sety 
for each row execute procedure spr_poprawnosc_setow(); 


create or replace function spr_zawodnikow_w_meczu() returns trigger as $$ 
declare 
liczba integer:=0;

begin
SELECT count(id_zawodnika) into liczba FROM wejscie_zawodnika WHERE id_meczu = new.id_meczu;

if liczba >= 6 then 
raise exception 'W meczu nie może być więcej niż 6 zawodników !'; 
else return new; 
end if; 

end; 
$$ language plpgsql; 
create trigger liczba_zawodnikow_w_meczu 
before insert or update on wejscie_zawodnika 
for each row execute procedure spr_zawodnikow_w_meczu(); 