<?php 

declare(strict_types=1);

namespace App\Http\Handlers\Devices\Documents;

use App\Http\Handlers\Handler;
use App\Http\Requests\StoreDocumentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Store extends Handler {
    public function __invoke(StoreDocumentRequest $request)
    {
        $file     = $request->file('file');
        $ext      = $file->getClientOriginalExtension();
        $filename = $file->storeAs('documents/' . Auth::user()->id, uniqid() . ".$ext");

        return response()->json([
            'status' => 0,
            'url'    => Storage::url($filename)
        ], 200);
    }
}
