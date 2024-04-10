<!-- 
    Zander Gall - galla@csp.edu
    CSC235 - Prof. Furtney

    11/16/23 - Added MySQL code, and 4 mysql join demonstration sections.
 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Data</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php 
    
    // Created new mysql user for this class
    $database = new mysqli('localhost', 'remote', 'mysqlCSC235');

    if($database->connect_error > 0) {
        die("Could not connect to the server database: ".$database->connect_error);
    }

    function attemptQuery($query) {
        global $database;
        if(!$result = $database->query($query))
            die("Error on '".$query."': ".$database->error);
        return $result;
    }

    // Use our database before continuing.
    attemptQuery("USE crudData"); 

    ?>
    
    <!-- Inner join section with table -->
    <section>
        <h2>INNER JOIN</h2>

        <pre>
SELECT CONCAT(employees.firstName, ' ', employees.lastName) AS employeeName, departments.name AS departmentName
    FROM employeesDepartments
    INNER JOIN employees ON employees.id = employeesDepartments.employee
    INNER JOIN departments ON departments.id = employeeDepartments.department
    ORDER BY departmentName
        </pre>

        <!-- Table powered by PHP; uses the given query and adds the results as entries in the table. -->
        <table border='1'>
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Department</th>    
                </tr>
            </thead>
            <tbody>
                <?php
                $result = attemptQuery("SELECT CONCAT(employees.firstName, ' ', employees.lastName) AS employeeName, departments.name AS departmentName
                                            FROM employeesDepartments
                                            INNER JOIN employees ON employees.id = employeesDepartments.employee
                                            INNER JOIN departments ON departments.id = employeesDepartments.department
                                            ORDER BY departmentName");
                while($row = $result->fetch_assoc()) {
                    echo "<tr>\n";
                    echo "<td>".$row['employeeName']."</td>\n";
                    echo "<td>".$row['departmentName']."</td>\n";
                    echo "</tr>\n";
                }

                ?>
            </tbody>
        </table>

        <p>This table shows which employees are in which departments. For every entry in employeesDepartments, we will select (and concatenate) first and last names for employees that match employeesDepartments given employee ids, and names for departments that match employeesDepartments given department id.</p>
        <p>An inner join only selects elements where a condition is true, AND where both elements in the condition aren't null.</p>
    </section>

    <!-- Left join -->
    <section>
        <h2>LEFT JOIN</h2>
        <pre>
SELECT CONCAT(employees.firstName, ' ', employees.lastName) AS name, departments.name AS department
    FROM employees
    LEFT JOIN departments ON employees.id = departments.manager
        </pre>

        <!-- See previous table section -->
        <table border='1'>
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Manager Of</th>    
                </tr>
            </thead>
            <tbody>
                <?php 
                $result = attemptQuery("SELECT CONCAT(employees.firstName, ' ', employees.lastName) AS name, departments.name AS department
                                            FROM employees
                                            LEFT JOIN departments ON employees.id = departments.manager");
                while($row = $result->fetch_assoc()) {
                    echo "<tr>\n";
                    echo "<td>".$row['name']."</td>\n";
                    echo "<td>".$row['department']."</td>\n";
                    echo "</tr>\n";
                }
                ?>
            </tbody>
        </table>

        <p>This table shows all employees, and (if applicable) the department they manage.</p>
        <p>The LEFT JOIN can be summed up with the key phrase "if applicable." It will produce all elements from the 'left' table, and match it with elements from the right table whenever the condition is valid and true.</p>
    </section>

    <!-- Right join -->
    <section>
        <h2>RIGHT JOIN</h2>

        <pre>
SELECT CONCAT(employees.firstName, ' ', employees.lastName) AS name, departments.name AS department
    FROM employees
    RIGHT JOIN departments ON employees.id = departments.manager
        </pre>

        <!-- See first table comment -->
        <table border='1'>
            <thead>
                <tr>
                    <th>Department</th>
                    <th>Manager</th>    
                </tr>
            </thead>
            <tbody>
                <?php 
                $result = attemptQuery("SELECT CONCAT(employees.firstName, ' ', employees.lastName) AS name, departments.name AS department
                                            FROM employees
                                            RIGHT JOIN departments ON employees.id = departments.manager");
                while($row = $result->fetch_assoc()) {
                    echo "<tr>\n";
                    echo "<td>".$row['department']."</td>\n";
                    echo "<td>".$row['name']."</td>\n";
                    echo "</tr>\n";
                }
                ?>
            </tbody>
        </table>

        <p>Notice the only difference between this and the last query is RIGHT JOIN. This will grab all elements from departments, and match it up with employees when applicable. (Printed in reverse order as previous.)</p>
        <p>The RIGHT JOIN is the same as a left join if the order were swapped. The 'right' table is garaunteed to be returned in its entirety, and the left table is only included whenever the condition is valid and true.</p>
    </section>

    <!-- Full join -->
    <section>
        <h2>BONUS: FULL JOIN</h2>

        <pre>
SELECT CONCAT(employees.firstName, ' ', employees.lastName) AS name, departments.name AS department
    FROM employees
    LEFT JOIN departments ON employees.id = departments.manager
UNION
SELECT CONCAT(employees.firstName, ' ', employees.lastName) AS name, departments.name AS department
    FROM employees
    RIGHT JOIN departments ON employees.id = departments.manager;
        </pre>

        <!-- See first table comment -->
        <table border='1'>
            <thead>
                <tr>
                    <th>Employee</th>    
                    <th>Manager Of</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $result = attemptQuery("SELECT CONCAT(employees.firstName, ' ', employees.lastName) AS name, departments.name AS department
                                            FROM employees
                                            LEFT JOIN departments ON employees.id = departments.manager
                                        UNION
                                        SELECT CONCAT(employees.firstName, ' ', employees.lastName) AS name, departments.name AS department
                                            FROM employees
                                            RIGHT JOIN departments ON employees.id = departments.manager");
                while($row = $result->fetch_assoc()) {
                    echo "<tr>\n";
                    echo "<td>".$row['name']."</td>\n";
                    echo "<td>".$row['department']."</td>\n";
                    echo "</tr>\n";
                }
                ?>
            </tbody>
        </table>

        <p>A FULL JOIN includes ALL entries from BOTH tables, with the entries from both tables lined up whenever the condition is valid and true.</p>
        <p>MySQL does not support the FULL join type, but we can mimick it by unioning a LEFT join and a RIGHT join.</p>
    </section>
</body>
</html>