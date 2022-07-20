# Laravel Manager Extension - Get available drivers
This is a simple manager extension to retrieve all the available drivers for a particular manager class.

## How to use
Essentially, instead of extending your custom manager class with the `Manager` class, you instead add the `BaseManager` class in this repo into your project, and then extend your customer class with `BaseManager`, and it will work the same as it would otherwise, but also have access to the `getAvailableDrivers` function.

```php
<?php

use App\Managers\BaseManager;

class ExampleManager extends BaseManager
{
//
}
```
