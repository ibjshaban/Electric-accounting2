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
<li class="nav-item">
    <a href="{{ aurl('statistics') }}" class="nav-link {{ active_link("statistics",'active') }}">
        <i class="fas fa-chart-bar"></i>
        <p>
            الاحصائيات
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



<!--collection_start_route-->
@if(admin()->user()->role("collection_show"))
    <li class="nav-item {{active_link('collection','menu-open')}} ">
        <a href="#" class="nav-link {{active_link('collection','active')}}">
            <i class="nav-icon fa fa-columns"></i>
            <p>
                {{trans('admin.collection')}}
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{aurl('collection')}}" class="nav-link  {{active_link('collection','active')}}">
                    <i class="fa fa-columns nav-icon"></i>
                    <p>{{trans('admin.collection')}} </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ aurl('collection/create') }}" class="nav-link">
                    <i class="fas fa-plus nav-icon"></i>
                    <p>{{trans('admin.create')}} </p>
                </a>
            </li>
        </ul>
    </li>
@endif
<!--collection_end_route-->

<!--filling_start_route-->
@if(admin()->user()->role("filling_show"))
    <li class="nav-item {{active_link('filling','menu-open')}} ">
        <a href="#" class="nav-link {{active_link('filling','active')}}">
            <i class="nav-icon fa fa-fill-drip"></i>
            <p>
                {{trans('admin.filling')}}
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{aurl('filling')}}" class="nav-link  {{active_link('filling','active')}}">
                    <i class="fa fa-fill-drip nav-icon"></i>
                    <p>{{trans('admin.filling')}} </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ aurl('filling/create') }}" class="nav-link">
                    <i class="fas fa-plus nav-icon"></i>
                    <p>{{trans('admin.create')}} </p>
                </a>
            </li>
        </ul>
    </li>
@endif
<!--filling_end_route-->

<!--payment_start_route-->
@if(admin()->user()->role("payment_show"))
    <li class="nav-item {{active_link('payment','menu-open')}} ">
        <a href="#" class="nav-link {{active_link('payment','active')}}">
            <i class="nav-icon fa fa-icons"></i>
            <p>
                {{trans('admin.payment')}}
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{aurl('payment')}}" class="nav-link  {{active_link('payment','active')}}">
                    <i class="fa fa-icons nav-icon"></i>
                    <p>{{trans('admin.payment')}} </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ aurl('payment/create') }}" class="nav-link">
                    <i class="fas fa-plus nav-icon"></i>
                    <p>{{trans('admin.create')}} </p>
                </a>
            </li>
        </ul>
    </li>
@endif
<!--payment_end_route-->

<!--generalrevenue_start_route-->
@if(admin()->user()->role("generalrevenue_show"))
    <li class="nav-item {{active_link('generalrevenue','menu-open')}} ">
        <a href="#" class="nav-link {{active_link('generalrevenue','active')}}">
            <i class="nav-icon fa fa-box-tissue"></i>
            <p>
                {{trans('admin.generalrevenue')}}
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{aurl('generalrevenue')}}" class="nav-link  {{active_link('generalrevenue','active')}}">
                    <i class="fa fa-box-tissue nav-icon"></i>
                    <p>{{trans('admin.generalrevenue')}} </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ aurl('generalrevenue/create') }}" class="nav-link">
                    <i class="fas fa-plus nav-icon"></i>
                    <p>{{trans('admin.create')}} </p>
                </a>
            </li>
        </ul>
    </li>
@endif
<!--generalrevenue_end_route-->

<!--withdrawals_start_route-->
@if(admin()->user()->role("withdrawals_show"))
    <li class="nav-item {{active_link('withdrawals','menu-open')}} ">
        <a href="#" class="nav-link {{active_link('withdrawals','active')}}">
            <i class="nav-icon fa fa-people-arrows"></i>
            <p>
                {{trans('admin.withdrawals')}}
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{aurl('withdrawals')}}" class="nav-link  {{active_link('withdrawals','active')}}">
                    <i class="fa fa-people-arrows nav-icon"></i>
                    <p>{{trans('admin.withdrawals')}} </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ aurl('withdrawals/0/create') }}" class="nav-link">
                    <i class="fas fa-plus nav-icon"></i>
                    <p>{{trans('admin.create')}} </p>
                </a>
            </li>
        </ul>
    </li>
@endif
<!--withdrawals_end_route-->
<!--payments_start_route-->
@if(admin()->user()->role("payments_show"))
    <li class="nav-item {{active_link('payments','menu-open')}} ">
        <a href="#" class="nav-link {{active_link('payments','active')}}">
            <i class="nav-icon fa fa-universal-access"></i>
            <p>
                {{trans('admin.payments')}}
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{aurl('payments')}}" class="nav-link  {{active_link('payments','active')}}">
                    <i class="fa fa-universal-access nav-icon"></i>
                    <p>{{trans('admin.payments')}} </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ aurl('payments/1/create') }}" class="nav-link">
                    <i class="fas fa-plus nav-icon"></i>
                    <p>{{trans('admin.create')}} </p>
                </a>
            </li>
        </ul>
    </li>
@endif
<!--payments_end_route-->
@if(admin()->user()->role("notebooks_show"))
    <li class="nav-item {{active_link('notebooks','menu-open')}} ">
        <a href="#" class="nav-link {{active_link('notebooks','active')}}">
            <i class="nav-icon fas fa-book-open"></i>
            <p>
                {{trans('admin.notebooks')}}
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{aurl('notebooks')}}" class="nav-link  {{active_link('notebooks','active')}}">
                    <i class="fa fas fa-book-open nav-icon"></i>
                    <p>{{trans('admin.notebooks')}} </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ aurl('notebooks/1/create') }}" class="nav-link">
                    <i class="fas fa-plus nav-icon"></i>
                    <p>{{trans('admin.create')}} </p>
                </a>
            </li>
        </ul>
    </li>
@endif

