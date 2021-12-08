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





