<?php

declare(strict_types=1);
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

function dump($data)
{
    echo '<div
    style="background: lightgray;
    border: solid 1px gray;
    ">
    <pre>';
    print_r($data);
    echo '</pre>
    </div>';
}

// dump('==== dump ===');



?>