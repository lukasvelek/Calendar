# Calendar
## Future plans
One of the main future plans is definitely an API because I think calendar is one of the apps that should have an API because of possible further integration.

## About
This is a Calendar app written in PHP and HTML and designed with CSS. It uses database to store events. Pardon the design but I am not really design oriented person. I rather focus on functionality but sometimes it lacks even that.

It has 2 PHP classes (Calendar and Database).

### Database class
It handles all operations with tables inside the database. Every time something is needed to be done with data in tables it calls one of the functions that are specified in there.

### Calendar class
This class is like the heart of the app. It contains all functions that are necessary to create the calendar UI - except for forms, those are created explicitly. There are also functions that are not currently in use. However some code refactoring will be needed and then they will be remove from the codebase.

## Credits
All code is mine, except for parts where the author is mentioned.

## Statistics
Lines of code: 615 (as of 2022/8/16, except for this README.md file)
Time taken (roughly): 2 hours