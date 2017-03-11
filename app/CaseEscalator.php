<?php namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;
class CaseEscalator extends Eloquent
{



       public function messagenotifications()
      {
        return $this->hasMany('App\Messagenotifications');
      }

    protected $table    = 'cases_escalations';
    protected $fillable = ['case_id','user','type','active','message'];

}
