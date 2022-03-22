# Laravel OptiKey

[![Build Status](https://travis-ci.org/riipandi/laravel-optikey.svg?branch=master)](https://travis-ci.org/riipandi/laravel-optikey)
[![StyleCI](https://github.styleci.io/repos/235965192/shield?branch=master)](https://github.styleci.io/repos/235965192)
[![Latest Stable Version](http://img.shields.io/packagist/v/riipandi/laravel-optikey.svg?style=flat)](https://packagist.org/packages/riipandi/laravel-optikey)
[![Total Downloads](http://img.shields.io/packagist/dt/riipandi/laravel-optikey.svg?style=flat)](https://packagist.org/packages/riipandi/laravel-optikey)
[![Treeware](https://img.shields.io/badge/dynamic/json?color=brightgreen&label=Treeware&query=%24.total&url=https%3A%2F%2Fpublic.offset.earth%2Fusers%2Ftreeware%2Ftrees)](https://treeware.earth)

Use UUID or Ulid as optional or primary key in Laravel.

```bash
composer require riipandi/laravel-optikey
```

This package adds a very simple trait to automatically generate a UUID or Ulid for your Models.

## Quick Start

### Update your schemas

First, you need to add uuid or ulid column in your migration. For example:

```sh
php artisan make:migration AddUuidColumnToUsersTable
```

In this case you will use UUID as secondary key:

```php
$table->uuid('uuid')->after('id')->unique()->index();
```

In this case you will use UUID as primary key:

```php
$table->uuid('id')->primary();
```

Sample migration:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUlidColumnToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('ulid', 26)->unique()->index()->after('id');
        });
    }
    
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('ulid');
        });
    }
}
```

### Using UUID

Add the "\Riipandi\LaravelOptiKey\Traits\HasUuidKey;" trait to your model:

```php
<?php

namespace App;

use Riipandi\LaravelOptiKey\Traits\HasUuidKey;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasUuidKey;
}
```

If your column name is not "uuid", simply add a new property to your model named "optiKeyFieldName":

```php
protected $optiKeyFieldName = 'unique_id';
```

This trait also adds a scope:

```php
\App\User::byUuid('uuid')->first();
```

And static find method:

```php
\App\User::findByUuid('uuid')
```

A second trait is available if you use your UUIDs as primary keys:

```php
<?php

namespace App;

use Riipandi\LaravelOptiKey\Traits\HasUuidKey;
use Riipandi\LaravelOptiKey\Traits\UuidAsPrimaryKey;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasUuidKey, UuidAsPrimaryKey;
}
```

### Using Ulid

Add the "\Riipandi\LaravelOptiKey\Traits\HasUlidKey;" trait to your model:

```php
<?php

namespace App;

use Riipandi\LaravelOptiKey\Traits\HasUlidKey;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasUlidKey;
}
```

If your column name is not "ulid", simply add a new property to your model named "optiKeyFieldName":

```php
protected $optiKeyFieldName = 'unique_id';
```

This trait also adds a scope:

```php
\App\User::byUlid('ulid')->first();
```

And static find method:

```php
\App\User::findByUlid('ulid')
```

A second trait is available if you use your Ulids as primary keys:

```php
<?php

namespace App;

use Riipandi\LaravelOptiKey\Traits\HasUlidKey;
use Riipandi\LaravelOptiKey\Traits\UlidAsPrimaryKey;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasUlidKey, UlidAsPrimaryKey;
}
```

It simply tells Laravel that your primary key isn't an auto-incrementing integer, so it will treat the value correctly.

## Licence

This project is licensed under MIT: <https://aris.mit-license.org>

Copyrights in this project are retained by their contributors.
No copyright assignment is required to contribute to this project.

[choosealicense]:https://choosealicense.com/licenses/mit/

This package is [Treeware](https://treeware.earth). If you use it in production, then we ask that you [**buy the world a tree**](https://plant.treeware.earth/riipandi/laravel-optikey) to thank us for our work. By contributing to the Treeware forest you’ll be creating employment for local families and restoring wildlife habitats.

Please see [license file](./license.txt) for more information.
