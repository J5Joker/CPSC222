<?php

session_start();

// Password Hash (SHA-256)
function hashPassword($password) {
    return hash('sha256', $password);
}

// Authentication of User
function authenticate($username, $password) {
    $authFile = "auth.db";
    $users = file($authFile, FILE_IGNORE_NEW_LINES);
    foreach ($users as $user) {
        list($uname, $hashedPassword) = explode(":", $user);
        if ($uname === $username && hashPassword($password) === $hashedPassword) {
            return true;
        }
    }
    return false;
}

// The Exoskeleton
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashedPassword = hashPassword($password);
    if (authenticate($username, $password)) {
        $_SESSION['username'] = $username;
        showDashboard($username);
    } else {
        showLoginPage("Invalid username or password");
    }
} elseif (isset($_POST['logout'])) {
    logout();
} elseif (isset($_SESSION['username'])) {
    showDashboard($_SESSION['username']);
} elseif (isset($_GET['page']) && $_GET['page'] == 'logout') {
    logout();
} else {
    showLoginPage();
}

// Login Page
function showLoginPage($error = '') {
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>CPSC222 Final Exam</title>";
    echo "</head>";
    echo "<body>";
    echo "<div class='container'>";
    echo "<h2>CPSC222 Final Exam</h2>";
    if ($error) {
        echo "<p style='color:red;'>$error</p>";
    }
    echo "<form method='post' action='final.php'>";
    echo "<table>";
    echo "<tr><td><label for='username'>Username:</label></td><td><input type='text' id='username' name='username' required></td></tr>";
    echo "<tr><td><label for='password'>Password:</label></td><td><input type='password' id='password' name='password' required></td></tr>";
    echo "</table>";
    echo "<input type='submit' value='Login'>";
    echo "</form>";
    echo "<footer>";
    echo "<hr>";
    echo "<br>";
    date_default_timezone_set('America/New_York');
    $timestamp = date('Y-d-m h:i:s A');
    echo $timestamp;
    echo "</footer>";
    echo "</div>";
    echo "</body>";
    echo "</html>";
}

// Logout Function
function logout() {
    session_unset();
    session_destroy();
    header("Location: final.php");
}

// Dashboard
function showDashboard($username) {
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>CPSC222 Final Exam</title>";
    echo "</head>";
    echo "<body>";
    echo "<div class='container'>";
    echo "<h2>CPSC222 Final Exam</h2>";
    echo "<h3>Welcome, $username! <form method='post' action='final.php'><input type='hidden' name='logout' value='true'><input type='submit' value='Logout'></form></h3>";
    // Dashboard Check
    if (!isset($_GET['page'])) {
        echo "<p>Dashboard:</p>";
        echo "<ul>";
        echo "<li><a href='final.php?page=userlist'>User List</a></li>";
        echo "<li><a href='final.php?page=grouplist'>Group List</a></li>";
        echo "<li><a href='final.php?page=syslog'>Syslog</a></li>";
        echo "</ul>";
    } else {
        // Dashboard Return Link
        echo "<br>";
        echo "<a href='final.php'> < Back to Dashboard</a>";
        echo "<br>";
        echo "<br>";
    }
    echo "</div>";

    // Page Displays
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        switch ($page) {
            case 'userlist':
                echo "<h3>User List</h3>";
                echo "<table border='1'>";
                echo "<tr><th>Username</th><th>Password</th><th>UID</th><th>GID</th><th>Display Name</th><th>Home Directory</th><th>Default Shell</th></tr>";
                $passwdContent = file_get_contents('/etc/passwd');
                $users = explode("\n", $passwdContent);
                foreach ($users as $user) {
                    $fields = explode(":", $user);
                    echo "<tr>";
                    foreach ($fields as $field) {
                        echo "<td>$field</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
                break;
            case 'grouplist':
                echo "<h3>Group List</h3>";
                echo "<table border='1'>";
                echo "<tr><th>Group Name</th><th>Password</th><th>GID</th><th>Users</th></tr>";
                $groupContent = file_get_contents('/etc/group');
                $groups = explode("\n", $groupContent);
                foreach ($groups as $group) {
                    $fields = explode(":", $group);
                    echo "<tr>";
                    foreach ($fields as $field) {
                        echo "<td>$field</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
                break;
            case 'syslog':
                echo "<h3>Syslog</h3>";
                echo "<table border='1'>";
                echo "<tr><th>Date</th><th>Hostname</th><th>Application[PID]</th><th>Message</th></tr>";
                $syslogContent = file('/var/log/syslog');
                foreach ($syslogContent as $line) {
                    preg_match('/^(\w{3} \d{1,2} \d{2}:\d{2}:\d{2}) (\S+) (\S+): (.+)$/', $line, $matches);
                    if (count($matches) == 5) {
                        $date = $matches[1];
                        $hostname = $matches[2];
                        $application = $matches[3];
                        $message = $matches[4];
                        echo "<tr><td>$date</td><td>$hostname</td><td>$application</td><td>$message</td></tr>";
                    }
                }
                echo "</table>";
                break;
            default:
                echo "Invalid page";
                break;
        }
    }

    echo "<footer>";
    echo "<hr>";
    echo "<br>";
    date_default_timezone_set('America/New_York');
    $timestamp = date('Y-d-m h:i:s A');
    echo $timestamp;
    echo "</footer>";

    echo "</body>";
    echo "</html>";
}


?>
