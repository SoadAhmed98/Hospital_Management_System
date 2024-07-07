<?php
namespace App\Traits;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait UploadTrait {

    public function verifyAndStoreImage(Request $request, $inputname, $foldername, $disk, $imageable_id, $imageable_type) {

        if ($request->hasFile($inputname)) {

            // Check if the image is valid
            if (!$request->file($inputname)->isValid()) {
                // Handle the error, e.g., by throwing an exception
                throw new \Exception('Invalid Image!');
            }

            $photo = $request->file($inputname);
            $extension = $photo->getClientOriginalExtension();
            $allowed_extensions = ['png', 'jpg', 'jpeg'];

            // Check if the file extension is allowed
            if (!in_array($extension, $allowed_extensions)) {
                // Handle the error, e.g., by throwing an exception
                throw new \Exception('Invalid Image Extension! Only png, jpg, and jpeg are allowed.');
            }

            $name = \Str::slug($request->input('name') ?? 'default_name');
            $filename = $name . '.' . $extension;

            // Insert Image
            $image = new Image();
            $image->filename = $filename;
            $image->imageable_id = $imageable_id;
            $image->imageable_type = $imageable_type;
            $image->save();

            return $request->file($inputname)->storeAs($foldername, $filename, $disk);
        }

        return null;
    }

    public function verifyAndStoreImageForeach($varforeach, $foldername, $disk, $imageable_id, $imageable_type) {

        $extension = $varforeach->getClientOriginalExtension();
        $allowed_extensions = ['png', 'jpg', 'jpeg'];

        // Check if the file extension is allowed
        if (!in_array($extension, $allowed_extensions)) {
            // Handle the error, e.g., by throwing an exception
            throw new \Exception('Invalid Image Extension! Only png, jpg, and jpeg are allowed.');
        }

        // Insert Image
        $image = new Image();
        $image->filename = $varforeach->getClientOriginalName();
        $image->imageable_id = $imageable_id;
        $image->imageable_type = $imageable_type;
        $image->save();

        return $varforeach->storeAs($foldername, $varforeach->getClientOriginalName(), $disk);
    }

    public function Delete_attachment($disk, $path, $id) {
        Storage::disk($disk)->delete($path);
        Image::where('imageable_id', $id)->delete();
    }
}
