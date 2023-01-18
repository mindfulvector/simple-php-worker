<?php
header('Content-Type: text');
$LPF = 'www';
include 'spawn_config.php';

print_log('Web request recieved *****');

echo '<START| '.($START=date('Ymd')).'>'.PHP_EOL;

$args = [
    '--name='.substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz_"),0,8),
    '--iter='.rand(2,10),
];
$return = exec($CMD='/usr/bin/nohup '.INTERPRETER.' '.WORKER_SCRIPT.' '.implode(' ', $args).' > /dev/null 2>&1 &');
echo '<CMD| '.$CMD.'>'.PHP_EOL;

echo '<DONE| '.($DONE=date('Ymd')).'>'.PHP_EOL;

if($START != $DONE) {
    echo '<ERROR| that took too long!>'.PHP_EOL;
} else {
    echo '<RESULT| seems to have instantly returned!>'.PHP_EOL;
}
