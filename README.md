# php-tracking

## Installation

```bash
composer require affise/php-tracking:^1.0
```

## Documentation

The links bellow should provide all the documentation needed to make the best
use of the library:

- [Documentation](https://help-center.affise.com/en/articles/6466563-postback-integration-s2s-admins)

## Usage

### Clicks

```php
<?php

use Affise\Tracking\Cookie;
use Affise\Tracking\CookieInvalidParamException;
use Affise\Tracking\CookieUnsetException;

try {
    Cookie::set();
}
catch (CookieInvalidParamException $e) {
    echo "Invalid click id param\n";
}
catch (CookieUnsetException $e) {
    echo "Failed to set cookie\n";
}
```

### Conversions

```php
<?php

use Affise\Tracking\PostbackSender;

$sender = new PostbackSender("example.com");

try {
    $sender->send(['clickID' => '111111111111111111111111']);
}
catch (PostbackInvalidClickIDException $e) {
    echo "Invalid click id\n";
} 
```
