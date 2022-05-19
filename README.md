# Laravel OptiKey

[![Build Status](https://travis-ci.com/riipandi/laravel-optikey.svg?branch=master)](https://travis-ci.com/riipandi/laravel-optikey)
[![StyleCI](https://github.styleci.io/repos/235965192/shield?branch=master)](https://github.styleci.io/repos/235965192)
[![Latest Stable Version](http://img.shields.io/packagist/v/riipandi/laravel-optikey.svg?style=flat)](https://packagist.org/packages/riipandi/laravel-optikey)
[![Total Downloads](http://img.shields.io/packagist/dt/riipandi/laravel-optikey.svg?style=flat)](https://packagist.org/packages/riipandi/laravel-optikey)
[![Treeware](https://img.shields.io/badge/dynamic/json?color=brightgreen&label=Treeware&query=%24.total&url=https%3A%2F%2Fpublic.offset.earth%2Fusers%2Ftreeware%2Ftrees)](https://treeware.earth)

Use UUID, Ulid, or nanoid as optional or primary key in Laravel.

```bash
composer require riipandi/laravel-optikey
```

This package adds a very simple trait to automatically generate a UUID, Ulid, or nanoid for your Models.

## ✌️ Using as Secondary Key

### 1. Update your schemas

First, you need to add an extra column in your migration. For example:

```sh
php artisan make:migration AddOptikeyToUsersTable
```

```php
// If using UUID for the key
$table->uuid('uid')->after('id')->unique()->index();

// If using nanoid or ulid for the key
$table->string('uid')->after('id')->unique()->index();
```

Sample migration:

```php
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOptikeyToUsersTable extends Migration
{
    public function up()
    {
        // Add uid column to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('uid', 26)->index()->after('id');
        });

        // Prefill uid column in users table
        Schema::table('users', function (Blueprint $table) {
            $results = DB::table('users')->select('id')->get();
            foreach ($results as $result) {
                $ulid = \Ulid\Ulid::generate($lowercase = true); // Generate new lowercase Ulid
                $generated = 'user_'.$ulid; // this is the generated value with optional prefix
                DB::table('users')->where('id', $result->id)->update(['uid' => $generated]);
            }
        });

        // Set uid column as unique
        Schema::table('users', function (Blueprint $table) {
            $table->unique('uid');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('uid');
        });
    }
}
```

### 2. Add the trait

Add the trait to your model (pick one between `HasUuidKey`, `HasUlidKey`, or `HasNanoidKey`):

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Riipandi\LaravelOptiKey\Traits\HasNanoidKey;

class User extends Model
{
    use HasNanoidKey;

    protected $optiKeyFieldName = 'uid';   // mandatory (you can change this field name)
    protected $optiKeyLowerCase = true;    // optional (default: false)
    protected $optiKeyPrefix = 'user_';    // optional (default: null)

    ....
}
```

### 3. Get Record using the key

Using scope:

```php
\App\User::byOptiKey('xxxxxxxxxxx')->first();
```

Or, using static find method:

```php
\App\User::findByOptiKey('xxxxxxxxxxx');
```

## ☝️ Using as Primary Key

You need to change the primary key field type in your migration. For example:

```php
$table->uuid('id')->primary();         // for UUID
$table->string('id', 26)->primary();   // for Ulid
$table->string('id', 16)->primary();   // for nanoid
```

Add second trait to use as primary key:

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Riipandi\LaravelOptiKey\Traits\HasUlidKey;
use Riipandi\LaravelOptiKey\Traits\OptiKeyAsPrimary;

class User extends Model
{
    use HasUlidKey;
    use OptiKeyAsPrimary;

    protected $optiKeyFieldName = 'id';

    ...
}
```

It simply tells Laravel that your primary key isn't an auto-incrementing integer, so it will treat the value correctly.

## 📝 Important Note

You can use `prefix` option to add a prefix to the generated key.

- [x] Default lengt for Ulid is 26 characters.
- [x] Default length for nanoid is 16 characters.
- [x] If you want to use prefix, set larger length.

## Licence

This project is licensed under MIT: <https://aris.mit-license.org>

Copyrights in this project are retained by their contributors.
No copyright assignment is required to contribute to this project.

[choosealicense]:https://choosealicense.com/licenses/mit/

This package is [Treeware](https://treeware.earth). If you use it in production, then we ask that you [**buy the world a tree**](https://plant.treeware.earth/riipandi/laravel-optikey) to thank us for our work. By contributing to the Treeware forest you’ll be creating employment for local families and restoring wildlife habitats.

Please see [license file](./license.txt) for more information.
