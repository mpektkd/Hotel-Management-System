DELIMITER $$

CREATE PROCEDURE CreateCustomer(
	IN FirstName varchar(45), IN LastName varchar(45), 
	IN BirthDate varchar(50), IN Gender varchar(50), 
	IN SSN varchar(20), IN SSNDocument varchar(45), 
	IN SSNissAuth varchar(20), IN Email varchar(45), 
	IN PhoneNumber varchar(255)
)
DETERMINISTIC
BEGIN
	
    DECLARE CustomerID int;
	DECLARE FormatDate date;
	SET @FormatDate = STR_TO_DATE(BirthDate,'%d,%m,%Y');
	INSERT INTO mydb.Customer (LastName, FirstName, BirthDate, Gender) VALUES (LastName, FirstName, @FormatDate, Gender);
	SET @CustomerID = LAST_INSERT_ID();
	INSERT INTO mydb.SIN (idCustomer, SINNumber, SINDocument, SINIssueAuthority) VALUES (@CustomerID, SSN, SSNDocument, SSNissAuth);
	INSERT INTO Email (idCustomer, Email) VALUES (@CustomerID, Email);
	INSERT INTO Phone (idCustomer, Number) VALUES (@CustomerID, PhoneNumber);

END$$
DELIMITER ;
