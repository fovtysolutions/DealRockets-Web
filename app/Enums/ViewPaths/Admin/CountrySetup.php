<?php

namespace App\Enums\ViewPaths\Admin;

enum CountrySetup
{
    const LIST = [
        'URI' => 'list',
        'VIEW' => 'admin-views.country-setup.index',
    ];

    const UPDATE = [
        'URI' => 'update',
        'VIEW' => 'admin-views.country-setup.update',
    ];

    const STATUS = [
        'URI' => 'status',
    ];

    const DELETE = [
        'URI' => 'delete',
    ];
}