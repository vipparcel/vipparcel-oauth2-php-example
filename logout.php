<?php
$c = require_once '_config.php';
session_start();
session_destroy();
header('Location: '.$c['script_url']);