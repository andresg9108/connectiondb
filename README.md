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

Start by creating a folder called "example" in the path we want for our example project. Then we will run the following command, which will create a "composer.json" file.

***composer init***

Now we are going to edit the file "composer.json" adding the array "repositories": [...], like this:

**File: ../example/composer.json**

~~~
{
    "name": "example/example",
    "license": "MIT",
    "authors": [
        {
            "name": "Andres Gonzalez"
        }
    ],
    "require": {
    },
    "repositories": [
	    {
	        "type": "vcs",
	    	"url": "https://github.com/andresg9108/connectiondb"
		}
	]
}
~~~

With this we are indicating to the project in which repository the "andresg9108/connectiondb" project is located and we are ready to execute the following command, using the console of its operating system and standing in the "example" folder.

***composer require andresg9108/connectiondb***