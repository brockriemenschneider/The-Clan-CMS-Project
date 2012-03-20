============================================================================================
                             co[dezyne] ClanCMS Fork Changes (complete)
============================================================================================

Major Features Added:
-  Article Headers
-  Squad Icons
-  Media Gallery
-  User Walls
-  Calendar Widget
-  Events Calendar
-  User Tracking
-  Shoutbox

***************************************
User Tracking
***************************************
Created tracker table to log user views for objects.  Assimilated articles and gallery images to check user
against tabled.  New items are branded with a 'new' image ribbon. Updated article headers to include 
no background image option. 

***************************************
Shoutbox
***************************************
The shoutbox allows users to communicate with each other via a sidebar widget 
on ClanCMS.  The widget tracks the latest recent shouts and displays a user-friendly 
timestamp.  Users are alerted via confirmation when their shouts are posted successfully. 
Links beginning with 'http' and 'www' are parsed into hyperlinks for easy site 
sharing within the community.

A shout history is visible to all site members and admin are given the authority 
to remove shouts no longer desired.

The shoutbox and shout history is inaccessible to visitors, and admin have the authority 
to restrict users from using the shoutbox.

***************************************
Gallery
***************************************
Users are able to upload images, modify a description of the image, and comment on it. 
Each image is given a statistical count, which will be implemented in future 
features.  Uploader comments are differentiated from user comments.  Each user 
is granted a 'My Media' tab in their profile.

Images are initially scaled to fit the site, however, an original size is maintained and 
available for download via the image properties panel.

Admins are able to remove images, remove comments, and bar users from uploading. 

Anons are able to view images but not comment or hotlink

Images and downloads are view-tracked for statistics and notifying users of new media.

Descriptions are editable inline

***************************************
Articles
***************************************
Articles are able to be given a header and be set to public or private

***************************************
New Files
***************************************
clancms/controllers/events.php
clancms/libraries/Calendar.php
clancms/libraries/Twitter.php
clancms/libraries/Youtube.php
clancms/models/events_model.php
clancms/models/social_model.php
clancms/views/admincp/articles_headers.php
clancms/views/admincp/squads_icons.php
clancms/views/images/headers/default.png
clancms/views/images/squad_icons/no_icon.png
clancms/views/themes/default/event.php
clancms/views/themes/default/events.php
clancms/views/themes/default/images.php
clancms/views/themes/default/images/24/fb.png
clancms/views/themes/default/images/24/ps_online.png
clancms/views/themes/default/images/24/skype.png
clancms/views/themes/default/images/24/twitter-icon.png
clancms/views/themes/default/images/24/xbox.png
clancms/views/themes/default/images/24/youtube.png
clancms/views/themes/default/images/badge-new.gif
clancms/views/themes/default/images/calendar.gif
clancms/views/themes/default/images/drawer.png
clancms/views/themes/default/images/edit.png
clancms/views/themes/default/images/new.png
clancms/views/themes/default/images/social_media_32.png
clancms/views/themes/default/images/sort.gif
clancms/views/themes/default/images/sort_asc.gif
clancms/views/themes/default/images/sort_desc.gif
clancms/views/themes/default/images/tw_bird_32_black.png
clancms/views/themes/default/images/tw_bird_32_blue.png
clancms/views/themes/default/images/tw_bird_32_gray.png
clancms/views/themes/default/images/tweet_favorite.png
clancms/views/themes/default/images/tweet_reply.png
clancms/views/themes/default/images/tweet_retweet.png
clancms/views/themes/default/images/tweet_sprite.png
clancms/views/themes/default/js/builder.js
clancms/views/themes/default/js/controls.js
clancms/views/themes/default/js/dragdrop.js
clancms/views/themes/default/js/effects.js
clancms/views/themes/default/js/prototype.js
clancms/views/themes/default/js/scriptaculous.js
clancms/views/themes/default/js/slider.js
clancms/views/themes/default/social.php
clancms/views/themes/default/social_agree.php
clancms/views/themes/default/user_wall.php
clancms/views/themes/default/users.php
clancms/views/themes/default/video.php
clancms/views/themes/default/videos.php
clancms/views/widgets/admin_stats.php
clancms/views/widgets/calendar.php
clancms/views/widgets/custom.php
clancms/views/widgets/tweet_sprite.png
clancms/views/widgets/twitter.php
clancms/widgets/admin_stats_widget.php
clancms/widgets/calendar_widget.php
clancms/widgets/twitter_widget.php

***************************************
Modified Files
***************************************
clancms/controllers/admincp/articles.php
clancms/controllers/admincp/squads.php
clancms/controllers/admincp/widgets.php
clancms/controllers/articles.php
clancms/controllers/dashboard.php
clancms/controllers/roster.php
clancms/controllers/shouts.php
clancms/libraries/FileDownloader.php
clancms/libraries/Update.php
clancms/libraries/Widget.php
clancms/models/articles_model.php
clancms/models/clancms.php
clancms/models/matches_model.php
clancms/models/squads_model.php
clancms/models/users_model.php
clancms/views/admincp/articles.php
clancms/views/admincp/articles_add.php
clancms/views/admincp/articles_edit.php
clancms/views/admincp/header.php
clancms/views/admincp/squads.php
clancms/views/admincp/squads_add.php
clancms/views/admincp/squads_edit.php
clancms/views/admincp/style.css
clancms/views/admincp/widgets.php
clancms/views/admincp/widgets_browse.php
clancms/views/install/sql/install.sql
clancms/views/themes/default/article.php
clancms/views/themes/default/articles.php
clancms/views/themes/default/dashboard.php
clancms/views/themes/default/images/avatar_none.png
clancms/views/themes/default/roster.php
clancms/views/themes/default/sidebar.php
clancms/views/themes/default/squad.php
clancms/views/themes/default/style.css
clancms/views/themes/default/widget.php
clancms/views/widgets/shoutbox.php
clancms/views/widgets/site_stats.php
clancms/widgets/administrator_alerts_widget.php
clancms/widgets/articles_widget.php
clancms/widgets/login_widget.php
clancms/widgets/matches_widget.php
clancms/widgets/new_users_widget.php
clancms/widgets/pages_widget.php
clancms/widgets/polls_widget.php
clancms/widgets/shoutbox_widget.php
clancms/widgets/site_stats_widget.php
clancms/widgets/sponsors_widget.php
clancms/widgets/users_online_widget.php


