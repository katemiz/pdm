<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

use App\Models\CkFile;

class CkImgController extends Controller
{

    public function store(Request $request) {

        $m = new CkFile();
        $m->id = 0;
        $m->exists = true;
        $image = $m->addMediaFromRequest('upload')->toMediaCollection('images');


        // Return JSON response
        return response()->json([
            'url' => $image->getUrl()
        ]);




        // $path = 'CKIMAGES/'.$props['model_item_id'];
        // $stored_file_as = Storage::disk('MyDisk')->put($path, $dosya);




        // Validate the uploaded image
        // $request->validate([
        //     'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        // ]);


        // // Get the uploaded image file
        // $image = $request->file('upload');


        // Log::info($request->all());
        // Log::info($request->file('upload'));
        // Log::info($image);


        // Generate a unique filename
        // $filename = uniqid().'.'.$image->getClientOriginalExtension();

        //$image->storeAs('images', $filename);

        // $path = 'ARALIK';
        // $stored_file_as = Storage::disk('CkImages')->put($path, $request->file('upload'));
        //$props['stored_file_as'] = $stored_file_as;

        // if ( $stored_file_as ) {
        //     Log::info('OLDU');

        //     Log::info(Storage::disk('CkImages')->url($stored_file_as));


        // } else {
        //     Log::info('OLMADI');

        // }

        //$stored_file_as = Storage::disk('MyDisk')->put($path, $dosya);





        // // Store the image in the desired location
        // $image->storeAs('images', $filename);

        // // Save the image filename and other relevant data to database (optional)

        // // Return a success response
        // return response()->json([
        //     'message' => 'Image uploaded successfully!',
        //     'filename' => $filename,
        // ]);





        // Return JSON response
        // return response()->json([
        //     'url' => Storage::disk('CkImages')->url($stored_file_as)
        // ]);
    }
}
