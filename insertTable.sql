
INSERT INTO users( LoginID, password, last_name, first_name,email,status ) Values 
('adi25','Roy1','Roy','Adity','Adity25@yahoo.ca','System Admin'),
("Farrah101","Dean101","Dean","Farrah","Farrah101@hotmail.com","Financial Office Staff"),
("Mark101","MrozMark","Mroz","Mark","Mark101@hotmail.com","System Admin"),
("niel111","Parker101","James","Michael","Mark101@uottawa.ca","Supervisor"),
("Parker01","Sam","Parker","Samantha","sam23@yahoo.ca","Requester"),
("Pram","Pram","Roy","Pramity","Pram23@yahoo.ca","Requester"),
("Proy","Pram","Roy","Pramity","pramity150@yahoo.ca","System Admin"),
("Roy101", "Cool","Roy","Pragya","proy061@uottawa.ca","Finacial Office Staff"),
("shey","sh","Richardson","Sasha","shey90@gmail.com","Supervisor");

INSERT INTO ApplicationRequest( LoginID, conferenceDetails , typeOfPresentation, presentationDetail ,registrationExpense, 
								transportationExpense, accomendationExpense,mealsExpense) Values 
								("Pram","This is a text","Biology","evolution is unique","200.78","200.00","300.00","100.00");
