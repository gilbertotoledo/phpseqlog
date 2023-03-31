<?php
require_once("../src/Seqlog.php");

Seqlog::Config("[SEQ_URI]", "[SEQ_APIKEY]", LogLevel::Information);

try {
    SeqLog::Debug("Trying to run specific method...");

    throw new Exception("Generic error!");
} catch(Exception $ex) {
    SeqLog::LogError($ex, "An error has ocurred");
}
?>