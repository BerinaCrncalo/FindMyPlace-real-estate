<?php

class RequestLogger
{
    public static function logRequest()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN';
        $timestamp = date("Y-m-d H:i:s");

        $logEntry = "[$timestamp] [$ip] $method $uri [$userAgent]" . PHP_EOL;

        $logDir = __DIR__ . '/../logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }

        file_put_contents("$logDir/requests.log", $logEntry, FILE_APPEND);
    }
}
