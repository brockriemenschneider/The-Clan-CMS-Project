=================================================================================
                                 co[dezyne] fork README
=================================================================================

[ 11 January, 2012 ]

Initial Commit from forked project: The-Clan-CMS-Project version 0.6.2

*** Changelog

SQUAD ROSTER MCV has been extended, removing the squad tag and replacing it with squad icons.

ARTICLES MCV has been extended, adding the article header functionality.

SHOUTBOX WIDGET and SHOUT MCV added.  The widget requires the SHOUT MCV in order to view shout history and permit admin moderation of shouts.

Install database creation has been modified to create the required changes necessary to validate with my extensions.


*** Important Notes

For those only looking to update certain files, use the files in /DB Tables to alter your existing database tables.

The Media GALLERY MCV is currently in alpha development and too embedded in current structer to remove the the purposes of this git commit.


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
