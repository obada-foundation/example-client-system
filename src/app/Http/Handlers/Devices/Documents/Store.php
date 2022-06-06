<?php 

declare(strict_types=1);

namespace App\Http\Handlers\Devices\Documents;

use App\Http\Handlers\Handler;
use App;

class Store extends Handler {
    public function __invoke()
    {
        $data = request()->all();

        $file      = $data['file'];
        $file_type = $data['file_type'];
        $filename  = uniqid() . '.' . $file->getClientOriginalExtension();

        $s3 = App::make('aws')->createClient('s3');

        $result = $s3->putObject([
            'Bucket'      => config('filesystems.disks.s3.bucket'),
            'Key'         => $data['folder'] . '/' . $filename,
            'Body'        => file_get_contents($file->getRealPath()),
            'ContentType' => $file_type,
            'ACL'         => 'public-read'
        ]);

        return response()->json([
            'status' => 0,
            'url'    => $result['ObjectURL']
        ], 200);
    }
}
