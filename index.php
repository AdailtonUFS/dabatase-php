<?php

try {
    date_default_timezone_set('UTC');
    # substitua os dados
    $host = "";
    $port = "";
    $database = "";
    $user = "";
    $password = "";

    $dsn = "pgsql:host=$host;port=$port;dbname=$database;";
    $pdoConnection = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    function insertUser($pdoConnection, $cpf, $name, $email, $password)
    {
        $today = date("Y-m-d");
        $sql = "INSERT INTO users(cpf, name, email, password, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)";
        $statement = $pdoConnection->prepare($sql);
        $statement->bindValue(1, $cpf);
        $statement->bindValue(2, $name);
        $statement->bindValue(3, $email);
        $statement->bindValue(4, $password);
        $statement->bindValue(5, $today);
        $statement->bindValue(6, $today);
        $statement->execute();
    }

    function getUsers($pdoConnection)
    {
        $sql = "SELECT * FROM users";
        $result = $pdoConnection->query($sql);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    insertUser($pdoConnection, "111.111.111-11", "John Doe", "johndoe@gmail.com", "johndoe");

    $users = getUsers($pdoConnection);
    foreach ($users as $user) {
        echo $user->name . "\n";
    }
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
} catch (\Exception $e) {
    die("An Error Occurred: " . $e->getMessage());
}

