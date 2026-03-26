<?php
echo "Current Folder Path: " . __DIR__;
echo "<br>";
echo "Is update_status.php exist?: " . (file_exists(__DIR__ . '/training/db/update_status.php') ? 'YES' : 'NO');