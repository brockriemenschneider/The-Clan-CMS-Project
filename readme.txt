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

widgets/
- shoutbox_widget.php

views/widgets/
- shoutbox.php

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

views/themes/default/js/
- jquery.jcarousel.js
- jquery.jcarousel.min.js
- jcarousel/*


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

[ end of table modifiers ]

