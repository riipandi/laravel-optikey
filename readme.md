# Laravel OptiKey

[![Build Status](https://travis-ci.org/riipandi/laravel-optikey.svg?branch=master)](https://travis-ci.org/riipandi/laravel-optikey)
[![Latest Stable Version](http://img.shields.io/packagist/v/riipandi/laravel-optikey.svg?style=flat)](https://packagist.org/packages/riipandi/laravel-optikey)
[![Total Downloads](http://img.shields.io/packagist/dt/riipandi/laravel-optikey.svg?style=flat)](https://packagist.org/packages/riipandi/laravel-optikey)

Use UUID or Ulid as optional or primary key in Laravel.

```bash
composer require riipandi/laravel-optikey
```

This package adds a very simple trait to automatically generate a UUID or Ulid for your Models.

## Using UUID

First, you need to add uuid column in your migration. For example:

```sh
php artisan make:migration AddUlidColumnToUsersTable
```

In this case you will use UUID as secondary key:

```php
$table->uuid('uuid')->after('id')->unique()->index();
```

In this case you will use UUID as primary key:

```php
$table->uuid('id')->primary();
```

Then add the "\Riipandi\LaravelOptiKey\Traits\HasUuidKey;" trait to your model:

```php
<?php

namespace App;

use Riipandi\LaravelOptiKey\Traits\HasUuidKey;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    use HasUuidKey;

}
```

If your column name is not "uuid", simply add a new property to your model named "uuidFieldName":

```php
protected $uuidFieldName = 'unique_id';
```

This trait also adds a scope:

```php
\App\Project::byUuid('uuid')->first();
```

And static find method:

```php
\App\Project::findByUuid('uuid')
```

A second trait is available if you use your UUIDs as primary keys:

```php
<?php

namespace App;

use Riipandi\LaravelOptiKey\Traits\HasUuidKey;
use Riipandi\LaravelOptiKey\Traits\UuidAsPrimaryKey;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    use HasUuidKey, UuidAsPrimaryKey;

}
```

It simply tells Laravel that your primary key isn't an auto-incrementing integer, so it will treat the value correctly.

## License

Copyright 2020 - Aris Ripandi

Licensed under the [Apache License][choosealicense], Version 2.0 (the "License"); you may not use this
file except in compliance with the License. You may obtain a copy of the License at:
<http://www.apache.org/licenses/LICENSE-2.0>

Unless required by applicable law or agreed to in writing, software distributed under
the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF
ANY KIND, either express or implied. See the License for the specific language
governing permissions and limitations under the License.

[choosealicense]:https://choosealicense.com/licenses/apache-2.0/
