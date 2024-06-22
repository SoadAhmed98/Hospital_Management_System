<?php
namespace App\Traits;

use Str;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait UploadTrait
{
    public function verifyAndStoreImage(Request $request, $inputName, $folderName, $disk, $imageableId, $imageableType)
    {
        try {
            if ($request->hasFile($inputName)) {
                Log::info('File detected in the request for input:', ['inputName' => $inputName]);

                // Check img
                if (!$request->file($inputName)->isValid()) {
                    Log::error('Invalid image file.');
                    return false;
                }

                $photo = $request->file($inputName);
                $name = \Str::slug($request->input('name'));
                $filename = $name . '.' . $photo->getClientOriginalExtension();

                // Insert Image
                $image = new Image();
                $image->filename = $filename;
                $image->imageable_id = $imageableId;
                $image->imageable_type = $imageableType;
                $image->save();

                Log::info('Image record saved in the database.', ['image_id' => $image->id]);

                // Store Image
                $stored = $request->file($inputName)->storeAs($folderName, $filename, $disk);
                Log::info('Image stored on disk.', ['path' => $stored]);
                // dd($stored);
                return $stored;
            }

            Log::info('No file to upload for input:', ['inputName' => $inputName]);
            return null;
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error('Image upload failed: ' . $e->getMessage());
            return false;
        }
    }

    public function Delete_attachment($disk,$path,$id){

        Storage::disk($disk)->delete($path);
        image::where('imageable_id',$id)->delete();

    }
}
