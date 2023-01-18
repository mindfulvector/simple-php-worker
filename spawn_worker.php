<?php

include 'spawn_config.php';

$WORKER_NAME = get_opt('name');

print_log("New spawn worker with PID #$PID, named `$WORKER_NAME` started!");
print_log(['{!argc}' => $argc, '{!argv}' => $argv]);

for($i = 1; $i < 5; $i ++) {
    print_log('Loop iteration '.$i.' sleeping!');
    sleep(rand(1, $i));
}

print_log("Worker #$PID named `$WORKER_NAME` done!");