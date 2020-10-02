<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StructuredData extends Model
{
    protected $table = 'structured_data';
    public $timestamps = true;

    public function getHash()
    {
        $str = $this->structured_data_type_id.json_encode($this->data_array);
        return hash('sha256',$str);
    }

}
