**Excuses:** ___I apologize for the English used, my language is Spanish.___

# Data Base Connection #

## Content ##

1. [Introduction.](#Introduction "Introduction")
2. [Dependencies.](#Dependencies "Dependencies")
3. [Starting.](#Starting "Starting")

<span id="Introduction"></span>
## Introduction ##

This project aims to create a connection to various database engines like MySQL or SQLite.

<span id="Dependencies"></span>
## Dependencies ##

- XAMPP (https://www.apachefriends.org/es/index.html).
- Composer (https://getcomposer.org).

<span id="Starting"></span>
## Starting ##

Start by creating a folder called "example" in the path we want for our example project. Then we will execute the following command, using the console of your operating system and stopped in the "example" folder, that will create a "composer.json" file following the instructions given by the console.

***composer init***

Then we will add the project dependency "andresg9108/connectiondb", using the following command:

***composer require andresg9108/connectiondb***

Now we will open the "XAMPP Control Panel" and give "Start" to "Apache" and "MySQL". Enter the "PhpMyAdmin" which can normally be entered using the URL "http://localhost/phpmyadmin", we will create a new database called "example" and run the following script.

~~~
CREATE TABLE example(
id int NOT NULL AUTO_INCREMENT, 
name VARCHAR(200), 
last VARCHAR(200), 
phone VARCHAR(200),
PRIMARY KEY(id)
);
~~~

This will create the "example" table that will serve to test this project.

Now we will create a new file called "test.php" inside the "example" folder and we will add the following code:

**File: ../example/test.php**

~~~
<?php

const __DIRMAIN__ = "./";
require_once __DIRMAIN__.'vendor/autoload.php';

use andresg9108\connectiondb\connection;

try {
	$aConnection = [
		'motor' => 'mysql', // mysql OR mysqlpdo OR sqlitepdo
		'server' => 'localhost', 
		'charset' => 'utf8', 
		'user' => 'root', 
		'password' => '', 
		'database' => 'example', 
		'sqlitepath' => ''
	];
	$oAConnection = (object)$aConnection;

	$oConnection = connection::getInstance($oAConnection);
	$oConnection->connect();

	$oConnection->run("INSERT INTO `example`(`name`, `last`, `phone`) VALUES ('Pepito', 'Peña', '123');");

	echo "ID: ". $oConnection->getIDInsert();

	$oConnection->commit();
	$oConnection->close();
} catch (Exception $e) {
	$oConnection->rollback();
	$oConnection->close();

	echo "Error: ".$e->getMessage();
}
~~~

We go to our browser and enter the following URL "http: //localhost/example/test.php". If everything goes well, we will show the ID of the file that was inserted and if we go back to "PhpMyAdmin", the "example" table should already have a new record.

The object "$ oConnection" is the most relevant of the file "test.php", so it deserves the following explanation:

1. "$oConnection = connection::getInstance($oAConnection);": You can see how the object is created from the connection object ($ oAConnection) that you established in previous lines.
2. "$oConnection->connect();": The connection to the database is established.
3. "$oConnection->run("SQL");": An SQL statement is executed, in this case insert.
4. "$oConnection->getIDInsert();": Returns the ID of the inserted record.
5. "$oConnection->commit();": Commits the transaction.
6. "$oConnection->close();": Close the connection to the database.
7. "$oConnection->rollback();": In case of error it reverts the entire transaction

You can also use the following functions of the "$oConnection" object, which could replace a "$oConnection->run()" in this example:

1. "$oConnection->multiRun("SQL");": Execute multiple lines of SQL code.
2. "$oConnection->getQuery();": Returns the result of an SQL query.
3. "$oConnection->queryArray("SQL")": Executes an SQL query that returns a set of rows. The result can be obtained with "$oConnection->getQuery();".
4. "$oConnection->queryRow("SQL")": Executes an SQL query that returns a row. The result can be obtained with "$oConnection->getQuery();".