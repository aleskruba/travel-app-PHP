<?php
require_once './constants/constants.php';
use Core\App;
use Core\Database;
use Models\Tour;

// Resolve dependencies
$db = App::resolve(Database::class);

$heading = 'spolucesty';
$emptyParam = false;

// Instantiate Tour model
$tourModel = new Tour($db);




require 'views/spolucestaNew.view.php';
?>
