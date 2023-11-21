<?php

$country = $_GET['country'];
$all = isset($_GET['all']) ? $_GET['all'] : false;
$host = 'localhost';
$username = 'lab5_user';
$password = '';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

if ($all) {
    $stmt = $conn->query("SELECT * FROM countries");
} elseif (!empty($country)) {
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $stmt->bindValue(':country', "%$country%", PDO::PARAM_STR);
    $stmt->execute();
} else {
    // Handle the case where no country is provided
    echo 'Please provide a country name.';
    exit;
}

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['lookup']) && $_GET['lookup'] === 'cities') {
    // Handle city lookup
    $stmt = $conn->prepare("SELECT cities.name AS city_name, cities.district, cities.population
                           FROM cities
                           JOIN countries ON cities.country_code = countries.code
                           WHERE countries.name LIKE :country");
    $stmt->bindValue(':country', "%$country%", PDO::PARAM_STR);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the results as an HTML table
    echo '<table border="1">';
    echo '<tr><th>Name</th><th>District</th><th>Population</th></tr>';
    foreach ($results as $row) {
        echo '<tr>';
        echo '<td>' . $row['city_name'] . '</td>';
        echo '<td>' . $row['district'] . '</td>';
        echo '<td>' . $row['population'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    // Output the country information as before
    echo '<ul>';
    foreach ($results as $row) {
        echo '<li>' . $row['name'] . ' is ruled by ' . $row['head_of_state'] . '</li>';
    }
    echo '</ul>';
}
?>