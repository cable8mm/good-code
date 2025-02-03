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

Facades provides a simple implementation for `set-code`:

```php
<?php
print GoodCode::of('SET7369x4zz4235x6')->value();
//=> ['7369'=>4,'4235'=>6]

print GoodCode::setCodeOf(
    [
        '1234' => 2,
        '5678' => 1,
    ]
)->code();
//=> 'set1234x2ZZ5678x1'
```

Facades provides a simple implementation for `complex-code`:

```php
print GoodCode::of('COM10', callback: function ($key) {
    $a = [
        10 => '123',
    ];

    return $a[$key];
})->value();
//=> '123'
```

Facades provides a simple implementation for `gift-code`:

```php
print GoodCode::of('GIF11', callback: function ($key) {
    $a = [
        11 => '456',
    ];

    return $a[$key];
});
//=> '456'
```

Facades provides a simple implementation for `option-code`:

> [!TIP]
> `option-code` are matching with **both** `option-code` **and** `option-good-option` name. Unfortunately all of online shops like Coupang and 11st have not send any key for option to sellers.

```php
print GoodCode::of($optionCode, option: $optionName, callback: function ($key, $option) {
    $a = [
        10 => [
            'Super Smash Bros. Ultimate' => 'COM4',
            'Animal Crossing: New Horizons' => '3124',
            'The Legend of Zelda: Tears of the Kingdom' => '1234',
            'Call of Duty®: Black Ops 6' => '2314',
            'Grand Theft Auto V' => '43123',
            '42342', 'name' => 'Marvel\'s Spider-Man 2',
        ],
    ];

    return $a[$key][$option];
})->value();
//=> '3124'

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
