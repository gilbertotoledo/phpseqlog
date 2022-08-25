<?php
class SeqLog{
    private $seqUri;
    private $apiKey;
    private $minimumLogLevel;

    function __construct($seqUri, $apiKey, $minimumLogLevel: LogLevel = LogLevel::Warning){
        $this->seqUri = $seqUri . "/api/events/raw?clef";
        $this->apiKey = $apiKey;
        $this->minimumLogLevel = $minimumLogLevel;
    }

    public function IsEnabled($logLevel::LogLevel){
        return $this->minimumLogLevel <= $logLevel;
    }

    public function CurrentLevel(){
        return $this->minimumLogLevel;
    }

    public function Trace($message){
        $this->Log(LogLevel::Trace, null, $message, null);
    }

    public function Trace($message, $params){
        $this->Log(LogLevel::Trace, null, $message, $params);
    }

    public function Trace($exception, $message, $params){
        $this->Log(LogLevel::Trace, $exception, $message, $params);
    }

    public function Debug($message){
        $this->Log(LogLevel::Debug, null, $message, null);
    }

    public function Debug($message, $params){
        $this->Log(LogLevel::Debug, null, $message, $params);
    }

    public function Debug($exception, $message, $params){
        $this->Log(LogLevel::Debug, $exception, $message, $params);
    }

    public function Information($message){
        $this->Log(LogLevel::Information, null, $message, null);
    }

    public function Information($message, $params){
        $this->Log(LogLevel::Information, null, $message, $params);
    }

    public function Information($exception, $message, $params){
        $this->Log(LogLevel::Information, $exception, $message, $params);
    }

    public function Warning($message){
        $this->Log(LogLevel::Warning, null, $message, null);
    }

    public function Warning($message, $params){
        $this->Log(LogLevel::Warning, null, $message, $params);
    }

    public function Warning($exception, $message, $params){
        $this->Log(LogLevel::Warning, $exception, $message, $params);
    }

    public function Error($message){
        $this->Log(LogLevel::Error, null, $message, null);
    }

    public function Error($message, $params){
        $this->Log(LogLevel::Error, null, $message, $params);
    }

    public function Error($exception, $message, $params){
        $this->Log(LogLevel::Error, $exception, $message, $params);
    }

    public function Critical($message){
        $this->Log(LogLevel::Critical, null, $message, null);
    }

    public function Critical($message, $params){
        $this->Log(LogLevel::Critical, null, $message, $params);
    }

    public function Critical($exception, $message, $params){
        $this->Log(LogLevel::Critical, $exception, $message, $params);
    }

    public function Log($logLevel, $exception, $message, $params){
        if(!$this->IsEnabled($logLevel)){
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
            //TO DO Add params to $logData
        }

        if($exception != null){
            $logData["@x"] = $exception;
        }

        return $this->Post($logData);
    }

    private function Post($logData){
        $options = [
            'http' => [
                'header'  => "Content-type: application/vnd.serilog.clef\r\nX-Seq-ApiKey: $this->apiKey\r\n",
                'method'  => 'POST',
                'content' => json_encode($logData)
            ]
        ];
        $context  = stream_context_create($options);
        return file_get_contents($this->seqUri, false, $context) !== false;
    }
}

enum LogLevel : int{
	case Trace = 0;
	case Debug = 1;
	case Information = 2;
	case Warning = 3;
	case Error = 4;
    case Critical = 5;
	
	public function toString(): string {
        return match ($this) {
            LogLevel::Trace => 'Trace',
            LogLevel::Debug => 'Debug',
            LogLevel::Information => 'Information',
            LogLevel::Warning => 'Warning',
            LogLevel::Error => 'Error',
            LogLevel::Critical => 'Critical'
        };
    }
}
?>
