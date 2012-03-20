<<<<<<< HEAD
============================================================================================
                             co[dezyne] ClanCMS Fork Changes
============================================================================================

This is the complete system with all file changes, working and not.  Refer to specific branches
for modification details.

******************************************
              Recent Changes
******************************************
Created tracker table to log user views for objects.  Assimilated articles and gallery images to check user
against tabled.  New items are branded with a 'new' image ribbon. Updated article headers to include 
no background image option. 

Fixed issue with squad icon not populating.

Added user walls

Added Twitter widget & library

******************************************
              Files Added:
******************************************

controllers/
- gallery.php
- shouts.php

models/
- gallery_model.php
- shouts_model.php
- social_model.php
- tracker_model.php

libraries/
- Youtube.php
- Twitter.php

widgets/
- shoutbox_widget.php
- twitter_widget.php

views/widgets/
- shoutbox.php
- twitter.php

views/images/
- gallery/
- gallery/thumbs/
- headers/
- squad_icons/

views/admincp/
- articles_headers.php
- squads_icons.php

views/themes/default/
- gallery.php
- image.php
- media.php
- shouts.php
- social.php
- social_agree.php
- users.php
- user_wall.php

views/themes/default/js/
- jquery.jcarousel.js
- jquery.jcarousel.min.js
- jcarousel/*
- tablesorter/

[ end of added ]

******************************************
              Files Changed
******************************************

controllers/admincp
- articles.php
- squads.php

controllers/
- account.php
- articles.php
- roster.php
- dashboard.php
- gallery.php

models/
- articles_model.php
- session_model.php
- squads_model.php
- users_model.php
- gallery_model.php

widgets/ 
- site_stats_widget.php

views/widgets/
- site_stats.php

views/admincp/
- articles.php
- articles_add.php
- articles_edit.php
- header.php
- squads_add.php
- squads_edit.php

views/themes/default/
- account.php
- article.php
- articles.php
- footer.php
- header.php
- profile.php
- roster.php
- squad.php
- gallery.php
- image.php


[ end of files changed ]

****************************************
               DB Tables Added
****************************************
_gallery
_gallery_comments
_headers
_shoutbox
_sqd_icons
_user_api
_user_extend
_user_social

[ end of new tables ]

*********************************************
               DB Tables Modified
*********************************************
_articles
	- added 'article_game'
_squads
	- added 'squad_icon'

_users
	-added 'can_shout'
	-added 'can_upload'
	-added 'has_voice'
	-added 'status'
	-added 'wall_enabled'

[ end of table modifiers ]

=======
==============================================================================
                               co[dezyne] Articles Header
==============================================================================

This extension permits admin to upload images for the purpose of adding unique 
headers to their articles. It works in combination with the user tracker model
 to digest users' activity, logging articles as new or visited. (Only new is 
shown, with applicable imagery.)

Recent Updates:
-- Added tracker database table
-- Added tracker model
-- Modified dropdown selector to include chosing the default banner
-- Modified database and article options for public and private articles

***************************************
        Files Added & Modified
***************************************
Database Tables:
- Edit Table '*prefix_articles'
	- Add row 'article_game'
	- Add row 'article_permission'

- Add Table '*prefix_headers'

controllers/admincp/
- UPDATE articles.php

controllers/
- UPDATE articles.php
- UPDATE dashboard.php

models/
- UPDATE articles_model.php
- Add tracker_model.php

views/admincp/
- UPDATE articles.php
- UPDATE articles_add.php
- UPDATE articles_edit.php
- ADD articles_headers.php
- UPDATE header.php

views/images/
- ADD headers/

views/themes/default/
- UPDATE articles.php
- UPDATE article.php
>>>>>>> articles
