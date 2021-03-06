# Maintenance module for Craft CMS 3.x

All the tools needed to keep the app running smoothly.

## Requirements

This module requires Craft CMS 3.0.0-RC1 or later.

## Installation

To install the module, follow these instructions.

First, you'll need to add the contents of the `app.php` file to your `config/app.php` (or just copy it there if it does not exist). This ensures that your module will get loaded for each request. The file might look something like this:
```
return [
    'modules' => [
        'maintenance-module' => [
            'class' => \y7k\maintenancemodule\MaintenanceModule::class,
            'components' => [
                'cachewarmer' => [
                    'class' => 'y7k\maintenancemodule\services\Cachewarmer',
                ],
            ],
        ],
    ],
    'bootstrap' => ['maintenance-module'],
];
```

After you have added this, you will need to do:

    composer dump-autoload

 …from the project’s root directory, to rebuild the Composer autoload map. This will happen automatically any time you do a `composer install` or `composer update` as well.

## Maintenance Overview

### Cachewarming

This plugin exposes two console commands:

```
php craft maintenance-module/cachewarmer/purge-and-warm
php craft maintenance-module/cachewarmer/purge-cache
```

## Maintenance Roadmap

Some things to do, and ideas for potential features:

Brought to you by [Y7K](y7k.com)
