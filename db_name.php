<!DOCTYPE html>
<html>

<head>
    <title>PHP Execution Results</title>
    <link rel="stylesheet" href="style.css">
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
                echo "\n\n";
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
            $Tablenames = getDatabaseTables($myDB);
            echo 'lenght :  ' . count($Tablenames) . "\n\n";
            foreach ($Tablenames as $value) {
                echo $value . "\n";
            }

            if ($_POST['dbTable']) {
                getDatabasequery($myDB, $_POST['dbTable']);
            }

            $myDB->close();
        }
    }

    ?>
    <section>
    <form action="db_name.php" method="post">

        <label for="id1">Databae name:</label>
        <!-- <input type="text" id='id1' name="dbName" value="<?php //echo $_POST['dbName'] ?? ''; 
                                                                ?>"> -->
        <select name="dbName">
            <?php foreach ($databases as $name) { ?>
                <option value="<?php echo $name; ?>" <?php if ($name == $_POST['dbName']) {
                                                            echo 'selected="selected"';
                                                        } ?>><?php echo $name; ?></option>
            <?php } ?>
        </select>

        <label for="id2">tables name:</label>
        <input type="text" name="dbTable" value="<?php echo $_POST['dbTable'] ?? ''; ?>" >

        <input type="submit" name="submit">
    </form>
    </section>
    </pre>
</body>

</html>