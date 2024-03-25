-- Create the database
CREATE DATABASE IF NOT EXISTS league_of_legends;

-- Switch to the newly created database
USE league_of_legends;

-- Create the tables within the league_of_legends database
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



