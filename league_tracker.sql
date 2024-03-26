-- Create the tables within the league_tracker database
CREATE TABLE League (
    LeagueName VARCHAR(100) PRIMARY KEY,
    NumberOfTeams INT
);

CREATE TABLE Tournament (
    TournamentName VARCHAR(100) PRIMARY KEY,
    Prize DECIMAL(10,2)
);

CREATE TABLE Coach (
    CoachName VARCHAR(100) PRIMARY KEY,
    Nationality VARCHAR(100)
);

CREATE TABLE Equipment (
    EquipmentName VARCHAR(100) PRIMARY KEY,
    Cost DECIMAL(10,2)
);

CREATE TABLE Player (
    PlayerID INT PRIMARY KEY,
    Name VARCHAR(100),
    Position VARCHAR(50),
    MostUsedChampion VARCHAR(100),
    Age INT,
    Nationality VARCHAR(100),
    WinRate DECIMAL(5,2) CHECK (WinRate >= 0 AND WinRate <= 1) -- Check constraint for WinRate
);

CREATE TABLE Champion (
    ChampionName VARCHAR(100) PRIMARY KEY,
    GamesPlayed INT,
    WinRate DECIMAL(5,2) CHECK (WinRate >= 0 AND WinRate <= 1) -- Check constraint for WinRate
);

CREATE TABLE Sponsor (
    SponsorName VARCHAR(100) PRIMARY KEY,
    Industry VARCHAR(100),
    Country VARCHAR(100)
);

CREATE TABLE Team (
    TeamName VARCHAR(100) PRIMARY KEY,
    LeagueName VARCHAR(100),
    WinRate DECIMAL(5,2) CHECK (WinRate >= 0 AND WinRate <= 1),
    Rank INT,
    FOREIGN KEY (LeagueName) REFERENCES League(LeagueName)
);

-- Create a trigger to enforce the Rank to be lower than the number of teams in the league
DELIMITER $$
CREATE TRIGGER CheckRankBeforeInsert BEFORE INSERT ON Team
FOR EACH ROW
BEGIN
    DECLARE teamCount INT;
    SET teamCount = (SELECT NumberOfTeams FROM League WHERE LeagueName = NEW.LeagueName);
    IF NEW.Rank >= teamCount THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Rank must be lower than NumberOfTeams for the corresponding league';
    END IF;
END$$
DELIMITER ;

-- Create the Sponsor table
CREATE TABLE Endorse (
    SponsorName VARCHAR(100),
    TeamName VARCHAR(100),
    Price DECIMAL(10, 2),
    PRIMARY KEY (SponsorName, TeamName),
    FOREIGN KEY (TeamName) REFERENCES Team(TeamName) ON DELETE CASCADE
    FOREIGN KEY (SponsorName) REFERENCES Sponsor(SponsorName) ON DELETE CASCADE
);

-- Create the Plays table
CREATE TABLE Plays (
    PlayerID INT,
    ChampionName VARCHAR(100),
    PRIMARY KEY (PlayerID, ChampionName),
    FOREIGN KEY (PlayerID) REFERENCES Player(PlayerID) ON DELETE CASCADE,
    FOREIGN KEY (ChampionName) REFERENCES Champion(ChampionName) ON DELETE CASCADE
);

-- Create the Uses table
CREATE TABLE Uses (
    EquipmentName VARCHAR(100),
    ChampionName VARCHAR(100),
    PRIMARY KEY (EquipmentName, ChampionName),
    FOREIGN KEY (EquipmentName) REFERENCES Equipment(EquipmentName) ON DELETE CASCADE,
    FOREIGN KEY (ChampionName) REFERENCES Champion(ChampionName) ON DELETE CASCADE
);

-- Example of data retrievals:

-- Select the player info given the PlayerID as 'Faker'
SELECT * FROM Player WHERE PlayerID = 'Faker';

-- Select the player info given the Position as 'Jungle' and Nationality as 'China'
SELECT * FROM Player WHERE Position = 'Jungle' AND Nationality = 'China';

-- Select the sponsor info given the Industry as 'Food' and country as 'United States'
SELECT * FROM Sponsor WHERE Industry = 'Food' AND Country = 'United States';

-- Select the team info given the TeamName as 'T1'
SELECT * FROM Team WHERE TeamName = 'T1';

-- Select the tournament info given the prize is greater than 1000000
SELECT * FROM Tournament WHERE Prize > 1000000;

INSERT INTO Champion (ChampionName, GamesPlayed, WinRate)
VALUES 
  ('Lee Sin', 300, 0.50),
  ('Ezreal', 420, 0.53),
  ('Senna', 215, 0.56),
  ('Kaisa', 390, 0.51),
  ('Yasuo', 180, 0.48),
  ('Akali', 290, 0.55),
  ('Ornn', 150, 0.61),
  ('Zoe', 320, 0.47),
  ('Thresh', 400, 0.49),
  ('Fiora', 250, 0.52);



INSERT INTO Coach (CoachName, Nationality)
VALUES 
  ('Reapered', 'Korea'),
  ('Kkoma', 'Korea'),
  ('Youngbuck', 'Netherlands'),
  ('Zaboutine', 'France'),
  ('Prolly', 'USA'),
  ('Parth', 'USA'),
  ('Mithy', 'Spain'),
  ('GrabbZ', 'Germany'),
  ('Homme', 'Korea'),
  ('Cain', 'Korea');





INSERT INTO Equipment (EquipmentName, Cost)
VALUES 
  ('Logitech G Pro Wireless Mouse', 130),
  ('Corsair K95 RGB Keyboard', 200),
  ('Razer DeathAdder Mouse', 70),
  ('SteelSeries Apex Pro Keyboard', 180),
  ('HyperX Pulsefire FPS Mouse', 60),
  ('Razer BlackWidow Keyboard', 140),
  ('Logitech G502 Hero Mouse', 50),
  ('Corsair K70 RGB MK.2 Keyboard', 160),
  ('SteelSeries Rival 600 Mouse', 80),
  ('HyperX Alloy FPS Keyboard', 100);

INSERT INTO League (LeagueName, NumberOfTeams)
VALUES 
  ('NA LCS', 10),
  ('EU LEC', 10),
  ('LCK', 10),
  ('LPL', 16),
  ('CBLOL', 8),
  ('LJL', 8),
  ('OPL', 8),
  ('LCL', 8),
  ('TCL', 10),
  ('PCS', 10);


INSERT INTO Player (PlayerID, Name, Position, MostUsedChampion, Age, Nationality, WinRate)
VALUES 
  (101, 'Faker', 'Mid', 'LeBlanc', 24, 'Korea', 0.63),
  (102, 'Doublelift', 'ADC', 'Lucian', 27, 'USA', 0.57),
  (103, 'Caps', 'Mid', 'Zoe', 21, 'Denmark', 0.60),
  (104, 'Rekkles', 'ADC', 'Sivir', 25, 'Sweden', 0.59),
  (105, 'Jankos', 'Jungle', 'Lee Sin', 26, 'Poland', 0.58),
  (106, 'Bwipo', 'Top', 'Gangplank', 22, 'Belgium', 0.55),
  (107, 'Perkz', 'Mid', 'Yasuo', 22, 'Croatia', 0.61),
  (108, 'Deft', 'ADC', 'Varus', 24, 'Korea', 0.62),
  (109, 'SwordArt', 'Support', 'Thresh', 23, 'Taiwan', 0.60),
  (110, 'Nuguri', 'Top', 'Akali', 21, 'Korea', 0.59);


INSERT INTO Sponsor (SponsorName, Industry, Country)
VALUES 
  ('Red Bull', 'Beverage', 'Austria'),
  ('Samsung Electronics', 'Electronics', 'South Korea'),
  ('Logitech', 'Computer Peripherals', 'Switzerland'),
  ('Intel', 'Semiconductor', 'USA'),
  ('Nike', 'Apparel', 'USA'),
  ('T-Mobile', 'Telecommunications', 'USA'),
  ('Audi', 'Automotive', 'Germany'),
  ('Cisco', 'Networking Equipment', 'USA'),
  ('Alienware', 'Computer Hardware', 'USA'),
  ('BMW', 'Automotive', 'Germany');

INSERT INTO Tournament (TournamentName, Prize)
VALUES 
  ('World Championship 2024', 2500000),
  ('Mid-Season Invitational 2024', 1000000),
  ('LEC Summer 2024', 500000),
  ('LCS Spring 2024', 500000),
  ('LCK Summer 2024', 800000),
  ('LPL Spring 2024', 800000),
  ('CBLOL Split 2 2024', 200000),
  ('LJL Summer 2024', 150000),
  ('OPL Split 1 2024', 100000),
  ('PCS Summer 2024', 300000);

INSERT INTO Team (TeamName, LeagueName, WinRate, Rank)
VALUES 
  ('T1', 'LCK', 0.70, 1),
  ('G2 Esports', 'EU LEC', 0.65, 2),
  ('Fnatic', 'EU LEC', 0.60, 3),
  ('Cloud9', 'NA LCS', 0.63, 1),
  ('Team Liquid', 'NA LCS', 0.59, 2),
  ('JD Gaming', 'LPL', 0.68, 1),
  ('Top Esports', 'LPL', 0.65, 2),
  ('DRX', 'LCK', 0.55, 4),
  ('MAD Lions', 'EU LEC', 0.58, 4),
  ('100 Thieves', 'NA LCS', 0.61, 3);
  ('SK Telecom T1', 'LCK', 0.70, 1),
  ('Samsung Galaxy', 'LCK', 0.65, 2),
  ('KT Rolster', 'LCK', 0.60, 3),
  ('Afreeca Freecs', 'LCK', 0.58, 4),
  ('Rogue', 'EU LEC', 0.62, 2),
  ('Schalke 04', 'EU LEC', 0.57, 3),
  ('Team SoloMid', 'NA LCS', 0.68, 1),
  ('Golden Guardians', 'NA LCS', 0.62, 2),
  ('Evil Geniuses', 'NA LCS', 0.58, 3);

INSERT INTO Endorse (SponsorName, TeamName, Price)
VALUES 
  ('Intel', 'T1', 600000),
  ('Twitch', 'G2 Esports', 400000),
  ('Adidas', 'Fnatic', 800000),
  ('Mastercard', 'Gen.G', 550000),
  ('Gillette', 'Cloud9', 350000),
  ('Red Bull', 'JD Gaming', 450000),
  ('Nike', 'Top Esports', 750000),
  ('Coca-Cola', 'DRX', 500000),
  ('Mercedes-Benz', 'MAD Lions', 400000),
  ('HyperX', 'Team Liquid', 300000);

INSERT INTO Plays (PlayerID, ChampionName)
VALUES 
  (101, 'LeBlanc'),
  (102, 'Lucian'),
  (103, 'Zoe'),
  (104, 'Sivir'),
  (105, 'Lee Sin'),
  (106, 'Gangplank'),
  (107, 'Yasuo'),
  (108, 'Varus'),
  (109, 'Thresh'),
  (110, 'Akali'),
  (111, 'Kai''Sa'),
  (112, 'Syndra'),
  (113, 'Galio'),
  (114, 'Riven'),
  (115, 'Ryze');


UPDATE Player
SET Age = 25
WHERE Name = 'Faker';

UPDATE Tournament
SET Prize = 2600000
WHERE TournamentName = 'World Championship 2024';

UPDATE Sponsor
SET Industry = 'Energy Drinks'
WHERE SponsorName = 'Red Bull';

UPDATE Equipment
SET Cost = 135
WHERE EquipmentName = 'Logitech G Pro Wireless Mouse';

UPDATE Coach
SET Nationality = 'South Korea'
WHERE CoachName = 'Reapered';

DELETE FROM Player
WHERE Name = 'Doublelift';

DELETE FROM Tournament
WHERE TournamentName = 'OPL Split 1 2024';

DELETE FROM Sponsor
WHERE SponsorName = 'Cisco';

DELETE FROM Equipment
WHERE EquipmentName = 'SteelSeries Rival 600 Mouse';

DELETE FROM Coach
WHERE CoachName = 'Zaboutine';
