<!-- PROJECT SHIELDS -->
<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#works">Works in this project</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project
This project is to use Laravel to build a web application and publish APIs development. </br> 
<p>Regarding web application, it doesn't require authentication from user, and it focuses on Post and Comment. In addition, users are allow to CRUD on Post and Comment. This web application is styled by TailwindCss for simple layouts. </p>
 <p> In terms of APIs, there are routes including Log In, and CRUD routes of Post and Category. For login route, feel free to use credential provided as key-value of form request - email: long@gmail.com ; password: 123456. After logging, please store token responded for other CRUD Routes because it requires authentication</p>
 
 <p>Brief:</br>
 - 1 Post has many Comments (1-many) </br>
 - Post and Category have many-many relationship </br>
 - Regarding API, only authorised users can edit / delete their Posts or Categories created </br>
 - Post and Category have applied Soft Delete. It means "deleted_at" value will be updated and record in pivot table will be delete</br>
 - Comment has Force Delete</br>
 - Database migration, Seeder, Factory</br>
 - PHP Unit tests for APIs actions</p>

### Built With
* [![Laravel][Laravel.com]][Laravel-url]
* [![TailwindCss][Tailwindcss.com]][Tailwind-url]

<!-- GETTING STARTED -->
## Getting Started

### Prerequisites

Depends on your OS, please ensure that your machine has following:  [Laravel Installer (optional)](https://laravel.com/), [NPM](https://www.npmjs.com/)

### Installation

_Follow the steps below:

1. Clone the repo
   ```sh
   git clone git@github.com:nganlong0510/laravel-project.git
   ```
2. Go to project directory cloned
   ```sh
   cd laravel-project
   ```
3. Install NPM packages
   ```sh
   npm install
   ```
3. Copy `.env.example` file to `.env. And configure your details such as localhost or database configuration in `.env` 
4. Migrate tables
   ```js
   php artisan migrate
   ```
5. Seeding data
   ```js
   php artisan db:seed
   ```
6. Compile Css and Js files - it will be published to `public` folder
   ```js
   npm run dev
   ```
7. Run watch to see new changes on web pages.
   ```js
   npm run watch
   ```
8. Start laravel
   ```js
   php artisan serve
   ```

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- Works -->
## Works
To sum up, I offered different approaches to the requirement because the requirement is fragment and unclear.</br>
For example, it requires restricting users they only can edit/delete their Post/Category, then I provide 2 solutions including authorise request in PostRequest and authorise user in CategoryPolicy.
<div>
  1/ Full-stack application (using blades for rendering views, and grabbing data from the back end using Laravel)  **All routes are developed including Post and Comment models only for anonymous users. </br> 
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;// Works inside:
  <ul>
    <li>Database tables like Posts or Comments have title and description columns. Database migration, factory and seeder</li>
    <li>Model relationship: 1 Post has many Comments</li>
    <li>CRUD routes, controllers and blades for Post and Comment (i.e creating/editing Posts, deleting Post also deleting its Comments, creating/editing/deleting Comments)</li>
    <li>Requests validation for Post and Comment</li>
    <li>Data Repository Pattern for Post, Collection and Resource for Post</li>
    <li>Soft Delete for Post, Force Delete for Comment</li>
  </ul>
</div>

<div>
  2/ APIs development  **All routes are developed including Post and Category models only, and they require an authenticated user.</br>
Feel free to use credentials provided for logging and testing in your environment like Postman (email: long@mail.com, password: 123456). 
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;// Works inside:
    <ul>
      <li>Database tables have title and description columns. Database migration, factory and seeder</li>
      <li>Model relationship: Post and Category are in many to many relationships. A pivot table is created for the relationship</li>
      <li>CRUD APIs routes in sanctum middleware</li>
      <li>Add data serialization: timestamp to this specific format (created_at)</li>
      <li>Requests validation object: PostRequest, CategoryRequest</li>
      <li>Add a Category Policy to define that only the user who published the post can edit/delete it and update the categories.</li>
      <li>Data Repository Pattern, Resource and Resource Collection for Post and Category.</li>
      <li>Soft Delete for Post, and Category. And also detach its records in the pivot table.</li>
      <li>Build PHP unit test for CRUD APIs</li>
      <li>Factory seeder for PHP unit test.</li>
  </ul>
</div>

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- LICENSE -->
## License

<!-- CONTACT -->
## Contact

Long Ngan Nguyen - nganlong0510@gmail.com

Project Link: [https://github.com/nganlong0510/laravel-project](https://github.com/nganlong0510/laravel-project)

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[Laravel.com]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[Laravel-url]: https://laravel.com
[Tailwindcss.com]: https://img.shields.io/badge/TailwindCss-563D7C?style=for-the-badge&logo=TailwindCss&logoColor=blue
[Tailwind-url]:https://tailwindcss.com/
