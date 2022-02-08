  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand
 {{ !empty(setting()->theme_setting) &&
    !empty(setting()->theme_setting->navbar)?
    setting()->theme_setting->navbar:'navbar-dark' }}
{{ !empty(setting()->theme_setting) &&
   !empty(setting()->theme_setting->main_header)?
    setting()->theme_setting->main_header:'' }}
    ">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ aurl('logout') }}" class="nav-link"><i class="nav-icon fas fa-sign-out-alt"></i> {{ trans('admin.logout') }}</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ aurl('lock/screen') }}?email={{ admin()->user()->email }}" class="nav-link"><i class="nav-icon fa fa-user-lock"></i> {{ trans('admin.lock_screen') }}</a>
      </li>
        <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ aurl('supplier') }}" class="nav-link"><i class="nav-icon fa fa-users"></i> {{ trans('admin.supplier') }}</a>
      </li>
      {{-- <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> --}}
    </ul>

    <!-- SEARCH FORM -->
    {{-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> --}}


    <!-- Right navbar links -->
    <ul class="navbar-nav mr-auto-navbav">

      <!-- Messages Dropdown Menu -->
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-box-open fa-lg"></i>
          <span class="badge badge-warning navbar-badge" style="width: 100%; font-size: 14px; top: -7px;">{{ShekelFormat($box_total)}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg notifications {{ app('l') == 'ar'?'dropdown-menu-right':'dropdown-menu-left' }}">
          <span class="dropdown-item dropdown-header"> <i class="fa fa-box-open fa-lg pl-2"></i>المجموع: {{ShekelFormat($box_total)}}</span>
          <div class="dropdown-divider"></div>
          <a href="{{aurl('debt')}}" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> الديون: {{ShekelFormat($debts_total)}}
          </a><div class="dropdown-divider"></div>
          <a href="{{aurl('startup')}}" class="dropdown-item">
            <i class="fas fa-file mr-2"></i>المصاريف التشغيلية: {{ShekelFormat($operating_expenses_total)}}
          </a>
            <div class="dropdown-divider"></div>
            <a href="{{aurl('heavy-expenses')}}" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> المصاريف الثقيلة:  {{ShekelFormat($heavy_expenses_total)}}
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{aurl('rentals')}}" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> دفتر الإيجارات: {{ShekelFormat($rent_book_total)}}
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{aurl('other-notebooks')}}" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> دفاتر أخرى: {{ShekelFormat($other_book_total)}}
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{aurl('withdrawals')}}" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> مسحوبات شخصية: {{ShekelFormat($withdrawals_totals)}}
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{aurl('payments')}}" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> دفعات التجار: {{ShekelFormat($payments_totals)}}
            </a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
<!-- /.navbar -->
<!-- Main Sidebar Menu Container -->
<aside class="main-sidebar {{ !empty(setting()->theme_setting) && !empty(setting()->theme_setting->sidebar_class)?setting()->theme_setting->sidebar_class:'sidebar-dark-primary' }} elevation-4">
  <!-- Brand Logo -->
  <a href="{{ aurl('/') }}" class="brand-link {{ !empty(setting()->theme_setting) && !empty(setting()->theme_setting->brand_color)?setting()->theme_setting->brand_color:'' }}">
    @if(!empty(setting()->logo))
    <img src="{{ it()->url(setting()->logo) }}" alt="{{ setting()->{l('sitename')} }}" class="brand-image img-circle elevation-3" style="opacity: .8">
    @endif
    <span class="brand-text font-weight-light">{{ setting()->{l('sitename')} }}</span>
  </a>
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        @if(!empty(admin()->user()->photo_profile))
        <img src="{{ it()->url(admin()->user()->photo_profile) }}" class="img-circle elevation-2" alt="{{ admin()->user()->name }}">
        @else
        <img src="{{ url('assets') }}/img/avatar5.png" class="img-circle elevation-2" alt="{{ admin()->user()->name }}">
        @endif
      </div>
      <div class="info">
        <a href="{{ aurl('account') }}" class="d-block">{{ admin()->user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
