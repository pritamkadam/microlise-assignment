# Microlise Assignment
Using Laravel 5.8, code a media library application, both front end UI and backbend.
Through the application, the user should be able to upload or store content in the following formats:


- Jpeg, PNG
- Mp4
- PDF
- Mp3,
- streamed content from YouTube or Vimeo

The user should be able to store, edit, delete and categorise the content into the following categories:

- Video
- Images
- Documents

Extra credit will be awarded for the following:
- store media meta data
- portability of the render code - this is so it could be used to render the media file easily in other parts of the application.
- front end using some Vue.js Elements
- good UI and UX
- add a 'favourite' feature for users to store their favourite content
- Your ability will also be judged on the quality of your code, so please adhere to your best coding practices. Code quality will win over code quantity.


Laravel Skills to Demonstrate:
- Request Validation
- Collections
- Eloquent queries and relations
- Migrations and data seeding
 


Coding Skills to Demonstrate:
- OOP design - e.g: inheritance, patterns
- SOLID principles
- MVC pattern adherence
- Testing (preferably Frontend and Backend)

# Installation

Clone the repo and switch to the repo folder. 

Install all the dependencies using composer

    comopser install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate
   
Run the database migrations & seeder (**Set the database connection in .env before migrating**)

        php artisan migrate
        php artisan db:seed

Link storage to public storage

    php artisan storage:link

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000
