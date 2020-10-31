<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientObit extends Model
{
    protected $table = 'client_obits';
    public $timestamps = true;

    public function device(){
        return $this->hasOne(Device::class,'usn','usn');
    }

    public function getMetadataRecords()
    {
        $metadata = [];
        $metadata_array = @json_decode($this->metadata, true);
        if($metadata_array) {
            foreach($metadata_array as $key=>$value) {
                $metadata[] = [
                    'key'=>$key,
                    'value'=>$value
                ];
            }
        }
        return $metadata;
    }

    public function getDocumentRecords()
    {
        $documents = [];
        $documents_array = @json_decode($this->documents, true);
        if($documents_array) {
            foreach($documents_array as $key=>$value) {
                $documents[] = [
                    'name'=>$key,
                    'hash_link'=>$value
                ];
            }
        }
        return $documents;
    }

    public function getStructuredDataRecords()
    {
        $structured_data = [];
        $structured_data_array = @json_decode($this->structured_data, true);
        if($structured_data_array) {
            foreach($structured_data_array as $key=>$value) {
                $structured_data[] = [
                    'key'=>$key,
                    'value'=>@json_encode($value)
                ];
            }
        }
        return $structured_data;
    }

}
