# Extract keyword with Rake algorithm

[![Latest Version on Packagist](https://img.shields.io/packagist/v/phamluann/rake.svg?style=flat-square)](https://packagist.org/packages/phamluann/rake)
[![Total Downloads](https://img.shields.io/packagist/dt/phamluann/rake.svg?style=flat-square)](https://packagist.org/packages/phamluann/rake)


## Installation

You can install the package via composer:

```bash
composer require phamluann/rake
```

## Usage
- get file content:
```php
$str = file_get_contents(__DIR__ . '/your-file');
```
- example index.php
```php
<?php
require __DIR__ . '/vendor/autoload.php';
use PhamLuann\Rake\Rake;
$str = file_get_contents(__DIR__ . '/src/stopword/text.txt');
$rake = new Rake($str);
$keyWords = $rake->getKeyword();

$result = '';
foreach ($keyWords as $keyWord => $score) {
    $result .= $keyWord . ' ==> ' . $score . "\n\r";
}
echo $result;
?>
```
### Security

If you discover any security related issues, please email pvluan17@gmail.com instead of using the issue tracker.

## Credits

-   [Luan Pham](https://github.com/phamluann)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
