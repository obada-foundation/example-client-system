<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Documents
 * @package App\Models
 */
class Documents extends Model
{
    protected $table = 'documents';
    public $timestamps = true;

    public function device() {
        return $this->belongsTo(Device::class, 'id','device_id');
    }

    public function schema(){
        return $this->hasOne(Schema::class,'id','doc_type_id');
    }

    public function getHash()
    {
        return '';
    }

}
