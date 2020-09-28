<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Metadata extends Model
{
    protected $table = 'metadata';
    public $timestamps = true;

    public function getHash()
    {
        $str = $this->metadata_type.$this->metadata_type_id.$this->data_fp.$this->data_int.$this->data_txt;
        return hash('sha256',$str);
    }

}
