# PHP MVC framework

Repository for PHP - MVC framework.

## Overview

MVC system created with PHP for demo purposes. A different approach creating routes/paths through a YAML file.

On the front-end side, it utilizes Vite, Tailwind and Vanilla JavaScript.

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

Run composer in root folder to get PHP dependencies/libraries.

```bash
composer install
```

Run npm in `/theme` folder to get JS dependencies/libraries.

```bash
npm install
```

The system uses a `.env` file that may store some sensitive information such as API keys or credentials and config options such as type of environment. It's not committed in the repository. There is a example file `.env.example`. **Please, create the `.env` file, it is mandatory**.

The webroot folder must point to `/public`.

## How to run

If you use Lando, just start it:

```bash
lando start
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
    methods:
      get: "action in controller to handle the logic"
      post: "action in controller to handle the logic"
```

#### Views

The values for the view are stored in the array `$data`:

```php
<p><?php echo $data['value']; ?></p>
```

#### Validate input

You can validate input with rules.
 
Example of how to validate data:

```php
use Core\Request;
use Core\Utils\Validation;

function store(): void {
  $request = new Request();
  $validation = new Validation();

  // Validate input.
  $fields = [
    'name' => 'required,max:255',
    'email' => 'required|email|unique:users,email',
    'password' => 'required',
    'password2' => 'required|same:password'
  ];
  if (!$validation->validate($request->httpData, $fields, ['password2' => ['same' => 'Password fields does not match.']])) {
    Message::set($validation->getErrors(), 'error');
    return;
  }

  // If pass validation, do your stuff.
  Message::set('Validation passed!');
  return;
}
```

See `Validation` class to check available rules.

## Users, roles and permissions

The system has 2 roles defined:

- `guest` (not authenticated) User or visitor not registered or not logged in.
- `auth` (authenticated) Authenticated user, registered user and logged in.

Every time a new page is created in `routes.yml`, it is necessary to set what type of role can access the page. _Warning: Choose wise, it may have security implications depending on the role._

## Caching system

Cache is created by using the library [Phpfastcache](https://www.phpfastcache.com).

It is stored in `/cache`.
Some objects could be already cached.
**Routes are cached**.

It may get enabled/disabled in `.env` file. Be aware some cached elements might be disabled individually in code.

```
# Cache settings
ENABLE_CACHE="true"
```

Cache can be cleared only deleting folder `/cache` for now.

Example of how to cache data:

```php
use Core\Cache;

function functionName(): array {
  $cache = new Cache();
  $key = 'keyName';

  // Check if it is cached.
  if ($cache->isCached($key)) {
    return $cache->get($key);
  }

  // Do your stuff to create the data.
  $data = [];
  // Cache data 60 minutes.
  $cache->set($data, $key, 3600);

  return $data;
}
```

## Theme

Although the basic theme is not built with any JS framework, [Vite](https://vitejs.dev/) is integrated in the `/theme` folder for a modern workflow (still work in progress).

Main CSS code is in the file `/theme/styles.css`. The theme is styled with [Tailwind](https://tailwindcss.com).

Main JavaScript code is in the file `/theme/scripts.js`. Code with Vanilla JavaScript.

### How to run

#### Start dev build process

(Still work in progress, it does not reflect changes yet)

```bash
npm run dev
```

#### Build for production.

(Works fine)

```bash
npm run build
```
