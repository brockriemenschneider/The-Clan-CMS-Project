==============================================================================
                               co[dezyne] Articles Header
==============================================================================

This extension permits admin to upload images for the purpose of adding unique 
headers to their articles.


***************************************
        Files Added & Modified
***************************************
Database Tables:
- Edit Table '*prefix_articles'
	- Add row 'article_game'
- Add Table '*prefix_headers'

controllers/admincp/
- UPDATE articles.php

models/
- UPDATE articles_model.php

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
