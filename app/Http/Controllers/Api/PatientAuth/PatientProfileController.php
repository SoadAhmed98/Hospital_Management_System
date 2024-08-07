<?php
namespace App\Http\Controllers\Api\PatientAuth;

use App\Models\Patient;
use App\Traits\ApiTrait;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\PatientResource;
use App\Http\Requests\PatientProfile\UpdatePhoneRequest;
use App\Http\Requests\PatientProfile\ResetPasswordRequest;
use App\Http\Requests\PatientProfile\UpdatePictureRequest;

class PatientProfileController extends Controller
{
    use ApiTrait, UploadTrait;

    public function changePicture(UpdatePictureRequest $request)
    {
        try {
            // Access the uploaded file
            $file = $request->file('image');

            // Get the original file name
            $filename = $file->getClientOriginalName();

            $patient = Patient::with('image')->findOrFail(Auth::guard('sanctum')->id());
            $request['name'] = $patient->name;

            // Delete old photo
            if ($patient->image) {
                $old_img = $patient->image->filename;
                $this->Delete_attachment('upload_image', 'patients/' . $old_img, $patient->id);
            }

            // Upload new image
            $this->verifyAndStoreImage($request, 'image', 'patients', 'upload_image', $patient->id, 'App\Models\Patient');
            // to reload model becuase i get image with null after migration fresh
            $patient = Patient::with('image')->findOrFail($patient->id);
            $patient=  new PatientResource($patient);
            return ApiTrait::Data(compact('patient'), 'Patient Image Updated Successfully', 200);
        } catch (\Exception $e) {
            return ApiTrait::ErrorMessage([], "{$e->getMessage()}", 500);
        }
    }

    public function chagePhoneNumber(UpdatePhoneRequest $request)
    {
        try {
            $patient = Patient::findOrFail(Auth::guard('sanctum')->id());
    
            // Check if the new phone number is the same as the current one
            if ($patient->phone === $request->phone) {
                return ApiTrait::ErrorMessage(['phone'=>'same phone number'], 'Nothing changed. The phone number is the same.', 400);
            }
    
            // Update the phone number
            $patient->update(['phone' => $request->phone]);
    
            return ApiTrait::Data(compact('patient'),'Phone Updated Successfully', 200);
        } catch (\Exception $e) {
            return ApiTrait::ErrorMessage([], 'Something Went Wrong', 500);
        }
    }
    

    public function ResetPassword(ResetPasswordRequest $request)
    {
        try{
            $patient=Patient::findOrFail(Auth::guard('sanctum')->id());
    
            $patient->update(['password'=>Hash::make($request->password)]);
            return ApiTrait::SuccessMessage('Password Updated Successfully',200);
            }
            catch(\Exception $e){
                return ApiTrait::ErrorMessage([],'Some Thing Went Wrong', 500);
            }
    }
}


