<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StructuredData extends Model
{
    protected $table = 'structured_data';
    public $timestamps = true;

    public function device()
    {
        return $this->belongsTo(Device::class, 'id', 'device_id');
    }

    public function schema()
    {
        return $this->hasOne(Schema::class, 'id', 'structured_data_type_id');
    }

    public function getHash()
    {
        return '';
    }
}
