==============================================================================
                          co[dezyne] Shoutbox
==============================================================================

Current Version: 1.9

The shoutbox allows users to communicate with each other via a sidebar widget 
on ClanCMS.  The widget tracks the latest recent shouts and displays a user-friendly 
timestamp.  Users are alerted via confirmation when their shouts are posted successfully. 
Links beginning with 'http' and 'www' are parsed into hyperlinks for easy site 
sharing within the community.

A shout history is visible to all site members and admin are given the authority 
to remove shouts no longer desired.

The shoutbox and shout history is inaccessible to visitors, and admin have the authority 
to restrict users from using the shoutbox.

**************************************************
               Required Files and Changes
**************************************************

Database
- Create table '*prefix*_shouts'
- Modify table '*prefix_users'
	-Add row 'can_shout'
	-Add row 'has_voice' *also required*
	-Add row 'can_upload' *also required*

controllers/
- Add shouts.php

models/
- Add shouts_model.php
- Update session_model.php

widgets/
- Add shoutbox_widget.php

views/widgets/
- Add shoutbox.php

views/theme/*theme*/
- Add shout.php
- Update profile.php

*************************************
    Changelog & Version History
*************************************
Current Version 1.9
- Modified session model to include checking if user has privileges to shout
- Gave admin authority to remove shout privs
- Gave admin authority to mute users *preparative function for future development*

Version 1.6
- Modified timestamp output calculation

Version 1.5
- Parses shouts and converts links to hyperlinks

Version 1.1
- Added shout history

Version 1
- Shoutbox widget developed
