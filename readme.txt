
============================================================================================
                             Clan CMS Read Me
============================================================================================


This is a quick guide on how to get set up with Clan CMS. Please feel free to contact us through the
Xcel Gaming forums for additional support.

Thanks,
Xcel Gaming
http://xcelgaming.com

-----REQUIREMENTS-----

PHP version 5.1.6 or greater
MySQL version 4.1 or greater
The mod_rewrite Apache module

-----INSTALLATION-----

1) Upload all the files to your server

2) Create a MySQL database and remember the details (Database name, Database username, Database password)

3) Visit http://yoursite.com/install/ and follow the step by step installation guide

4) After you install the script you need to remove the installation files. Either by clicking "Resolve Now" on the Installation file alert in the Admin CP or
by manually deleting the "clancms/controllers/install.php", "clancms/libraries/Installer.php", and the "clancms/views/install/" folder.

5) After you have done all of this you will be able to login to the Admin CP and start managing your site.

-----TROUBLESHOOTING-----

If you are using GoDaddy or the installation guide is not appearing then follow the steps below:

1) Open up .htaccess file in the root directory and change
#RewriteBase /
to
RewriteBase /

2) Save and close the file and refresh to see if you can get to the installation guide. If you are still having issues please contact us on the Xcel Gaming Forums.