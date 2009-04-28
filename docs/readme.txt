WeBid, the free auction script

For recent updates etc. visit.
http://sourceforge.net/projects/simpleauction
http://www.webidsupport.com/

WeBid is an opensource program and released under GPL

INSTALLATION
--------------------------------------------------------
1. Upload all the files except the docs directory
2. CHMOD the uploaded directory to 0777
3. CHMOD the includes/config.inc.php to 0777
4. CHMOD the includes/countries.inc.php to 0777
5. CHMOD the includes/membertypes.inc.php to 0777
6. CHMOD the language/EN/categories.inc.php to 0777
7. CHMOD the language/EN/categories_select_box.inc.php to 0777
8. CHMOD the cache directory to 0777
9. go to http://yoursite/webid/install/install.php and follow the steps

For a more detailed set of instructions read install.txt

UPDATING WeBid
--------------------------------------------------------
1. Upload all the files except the docs directory
2. CHMOD the uploaded directory to 0777
3. CHMOD the includes/config.inc.php to 0777
4. CHMOD the includes/countries.inc.php to 0777
5. CHMOD the includes/membertypes.inc.php to 0777
6. CHMOD the language/EN/categories.inc.php to 0777
7. CHMOD the language/EN/categories_select_box.inc.php to 0777
8. CHMOD the cache directory to 0777
9. go to http://yoursite/webid/install/update.php and follow the steps
10. go to http://localhost/WeBid/admin/index.php -> SETTINGS -> Categories Table and click process changes to update the category files
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