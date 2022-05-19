# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0] - 2022-05-20
- Update Laravel 9 support.
- Add support for `nanoid` as key, trait `HasNanoidKey`
- Add optional prefix to key, trait `HasNanoidKey` and `HasUlidKey`
- Change `Str::uuid()` to `Str::orderedUuid()` (timestamp based)
- Change `UuidAsPrimaryKey` trait to `OptiKeyAsPrimary`
- Change `UlidAsPrimaryKey` trait to `OptiKeyAsPrimary`

## [1.4] - 2021-01-31
- Fix minimal PHP requirements to ^7.3 | ^8.0
- Change variable `$uuidFieldName` to `$optiKeyFieldName`
- Change variable `$ulidFieldName` to `$optiKeyFieldName`
- Change license from Apache 2.0 to MIT

## [1.3] - 2020-12-21
- Update Laravel 8 support.

## [1.2] - 2020-03-04
- Add Laravel v7 and lowercase ULID option.

## [1.1] - 2020-01-25
- Fix PHP and Laravel requirements

## [1.0] - 2020-01-24
- Initial release
