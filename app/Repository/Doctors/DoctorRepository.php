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
        DB::beginTransaction();
    
        try {
            $doctor = new Doctor();
            $doctor->email = $request->email;
            $doctor->password = Hash::make($request->password);
            $doctor->department_id = $request->section_id; // Ensure this is the correct field name
            $doctor->phone = $request->phone;
            $doctor->price = $request->price;
            $doctor->status = 1;
            $doctor->name = $request->name;
            $doctor->appointments = implode(",", $request->appointments);
            $doctor->save();
    
            Log::info('Doctor created successfully', ['doctor_id' => $doctor->id]);
    
            // Upload image
            if ($request->hasFile('photo')) {
                Log::info('Photo is present in the request.');
                $result = $this->verifyAndStoreImage($request, 'photo', 'doctors', 'public', $doctor->id, Doctor::class);
                Log::info('Image uploaded', ['result' => $result]);
            } else {
                Log::info('No photo found in the request.');
            }
    
            DB::commit();
            session()->flash('add', 'Doctor added successfully!');
            return redirect()->route('Doctors.create');
        } catch (\Exception $e) {
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
        // Implement the destroy logic if needed
    }
}
