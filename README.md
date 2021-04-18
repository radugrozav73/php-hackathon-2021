# PHP Hackathon
This document has the purpose of summarizing the main functionalities your application managed to achieve from a technical perspective. Feel free to extend this template to meet your needs and also choose any approach you want for documenting your solution.

## Technical documentation
### Data and Domain model
The main entities are Admins (users), Programs and ActiveProgrammes.
Admins are users, that can log and create health plans, this table has a one to many relationship with Programs table.
Programs belong to Admins, this is the table responsible for holidng all the information about the plans that Admins create, it has one to many relationship with ActiveProgrammes.
ActiveProgrammes belong to Programmes, here people can register for the plans provided in Programmes, it has a CNP column that is not unique, just so the same user can register to more than one activity.
### Application architecture

unprotected routes: - /admins/register - Register system for admins, receives as parameters: name, email, age, gender, password

             - /admins/login - Login system for admins, receives as parameters: email, password, returns a token that must be saved for authentication
             - /activeprogrammes/{id} - Here people can register for sports programs, receive as a parameter the id of that program and a cnp.
             - /activeprogrammers/{id}/{cnp}/delete - The route by which people can be removed from the list of activities, receives as parameters the program id and the cnp

protected routes:  
            -/admins -> Returns the admin list with the data
            -/admins/update -> Updates the logged in user, receives as parameters: name, age, gender
            -/admins/{id} -> Search for a specific admin by id and return information about it, parameters: id
            -/admins/{id}/delete -> It receives the admin id as a parameter and deletes it from the database

            -/programmes/store - Create new programs, receive as parameters: start_date, 'end_date', 'room_name', 'program_type', 'max_attenders'
            -/programmes - Returns the list of programs
            -/programmes/{id} - It receives as a parameter the id of a program and returns information about it
            -/programmes/update/{id} -> Get as parameters the program id, start_date, end_date, program_type, room_name, max_attenders and update the respective program
            -/programmes/{id}/delete -> It receives the program id as a parameter and deletes it from the database.

            -/activeprogrammes/index/{cnp} -> returns information about a person registered for a course, receives the cnp as a parameter
            -/activeprogrammes/index/ -> returns all registered persons to the course
###  Implementation
##### Functionalities
For each of the following functionalities, please tick the box if you implemented it and describe its input and output in your application:

[ ] Brew coffee \
[x] Create programme \
[x] Delete programme \
[x] Book a programme 

##### Business rules
Created a table for each admin, so they can manage their own plans.


##### 3rd party libraries (if applicable)
Please give a brief review of the 3rd party libraries you used and how/ why you've integrated them into your project.

https://github.com/barryvdh/laravel-debugbar
laravel-debugbar

is a toolbar that helps me debug and i also used JWT for token generating.

##### Environment
Please fill in the following table with the technologies you used in order to work at your application. Feel free to add more rows if you want us to know about anything else you used.
| Name | Choice |
| ------ | ------ |
| Operating system (OS) | Windows 10 |
| Database  | MySQL 8.0|
| Web server| xampp |
| Laravel | 7.0/8.0 |
| IDE | Visual Studio Code |

### Testing
https://github.com/barryvdh/laravel-debugbar

laravel-debugbar

## Feedback
In this section, please let us know what is your opinion about this experience and how we can improve it:

1. Have you ever been involved in a similar experience? If so, how was this one different?
Learned a lot, no real ideas about improvements. sorry :(
2. Do you think this type of selection process is suitable for you?
yes, i learned some staff, plus it was a good experience.
3. What's your opinion about the complexity of the requirements?
High first day, Average next day. The overthinking process slows it down.
4. What did you enjoy the most?
Coding the task made me understand more about api coding.
5. What was the most challenging part of this anti hackathon?
Overcome my overthinking, could finish this project a lot faster if it wasn't for me changing tables.
6. Do you think the time limit was suitable for the requirements?
Yes, more than enough.
7. Did you find the resources you were sent on your email useful?
Yes, the advanced part was good to read.
8. Is there anything you would like to improve to your current implementation?
Yes, but i have no more energy to think :(
9. What would you change regarding this anti hackathon?
Can't think of something now.

