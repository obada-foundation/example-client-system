<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Device
 * @package App\Models
 */
class Device extends Model
{
    protected $table = 'devices';
    public $timestamps = true;

    /*
     * Relationships
     */
    public function documents(){
        return $this->hasMany(Documents::class,'device_id','id');
    }

    public function metadata(){
        return $this->hasMany(Metadata::class,'device_id','id');
    }

    public function structured_data(){
        return $this->hasMany(StructuredData::class,'device_id','id');
    }

    public function obit(){
        return $this->hasOne(ClientObit::class,'usn','usn');
    }


    /*
     * Methods
     */

    /**
     * Returns Device Metadata in an array format.
     * @return array
     */
    public function getMetadataRecords()
    {
        $metadata = [];
        if($this->metadata) {
            foreach($this->metadata as $m) {
                $metadata[] = [
                    'key'=>$m->metadata_type_id,
                    'value'=>$m->data_txt == null ? ($m->data_int == null ? $m->data_fp : $m->data_int) : $m->data_txt
                ];
            }
        }
        return $metadata;
    }

    /**
     * Returns device structured data in an array format
     * @return array
     */
    public function getStructuredDataRecords()
    {
        $structured_data = [];

        if($this->structured_data) {
            foreach($this->structured_data as $s) {
                $structured_data[] = [
                    'key'=>$s->structured_data_type_id,
                    'value'=>$s->data_array
                ];
            }
        }
        return $structured_data;
    }

    /**
     * Returns device documents in an array format
     * @return array
     */
    public function getDocumentsRecords()
    {
        $documents = [];

        if($this->documents) {
            foreach($this->documents as $d) {
                $documents[] = [
                    'name'=>$d->doc_type_id,
                    'hash_link'=>$d->doc_path
                ];
            }
        }
        return $documents;
    }


    /**
     * Returns Device Metadata in an array format.
     * @return array
     */
    public function getMetadataArray()
    {
        $metadata = [];
        if($this->metadata) {
            foreach($this->metadata as $m) {
                $metadata[$m->metadata_type_id] = $m->data_txt == null ? ($m->data_int == null ? $m->data_fp : $m->data_int) : $m->data_txt;
            }
        }
        return $metadata;
    }

    /**
     * Returns device structured data in an array format
     * @return array
     */
    public function getStructuredDataArray()
    {
        $structured_data = [];

        if($this->structured_data) {
            foreach($this->structured_data as $s) {
                $structured_data[$s->structured_data_type_id]=$s->data_array;
            }
        }
        return $structured_data;
    }

    /**
     * Returns device documents in an array format
     * @return array
     */
    public function getDocumentsArray()
    {
        $documents = [];

        if($this->documents) {
            foreach($this->documents as $d) {
                $documents[$d->doc_type_id]=$d->doc_path;
            }
        }
        return $documents;
    }





}
