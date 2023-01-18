<?php

const LOG_FILE = '/var/www/html/worker.log';
const WORKER_SCRIPT = __DIR__.'/spawn_worker.php';
const INTERPRETER = '/usr/bin/php';


// Handly consts

const LCB = '{';
const RCB = '}';
const SP = ' ';
const SP2 = '  ';
const SP3 = '   ';
const SP4 = '    ';
const SP5 = '     ';
const SP6 = '      ';
const SP7 = '       ';
const SP8 = '        ';
const SP9 = '         ';
const SP10 = '          ';
const LF = "\n";
const CR = "\r";
const CRLF = CR.LF;
const TAB = "\t";

// Setup shared log file between web and worker
// NOTE: The web process owner and the worker process owner must have write to this file!
ini_set('error_log',        LOG_FILE);

// Temporary global values
$PID = getmypid();

// Setup $LPF aka the Log PreFix -- put at start of error_log for reference or use print_log() helper func
if(isset($LPF)) {
    $LPF = LCB."$LPF:$PID".RCB.SP;   // You can set $LPF before including the config to set the prefix of the prefix ;)
} else {
    $LPF = "[$PID] ";
}

function print_log($val) {
    global $LPF;
    if(is_array($val) || is_object($val)) {
        $val = json_encode($val, JSON_PRETTY_PRINT);
    }
    $val = str_replace([TAB, LF, SP10, SP9, SP8, SP7, SP6, SP5, SP4, SP2], SP, $val);
    error_log($LPF.$val);
}

function get_opt($opt_name, $default = 'NONE') {
    global $argv;
    //DEBUG error_log('Looking for '.$opt_name);    
    //DEBUG error_log(print_r($argv, true));
    foreach($argv as $actual_argument_value) {
        //DEBUG error_log('arg:'.$actual_argument_value);
        if(str_starts_with(needle: '--'.$opt_name, haystack: $actual_argument_value)) {
            //DEBUG error_log('Found: `'.$actual_argument_value.'` starts with  `--'.$opt_name.'`');
            $actual_argument_value = explode(separator: '=', string: $actual_argument_value);
            // Remove first argument to remove option part
            array_shift($actual_argument_value);
            $actual_argument_value = implode(separator: '=', array: $actual_argument_value); // recombine in case there were multiple = characters in the value
            return $actual_argument_value;
        } else {
            //DEBUG error_log('`'.$actual_argument_value.'` does not start with `--'.$opt_name.'`');
        }
    }
    return $default;
}