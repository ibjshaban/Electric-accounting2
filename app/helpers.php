<?php
if (!function_exists('ShekelFormat')) {
    function ShekelFormat($amount)
    {
        return '₪' . number_format($amount, 0);
    }
}

if (!function_exists('InsertLargeNumber')) {
    function InsertLargeNumber($number)
    {
        return str_replace(',', '', number_format($number, 2));
    }
}


if (!function_exists('CheckParentRoute')) {
    function CheckParentRoute($url)
    {
        switch ($url) {
            case 'admin/startup':
                 $item = '0';
                break;
                case \Request::is('admin/startup/*'):
                 $item = '0';
                break;
            case 'admin/heavy-expenses':
                 $item = '1';
                break;
                case \Request::is('admin/heavy-expenses/*'):
                 $item = '1';
                break;
            case 'admin/rentals':
                $item = '2';
                break;
            case \Request::is('admin/rentals/*'):
                $item = '2';
                break;
                case 'admin/other-notebooks':
                $item = '3';
                break;
            case \Request::is('admin/other-notebooks/*'):
                $item = '3';
                break;
            case 'admin/withdrawals':
                $item = '4';
                break;
            case \Request::is('admin/withdrawals/*'):
                $item = '4';
                break;
            case 'admin/payments':
                $item = '5';
                break;
            case \Request::is('admin/payments/*'):
                $item = '5';
                break;
            default:
                $item = '0';
        }
        return $item;
    }
}


if (!function_exists('CheckParentTitle')) {
    function CheckParentTitle($url)
    {
        switch ($url) {
            case 'admin/startup':
                 $title = trans('admin.startup');
                break;
                case \Request::is('admin/startup/*'):
                    $title = trans('admin.startup');
                break;
            case 'admin/heavy-expenses':
                 $title = trans('admin.heavy-expenses');
                break;
                case \Request::is('admin/heavy-expenses/*'):
                    $title = trans('admin.heavy-expenses');
                break;
            case 'admin/rentals':
                $title = trans('admin.rentals');
                break;
            case \Request::is('admin/rentals/*'):
                $title = trans('admin.rentals');
                break;
                case 'admin/other-notebooks':
                $title = trans('admin.other-notebooks');
                break;
            case \Request::is('admin/other-notebooks/*'):
                $title = trans('admin.other-notebooks');
                break;
            case 'admin/withdrawals':
                $title = trans('admin.withdrawals');
                break;
            case \Request::is('admin/withdrawals/*'):
                $title = trans('admin.withdrawals');
                break;
            case 'admin/payments':
                $title = trans('admin.payments');
                break;
            case \Request::is('admin/payments/*'):
                $title = trans('admin.payments');
                break;
            default:
                $title = 'عنوان مجهول';
        }
        return $title;
    }
}

if (!function_exists('AddNewLog') ){
    function AddNewLog($name,$queries,$admin_id,$operation,$table,$item_id,$new_date)
    {
        \App\Models\ActivityLog::create([
            'name'=> $name,
            'query'=> json_encode($queries),
            'information'=> json_encode(['admin_id'=> $admin_id,'operation'=> $operation, 'table'=> $table,
                'item_id'=> $item_id,'new_data'=> $new_date])
        ]);
        return true;
    }
}


?>
