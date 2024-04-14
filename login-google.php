<?php
require_once 'config.php';

if (isset($_SESSION['user_token'])) {
  header("Location: http://localhost/laboratory6.php/laboratory6/index.php");
} else {
  echo "<a href='" . $client->createAuthUrl() . "'>Google Login</a>";
}
