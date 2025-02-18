<?php

namespace App\Enums\ViewPaths\Admin;

enum Tradeshow{
    const ADD = [
        URI => 'tradeshow/add-new',
        VIEW => 'admin-views.tradeshow.add-new',
    ];

    const BULK = [
        URI => 'tradeshow/bulk',
        VIEW => 'admin-views.tradeshow.bulk-import',
    ];

    const EDIT = [
        URI => 'tradeshow/edit',
        VIEW => 'admin-views.tradeshow.edit',
    ];

    const LIST = [
        URI => 'tradeshow/list',
        VIEW => 'admin-views.tradeshow.list',
    ];

    const VIEW = [
        URI => 'tradeshow/view',
        VIEW => 'admin-views.tradeshow.view',
    ];
}