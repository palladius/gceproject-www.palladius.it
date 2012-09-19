/** ---------------------------------------------------------------------------- //
* ----------------------------------------------------------------------------- //
* -------------      Jim (Joomla internal Messaging       --------------------- //
* -------------	      Jim - Joomla Internal Messaging     --------------------- //
* -------------  Copyright (c) 2006  By Laurent Belloeil  --------------------- //
* -------------           <www.comeonjoomla.com>          --------------------- //
* ----------------------------------------------------------------------------- //
* ----------------------------------------------------------------------------- //
* This program is a free software released under GNU GPL license. This program  //
* is provided WITHOUT ANY WARRANTY; without even the implied warranty of        //
* MERCHANTABILITYor FITNESS FOR A PARTICULAR PURPOSE.                           //
* ----------------------------------------------------------------------------- //
*             Version : 1.0      Release date : 21.04.2006                //
* ----------------------------------------------------------------------------- //


Introduction
***************************************

Jim is a private messaging system which enables the registered users
of Joomla to communicate with each other directly and easily.

The code of Jim is based on myjim 1.0 alpha from Danial Taherzadeh.
Very first and basic version of this software was based on parts of the original e-post 
by ryan marshall of irealms.co.uk. Many thanks for his effort.


What's New in 1.0?
***************************************

- New administration backend with 8 options to control how Jim acts and looks(bug corrected).
  Localisation is now supported. Ini file writing bug corrected.
- Module for pm check which uses XML-RPC technology with refresh rate control option in backend.
  No more need for refreshing the pages! 
- You can chosse beetween 2 great looks : tabs or buttons (customizable).
- Email notification and its switch
- Link to Community Builder users is switchable in admin (visit http://www.joomlapolis.com)
- Autocomplete feature for username search and option in backend
- Enhanced reply system
- Invalid username check

Installation
***************************************

1. Install the component from the administrator "Component Installer" interface and then create a
main link in the frontpage: Site -> Menu Manager -> Main Menu.

2. Install the Jim module from the administrator "Module Installer" interface 

3. Thats all, Enjoy it!


Upgrade
***************************************
There is a database structure change in the JIM.
To migrate your myPMS table :

0. Be sure to backup your Joomla database first!
1. Install JIM.
2. Delete the JIM table created during install.
3. Copy your PMS table structure and data to #__test (where #_ is your Joomla table prefix)
4. Apply the following upgrade SQLs (we considere you kept the default Joomla prefix for table name).

	ALTER TABLE `jos_jim`
	  DROP COLUMN `groupname`;
	  
	ALTER TABLE `jos_jim`
  	  DROP COLUMN `time`;

  	ALTER TABLE `jos_jim`
  	 CHANGE COLUMN `date` `date` datetime NOT NULL;  
  	 
  	ALTER TABLE `jos_jim`
     CHANGE COLUMN `subject` `subject` varchar(255) NOT NULL; 

        ALTER TABLE `jos_jim`
     ADD `outbox` SMALLINT( 1 ) UNSIGNED NOT NULL DEFAULT '1' AFTER `whofrom`

5. Backup your jos_jim table. Use complete insert option
6. Welcome to the new Jim 1.0!


License
***************************************
Please refer to the administration backend license tab.