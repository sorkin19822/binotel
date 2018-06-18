<?php

error_reporting(E_ALL);

$str='https://dobro-clinic.com/hirurgija-jendoskopicheskaja/lecheniye-raka-tolstoy-kishki?gclid=EAIaIQobChMI6PrJ-ryU2wIVVYXVCh3p0wg8EAAYASAAEgKyffD_BwE';

$res = (strlen($str)<254) ? $str : substr($str,0,254);
var_dump($res);