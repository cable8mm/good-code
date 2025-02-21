# Release Notes

## v2.6.0 - 2025-02-21

### What's Changed

* Set `prefix` of receipt code changeable by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/good-code/pull/22

**Full Changelog**: https://github.com/cable8mm/good-code/compare/v2.5.1...v2.6.0

## v2.5.1 - 2025-02-21

### What's Changed

* Set `of()` to be nullable in `ReceiptCode` by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/good-code/pull/21

**Full Changelog**: https://github.com/cable8mm/good-code/compare/v2.5.0...v2.5.1

## v2.5.0 - 2025-02-20

### What's Changed

* Give production codes on the README by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/good-code/pull/18
* Write comments of classes all by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/good-code/pull/19
* Add receipt code classes by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/good-code/pull/20

**Full Changelog**: https://github.com/cable8mm/good-code/compare/v2.4.0...v2.5.0

## v2.4.0 - 2025-02-04

### What's Changed

* Provide `SetGood` class and parsed apis by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/good-code/pull/17

**Full Changelog**: https://github.com/cable8mm/good-code/compare/v2.3.0...v2.4.0

## v2.3.0 - 2025-02-03

### What's Changed

* Redesign all of codes by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/good-code/pull/16

**Full Changelog**: https://github.com/cable8mm/good-code/compare/v2.2.0...v2.3.0

## v2.2.0 - 2025-02-03

### What's Changed

* Make `GoodCodeType` enum and `GoodCodeType::of()` method by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/good-code/pull/15

**Full Changelog**: https://github.com/cable8mm/good-code/compare/v2.1.0...v2.2.0

## v2.1.0 - 2025-02-01

### What's Changed

* Add static facade for easy-going by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/good-code/pull/14

**Full Changelog**: https://github.com/cable8mm/good-code/compare/v2.0.0...v2.1.0

## v2.0.0 - 2025-01-21

### What's Changed

* Revise package description by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/good-code/pull/12
* Change package name to `cable8mm/good-code` by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/good-code/pull/13

**Full Changelog**: https://github.com/cable8mm/good-code/compare/v1.0.3...v2.0.0

## v1.0.3 - 2024-03-09

### What's Changed

* Fix the package name by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/good-code-parser/pull/11

**Full Changelog**: https://github.com/cable8mm/good-code-parser/compare/v1.0.2...v1.0.3

## v1.0.2 - 2024-03-09

### What's Changed

* Add classes and methods comments for API Documentation by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/good-code-parser/pull/9
* Organizing various document wordings by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/good-code-parser/pull/10

**Full Changelog**: https://github.com/cable8mm/good-code-parser/compare/v1.0.1...v1.0.2

## v1.0.1 - 2024-03-03

### What's Changed

* Add phpunit config file by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/good-code-parser/pull/7
* Revise readme and composer config by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/good-code-parser/pull/8

**Full Changelog**: https://github.com/cable8mm/good-code-parser/compare/v1.0.0...v1.0.1

## v1.0.0 - 2024-03-03

### What's Changed

* Fix namespace of test classes by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/good-code-parser/pull/2
* Add github actions by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/good-code-parser/pull/3
* Fix some errors of ci by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/good-code-parser/pull/4
* Add changelog action by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/good-code-parser/pull/5
* Change package name to esc-company/good-code-parser by [@cable8mm](https://github.com/cable8mm) in https://github.com/cable8mm/good-code-parser/pull/6

**Full Changelog**: https://github.com/cable8mm/good-code-parser/compare/v0.8...v1.0.0

## v0.8 - 2023-07-19

### What's Changed

- Change namespace by @cable8mm in https://github.com/cable8mm/good-code-parser/pull/1

### New Contributors

- @cable8mm made their first contribution in https://github.com/cable8mm/good-code-parser/pull/1

**Full Changelog**: https://github.com/cable8mm/good-code-parser/compare/0.7.1...v0.8

## v0.7.1 - 2021-11-09

Feature : Setcode default value. The patch apply setcode default value.

```php
    public function test_세트코드_축약버전_파싱이_되는지()
    {
        // Arrange
        $input = 'set107253x1ZZ102257ZZ104128x2';
        $expect = [
            '107253' => 1,
            '102257' => 1, // 이 값은 코드에 없기 때문에 1(default value)로 처리됨.
            '104128' => 2,
        ];

        // Act
        $parsed = (new GoodCodeParser($input))->with(SetGood::class)->get();

        // Assert
        $this->assertEquals($parsed, $expect);
    }












```
## v0.7.0 - 2020-05-22

Launch code parser for Ecommerce
