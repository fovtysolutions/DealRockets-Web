<?php

namespace App\Enums\ViewPaths\Admin;

enum Supplier{
    const INDEX = [
        URI => 'suppliers',
        VIEW => 'views.supplier.index',
    ];
    
    const ADD = [
        URI => 'suppliers/add-new',
        VIEW => 'admin-views.supplier.add-new',
    ];

    const BULK = [
        URI => 'suppliers/bulk',
        VIEW => 'admin-views.supplier.bulk-import',
    ];

    const EDIT = [
        URI => 'suppliers/edit',
        VIEW => 'admin-views.supplier.edit',
    ];

    const LIST = [
        URI => 'suppliers/list',
        VIEW => 'admin-views.supplier.list',
    ];

    const VIEW = [
        URI => 'suppliers/view',
        VIEW => 'admin-views.supplier.view',
    ];
}