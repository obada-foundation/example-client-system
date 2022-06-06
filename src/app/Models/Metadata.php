<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Obada\ClientHelper\LocalObitMetadata;

class Metadata extends Model
{
    protected $table = 'metadata';
    public $timestamps = true;

    public function device()
    {
        return $this->belongsTo(Device::class, 'id', 'device_id');
    }

    public function schema()
    {
        return $this->hasOne(Schema::class, 'id', 'metadata_type_id');
    }

    public function value()
    {
        return $this->data_txt == null ? ($this->data_int == null ? $this->data_fp : $this->data_int) : $this->data_txt;
    }

    public function getLocalMetadata()
    {
        return new LocalObitMetadata([
            'key' => $this->metadata_type_id,
            'value' => $this->value()
        ]);
    }
}
