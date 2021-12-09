<!-- Add icons to the links using the .nav-icon class
with font-awesome or any other icon font library -->
<li class="nav-header"></li>
<li class="nav-item">
  <a href="{{ aurl('') }}" class="nav-link {{ active_link(null,'active') }}">
    <i class="nav-icon fas fa-home"></i>
    <p>
      {{ trans('admin.dashboard') }}
    </p>
  </a>
</li>
@if(admin()->user()->role('settings_show'))
<li class="nav-item">
  <a href="{{ aurl('settings') }}" class="nav-link  {{ active_link('settings','active') }}">
    <i class="nav-icon fas fa-cogs"></i>
    <p>
      {{ trans('admin.settings') }}
    </p>
  </a>
</li>
@endif
@if(admin()->user()->role("admins_show"))
<li class="nav-item {{ active_link('admins','menu-open') }}">
  <a href="#" class="nav-link  {{ active_link('admins','active') }}">
    <i class="nav-icon fas fa-users"></i>
    <p>
      {{trans('admin.admins')}}
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('admins')}}" class="nav-link {{ active_link('admins','active') }}">
        <i class="fas fa-users nav-icon"></i>
        <p>{{trans('admin.admins')}}</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ aurl('admins/create') }}" class="nav-link">
        <i class="fas fa-plus nav-icon"></i>
        <p>{{trans('admin.create')}}</p>
      </a>
    </li>
  </ul>
</li>
@endif
@if(admin()->user()->role("admingroups_show"))
<li class="nav-item {{ active_link('admingroups','menu-open') }}">
  <a href="#" class="nav-link  {{ active_link('admingroups','active') }}">
    <i class="nav-icon fas fa-users"></i>
    <p>
      {{trans('admin.admingroups')}}
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('admingroups')}}" class="nav-link {{ active_link('admingroups','active') }}">
        <i class="fas fa-users nav-icon"></i>
        <p>{{trans('admin.admingroups')}}</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ aurl('admingroups/create') }}" class="nav-link ">
        <i class="fas fa-plus nav-icon"></i>
        <p>{{trans('admin.create')}}</p>
      </a>
    </li>
  </ul>
</li>
@endif
<!--city_start_route-->
@if(admin()->user()->role("city_show"))
<li class="nav-item {{active_link('city','menu-open')}} ">
  <a href="#" class="nav-link {{active_link('city','active')}}">
    <i class="nav-icon fa fa-city"></i>
    <p>
      {{trans('admin.city')}}
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('city')}}" class="nav-link  {{active_link('city','active')}}">
        <i class="fa fa-city nav-icon"></i>
        <p>{{trans('admin.city')}} </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ aurl('city/create') }}" class="nav-link">
        <i class="fas fa-plus nav-icon"></i>
        <p>{{trans('admin.create')}} </p>
      </a>
    </li>
  </ul>
</li>
@endif
<!--city_end_route-->



<!--stock_start_route-->
@if(admin()->user()->role("stock_show"))
<li class="nav-item {{active_link('stock','menu-open')}} ">
  <a href="#" class="nav-link {{active_link('stock','active')}}">
    <i class="nav-icon fa fa-window-maximize"></i>
    <p>
      {{trans('admin.stock')}}
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('stock')}}" class="nav-link  {{active_link('stock','active')}}">
        <i class="fa fa-window-maximize nav-icon"></i>
        <p>{{trans('admin.stock')}} </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ aurl('stock/create') }}" class="nav-link">
        <i class="fas fa-plus nav-icon"></i>
        <p>{{trans('admin.create')}} </p>
      </a>
    </li>
  </ul>
</li>
@endif
<!--stock_end_route-->

<!--supplier_start_route-->
@if(admin()->user()->role("supplier_show"))
<li class="nav-item {{active_link('supplier','menu-open')}} ">
  <a href="#" class="nav-link {{active_link('supplier','active')}}">
    <i class="nav-icon fa fa-users"></i>
    <p>
      {{trans('admin.supplier')}}
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('supplier')}}" class="nav-link  {{active_link('supplier','active')}}">
        <i class="fa fa-users nav-icon"></i>
        <p>{{trans('admin.supplier')}} </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ aurl('supplier/create') }}" class="nav-link">
        <i class="fas fa-plus nav-icon"></i>
        <p>{{trans('admin.create')}} </p>
      </a>
    </li>
  </ul>
</li>
@endif
<!--supplier_end_route-->

<!--employeetype_start_route-->
@if(admin()->user()->role("employeetype_show"))
<li class="nav-item {{active_link('employeetype','menu-open')}} ">
  <a href="#" class="nav-link {{active_link('employeetype','active')}}">
    <i class="nav-icon fab fa-typo3"></i>
    <p>
      {{trans('admin.employeetype')}}
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('employeetype')}}" class="nav-link  {{active_link('employeetype','active')}}">
        <i class="fab fa-typo3 nav-icon"></i>
        <p>{{trans('admin.employeetype')}} </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ aurl('employeetype/create') }}" class="nav-link">
        <i class="fas fa-plus nav-icon"></i>
        <p>{{trans('admin.create')}} </p>
      </a>
    </li>
  </ul>
</li>
@endif
<!--employeetype_end_route-->

<!--employee_start_route-->
@if(admin()->user()->role("employee_show"))
    <li class="nav-item {{active_link('employee','menu-open')}} ">
        <a href="#" class="nav-link {{active_link('employee','active')}}">
            <i class="fa fa-user-friends"></i>
            <p>
                {{trans('admin.employee')}}
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{aurl('employee')}}" class="nav-link  {{active_link('employee','active')}}">
                    <i class="fa fa-user-friends"></i>
                    <p>{{trans('admin.employee')}} </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ aurl('employee/create') }}" class="nav-link">
                    <i class="fas fa-plus nav-icon"></i>
                    <p>{{trans('admin.create')}} </p>
                </a>
            </li>
        </ul>
    </li>
@endif
<!--employee_end_route-->






<!--revenue_start_route-->
@if(admin()->user()->role("revenue_show"))
<li class="nav-item {{active_link('revenue','menu-open')}} ">
  <a href="#" class="nav-link {{active_link('revenue','active')}}">
    <i class="nav-icon fa fa-layer-group"></i>
    <p>
      {{trans('admin.revenue')}}
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('revenue')}}" class="nav-link  {{active_link('revenue','active')}}">
        <i class="fa fa-layer-group nav-icon"></i>
        <p>{{trans('admin.revenue')}} </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ aurl('revenue/create') }}" class="nav-link">
        <i class="fas fa-plus nav-icon"></i>
        <p>{{trans('admin.create')}} </p>
      </a>
    </li>
  </ul>
</li>
@endif
<!--revenue_end_route-->

<!--debt_start_route-->
@if(admin()->user()->role("debt_show"))
<li class="nav-item {{active_link('debt','menu-open')}} ">
  <a href="#" class="nav-link {{active_link('debt','active')}}">
    <i class="nav-icon fa fa-money-check-alt"></i>
    <p>
      {{trans('admin.debt')}}
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('debt')}}" class="nav-link  {{active_link('debt','active')}}">
        <i class="fa fa-money-check-alt nav-icon"></i>
        <p>{{trans('admin.debt')}} </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ aurl('debt/create') }}" class="nav-link">
        <i class="fas fa-plus nav-icon"></i>
        <p>{{trans('admin.create')}} </p>
      </a>
    </li>
  </ul>
</li>
@endif
<!--debt_end_route-->

<!--salary_start_route-->
@if(admin()->user()->role("salary_show"))
<li class="nav-item {{active_link('salary','menu-open')}} ">
  <a href="#" class="nav-link {{active_link('salary','active')}}">
    <i class="nav-icon fa fa-money-bill-wave"></i>
    <p>
      {{trans('admin.salary')}}
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('salary')}}" class="nav-link  {{active_link('salary','active')}}">
        <i class="fa fa-money-bill-wave nav-icon"></i>
        <p>{{trans('admin.salary')}} </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ aurl('salary/create') }}" class="nav-link">
        <i class="fas fa-plus nav-icon"></i>
        <p>{{trans('admin.create')}} </p>
      </a>
    </li>
  </ul>
</li>
@endif
<!--salary_end_route-->

<!--expenses_start_route-->
@if(admin()->user()->role("expenses_show"))
<li class="nav-item {{active_link('expenses','menu-open')}} ">
  <a href="#" class="nav-link {{active_link('expenses','active')}}">
    <i class="nav-icon fa fa-money-bill-alt"></i>
    <p>
      {{trans('admin.expenses')}} 
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('expenses')}}" class="nav-link  {{active_link('expenses','active')}}">
        <i class="fa fa-money-bill-alt nav-icon"></i>
        <p>{{trans('admin.expenses')}} </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ aurl('expenses/create') }}" class="nav-link">
        <i class="fas fa-plus nav-icon"></i>
        <p>{{trans('admin.create')}} </p>
      </a>
    </li>
  </ul>
</li>
@endif
<!--expenses_end_route-->

<!--otheroperation_start_route-->
@if(admin()->user()->role("otheroperation_show"))
<li class="nav-item {{active_link('otheroperation','menu-open')}} ">
  <a href="#" class="nav-link {{active_link('otheroperation','active')}}">
    <i class="nav-icon fa fa-money-bill-alt"></i>
    <p>
      {{trans('admin.otheroperation')}} 
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('otheroperation')}}" class="nav-link  {{active_link('otheroperation','active')}}">
        <i class="fa fa-money-bill-alt nav-icon"></i>
        <p>{{trans('admin.otheroperation')}} </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ aurl('otheroperation/create') }}" class="nav-link">
        <i class="fas fa-plus nav-icon"></i>
        <p>{{trans('admin.create')}} </p>
      </a>
    </li>
  </ul>
</li>
@endif
<!--otheroperation_end_route-->
