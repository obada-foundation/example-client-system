<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = 'devices';
    public $timestamps = true;

    public function documents(){
        return $this->hasMany(Documents::class,'device_id','id');
    }

    public function metadata(){
        return $this->hasMany(Metadata::class,'device_id','id');
    }

    public function structured_data(){
        return $this->hasMany(StructuredData::class,'device_id','id');
    }

    public function generateObitData()
    {

    }

}
