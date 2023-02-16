<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// {url}/dashbaord/
Breadcrumbs::for('dashboard.index', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard.index'));
});

// {url}/master/
Breadcrumbs::for('master', function (BreadcrumbTrail $trail) {
    $trail->push('Master', route('dashboard.index'));
});

// {url}/master/admin/
Breadcrumbs::for('master.admin.index', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Admin', route('admin.index'));
});

// {url}/master/item/
Breadcrumbs::for('master.item.index', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Produk', route('item.index'));
});

Breadcrumbs::for('master.item.add', function (BreadcrumbTrail $trail) {
    $trail->parent('master.item.index');
    $trail->push('Tambah Produk', route('item.add'));
});

Breadcrumbs::for('master.item.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('master.item.index');
    $trail->push('Edit Produk');
});

// {url}/buy/item/
Breadcrumbs::for('buy.items.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard.index');
    $trail->push('Produk', route('items.index'));
});

Breadcrumbs::for('buy.items.history', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard.index');
    $trail->push('Riwayat Pesanan', route('items.history'));
});