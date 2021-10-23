<div id="sidebar" class="sidebar">
    <div data-scrollbar="true" data-height="100%">
        <ul class="nav">
            <li class="nav-profile">
                <div class="image">
                    <a href="javascript:;"><img src="{{ asset('vendor/assets/img/user-13.jpg') }}" alt="" /></a>
                </div>
                <div class="info">
                    {{ Auth::user()->name }}
                    <small>{{ Auth::user()->email }}</small>
                </div>
            </li>
        </ul>
        <ul class="nav">
            <li class="nav-header">Navigation</li>
            {{-- menu dashboard --}}
            <li class="{{ set_active('dashboard.index') }}">
                <a href="{{ route('dashboard.index') }}">
                    <i class="fa fa-laptop"></i>
                    <span>{{ trans('dashboard.link.dashboard') }}</span>
                </a>
            </li>
            {{-- menu master data --}}
            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-list"></i>
                    <span>{{ trans('dashboard.menu.master') }}</span>
                </a>
                <ul class="sub-menu" style="display: none;">
                    <li>
                        <a href="{{ route('matauang.index') }}">
                            {{ trans('dashboard.menu.matauang') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('rate-matauang.index') }}">
                            {{ trans('dashboard.menu.rate_matauang') }}
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('bank.index') }}">
                            {{ trans('dashboard.menu.bank') }}
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('rekening-bank.index') }}">
                            {{ trans('dashboard.menu.rekening_bank') }}
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('supplier.index') }}">
                            {{ trans('dashboard.menu.supplier') }}
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('area.index') }}">
                            {{ trans('dashboard.menu.area') }}
                        </a>
                    </li>

                    <li>
                        <a
                            href="{{ route('satuan-barang.index') }}">{{ trans('dashboard.menu.satuan_barang') }}</a>
                    </li>

                    <li>
                        <a href="{{ route('pelanggan.index') }}">
                            {{ trans('dashboard.menu.pelanggan') }}
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('salesman.index') }}">
                            {{ trans('dashboard.menu.salesman') }}
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('gudang.index') }}">
                            {{ trans('dashboard.menu.gudang') }}
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('kategori.index') }}">
                            {{ trans('dashboard.menu.kategori') }}
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('barang.index') }}">
                            {{ trans('dashboard.menu.barang') }}
                        </a>
                    </li>
                </ul>
            </li>

            {{-- menu inventory --}}
            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-archive"></i>
                    <span>{{ trans('dashboard.menu.inventory') }}</span>
                </a>
                <ul class="sub-menu" style="display: none;">
                    <li>
                        <a href="{{ route('adjustment-plus.index') }}">
                            {{ trans('dashboard.menu.adjustment_plus') }}
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('adjustment-minus.index') }}">
                            {{ trans('dashboard.menu.adjustment_minus') }}
                        </a>
                    </li>
                </ul>
            </li>

            {{-- menu pembelian --}}
            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-briefcase"></i>
                    <span>{{ trans('dashboard.menu.pembelian') }}</span>
                </a>
                <ul class="sub-menu" style="display: none;">
                    <li>
                        <a href="{{ route('pesanan-pembelian.index') }}">
                            {{ trans('dashboard.menu.pesanan_pembelian') }}
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('pembelian.index') }}">
                            {{ trans('dashboard.menu.pembelian') }}
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('retur-pembelian.index') }}">
                            {{ trans('dashboard.menu.retur_pembelian') }}
                        </a>
                    </li>
                </ul>
            </li>

            {{-- menu Setting --}}
            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-gear"></i>
                    <span>{{ trans('dashboard.menu.setting') }}</span>
                </a>
                <ul class="sub-menu" style="display: none;">
                    <li>
                        <a href="{{ route('toko.index') }}">
                            {{ trans('dashboard.menu.toko') }}
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify">
                    <i class="fa fa-angle-double-left"></i>
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="sidebar-bg"></div>
