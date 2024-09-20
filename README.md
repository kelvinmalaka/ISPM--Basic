# Binus Business and System Innovation Challenge (Basic)

This repository contains both landing page and application for Binus Basic annual event, built based on PHP using Laravel 8 and Bootstrap 5.

## :factory: Requirements

-   **Code Editor**, recommended to use [Visual Studio Code](https://code.visualstudio.com/).
-   **PHP 7.4 and MySQL Server**. Recommended to use [XAMPP](https://sourceforge.net/projects/xampp/files/), and make sure to download version 7.4.30 to also run PHP 7.4.30.
-   **PHP Dependency Manager**, using [Composer](https://getcomposer.org).
-   **[NodeJS and Node Package Manager (NPM)](https://nodejs.org/en/download/current)** as JavaScript Runtime Environment, this is needed by Laravel Mix.
-   **[Git](https://git-scm.com/downloads)** as Version Control System, and GitHub Account ofc. _Optionally_, we can also install **Github Desktop**. :sunglasses:

## :pill: Preparation

### Setup Git

-   Create an account in **[Github](https://www.github.com)**.
-   Open Windows command prompt or Mac terminal.
-   Run Git version check, to ensure Git has been installed properly.

```
git version
```

-   Set your name.

```
git config --global user.name "<your_name>"
```

-   Set your email.

```
git config --global user.email "<your_github_email>"
```

-   Setup Github Personal Token. Open [token settings page](https://github.com/settings/tokens).
    1. Generate new token (Classic).
    2. Fill notes field.
    3. In scopes field, check all `repo` scope.
    4. Save the generated personal token. Don't worry we can regenerate again if loses the token.

## :cd: Initialization

### Start PHP Server

-   Open XAMPP Control Panel.
-   Start the Apache and MySQL module.
-   Open PHPMyAdmin in browser _http://localhost/phpmyadmin_.
-   Create new database, recommended to name it `ispm_basic`.

### Clone Repository

-   Open Windows command prompt or Mac terminal.
-   Navigate to directory which you want to put this project into. Find reference in Google of the `cd` and `mkdir` command usage.

-   Clone this repository.

```
git clone https://github.com/jetmiky/ispm-basic.git
```

-   Enter your Github username.
-   Enter the personal access token generated earlier as password.

### Install Dependencies

-   Redirect to project page.

```
cd ispm-basic
```

-   Run Composer version check, to ensure Composer has been installed properly.

```
composer --version
```

-   Install PHP package dependencies.

```
composer install
```

-   Run NPM version check, to ensure NPM has been installed properly.

```
npm --version
```

-   Install NPM dependencies.

```
npm install
```

### Initialize Application

-   Open this project in your code editor. In case _Visual Studio Code_, you can use these command.

```
code .
```

-   Duplicate `.env.example` file and rename it to `.env`

-   Find row of `DB_DATABASE` and set it to the database which you have created earlier, i.e. `DB_DATABASE=ispm_basic`

-   Run this command to generate appkey. We need to do this in cloned repository of Laravel App. But if we install it from scratch, we don't need this command.

```
php artisan key:generate
```

-   Run migration to add essential tables to database.

```
php artisan migrate
```

-   Run seeder to add fake data to tables. Users password default is `password`

```
php artisan db:seed
```

### Run Application

-   Run Laravel Mix to watch JavaScript and CSS files change.

```
npm run watch
```

-   Open new cmd or terminal, navigate to the project directory, then run Laravel application.

```
php artisan serve
```

-   Open the application in the browser, the address should be _http://localhost:8000_

**Congratulations!** After this step you can start exploring the alternate coding universe. :sunglasses:

---

## :video_game: Development

### Warm up the Engine

After completing the initialization steps, you only have to do these step everytime you start turning on your coding mood.

-   Start XAMPP PHP Server
-   Run Laravel Mix

```
npm run watch
```

-   Run Laravel Application

```
php artisan serve
```

-   Open the application in the browser, by default its address should be _http://localhost:8000_

### Development collaboration

**Version Control System (VCS)** is a tool that professionals—individual or in teams—always use while developing applications. Not only preserving history, VCS can also combine code supplied by several developers, in example developers can work on different features and combine their code. The most used VCS in the market is Git, and its popular providers are Github, Gitlab, and BitBucket.

I recommend to learn these basic concepts of Git:

-   **commit**: make a checkpoint of development progress.
-   **branch**: make a _parallel universe_ of development.
-   **pull**: pull the latest code update from the repository.
-   **push**: push your code progress to the repository.

#### Pull latest code respository

Each time before start developing, sync latest code from Github and your local repository.

```
git pull
```

#### Create a branch

Create a branch on what are you developing with naming convention of `role/feature`.

```
// Create new branch
git branch admin/user-management

// Switch to created branch
git checkout admin/user-management

// Below is shorthand of two commands above
git checkout -b admin/user-management
```

#### Commit changes

After writing some code and feels that they are okay and smooth, commit them to make a checkpoint.

```
git add <files>

// or below to stage all files changed

git add .

// commit changes
git commit -m "<description>"
```

#### Push to Github

When it's time to log off from development and do another college tasks, push your code to Github.

```
// first time a branch pushed to Github
git push --set-upstream origin <branch_name>

// branch has been pushed to Github before
git push
```

#### Create Pull Request

If you feels like the feature which you developed (i.e. `admin/user-management`) is already finished, create a pull request. A reviewer (currently only me) will review your code, to approve or request changes of your code.

-   Open this repository in your browser.
-   Select **Pull requests** tab.
-   Select **New pull request**.
-   Select **main** branch as **base**, and **your branch** in **compare** field.
-   Fill appropriate description.
-   Click save.

#### Practice Git

You can also create branch with naming convention `practice/your-name` to practice, and create pull request.

For example, create a file `practice.txt` and add any content.

## :fire: Quotes

> Programming is not about what you know; it's about what you can figure out.

> Any programmer can write code that computer can understand. Great programmers write code that humans can understand.

> Programming is a skill best acquired by practice and example rather than from books.

> Everybody should learn to program a computer; because it teaches how to think.
