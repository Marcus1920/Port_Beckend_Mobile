<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    public function driverCompany(){

        return $this->belongsTo('App\DriverCompany','companyId');
    }

}
