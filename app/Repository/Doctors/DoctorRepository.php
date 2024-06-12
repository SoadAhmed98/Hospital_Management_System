<?php
namespace App\Repository\Doctors;

use App\Interfaces\Doctors\DoctorRepositoryInterface;
use App\Models\Doctor;
use App\Models\Department;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class DoctorRepository implements DoctorRepositoryInterface
{
    use UploadTrait;

    public function index()
    {
        $doctors = Doctor::all();
        return view('Dashboard.Doctors.index', compact('doctors'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('Dashboard.Doctors.add', compact('departments'));
    }

    public function store($request)
    {
        // dd($request);
        DB::beginTransaction();
    
        try {
            $doctor = new Doctor();
            $doctor->email = $request->email;
            $doctor->password = Hash::make($request->password);
            $doctor->department_id = $request->department_id; // Ensure this is the correct field name
            $doctor->phone = $request->phone;
            $doctor->consultation_fees = $request->fees;
            $doctor->status = 1;
            $doctor->name = $request->name;
            $doctor->save();
    
            Log::info('Doctor created successfully', ['doctor_id' => $doctor->id]);
            // dd($request->hasFile('photo'));
            // Upload image
            if ($request->hasFile('photo')) {
                Log::info('Photo is present in the request.');
                $result = $this->verifyAndStoreImage($request, 'photo', 'doctors', 'upload_image', $doctor->id, Doctor::class);
                Log::info('Image uploaded', ['result' => $result]);
            } else {
                Log::info('No photo found in the request.');
            }
    
            DB::commit();
            session()->flash('add', 'Doctor added successfully!');
            return redirect()->route('Doctors.index');
        } catch (\Exception $e) {
            // dd($e->getMessage());
            DB::rollback();
            Log::error('Doctor creation failed: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    

    public function update($request)
    {
        // Implement the update logic if needed
    }

    public function destroy($request)
    {
        if($request->page_id==1){
  
         if($request->filename){
  
           $this->Delete_attachment('upload_image','doctors/'.$request->filename,$request->id,$request->filename);
         }
            Doctor::destroy($request->id);
            session()->flash('delete');
            return redirect()->route('Doctors.index');
        }
  
  
        //---------------------------------------------------------------
  
        else{
  
            // delete selector doctor
            $delete_select_id = explode(",", $request->delete_select_id);
            foreach ($delete_select_id as $ids_doctors){
                $doctor = Doctor::findorfail($ids_doctors);
                if($doctor->image){
                    $this->Delete_attachment('upload_image','doctors/'.$doctor->image->filename,$ids_doctors,$doctor->image->filename);
                }
            }
  
            Doctor::destroy($delete_select_id);
            session()->flash('delete');
            return redirect()->route('Doctors.index');
        }
  
      }
}
