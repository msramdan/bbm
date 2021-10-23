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
});
// Master Data > Satuan Barang
Breadcrumbs::for('satuanbarang', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Satuan Barang', route('satuan-barang.index'));
});

// Master Data > Satuan Barang > Tambah
Breadcrumbs::for('satuanbarang_add', function (BreadcrumbTrail $trail) {
    $trail->parent('satuanbarang');
    $trail->push('Tambah', route('satuan-barang.create'));
});

// Master Data > Satuan Barang > Tambah
Breadcrumbs::for('satuanbarang_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('satuanbarang');
    $trail->push('Edit');
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

// Master Data > Pelanggan
Breadcrumbs::for('pelanggan', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Pelanggan', route('pelanggan.index'));
});
// Master Data > Pelanggan > Tambah
Breadcrumbs::for('pelanggan_add', function (BreadcrumbTrail $trail) {
    $trail->parent('pelanggan');
    $trail->push('Tambah', route('pelanggan.create'));
});
// Master Data > Pelanggan > Edit
Breadcrumbs::for('pelanggan_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('pelanggan');
    $trail->push('Edit');
});


// Master Data > Salesman
Breadcrumbs::for('salesman', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Salesman', route('salesman.index'));
});
// Master Data > Salesman > Tambah
Breadcrumbs::for('salesman_add', function (BreadcrumbTrail $trail) {
    $trail->parent('salesman');
    $trail->push('Tambah', route('salesman.create'));
});
// Master Data > Salesman > Edit
Breadcrumbs::for('salesman_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('salesman');
    $trail->push('Edit');
});


// Master Data > Gudang
Breadcrumbs::for('gudang', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Gudang', route('gudang.index'));
});
// Master Data > Gudang > Tambah
Breadcrumbs::for('gudang_add', function (BreadcrumbTrail $trail) {
    $trail->parent('gudang');
    $trail->push('Tambah', route('gudang.create'));
});
// Master Data > Gudang > Edit
Breadcrumbs::for('gudang_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('gudang');
    $trail->push('Edit');
});

// Master Data > Kategori
Breadcrumbs::for('kategori', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('kategori', route('kategori.index'));
});
// Master Data > Kategori > Tambah
Breadcrumbs::for('kategori_add', function (BreadcrumbTrail $trail) {
    $trail->parent('kategori');
    $trail->push('Tambah', route('kategori.create'));
});
// Master Data > Kategori > Edit
Breadcrumbs::for('kategori_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('kategori');
    $trail->push('Edit');
});

// Master Data > Barang
Breadcrumbs::for('barang', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Barang', route('barang.index'));
});
// Master Data > Barang > Tambah
Breadcrumbs::for('barang_add', function (BreadcrumbTrail $trail) {
    $trail->parent('barang');
    $trail->push('Tambah', route('barang.create'));
});
// Master Data > Barang > Edit
Breadcrumbs::for('barang_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('barang');
    $trail->push('Edit');
});


// Master Data > Adjustment Plus
Breadcrumbs::for('adjustment_plus', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Adjustment Plus', route('adjustment-plus.index'));
});
// Master Data > Adjustment Plus > Tambah
Breadcrumbs::for('adjustment_plus_add', function (BreadcrumbTrail $trail) {
    $trail->parent('adjustment_plus');
    $trail->push('Tambah', route('adjustment-plus.create'));
});
// Master Data > Adjustment Plus > Edit
Breadcrumbs::for('adjustment_plus_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('adjustment_plus');
    $trail->push('Edit');
});


// Master Data > Adjustment Minus
Breadcrumbs::for('adjustment_minus', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Adjustment Minus', route('adjustment-minus.index'));
});
// Master Data > Adjustment Minus > Tambah
Breadcrumbs::for('adjustment_minus_add', function (BreadcrumbTrail $trail) {
    $trail->parent('adjustment_minus');
    $trail->push('Tambah', route('adjustment-minus.create'));
});
// Master Data > Adjustment Minus > Edit
Breadcrumbs::for('adjustment_minus_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('adjustment_minus');
    $trail->push('Edit');
});


// Master Data > Pesanan Pembelian
Breadcrumbs::for('pesanan_pembelian', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Pesanan Pembelian', route('pesanan-pembelian.index'));
});
// Master Data > Pesanan Pembelian > Tambah
Breadcrumbs::for('pesanan_pembelian_add', function (BreadcrumbTrail $trail) {
    $trail->parent('pesanan_pembelian');
    $trail->push('Tambah', route('pesanan-pembelian.create'));
});
// Master Data > Pesanan Pembelian > Edit
Breadcrumbs::for('pesanan_pembelian_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('pesanan_pembelian');
    $trail->push('Edit');
});
// Master Data > Pesanan Pembelian > Show
Breadcrumbs::for('pesanan_pembelian_show', function (BreadcrumbTrail $trail) {
    $trail->parent('pesanan_pembelian');
    $trail->push('Show');
});


// Master Data > Pembelian
Breadcrumbs::for('pembelian', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Pembelian', route('pembelian.index'));
});
// Master Data > Pembelian > Tambah
Breadcrumbs::for('pembelian_add', function (BreadcrumbTrail $trail) {
    $trail->parent('pembelian');
    $trail->push('Tambah', route('pembelian.create'));
});
// Master Data > Pembelian > Edit
Breadcrumbs::for('pembelian_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('pembelian');
    $trail->push('Edit');
});
// Master Data > Pembelian > Show
Breadcrumbs::for('pembelian_show', function (BreadcrumbTrail $trail) {
    $trail->parent('pembelian');
    $trail->push('Show');
});


// Master Data > Retur
Breadcrumbs::for('retur_pembelian', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Retur', route('retur-pembelian.index'));
});
// Master Data > Retur > Tambah
Breadcrumbs::for('retur_pembelian_add', function (BreadcrumbTrail $trail) {
    $trail->parent('retur_pembelian');
    $trail->push('Tambah', route('retur-pembelian.create'));
});
// Master Data > Retur > Edit
Breadcrumbs::for('retur_pembelian_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('retur_pembelian');
    $trail->push('Edit');
});
// Master Data > Retur > Show
Breadcrumbs::for('retur_pembelian_show', function (BreadcrumbTrail $trail) {
    $trail->parent('retur_pembelian');
    $trail->push('Show');
});
