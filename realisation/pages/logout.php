<?php
session_start();

// Clear Session
session_unset();
session_destroy();



header("Location: index.php");
exit();
