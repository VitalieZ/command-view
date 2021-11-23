# Commands create model, view and controller

<p align="center">⛵<code>viro-crud</code> is laravel commands which can help you build view, model, and controller files in line command.</p>

## Installation

```
composer require viro/crud
```

## Usage

### Creating views

```bash
# Create a view 'index.blade.php' in the default directory
$ php artisan crud:view index

# Create a view 'index.blade.php' in a subdirectory ('pages')
$ php artisan crud:view index --path=pages

# Create a view 'index.blade.php' with extends ('layouts.main') in the default is 'layouts.app'
$ php artisan crud:view index --extends=layouts.main

# Create a view 'index.blade.php' with section ('footer') in the default is 'content'
$ php artisan crud:view index --section=footer
```

### Creating model

```bash
# Create a model 'Post'
$ php artisan crud:model Post

# Create a model 'Post' with name table db 'products'
$ php artisan crud:model Post --table=products

# Create a model 'Post' and view 'products'
$ php artisan crud:model Post -w --viewname=products

# Create a model 'Post' with view 'products'
$ php artisan crud:model Post -w --viewname=products

# Create a model 'Post' with view 'products' and in a subdirectory 'products'
$ php artisan crud:model Post -w --viewname=products --path=products

# Create a model 'Post' and controller
$ php artisan crud:model Post -c

# Create a model 'Post', controller and view (index.blade.php)
$ php artisan crud:model Post -cw

# Create a model 'Post', controller and view resources (index, create, edit, show)
$ php artisan crud:model Post -cW

# Create a model 'Post', controller resources and view resources (index, create, edit, show)
$ php artisan crud:model Post -r

# Create a model 'Post', controller resources, view resources (index, create, edit, show) and Requests
$ php artisan crud:model Post -rR

# Create a model 'Post', controller resources, view resources (index, create, edit, show) in a subdirectory 'products' and Requests
$ php artisan crud:model Post -rR --path=products
```
