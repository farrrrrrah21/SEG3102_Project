CREATE TABLE InboxItems(
	LoginId VARCHAR(30) NOT NULL,
	itemId SERIAL NOT NULL,
	sender VARCHAR(30) NOT NULL,
	message VARCHAR(1000),
	date DATE NOT NULL,
	Primary Key (itemId),
	FOREIGN KEY (LoginId) REFERENCES users (LoginId)
);