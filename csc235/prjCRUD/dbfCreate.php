<!--
    Zander Gall - galla@csp.edu
    Csc235 - Prof. Furney

    11/15/23: Set up basic HTML template, and wrote majority of createDatabase function.
    11/16/23: Replacing queries with attemptQuery (catches errors) function.
    11/19/23: Cleaned up commented out code, and added more comments.
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Database</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php 
    
    // Created new mysql user for this class
    $database = new mysqli('localhost', 'remote', 'mysqlCSC235');

    if($database->connect_error > 0) {
        die("Could not connect to the server database: ".$database->connect_error);
    }

    // Attempts a query, if it fails, dies
    function attemptQuery($query) {
        global $database;
        if(!$result = $database->query($query))
            die("Error on '".$query."': ".$database->error);
        return $result;
    }

    // Drops crudData database if it exists, creates it, uses it, and creates 3 tables for it
    function createDatabase() {
        attemptQuery("drop database if exists crudData");
        attemptQuery("create database crudData");
        attemptQuery("use crudData");
       
        attemptQuery("CREATE TABLE employees (
                        id int NOT NULL AUTO_INCREMENT,
                        firstName varchar(255) NOT NULL,
                        lastName varchar(255) NOT NULL,
                        primary key (id)
                    )");
        attemptQuery("CREATE TABLE departments (
                        id int NOT NULL AUTO_INCREMENT,
                        name varchar(255) NOT NULL,
                        manager int,
                        primary key (id),
                        foreign key (manager) references employees(id)
                    )");
        attemptQuery("CREATE TABLE employeesDepartments (
                        employee int NOT NULL,
                        department int NOT NULL,
                        foreign key (employee) references employees(id),
                        foreign key (department) references departments(id)
                    )");

    }

    // A series of 'insert into __ values __' queries. Adds employees, departments, and populates the n:n employeesDepartments table
    function populateTable() {
        attemptQuery("INSERT INTO employees (firstName, lastName) VALUES ('Norville', 'Rogers')");  // 1
        attemptQuery("INSERT INTO employees (firstName, lastName) VALUES ('Daphne', 'Blake')");     // 2    
        attemptQuery("INSERT INTO employees (firstName, lastName) VALUES ('Velma', 'Dinkley')");    // 3
        attemptQuery("INSERT INTO employees (firstName, lastName) VALUES ('Fred', 'Jones')");       // 4
        attemptQuery("INSERT INTO employees (firstName, lastName) VALUES ('Scoobert', 'Doo')");     // 5

        attemptQuery("INSERT INTO departments (name, manager) VALUES ('Event Organizers', 1)");     // 1, Manager = Norville Rogers
        attemptQuery("INSERT INTO departments (name, manager) VALUES ('Research', 3)");             // 2, Manager = Velma Dinkley
        attemptQuery("INSERT INTO departments (name, manager) VALUES ('The Mystery Gang', 4)");     // 3, Manager = Fred Jones
        attemptQuery("INSERT INTO departments (name, manager) VALUES ('Safety Commission', NULL)"); // 4, Manager = null
        attemptQuery("INSERT INTO departments (name, manager) VALUES ('Finances', NULL)");          // 5, Manager = null

        // Registering employees for their respective departments
        attemptQuery("INSERT INTO employeesDepartments (employee, department) VALUES(1, 1)"); // Shaggy and Scooby in event organizers
        attemptQuery("INSERT INTO employeesDepartments (employee, department) VALUES(5, 1)");

        attemptQuery("INSERT INTO employeesDepartments (employee, department) VALUES(2, 2)"); // Daphne and Velma in researchers
        attemptQuery("INSERT INTO employeesDepartments (employee, department) VALUES(3, 2)");

        attemptQuery("INSERT INTO employeesDepartments (employee, department) VALUES(1, 3)"); // The whole gang in the mystery gang
        attemptQuery("INSERT INTO employeesDepartments (employee, department) VALUES(2, 3)");
        attemptQuery("INSERT INTO employeesDepartments (employee, department) VALUES(3, 3)");
        attemptQuery("INSERT INTO employeesDepartments (employee, department) VALUES(4, 3)");
        attemptQuery("INSERT INTO employeesDepartments (employee, department) VALUES(5, 3)");
    }

    // Lots and lots of echoing.
    // Creates the display tables for the 3 crudData tables created and populated by the previous two functions.
    function displayTable() {
        // Beginning of employees table, print head of table 
        echo "  <table id='employees' border='1'>\n";
        echo "      <caption>Employees</caption>\n";
        echo "      <thead>\n";
        echo "          <tr><th>Name</th></tr>\n";
        echo "      </thead>\n";
        echo "      <tbody>\n";

        // Select firstName and lastName from employees, concatenating them. Printing each result as a row in the table
        $result = attemptQuery("SELECT CONCAT(firstName, \" \", lastName) as name from employees");
        while ($row = $result->fetch_assoc()) {
            echo "      <tr><td>{$row['name']}</td></tr>\n";
        }

        echo "      </tbody>\n";
        echo "  </table>\n";
        // End of employees

        // Beginning of departments table
        echo "  <table id='departments' border='1'>\n";
        echo "      <caption>Departments</caption>\n";
        echo "      <thead>\n";
        echo "          <tr><th>Name</th><th>Manager ID</th></tr>\n";
        echo "      </thead>\n";
        echo "      <tbody>\n";

        // Select all names and managers from departments, printing each as an entry in a row
        $result = attemptQuery("SELECT name, manager from departments");
        while ($row = $result->fetch_assoc()) {
            echo "      <tr><td>{$row['name']}</td><td>{$row['manager']}</td></tr>\n";
        }
        echo "      </tbody>\n";
        echo "  </table>\n";
        // End of departments

        // Beginning of employeesDepartments table
        echo "  <table id='employeesDepartments' border='1'>\n";
        echo "      <caption>Employees-Departments</caption>";
        echo "      <thead>\n";
        echo "          <tr><th>Employee ID</th><th>Manager ID</th></tr>\n";
        echo "      </thead>\n";
        echo "      <tbody>\n";

        // Select all employee and department pairs from employeesDepartments and print as rows
        $result = attemptQuery("SELECT employee, department from employeesDepartments");
        while ($row = $result->fetch_assoc()) {
            echo "      <tr><td>{$row['employee']}</td><td>{$row['department']}</td></tr>\n";
        }
        echo "      </tbody>\n";
        echo "  </table>\n";
        // End of employeesDepartments
    }

    createDatabase();
    populateTable();
    displayTable();

    ?>
</body>
</html>