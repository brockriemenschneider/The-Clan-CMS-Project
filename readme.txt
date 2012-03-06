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
