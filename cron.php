<?php

use includes\cron;

$cron_handlers = [
    'AutoRelistAuctions', // This must happen before closing auctions
    'SendBulkEmailUpdates',
    'PurgeThumbCache',
    'PurgeOldData',
    'ResyncCounters' // This should run last
];

include INCLUDE_PATH . 'functions_cron.php';

$query = "SELECT * FROM " . $DBPrefix . "cron_log";
$db->direct_query($query);
$last_ran = [];
while ($row = $db->fetch()) {
    $last_ran[$row['handler']] = $row['last_ran'];
}

// load each cron handler class
foreach ($cron_handlers as $handler) {
    $handlerClass = new $handler;
    if ($handlerClass->canRun($last_ran[$handler])) {
        $handlerClass->handle();
    }
}
