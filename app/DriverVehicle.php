<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverVehicle extends Model
{
    public function vehicleCompany(){

        return $this->belongsTo('App\DriverCompany','company_id');
    }
}
