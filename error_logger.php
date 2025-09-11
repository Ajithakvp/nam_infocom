<?php
// === Daily Error Logger ===
function logError($message)
{
    $logDir = __DIR__ . "/logs";   // store logs inside 'logs' folder
    if (!is_dir($logDir)) {
        mkdir($logDir, 0777, true); // create if missing
    }

    $date = date("Y-m-d");
    $logFile = $logDir . "/error-$date.txt";

    $time = date("H:i:s");
    $errorMsg = "[$date $time] $message" . PHP_EOL;

    file_put_contents($logFile, $errorMsg, FILE_APPEND);
}

// === Catch PHP Warnings & Fatal Errors ===
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    logError("PHP Error [$errno]: $errstr in $errfile on line $errline");
    return true; // prevent default error handler
});

set_exception_handler(function ($exception) {
    logError("Uncaught Exception: " . $exception->getMessage() . " in " . $exception->getFile() . " on line " . $exception->getLine());
});

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error !== null) {
        logError("Fatal Error: {$error['message']} in {$error['file']} on line {$error['line']}");
    }
});
