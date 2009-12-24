<?php
//0.8.5 to 1.0.0
$query[] = "ALTER TABLE  `" . $DBPrefix . "settings` DROP uniqueseller, DROP pagewidth, DROP pagewidthtype, DROP background, DROP brepeat;";
$query[] = "DROP TABLE IF EXISTS `" . $DBPrefix . "fontsandcolors`;";

?>