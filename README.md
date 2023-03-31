# PHP SeqLog client

A Seq client for logging in PHP

Usage with constructor
```
require_once("./src/SeqLog.php");

Seqlog::Config("https://YOUR_SEQ_URI", "YOUR_API_KEY");

$SeqLog::Trace("Call log");
$SeqLog::Debug("Call log");
$SeqLog::Information("Call log");
$SeqLog::Warning("Call log");
$SeqLog::Critical("Call log");

```

With Exceptions

```
$SeqLog::Trace($exception, "Call log");
$SeqLog::Debug($exception, "Call log");
$SeqLog::Information($exception, "Call log");
$SeqLog::Warning($exception, "Call log");
$SeqLog::Critical($exception, "Call log");
```
