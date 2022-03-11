<?php

$date = new DateTime('15-01-2001');
$date->add(new DateInterval('P11D'));
echo $date->format('d-m-Y') . "\n";
