<!DOCTYPE html>
<html>

<head>
    <title>PHP Execution Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f1f1f1;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        pre {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
            overflow: auto;
            font-size: 14px;
            line-height: 1.4;
        }
    </style>
</head>

<body>
    <h1>PHP Execution Results</h1>

    <pre>
    <?php
    echo "<per>";
    if ($_POST) {
        print_r($_POST);
        echo "\n\n\n";
    }

    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '123456';
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass);

    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    function getDatabaseNames($mysqli)
    {
        $databaseNames = array();

        $result = $mysqli->query("SHOW DATABASES");
        if ($result) {
            while ($row = $result->fetch_row()) {
                $databaseNames[] = $row[0];
            }
            $result->free();
        }

        return $databaseNames;
    }

    function getDatabasequery($mysDB, $DBtable)
    {
        $sql = "SELECT * FROM $DBtable";
        $result = $mysDB->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                print_r($row);
            }
        }
    }

    function getDatabaseTables($mysDB)
    {
        $tableNmaes = array();
        $result = $mysDB->query("SHOW TABLES");

        if ($result) {
            while ($row = $result->fetch_row()) {
                $tableNmaes[] = $row[0];
            }
            $result->free();
        }
        return $tableNmaes;
    }


    // Call the function to retrieve database names
    $databases = getDatabaseNames($mysqli);

    // Output the database names
    foreach ($databases as $database) {
        echo $database . "<br />";
    }

    // Close the MySQL connection
    $mysqli->close();

    if ($_POST) {

        if ($_POST['dbName']) {
            $myDB = new mysqli($dbhost, $dbuser, $dbpass, $_POST['dbName']);
            $result = getDatabaseTables($myDB);
            echo 'lenght :  ' . count($result) . "\n\n";
            foreach ($result as $value) {
                echo $value . "\n";
            }

            if ($_POST['dbTable']) {
                getDatabasequery($myDB,$_POST['dbTable']);
            }

            $myDB->close();
        }
    }

    ?>
    <section>
    <form action="db_name.php" method="post">

        <label for="id1">Databae name:</label>
        <input type="text" id='id1' name="dbName" value="<?php echo $_POST['dbName'] ?? ''; ?>">

        <input type="text" name="dbTable" >

        <input type="submit" name="submit">
    </form>
    </section>
    </pre>
</body>

</html>