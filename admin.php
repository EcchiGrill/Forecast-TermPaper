<?php
session_start();

$servername = "localhost";
$username = "root";

$conn = new mysqli($servername, $username);

if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}

$sql_create_db = "CREATE DATABASE IF NOT EXISTS weather";
if ($conn->query($sql_create_db) === FALSE) {
    echo "Помилка при створенні бази даних: " . $conn->error;
}

$conn->select_db("weather");

$sql_create_weather_table = "CREATE TABLE IF NOT EXISTS forecast (
    id INT AUTO_INCREMENT PRIMARY KEY,
    city VARCHAR(50) NOT NULL,
    date DATE,
    temperature INT,
    pressure INT,
    humidity INT,
    wind INT
)";

if ($conn->query($sql_create_weather_table) === TRUE) {
    echo "<script>console.log('Таблиці створені успішно або вже існують')</script>";
} else {
    echo "<script>console.log('Помилка при створенні таблиць')</script>" . $conn->error;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $city = $_POST["city"];
    $date = $_POST["date"];
    $temperature = $_POST["temperature"];
    $pressure = $_POST["pressure"];
    $humidity = $_POST["humidity"];
    $wind = $_POST["wind"];

    if (empty($city) || empty($date) || empty($temperature) || empty($pressure) || empty($humidity) || empty($wind)) {
        $_SESSION['message'] = "<h2 style='color: red'>Будь ласка, заповніть всі поля</h2>";
    } else {
        $sql_check_existing = "SELECT * FROM forecast WHERE city='$city' AND date='$date'";
        $result = $conn->query($sql_check_existing);

        if ($result->num_rows > 0) {
            $sql_update = "UPDATE forecast SET temperature='$temperature', pressure='$pressure', humidity='$humidity', wind='$wind' WHERE city='$city' AND date='$date'";
            if ($conn->query($sql_update) === TRUE) {
                $_SESSION['message'] = "<h2 style='color: green'>Прогноз погоди успішно оновлено</h2>";
            } else {
                $_SESSION['message'] = "<h2 style='color: red'>Помилка: </h2>" . $conn->error;
            }
        } else {
            $sql_insert = "INSERT INTO forecast (city, date, temperature, pressure, humidity, wind) VALUES ('$city', '$date', '$temperature', '$pressure', '$humidity', '$wind')";
            if ($conn->query($sql_insert) === TRUE) {
                $_SESSION['message'] = "<h2 style='color: green'>Прогноз погоди успішно додано</h2>";
            } else {
                $_SESSION['message'] = "<h2 style='color: red'>Помилка: </h2>" . $sql_insert . "<br>" . $conn->error;
            }
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.php">
    <title>Адмін-панель</title>
</head>

<body>
    <h1>Додати прогноз погоди</h1>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label>Місто: </label><input type="text" name="city"><br><br>
        <label>Дата: </label><input type="date" name="date"><br><br>
        <label>Температура, °C: </label><input type="number" name="temperature"><br><br>
        <label>Тиск, мм: </label><input type="number" name="pressure"><br><br>
        <label>Вологість, %: </label><input type="number" name="humidity"><br><br>
        <label>Вітер, м/c: </label><input type="number" name="wind"><br><br>
        <input class="submit" type="submit" name="submit" value="Додати">
    </form>

    <?php
    if (isset($_SESSION['message'])) {
        echo ($_SESSION['message']);
        unset($_SESSION['message']);
    }
    ?>

</body>

</html>