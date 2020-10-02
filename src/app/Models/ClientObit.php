<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Obada\Entities\MetaDataRecord;
use Obada\Entities\StructureDataRecord;

class ClientObit extends Model
{
    protected $table = 'client_obits';
    public $timestamps = true;

    public function getMetadata()
    {
        $metadata = [];
        $metadata_array = @json_decode($this->metadata, true);
        if($metadata_array) {
            foreach($metadata_array as $mdata) {
                $metadata[] = new MetaDataRecord([
                    'key'=>$mdata['metadata_type_id'],
                    'value'=>$mdata['value']
                ]);
            }
        }
        return $metadata;
    }

    public function getDocuments()
    {
        return null;
    }

    public function getStructuredData()
    {
        $structured_data = [];
        $structured_data_array = @json_decode($this->structured_data, true);
        if($structured_data_array) {
            foreach($structured_data_array as $sdata) {
                $structured_data[] = new StructureDataRecord([
                    'key'=>$sdata['structured_data_type_id'],
                    'value'=>@json_encode($sdata['value'])
                ]);
            }
        }
        return $structured_data;
    }

}
