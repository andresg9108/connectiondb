CREATE TABLE example(
id int NOT NULL AUTO_INCREMENT, 
name VARCHAR(200), 
last VARCHAR(200), 
phone VARCHAR(200),
PRIMARY KEY(id)
);

CREATE TABLE example2(
id int NOT NULL AUTO_INCREMENT, 
id2 int NOT NULL, 
name VARCHAR(200), 
last VARCHAR(200), 
phone VARCHAR(200),
PRIMARY KEY(id, id2)
);