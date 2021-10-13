<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard.index'));
});
// Master
Breadcrumbs::for('master', function (BreadcrumbTrail $trail) {
    $trail->push('Master Data');
});
// Master Data > Mata Uang
Breadcrumbs::for('matauang', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Mata Uang', route('matauang.index'));
});
// Master Data > Mata Uang > Tambah
Breadcrumbs::for('matauang_add', function (BreadcrumbTrail $trail) {
    $trail->parent('matauang');
    $trail->push('Tambah', route('matauang.create'));
});
// Master Data > Mata Uang > Tambah
Breadcrumbs::for('matauang_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('matauang');
    $trail->push('Edit');
});



// Master Data > Rate Mata Uang
Breadcrumbs::for('rate_matauang', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Rate Mata Uang', route('rate-matauang.index'));
});

// Master Data > Rate Mata Uang > Tambah
Breadcrumbs::for('rate_matauang_add', function (BreadcrumbTrail $trail) {
    $trail->parent('rate_matauang');
    $trail->push('Tambah', route('rate-matauang.create'));
});

// Master Data > Rate Mata Uang > Edit
Breadcrumbs::for('rate_matauang_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('rate_matauang');
    $trail->push('Edit');
});



// Master Data > Bank
Breadcrumbs::for('bank', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Bank', route('bank.index'));
});

// Master Data > Bank > Tambah
Breadcrumbs::for('bank_add', function (BreadcrumbTrail $trail) {
    $trail->parent('bank');
    $trail->push('Tambah', route('bank.create'));
});

// Master Data > Bank > Edit
Breadcrumbs::for('bank_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('bank');
    $trail->push('Edit');
});




// Master Data > Rekening Bank
Breadcrumbs::for('rekening_bank', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Rekening Bank', route('rekening-bank.index'));
});

// Master Data > Rekening Bank > Tambah
Breadcrumbs::for('rekening_bank_add', function (BreadcrumbTrail $trail) {
    $trail->parent('rekening_bank');
    $trail->push('Tambah', route('rekening-bank.create'));
});

// Master Data > Rekening Bank > Edit
Breadcrumbs::for('rekening_bank_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('rekening_bank');
    $trail->push('Edit');
// Master Data > Satuan Barang
Breadcrumbs::for('satuanbarang', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Satuan Barang', route('satuan-barang.index'));
});




// Master Data > Supplier
Breadcrumbs::for('supplier', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Supplier', route('supplier.index'));
});

// Master Data > Supplier > Tambah
Breadcrumbs::for('supplier_add', function (BreadcrumbTrail $trail) {
    $trail->parent('supplier');
    $trail->push('Tambah', route('supplier.create'));
});

// Master Data > Supplier > Edit
Breadcrumbs::for('supplier_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('supplier');
    $trail->push('Edit');
});




// Master Data > Area
Breadcrumbs::for('area', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Area', route('area.index'));
});

// Master Data > Area > Tambah
Breadcrumbs::for('area_add', function (BreadcrumbTrail $trail) {
    $trail->parent('area');
    $trail->push('Tambah', route('area.create'));
});

// Master Data > Area > Edit
Breadcrumbs::for('area_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('area');
    $trail->push('Edit');
});
