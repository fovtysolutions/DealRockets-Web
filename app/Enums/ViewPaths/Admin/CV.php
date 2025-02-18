<?php

namespace App\Enums\ViewPaths\Admin;

enum CV{
    const BULK = [
        URI => 'cv/bulk',
        VIEW => 'admin-views.cv.bulk-import',
    ];

    const EDIT = [
        URI => 'cv/edit',
        VIEW => 'admin-views.cv.edit',
    ];

    const LIST = [
        URI => 'cv/list',
        VIEW => 'admin-views.cv.list',
    ];

    const VIEW = [
        URI => 'cv/view',
        VIEW => 'admin-views.cv.view',
    ];
}