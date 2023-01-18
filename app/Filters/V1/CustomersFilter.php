<?php
namespace  App\Filters\V1;

use App\Filters\ApiFilter;
use Illuminate\Http\Request;

class CustomersFilter extends  apiFilter{
    protected  $safeParams = [
        'name'  => ['eq'] ,
        'type'  => ['eq'] ,
        'email' => ['eq'] ,
        'address' => ['eq'] ,
        'city'  => ['eq'] ,
        'state' => ['eq'] ,
        'postalCode' => ['eq', 'gt' , 'lt']
    ];

    //Transform field in database
    protected $columnMap = [
        'postalCode' => 'postal_code'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '≤ ',
        'gt' => '>',
        'gte' => '>',
    ];

}
