<?php
require_once("./LogLevel.php");

class SeqLog{
    private static $seqUri;
    private static $apiKey;
    private static $minimumLogLevel;

    public static function Config(string $seqUri, string $apiKey, LogLevel $minimumLogLevel = LogLevel::Warning){
        self::$seqUri = $seqUri."/api/events/raw?clef";
        self::$apiKey = $apiKey;
        self::$minimumLogLevel = $minimumLogLevel;
    }

    public static function IsEnabled(LogLevel $logLevel){
        return self::$minimumLogLevel <= $logLevel;
    }

    public static function CurrentLevel(): LogLevel{
        return self::$minimumLogLevel;
    }

    public static function Trace($message){
        return self::Log(LogLevel::Trace, null, $message, null);
    }

    public static function Trace($message, $params){
        return self::Log(LogLevel::Trace, null, $message, $params);
    }

    public static function Trace($exception, $message, $params){
        return self::Log(LogLevel::Trace, $exception, $message, $params);
    }

    public static function Debug($message){
        return self::Log(LogLevel::Debug, null, $message, null);
    }

    public static function Debug($message, $params){
        return self::Log(LogLevel::Debug, null, $message, $params);
    }

    public static function Debug($exception, $message, $params){
        return self::Log(LogLevel::Debug, $exception, $message, $params);
    }

    public static function Information($message){
        return self::Log(LogLevel::Information, null, $message, null);
    }

    public static function Information($message, $params){
        return self::Log(LogLevel::Information, null, $message, $params);
    }

    public static function Information($exception, $message, $params){
        return self::Log(LogLevel::Information, $exception, $message, $params);
    }

    public static function Warning($message){
        return self::Log(LogLevel::Warning, null, $message, null);
    }

    public static function Warning($message, $params){
        return self::Log(LogLevel::Warning, null, $message, $params);
    }

    public static function Warning($exception, $message, $params){
        return self::Log(LogLevel::Warning, $exception, $message, $params);
    }

    public static function Error($message){
        return self::Log(LogLevel::Error, null, $message, null);
    }

    public static function Error($message, $params){
        return self::Log(LogLevel::Error, null, $message, $params);
    }

    public static function Error($exception, $message, $params){
        return self::Log(LogLevel::Error, $exception, $message, $params);
    }

    public static function Critical($message){
        return self::Log(LogLevel::Critical, null, $message, null);
    }

    public static function Critical($message, $params){
        return self::Log(LogLevel::Critical, null, $message, $params);
    }

    public static function Critical($exception, $message, $params){
        return self::Log(LogLevel::Critical, $exception, $message, $params);
    }

    public static function Log(LogLevel $logLevel, $exception, $message, $params){
        if(!self::IsEnabled($logLevel)){
            return;
        }

        date_default_timezone_set('America/Sao_Paulo');
        $now = date('c', time());

        $logData = [
            "@t" => $now,
            "@l" => $logLevel->toString(),
        ];

        if($params == null){
            $logData["@m"] = $message;
        }else{
            $logData["@mt"] = $message;
            $logData = array_merge($logData, $params);
        }

        if($exception != null){
            $logData["@x"] = $exception;
        }

        return self::Post($logData);
    }

    private static function Post($logData){
        $options = [
            'http' => [
                'header'  => "Content-type: application/vnd.serilog.clef\r\nX-Seq-ApiKey: ".self::$apiKey."\r\n",
                'method'  => 'POST',
                'content' => json_encode($logData)
            ]
        ];
        $context  = stream_context_create($options);

        return file_get_contents(self::$seqUri, false, $context) !== false;
    }
}
?>
