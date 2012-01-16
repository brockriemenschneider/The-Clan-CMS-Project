=============================================================================
                          co[dezyne] Gallery
=============================================================================

This MCV gives the functionality for users to upload images to the site and to display 
an official youtube channel into a video slider.  This extension is in alpha mode 
and is not ready for implementation.

Current functionality:
Users are able to upload images, modify a description of the image, and comment on it. 
Each image is given a statistical count, which will be implemented in future 
features.  Uploader comments are differentiated from user comments.  Each user 
is granted a 'My Media' tab in their profile.

Images are initially scaled to fit the site, however, an original size is maintained and 
available for download via the image properties panel.

Admins are able to remove images, remove comments, and bar users from uploading. 

Anons are able to view images but not comment or hotlink

Future Functionality:
Image properties panel will provide the ability to 'favor' and image as well as 
share the image via several social network outlets.

Images will be presented as either 'new' or previously viewed to distinguish files. 

Calculations on user gallery statistics will be used to award badges and ranks

Videos will be implemented

Official channel will own videos

Categories for media

Uploading from 'My Media'

Inline editing of descriptions and comments

***************************************
    Files Added & Modified 
***************************************
Database Tables
- Add table '*prefix_gallery'
- Add table '*prefix_gallery_comments'
- Update table '*prefix_users'
	- Add row 'can_upload'
	- Add row 'can_shout'
	- Add row 'has_voice'

controllers/
- Add gallery.php
- Update roster.php
- Update account.php

models/
- Add gallery_model.php
- Update session_model.php

views/themes/default/
- Add gallery.php
- Add image.php
- Add media.php
- Update style.css
- Update header.php
- Update profile.php
- Update account.php
- Update footer.php

views/themes/default/js/
- Add jcarousel/
- Add jquery.carousel.min.js
- Add jquery.carousel.js

