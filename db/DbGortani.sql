CREATE DATABASE DbGortani;

USE DbGortani;

CREATE TABLE Dipendenti(
    idDipendenti INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(50) NOT NULL CHECK(email LIKE '%@%.%'),
    password VARCHAR(60) NOT NULL
);

INSERT INTO Dipendenti VALUES (
    1,'alessio.hoxhallari@gmail.com','12345678'
);


CREATE TABLE Sale(
    idSala INT NOT NULL PRIMARY KEY,
    nome VARCHAR(25) NOT NULL
    CHECK(nome IN('Sala Piccola','Sala Grande','Sala Platinum','Sala Riunione 1','Sala Riunione 2'))
);

INSERT INTO Sale VALUES
    (1,'Sala Piccola'),
    (2,'Sala Grande'),
    (3,'Sala Platinum'),
    (4,'Sala Riunione 1'),
    (5,'Sala Riunione 2');

CREATE TABLE Automobili(
    idAuto INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    targa VARCHAR(7) NOT NULL,
    modello VARCHAR(50),
    colore VARCHAR(25) NOT NULL,
    parcheggio VARCHAR(10) NOT NULL,
    stato varchar(25) NOT NULL 
    CHECK(stato IN('Usata', 'Nuova')),
    cambio varchar(25) NOT NULL 
    CHECK(cambio IN('Manuale', 'Automatica')),
    rifornimento varchar(25) NOT NULL 
    CHECK(rifornimento IN('Gasolio', 'Benzina'))

);

INSERT INTO Automobili VALUES 
    (1,'EZ667SJ','VOLVO V40','grigia','7','Usata','Manuale','Gasolio'),
    (2,'FG709MR','FIAT 500L','rossa','6','Usata','Manuale','Gasolio'),
    (3,'FK770JC', 'CYTROEN C3 PICASSO','bianca','3','Usata','Manuale','Gasolio'),
    (4,'FA578GR', 'DOBLO', 'bianca', 'Magazzino','Usata','Manuale','Gasolio'),  
    (5,'FB726BD', 'DOBLO','grigia','5','Usata','Manuale','Gasolio'); 



CREATE TABLE prenotazioni_sale(
    idprenotazione INT NOT NULL PRIMARY KEY,
    data date NOT NULL,
    nome VARCHAR(30) NOT NULL,
    oraInizio TIME NOT NULL,
    oraFine TIME NOT NULL,
    oggetti VARCHAR(50),
    prenotazione_dipendenti INTEGER NOT NULL,
    prenotazione_sale INTEGER NOT NULL,
    FOREIGN KEY( prenotazione_dipendenti) REFERENCES Dipendenti(idDipendenti) ON UPDATE RESTRICT ON DELETE RESTRICT,
    FOREIGN KEY(prenotazione_sale) REFERENCES Sale(idSala) ON UPDATE RESTRICT ON DELETE RESTRICT
   
);





CREATE TABLE prenotazioni_automobili(
    idprenotazione INT NOT NULL PRIMARY KEY,
    data date NOT NULL,
    nome VARCHAR(30) NOT NULL,
    oraInizio TIME NOT NULL,
    oraFine TIME NOT NULL,
    prenotazione_dipendente INTEGER NOT NULL,
    prenotazione_automobile INTEGER NOT NULL,
    FOREIGN KEY(prenotazione_dipendente) REFERENCES Dipendenti(idDipendenti) ON UPDATE RESTRICT ON DELETE RESTRICT,
    FOREIGN KEY(prenotazione_automobile) REFERENCES Automobili(idAuto) ON UPDATE RESTRICT ON DELETE RESTRICT
);


DROP DbGortani;
DROP TABLE Dipendenti;
DROP TABLE Sale;
DROP TABLE prenotazioni;
DROP TABLE Automobili;