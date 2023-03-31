<?php
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
