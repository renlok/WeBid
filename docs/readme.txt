WeBid, the free auction script

For recent updates etc. visit.
http://sourceforge.net/projects/simpleauction
http://www.webidsupport.com/

WeBid is an opensource program and released under GPL.

We request you retain the full copyright notice placed in the footer with the link to www.webidsupport.com.
This not only gives respect to the large amount of time given freely by the developers but also helps
build interest, traffic and use of WeBid. If you (honestly) cannot retain the full copyright we
ask you at least leave in place the "Powered by WeBid" line, with "WeBid" linked to www.webidsupport.com.

INSTALLATION
--------------------------------------------------------
1. Upload all the files except the docs directory
2. CHMOD the uploaded directory to 0644
3. CHMOD the includes/config.inc.php.new to 0777
4. CHMOD the language/EN/categories.inc.php to 0777
5. CHMOD the language/EN/categories_select_box.inc.php to 0777
6. CHMOD the cache directory to 0777
7. go to http://yoursite/webid/install/install.php and follow the steps

For a more detailed set of instructions read install.txt

UPDATING WeBid
--------------------------------------------------------
1. Upload all the files except the docs directory
2. go to http://yoursite/webid/install/update.php and follow the steps
Note: if you have a custom template and it doesnt work on the new version check at http://www.webidsupport.com for help

ADDING A LANGUAGE
--------------------------------------------------------
1. Open the language directory and copy the entire EN folder, rename it to the abrviation of your language (e.g DL, NL, JP)
2. CHMOD the language/xx/categories.inc.php to 0777
3. CHMOD the language/xx/categories_select_box.inc.php to 0777
4. Translate every file in there.

MODS
--------------------------------------------------------
Well if you have made any fixes/mods for WeBid please feel free to share them at the link above