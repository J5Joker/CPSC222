<?php
function Input($data) {
    return htmlspecialchars(trim($data));
}

if(isset($_GET["isoDate"])) {
    $isoDate = $_GET["isoDate"];
    $formatedDate = "";
    $birthdate = date("F j, Y h:i A", strtotime($isoDate));
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $day = isset($_POST["day"]) ? Input($_POST["day"]) : "";
        $month = isset($_POST["month"]) ? Input($_POST["month"]) : "";
        $year = isset($_POST["year"]) ? Input($_POST["year"]) : "";
        $hour = isset($_POST["hour"]) ? Input($_POST["hour"]) : "";
        $minute = isset($_POST["minute"]) ? Input($_POST["minute"]) : "";
        $ampm = isset($_POST["ampm"]) ? Input($_POST["ampm"]) : "";

        $hour = ($ampm == "PM" && $hour != 12) ? $hour + 12 : $hour;
        $hour = ($ampm == "AM" && $hour == 12) ? 0 : $hour;

        $birthdate = "$year-$month-$day $hour:$minute:00";
        $formatedDate = date("F j, Y h:i A", strtotime($birthdate));
        $isoDate = date("Y-m-d H:i:s", strtotime($birthdate));
    } else {
        $formatedDate = "";
        $isoDate = "";
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
<div class="container">
    <h1>Birthday Formatter</h1>

    <?php if (isset($_GET["isoDate"])) : ?>
        <table border='1'>
            <tr>
                <?php echo $isoDate; ?>
            </tr>
        </table>
    <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST") : ?>
        <table border='1'>
            <tr>
                <?php echo $formatedDate; ?><br>
		<br>
            </tr>
                <a href='?isoDate=<?php echo urlencode($isoDate); ?>'>Show date in ISO Format</a>
            </tr>
        </table>
    <?php else : ?>
       <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <table border='1'>
        <tr>
            <th>Month</th>
            <th>Day</th>
            <th>Year</th>
            <th>Hour</th>
            <th>Minute</th>
            <th>AM/PM</th>
        </tr>
        <tr>
            <td>
                <select name="month" id="month" required>
                    <?php
                    $months = array(
                        "01" => "January", "02" => "February", "03" => "March", "04" => "April",
                        "05" => "May", "06" => "June", "07" => "July", "08" => "August",
                        "09" => "September", "10" => "October", "11" => "November", "12" => "December"
                    );
                    foreach ($months as $key => $value) : ?>
                        <option value='<?php echo $key; ?>'><?php echo $value; ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td>
                <select name="day" id="day" required>
                    <?php for ($i = 1; $i <= 31; $i++) : ?>
                        <option value='<?php echo $i; ?>'><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </td>
            <td>
                <select name="year" id="year" required>
                    <?php
                    $currentYear = date("Y");
                    $startYear = $currentYear - 100;
                    $endYear = $currentYear;
                    for ($i = $endYear; $i >= $startYear; $i--) : ?>
                        <option value='<?php echo $i; ?>'><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </td>
            <td>
                <select name="hour" id="hour" required>
                    <?php for ($i = 1; $i <= 12; $i++) : ?>
                        <option value='<?php echo $i; ?>'><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </td>
            <td>
                <select name="minute" id="minute" required>
                    <?php for ($i = 0; $i <= 59; $i++) : ?>
                        <option value='<?php echo sprintf("%02d", $i); ?>'><?php echo sprintf("%02d", $i); ?></option>
                    <?php endfor; ?>
                </select>
            </td>
            <td>
                <select name="ampm" id="ampm" required>
                    <option value="AM">AM</option>
                    <option value="PM">PM</option>
                </select>
            </td>
	</tr>
	<tr>
		<td colspan="7" style="text-align: center;">
                <input type="submit" value="Format Date" style="margin: 0 auto;">
            </td>
        </tr>
    </table>
</form>
    <?php endif; ?>
</div>
</body>
</html>
