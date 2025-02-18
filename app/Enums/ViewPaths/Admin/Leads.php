<?php

namespace App\Enums\ViewPaths\Admin;

enum Leads{
    CONST BUYER = [
        URI => 'buyers',
        VIEW => 'views.leads.buyer',
    ];

    CONST SELLER = [
        URI => 'sellers',
        VIEW => 'views.leads.seller',
    ];

    const ADD = [
        URI => 'leads/add-new',
        VIEW => 'admin-views.leads.add-new',
    ];

    const BULK = [
        URI => 'leads/bulk',
        VIEW => 'admin-views.leads.bulk-import',
    ];

    const EDIT = [
        URI => 'leads/edit',
        VIEW => 'admin-views.leads.edit',
    ];

    const LIST = [
        URI => 'leads/list',
        VIEW => 'admin-views.leads.list',
    ];

    const VIEW = [
        URI => 'leads/view',
        VIEW => 'admin-views.leads.view',
    ];

    const VADD = [
        URI => 'leads/add-new',
        VIEW => 'vendor-views.leads.add-new',
    ];

    const VBULK = [
        URI => 'leads/bulk',
        VIEW => 'vendor-views.leads.bulk-import',
    ];

    const VEDIT = [
        URI => 'leads/edit',
        VIEW => 'vendor-views.leads.edit',
    ];

    const VLIST = [
        URI => 'leads/list',
        VIEW => 'vendor-views.leads.list',
    ];

    const VVIEW = [
        URI => 'leads/view',
        VIEW => 'vendor-views.leads.view',
    ];
}