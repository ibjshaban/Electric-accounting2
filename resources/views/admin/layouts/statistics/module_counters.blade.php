<!--admingroups_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{ App\Models\AdminGroup::count() }}</h3>
        <p>{{ trans('admin.admingroups') }}</p>
      </div>
      <div class="icon">
        <i class="fas fa-users"></i>
      </div>
      <a href="{{ aurl('admingroups') }}" class="small-box-footer">{{ trans('admin.admingroups') }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
<!--admingroups_end-->
<!--admins_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{ App\Models\Admin::count() }}</h3>
        <p>{{ trans('admin.admins') }}</p>
      </div>
      <div class="icon">
        <i class="fas fa-users"></i>
      </div>
      <a href="{{ aurl('admins') }}" class="small-box-footer">{{ trans('admin.admins') }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
<!--admins_end-->

<!--city_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\City::count()) }}</h3>
        <p>{{ trans("admin.city") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-city"></i>
      </div>
      <a href="{{ aurl("city") }}" class="small-box-footer">{{ trans("admin.city") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--city_end-->

<!--stock_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\Stock::count()) }}</h3>
        <p>{{ trans("admin.stock") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-window-maximize"></i>
      </div>
      <a href="{{ aurl("stock") }}" class="small-box-footer">{{ trans("admin.stock") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--stock_end-->
<!--supplier_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\Supplier::count()) }}</h3>
        <p>{{ trans("admin.supplier") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-users"></i>
      </div>
      <a href="{{ aurl("supplier") }}" class="small-box-footer">{{ trans("admin.supplier") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--supplier_end-->
<!--employeetype_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\EmployeeType::count()) }}</h3>
        <p>{{ trans("admin.employeetype") }}</p>
      </div>
      <div class="icon">
        <i class="fab fa-typo3"></i>
      </div>
      <a href="{{ aurl("employeetype") }}" class="small-box-footer">{{ trans("admin.employeetype") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--employeetype_end-->
<!--revenue_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\revenue::count()) }}</h3>
        <p>{{ trans("admin.revenue") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-layer-group"></i>
      </div>
      <a href="{{ aurl("revenue") }}" class="small-box-footer">{{ trans("admin.revenue") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--revenue_end-->
