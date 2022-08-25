# PHP SeqLog client

A Seq client for logging in PHP

Usage
```
require_once("./src/SeqLog.php");

$logger = new Seqlog("https://YOUR_SEQ_URI", "YOUR_API_KEY");

$logger->Trace("Call log");
$logger->Debug("Call log");
$logger->Information("Call log");
$logger->Warning("Call log");
$logger->Critical("Call log");

```

With Exceptions

```
$logger->Trace($exception, "Call log");
$logger->Debug($exception, "Call log");
$logger->Information($exception, "Call log");
$logger->Warning($exception, "Call log");
$logger->Critical($exception, "Call log");
```
