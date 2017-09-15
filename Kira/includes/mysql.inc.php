<?php

DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'Kira');

$dbc = mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if(!isset($dbc))
    echo '<h1>Problem sa spajanjem na bazu podataka</h1>';


?>