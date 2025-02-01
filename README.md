# Good Code Parser

[![code-style](https://github.com/cable8mm/good-code/actions/workflows/code-style.yml/badge.svg)](https://github.com/cable8mm/good-code/actions/workflows/code-style.yml)
[![run-tests](https://github.com/cable8mm/good-code/actions/workflows/run-tests.yml/badge.svg)](https://github.com/cable8mm/good-code/actions/workflows/run-tests.yml)
![Packagist Version](https://img.shields.io/packagist/v/cable8mm/good-code)
![Packagist Downloads](https://img.shields.io/packagist/dt/cable8mm/good-code)
![Packagist Dependency Version](https://img.shields.io/packagist/dependency-v/cable8mm/good-code/php)
![Packagist Stars](https://img.shields.io/packagist/stars/cable8mm/good-code)
![Packagist License](https://img.shields.io/packagist/l/cable8mm/good-code)

A robust code specification is crucial within the commercial market industry, especially for online stores like Amazon. The integration of online stores with Warehouse Management Systems (WMS) is essential as both systems handle extensive seller and product data. Therefore, we recommend implementing a solid structure and providing robust support for these systems.

These specifications cover a variety of online stores, including Coupang, 11th Street, Naver Storefarm, and many others for a while.

We have provided the API Documentation on the web. For more information, please visit <https://www.palgle.com/good-code/> ❤️

## Features

- [x] General good code parser
- [x] Gift good code parser
- [x] Set good code parser
- [x] Complex good code parser
- [x] Option Good code parser(No code, name matched by name)

## Install

```bash
composer require cable8mm/good-code
```

## Usage

```php
<?php

print GoodCode::getSetCodes('set7369x4ZZ4235x6')
//=> ['7369'=>4,'4235'=>6]

print GoodCode::makeSetCode(
    [
        '1234' => 2,
        '5678' => 1,
    ]
)
//=> set1234x2ZZ5678x1

print GoodCode::getId('COM10')
//=> 10

print GoodCode::getId('GIF239')
//=> 239

$parsed = (new GoodCodeParser('com2'))->with(ComplexGood::class, [
    1 => 'set11319x1ZZ11626x1ZZ11624x1ZZ11628x1',
    2 => 'set11318x1ZZP3800x1ZZP7776x1ZZP9732x1',
    3 => 'set11318x1ZZP2526x1ZZP7776x1'
])->get();

// set11318x1ZZP3800x1ZZP7776x1ZZP9732x1

$parsed = (new GoodCodeParser('gif1'))->with(GiftGood::class, [
    1 => 'set11319x1ZZ11626x1ZZ11624x1ZZ11628x1',
    2 => 'set11318x1ZZP3800x1ZZP7776x1ZZP9732x1',
    3 => 'set11318x1ZZP2526x1ZZP7776x1'
])->get();

// set11319x1ZZ11626x1ZZ11624x1ZZ11628x1

$inOptionCode = 'OPT1';
$inOptionName = 'Super Smash Bros. Ultimate';

$parsed = (new OptionCodeParser($inOptionCode, $inOptionName))
    ->with(OptionGood::class, [
            ['id' => 1, 'code' => 'OPT1', 'name' => 'Nintendo Switch Super Sales'],
            ['id' => 2, 'code' => 'OPT2', 'name' => 'Playstation Super Sales'],
        ], [
            ['code' => 1, 'master_code' => 'COM4', 'name' => 'Super Smash Bros. Ultimate'],
            ['code' => 1, 'master_code' => '3124', 'name' => 'Animal Crossing: New Horizons'],
            ['code' => 1, 'master_code' => '1234', 'name' => 'The Legend of Zelda: Tears of the Kingdom'],
            ['code' => 1, 'master_code' => '4324', 'name' => 'Super Mario 3D World + Bowser\'s Fury'],
            ['code' => 2, 'master_code' => '2314', 'name' => 'Call of Duty®: Black Ops 6'],
            ['code' => 2, 'master_code' => '43123', 'name' => 'Grand Theft Auto V'],
            ['code' => 2, 'master_code' => '42342', 'name' => 'Marvel\'s Spider-Man 2'],
        ])
    ->get();

// COM4

```

## Formatting

```sh
composer lint
```

## Test

```sh
composer test
```

## Support codes

| Type           | Notation | Description                                                                                                                      | Implement |
| -------------- | -------- | -------------------------------------------------------------------------------------------------------------------------------- | --------- |
| `Normal Code`  | -        | Match only one good                                                                                                              | Yes       |
| `Set Code`     | SET      | Match one more good, max 255 characters                                                                                          | Yes       |
| `Complex Code` | COM      | Shorten code for `Set Code`                                                                                                      | Yes       |
| `Gift Code`    | GIF      | Alias `Complex Code`                                                                                                             | Yes       |
| `Option Code`  | OPT      | Very complicated code. Not mastercode, but code + search name.(eq. wemakeprice, naver petWindow and all most OpenMarket options) | Yes       |

## License

The Phpunit Start Kit is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
