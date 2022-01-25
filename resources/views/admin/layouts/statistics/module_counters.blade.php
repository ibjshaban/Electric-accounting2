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

<!--debt_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\Debt::count()) }}</h3>
        <p>{{ trans("admin.debt") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-money-check-alt"></i>
      </div>
      <a href="{{ aurl("debt") }}" class="small-box-footer">{{ trans("admin.debt") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--debt_end-->
<!--salary_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\Salary::count()) }}</h3>
        <p>{{ trans("admin.salary") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-money-bill-wave"></i>
      </div>
      <a href="{{ aurl("salary") }}" class="small-box-footer">{{ trans("admin.salary") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--salary_end-->

<!--expenses_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\Expenses::count()) }}</h3>
        <p>{{ trans("admin.expenses") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-money-bill-alt"></i>
      </div>
      <a href="{{ aurl("expenses") }}" class="small-box-footer">{{ trans("admin.expenses") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--expenses_end-->
<!--otheroperation_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\OtherOperation::count()) }}</h3>
        <p>{{ trans("admin.otheroperation") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-money-bill-alt"></i>
      </div>
      <a href="{{ aurl("otheroperation") }}" class="small-box-footer">{{ trans("admin.otheroperation") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--otheroperation_end-->
<!--collection_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\Collection::count()) }}</h3>
        <p>{{ trans("admin.collection") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-columns"></i>
      </div>
      <a href="{{ aurl("collection") }}" class="small-box-footer">{{ trans("admin.collection") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--collection_end-->
<!--filling_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\Filling::count()) }}</h3>
        <p>{{ trans("admin.filling") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-fill-drip"></i>
      </div>
      <a href="{{ aurl("filling") }}" class="small-box-footer">{{ trans("admin.filling") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--filling_end-->
<!--revenuefule_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\RevenueFule::count()) }}</h3>
        <p>{{ trans("admin.revenuefule") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-hand-holding-water"></i>
      </div>
      <a href="{{ aurl("revenuefule") }}" class="small-box-footer">{{ trans("admin.revenuefule") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--revenuefule_end-->
<!--payment_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\Payment::count()) }}</h3>
        <p>{{ trans("admin.payment") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-icons"></i>
      </div>
      <a href="{{ aurl("payment") }}" class="small-box-footer">{{ trans("admin.payment") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--payment_end-->

<!--generalrevenue_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">

        <h3>{{ mK(App\Models\BasicParent::count()) }}</h3>
        <p>{{ trans("admin.basicparents") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-icons"></i>
      </div>
      <a href="{{ aurl("basicparents") }}" class="small-box-footer">{{ trans("admin.basicparents") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--basicparents_end-->
<!--basicparentitems_start-->

        <h3>{{ mK(App\Models\GeneralRevenue::count()) }}</h3>
        <p>{{ trans("admin.generalrevenue") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-box-tissue"></i>
      </div>
      <a href="{{ aurl("generalrevenue") }}" class="small-box-footer">{{ trans("admin.generalrevenue") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--generalrevenue_end-->
<!--withdrawalspayments_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">

        <h3>{{ mK(App\Models\BasicParentItem::count()) }}</h3>
        <p>{{ trans("admin.basicparentitems") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-sitemap"></i>
      </div>
      <a href="{{ aurl("basicparentitems") }}" class="small-box-footer">{{ trans("admin.basicparentitems") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--basicparentitems_end-->

        <h3>{{ mK(App\Models\WithdrawalsPayments::count()) }}</h3>
        <p>{{ trans("admin.withdrawalspayments") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-icons"></i>
      </div>
      <a href="{{ aurl("withdrawalspayments") }}" class="small-box-footer">{{ trans("admin.withdrawalspayments") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--withdrawalspayments_end-->
