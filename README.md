# PHP MVC framework

Repository for PHP - MVC framework.

## Overview

Simple MVC system created with PHP for demo purposes.
On the front-end side, it utilizes Tailwind and Vanilla JavaScript.
It still needs many improvements, changes and testing, I do not think the system is ready for production but give it a try.

## Requirements

- Apache 2.4+
- PHP 8.1
- Node.js
- Tailwind 3
- Coffee and chocolate

## Dev environment

The system has been developed using [Lando](https://lando.dev) based in Docker as a dev environment. The recipe file `.lando.yml` can be found in root folder.

Use [Kint](https://kint-php.github.io/kint/) to debug variables:

```php
<?php d($data); ?>
```

## Getting started

Clone the project using git or download it.

Run composer in your site to get PHP dependencies/libraries.

```bash
composer install
```

Run npm in your site to get JS dependencies/libraries.

```bash
npm install
```

The system uses a `.env` file that may store some sensitive information such as API keys or credentials and config options such as type of environment. It's not committed in the repository. There is a example file `.env.example`. **Please, create the `.env` file, it is mandatory**.

The webroot folder must point to `/public`.

## How to run

The system has installed the Tailwind Standalone CLI (see https://tailwindcss.com/blog/standalone-cli and https://tailwindcss.com/docs/installation).

### Start dev build process

```bash
npx tailwindcss -i ./public/theme/css/input.css -o ./public/theme/css/output.css --watch
```

### Build for production.

```bash
npx tailwindcss -i ./public/theme/css/input.css -o ./public/theme/css/output.css --minify
```

## How to create a new page

Create a view file in `/App/Views` with the following convention _filename.php_.

Create a controller file in `/App/Controllers` with the following convention _FilenameController.php_. The controller file will handle the logic of the page.

Create a model file in `/App/Models` with the following convention _FilenameModel.php_.

Go to file `/App/routes.yml` and create a new URL with settings under `pages`.

```yaml
pages:
  # Example
  - path: "/path/etc"
    settings:
      controller: "FilenameController"
      view: "filename"
      title: "page title"
      body_classes: "css classes for body tag"
      access_role: "(guest, auth), what role can access to the resource"
```

#### Views data

The values for the view are stored in the array `$data`:

```php
<p><?php echo $data['value']; ?></p>
```

## Users, roles and permissions

The system has 2 roles defined:

- `guest` (not authenticated) User or visitor not registered or not logged in.
- `auth` (authenticated) Authenticated user, registered user and logged in.

Every time a new page is created in `routes.yml`, it is necessary to set what type of role can access the page. _Warning: Choose wise, it may have security implications depending on the role._

## Theme

The system is using a custom theme made with Tailwind.

### CSS

Main CSS code in the file `/theme/css/input.css`.

### JavaScript

Main JavaScript code in the file `/theme/js/scripts.js`.

Code with Vanilla JavaScript.