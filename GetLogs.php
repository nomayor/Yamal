<?php


$Logs = file_get_contents('/var/www/html/LOGGING/ConfigApplied.txt', true);

echo nl2br($Logs);


?>