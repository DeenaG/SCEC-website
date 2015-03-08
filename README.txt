README file for SCEC website
programmer: Deena Rubin, NEIU graduate student

For questions about the code: See Rachel Adler, professor from computer science department
For questions about the SCEC club: See current state liason officer or faculty advisor for the SCEC

List of pages in the website:
	Front Facing PHP/HTML Pages:
		index.php: main page
		officers.php: List of officers with title, position, description and picture ******backed up by database
		Calendar: Link to Google Calendar. *******Ask faculty advisor of the SCEC or state liason officer for nmail login information to access the calendar
		constitution.php: List of constitution articles and bylaws
		events.php: List of past events with description and 2-5 pictures (each event is displayed in a jquery accordion) *****backed up by database
		resources.php: list of external resources including logo which is a link to organizations' websites. 
		minutes.php: List of meeting dates that link to PDF files *****backed up by database
		Includes Folder - each of the above pages includes the following:
			header.php: header with NEIU logo, SCEC logo, and title of page
			navigation.php: navigation structure
			footer.php: contact information and link to admin login
	Front Facing CSS pages (in styles folder):
		Each page links to:
			main_style.css: default styles for fonts, colors and body of the website
			navigation_style.css: style for the navigation bar
		Each page also has its own specific CSS style page (also in styles folder)
	Admin Control pages (in admin_controls folder):
	******See Rachel Adler from the Computer Science department/faculty advisor for the SCEC/state liason officer for the SCEC for login information 
		admin_login.php: login form
		login_process.php: processes the login form and checks credentials
		admin_navigation.php: includes links to three admin control pages (officers, minutes, events)
		update_events.php: forms to update and delete events
		events_process.php: process the add events form and adds event to the database
		delete_events.php: processes the delete events form and deletes event from the database ***pictures are deleted from server as well
		update_minutes.php: forms to update and delete minutes
		minutes_process.php: processes add minutes form and adds minutes to the database
		delete_minutes.php: processes the delete_minutes form and deletes minutes from the database ***PDF files are deleted from server as well
		update_officers.php: forms to update and delete officers
		officers_process.php: processes the add officers form and adds officer to the database
		delete_officers.php: processes the delete officers form and deletes officer from database ***pictures are deleted from server as well
		logout.php: logs user out of the admin controls
		database_variables.php: includes session variables that are used by other pages.
			**********This page includes the variables needed to connect with the database, and they are currently set to null in the code. Make sure to change these before uploading
		password_hash.php: (in  admin_controls/hash folder) This page is included in the code, but not uploaded to the server. It can be used to 
			hash a new password and insert it into the user table in the database. 
	Admin Control style pages(in admin_controls/styles folder
		admin_style.css: all admin pages that include html link here
		logout_style.css: for logout page
		navigation_style.css: for navigation page
		update_style.css: for all pages with add/delete forms
		
Additional features that would be useful for the website:
1) use of cookies so that the site remembers the admin password
2) a form to update the password
3) password recovery

When the PHP version on the server is updated, these are some areas that may need to be updated:
1) The current code uses the crypt function with salt for password hashing. later versions of PHP include more secure functions that automatically generate salt
2) Any page that uses dates/times. 
	A) In the officers_process.php page, a class is used to mimic the functionality of the timestamp class. This can be changed with a version of PHP that uses timestamps
	B) In order for dates to be displayed, some versions of PHP require a default time zone to be specified. Newer versions do not seem to require this. On the delete minutes form
	(in the update_minutes.php page) and in the minutes.php page, the default time zone methods are commented out. They should be uncommented if needed.
3) On the CS server, using a relative path to upload pictures works, on the NEIU server, an absolute path is needed. These paths are specified in the database_variables.php page. 
Update the paths based on the server being used

Database Information:
Sign into NEIU server with username scec. 
Get password from Rachel Adler from computer science department. Password can also be obtained by having the current SCEC faculty advisor send an email to the help desk to request it.
Database name: scec
Tables:
1) officers: officers.php is backed up by this table
	columns: id (autoincrement, primary key) name, position, description and imagePath. The image is uploaded to the images folder, and the path is stored in the database
2) minutes: minutes.php is backed up by this table
	columns: id(autoincrement, primary key), date (stored as timestamp), filePath. The PDF is uploaded to the documents folder, and the path is stored here
3) events: Part of events.php is backed up by this table
	columns: id(autoincrement, primary key), title, description
4) pictures: images for the events.php page are backed up here
	columns: id(autoincrement, primary key), imagePath (Images are uploaded to the images folder and path is stored here), eventID (foreign key matching up with primary key 
		from the events table)
5) user: contains login information for the admin account. Since there is only one admin account, this table contains only one row
	columns: user (contains username), password(contains hashed password), email (the scec email account). This is not currently used in the program, but may be useful for 
	additional features that use notifications or password recovery
	
Information about the old website:
The code for the old website is stored in the folder called: old_website. The files in here are not needed for the current website. 
The old website redirected to SCEC/SCEC_HOME.html. This file now just has a redirect to the new website so that old links will still work

		

		
		
		
		
			
			
	