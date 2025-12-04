<?php
require_once 'config.php';

//fazer Logout
session_unset();
session_destroy();

//redirecina para login
header('location: login.php');
exit;
