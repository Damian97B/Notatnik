<?php

declare(strict_types=1);

namespace App;

require_once ('src/utils/debug.php');
require_once('src/View.php');
$test = 'test';
// dump($test);
$action = $_GET['action']?? null;
// równoznaczne z tym powyższym
// if (!empty($_GET['action'])){
//     $action = $_GET['action'];
// } else {
//     $action = null;
// }

$view = new View();
$view->render($action);
// dump($view); 


?>