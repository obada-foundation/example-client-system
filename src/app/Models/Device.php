<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Obada\Entities\LocalObit;

/**
 * Class Device
 * @package App\Models
 */
class Device extends Model
{
    protected $table = 'devices';

    public $timestamps = true;

    protected $guarded = [];

    public function scopeByUsn($query, string $usn) {
        $query->where('usn', $usn);

        return $query;
    }

    public function scopeByAddress($query, string $address) {
        $query->where('address', $address);

        return $query;
    }

    public function scopeHasLocalObits($query) {
        $query->whereNotNull('obit_checksum');

        return $query;
    }

    /*
     * Relationships
     */
    public function documents()
    {
        return $this->hasMany(Document::class, 'device_id', 'id');
    }

    public function metadata()
    {
        return $this->hasMany(Metadata::class, 'device_id', 'id');
    }

    public function structuredData()
    {
        return $this->hasMany(StructuredData::class, 'device_id', 'id');
    }

    /**
     * Returns device documents in an array format
     * @return array
     */
    public function getDocumentsRecords()
    {
        $documents = [];

        if ($this->documents) {
            foreach ($this->documents as $d) {
                $documents[] = [
                    'name'      => $d->doc_type_id,
                    'hash_link' => $d->doc_path
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
        if ($this->metadata) {
            foreach ($this->metadata as $m) {
                $metadata[$m->metadata_type_id] = $m->data_txt == null
                    ? ($m->data_int == null ? $m->data_fp : $m->data_int)
                    : $m->data_txt;
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

        if ($this->structured_data) {
            foreach ($this->structured_data as $s) {
                $structured_data[$s->structured_data_type_id] = @json_decode($s->data_array, true, 512, JSON_THROW_ON_ERROR);
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

        if ($this->documents) {
            foreach ($this->documents as $d) {
                $documents[$d->doc_type_id] = $d->doc_path;
            }
        }
        return $documents;
    }

    public function getLocalObit()
    {
        return new LocalObit([
            'owner' => $this->owner,
            'obitStatus' => $this->status,
            'manufacturer' => $this->manufacturer,
            'partNumber' => $this->part_number,
            'serialNumber' => $this->serial_number,
            'metadata' => $this->getMetadataRecords(),
            'documents' => [],
            'structuredData' => [],
            'modifiedOn' => (new \DateTime($this->updated_at))->getTimestamp()
        ]);
    }

    public function getImageAttribute(): ?string {
        return $this->documents
            ->filter(fn ($d) => $d->type === 'mainImage')
            ->map(function ($d) {
                if (preg_match('/^(ipfs):\/\/(.*)$/m', $d->path, $ipfsUrl)) {
                    $ipfsHash = $ipfsUrl[2];

                    return config('ipfs.gateway') . $ipfsHash;
                }

                return $d->path;
            })
            ->first();
    }
}
