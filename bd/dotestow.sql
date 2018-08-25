DELETE FROM Sety;
DELETE FROM Wejscie_zawodnika;
DELETE FROM Zawodnik;
DELETE FROM Mecz;
DELETE FROM Druzyna;


INSERT INTO Druzyna (nazwa) VALUES ('Druzyna1');
INSERT INTO Druzyna (nazwa) VALUES ('Druzyna2');
INSERT INTO Druzyna (nazwa) VALUES ('Druzyna3');
INSERT INTO Druzyna (nazwa) VALUES ('Druzyna4');

INSERT INTO Zawodnik (imie, nazwisko, id_druzyny) VALUES ('Jan1', 'Kowalski1', 1);
INSERT INTO Zawodnik (imie, nazwisko, id_druzyny) VALUES ('Jan2', 'Kowalski2', 2);
INSERT INTO Zawodnik (imie, nazwisko, id_druzyny) VALUES ('Jan3', 'Kowalski3', 3);
INSERT INTO Zawodnik (imie, nazwisko, id_druzyny) VALUES ('Jan4', 'Kowalski4', 4);

INSERT INTO Mecz (data, druzyna1_id, druzyna2_id) VALUES ('2017-06-25 10:00:00', 1, 2);
INSERT INTO Mecz (data, druzyna1_id, druzyna2_id) VALUES ('2017-06-25 10:00:00', 1, 3);
INSERT INTO Mecz (data, druzyna1_id, druzyna2_id) VALUES ('2017-06-25 10:00:00', 1, 4);
INSERT INTO Mecz (data, druzyna1_id, druzyna2_id) VALUES ('2017-06-25 10:00:00', 2, 3);

INSERT INTO Wejscie_zawodnika VALUES (1, 1);
INSERT INTO Wejscie_zawodnika VALUES (1, 2);
INSERT INTO Wejscie_zawodnika VALUES (1, 3);
INSERT INTO Wejscie_zawodnika VALUES (2, 4);

INSERT INTO Sety (id_meczu, nr_seta) VALUES (1, 1);
INSERT INTO Sety (id_meczu, nr_seta) VALUES (1, 2);
INSERT INTO Sety (id_meczu, nr_seta) VALUES (1, 3);
INSERT INTO Sety (id_meczu, nr_seta) VALUES (1, 4);
INSERT INTO Sety (id_meczu, nr_seta) VALUES (1, 5);