# Calendar
## About
This is a Calendar app written in PHP and HTML and designed with CSS. It uses database to store events. Pardon the design but I am not really design oriented person. I rather focus on functionality but sometimes it lacks even that.

Currently it has partially working API but only GET for calendar_entries table and with limited usability.

It has 3 PHP classes - Calendar, Database and Utils.

### Database class
It handles all operations with tables inside the database. Every time something is needed to be done with data in tables it calls one of the functions that are specified in there.

### Calendar class
This class is like the heart of the app. It contains all functions that are necessary to create the calendar UI - except for forms, those are created explicitly. There are also functions that are not currently in use. However some code refactoring will be needed and then they will be remove from the codebase.

### Utils class
Utils (Utilities) contains functions that are used often within the whole app.

## Credits
All code is mine, except for parts where the author is mentioned.

## Statistics
Time taken (roughly): 3 hours
### Lines of code: (Except for git files and md files)
- 1237 (2022/8/17)
- 870 (2022/8/16)