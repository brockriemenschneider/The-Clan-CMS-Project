
============================================================================================
                             Clan CMS Read Me
============================================================================================


This is a quick guide on how to get set up with Clan CMS. Please feel free to contact us through the
Xcel Gaming forums for additional support.

Thanks,
Xcel Gaming
http://xcelgaming.com

-----REQUIREMENTS-----

PHP version 4.3.2 or greater
MySQL version 4.1 or greater
The mod_rewrite Apache module

-----INSTALLATION-----

1) Upload all the files to your server

2) Create a MySQL database and remember the details (Database name, Database username, Database password)

3) Visit http://yoursite.com/install/ and follow the step by step installation guide

4) After you install the script you need to remove the installation files. Either by clicking "Resolve Now" on the Installation file alert in the Admin CP or
by manually deleting the "clancms/controllers/install.php", "clancms/libraries/Installer.php", and the "clancms/views/install/" folder.

5) After you have done all of this you will be able to login to the Admin CP and start managing your site.

-----UPDATING-----

1) If your version is less then 0.5.3 then you must manual update to v0.5.3, otherwise go to step 2.

2) Rename the zip to Update.zip and upload the the root of the installation.

3) OPEN clancms/libraries/Unzip.php
FIND function extract($file, $destination)
REPLACE WITH function extract($file, $destination = '')
SAVE AND CLOSE

4) Click "Resolve Now" in Admin CP for pending manaual update.

-----F.A.Q-----

Q: I have mod_rewrite but it still isn't working. What do I do?

A: You may have to turn on QUERY STRING by following this simple process:

OPEN clancms/config/config.php
FIND $config['uri_protocol'] = "AUTO";
REPLACE WITH $config['uri_protocol'] = "QUERY_STRING";
SAVE AND CLOSE

OPEN .htaccess
FIND 
RewriteRule ^(.*)$ ./index.php/$1 [L,QSA]
REPLACE WITH 
RewriteRule ^(.*)$ ./index.php?/$1 [L,QSA]
SAVE AND CLOSE
