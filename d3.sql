CREATE TABLE users (
	LoginId VARCHAR(30) NOT NULL,
	password VARCHAR(30) NOT NULL,
	last_name VARCHAR(30) NOT NULL,
	first_name VARCHAR(30) NOT NULL,
	email VARCHAR(50) NOT NULL UNIQUE,
	status VARCHAR(50) NOT NULL,
	Primary KEY(LoginId)
	);

CREATE TABLE Requester ( 
	LoginId VARCHAR(30) NOT NULL,
	studentNumber INT NOT NULL,
	academicUnit VARCHAR(30) NOT NULL,
	program VARCHAR (30) NOT NULL,
	sessionNumber INT NOT NULL,
	Thesis_Topic VARCHAR(50) NOT NULL,
	BankAccountNumber INT NOT NULL, 
	RequestType VARCHAR (20) NOT NULL,
	Primary Key (LoginId),
	FOREIGN KEY (LoginId) REFERENCES users (LoginId)
); 

CREATE TABLE ApplicationRequest(
	LoginId VARCHAR(30) NOT NULL,
	applicationNumber SERIAL NOT NULL,
	conferenceDetails VARCHAR(1000) NOT NULL, 
	typeOfPresentation VARCHAR (100) NOT NULL,
	presentationDetail VARCHAR(1000) Not NULL,
	registrationExpense FLOAT(10) NOT NULL,
	transportationExpense FLOAT(10) NOT NULL,
	accomendationExpense FLOAT(10) NOT NULL,
	mealsExpense FLOAT(10) NOT NULL,
	advancedFunds FLOAT(10),
	applicationStatus VARCHAR(30),
	Primary Key (applicationNumber),
	FOREIGN KEY (LoginId) REFERENCES users (LoginId)
	);
	
CREATE TABLE InboxItems(
	LoginId VARCHAR(30) NOT NULL,
	itemId SERIAL NOT NULL,
	sender VARCHAR(30) NOT NULL,
	message VARCHAR(1000),
	date DATE NOT NULL,
	Primary Key (itemId),
	FOREIGN KEY (LoginId) REFERENCES users (LoginId)
);