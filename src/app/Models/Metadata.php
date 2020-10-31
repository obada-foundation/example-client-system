<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Metadata extends Model
{
    protected $table = 'metadata';
    public $timestamps = true;

    public function device() {
        return $this->belongsTo(Device::class, 'id','device_id');
    }

    public function schema(){
        return $this->hasOne(Schema::class,'id','metadata_type_id');
    }

    public function getHash()
    {
        return '';
    }

}
