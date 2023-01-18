<?php
namespace  App\Filters\V1;

use App\Filters\ApiFilter;
use Illuminate\Http\Request;

class InvoicesFilter extends  apiFilter{
    protected  $safeParams = [
        'customerId'    => ['eq'] ,
        'amount'        => ['eq', 'lt' , 'gt','lte','gte'] ,
        'status'        => ['eq','ne'] ,
        'billDate'      => ['eq', 'lt' , 'gt','lte','gte'] ,
        'paidDate'      => ['eq', 'lt' , 'gt','lte','gte'] ,
    ];

    //Transform field in database
    protected $columnMap = [
        'customerId' => 'customer_id',
        'billDate'  => 'billed_date',
        'paidDate'  => 'paid_date',

    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '≤ ',
        'gt' => '>',
        'gte' => '≥',
        'ne' => '≠',

    ];
}
