<?php

namespace App\Enums\ViewPaths\Admin;

enum Quotation{
    const BULK = [
        URI => 'quotation/bulk',
        VIEW => 'admin-views.quotation.bulk-import',
    ];

    const EDIT = [
        URI => 'quotation/edit',
        VIEW => 'admin-views.quotation.edit',
    ];

    const LIST = [
        URI => 'quotation/list',
        VIEW => 'admin-views.quotation.list',
    ];

    const VIEW = [
        URI => 'quotation/view',
        VIEW => 'admin-views.quotation.view',
    ];
}