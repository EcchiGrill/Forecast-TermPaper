<?php
$servername = "localhost";
$username = "root";

$conn = new mysqli($servername, $username);

$conn->select_db("weather");

if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}

$sql_cities = "SELECT DISTINCT city FROM forecast";
$cities_result = $conn->query($sql_cities);

function getDayOfWeek($date)
{
    $daysOfWeek = [
        'Sunday' => 'Неділя',
        'Monday' => 'Понеділок',
        'Tuesday' => 'Вівторок',
        'Wednesday' => 'Середа',
        'Thursday' => 'Четвер',
        'Friday' => 'П’ятниця',
        'Saturday' => 'Субота'
    ];
    $dateTime = new DateTime($date);
    $dayOfWeek = $dateTime->format('l');
    return $daysOfWeek[$dayOfWeek];
}

function getMonth($date)
{
    $months = [
        'January' => 'січня',
        'February' => 'лютого',
        'March' => 'березня',
        'April' => 'квітня',
        'May' => 'травня',
        'June' => 'червня',
        'July' => 'липня',
        'August' => 'серпня',
        'September' => 'вересня',
        'October' => 'жовтня',
        'November' => 'листопада',
        'December' => 'грудня'
    ];
    $dateTime = new DateTime($date);
    $month = $dateTime->format('F');
    return $months[$month];
}

function getDay($date)
{
    $dateTime = new DateTime($date);
    return ltrim($dateTime->format('d'));
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Прогноз погоди</title>
    <link rel="stylesheet" href="style.php">
</head>

<body>
    <div class="weather_container">
        <div class="weather_block">
            <h1>Прогноз погоди</h1>
            <form method="post" action="">
                <div class="city_container">
                    <label for="city_select">Виберіть місто:</label>
                    <select name="city" id="city_select">
                        <?php
                        if ($cities_result->num_rows > 0) {
                            while ($row = $cities_result->fetch_assoc()) {
                                echo "<option value='" . $row['city'] . "'>" . $row['city'] . "</option>";
                            }
                        } else {
                            echo "<option value='' disabled>Немає доступних міст</option>";
                        }
                        ?>
                    </select><br>
                </div>
                <div class="date_container">
                    <label for="date_select">Виберіть дату:</label>
                    <input class="date" type="date" name="date"></input><br>
                </div>
                <input class="submit" type="submit" value="Показати прогноз">
            </form>
        </div>
        <?php
        $selected_city = '';
        $selected_date = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $selected_city = $_POST["city"];
            $selected_date = $_POST["date"];
        } else {
            $today = date('Y-m-d');
            $selected_date = $today;
            $selected_city = 'Київ';
        }

        if ($selected_city && $selected_date) {
            $sql_forecast = "SELECT * FROM forecast WHERE city = '$selected_city' AND date = '$selected_date'";
            $forecast_result = $conn->query($sql_forecast);

            if ($forecast_result->num_rows > 0) {
                while ($row = $forecast_result->fetch_assoc()) {
                    $dayOfWeek = getDayOfWeek($row["date"]);
                    $day = getDay($row["date"]);
                    $month = getMonth($row["date"]);
                    echo
                        "<div class='forecast_container'>" .
                        "<div class='forecast_date'>" .
                        "<strong> $dayOfWeek </strong><br>" .
                        "<strong> $day </strong><br>" .
                        "<strong> $month </strong>" .
                        "</div>" .
                        "<div class='forecast_text'>" .
                        "<strong>Температура: " . $row["temperature"] . "<span> °C</span></strong>" .
                        "<strong>Тиск: " . $row["pressure"] . "<span> мм</span></strong>" .
                        "<strong>Вологість: " . $row["humidity"] . "<span> %</span></strong>" .
                        "<strong>Вітер: " . $row["wind"] . "<span> м/c</span></strong>" .
                        "</div>" .
                        "</div>";
                }
            } else {
                echo "Немає даних про прогноз погоди для обраної дати";
            }
        }
        ?>
    </div>
</body>

</html>