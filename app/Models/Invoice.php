<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
   // protected $guarded=[];
    protected $fillable =['invoice_status'];
    
    public function Group()
    {
        return $this->belongsTo(Group::class,'Group_id');
    }

    public function Service()
    {
        return $this->belongsTo(Service::class,'Service_id');
    }

    public function Patient()
    {
        return $this->belongsTo(Patient::class,'patient_id');
    }

    public function Doctor()
    {
        return $this->belongsTo(Doctor::class,'doctor_id');
    }

    public function Department()
    {
        return $this->belongsTo(Department::class,'department_id');
    }

    public function patientHistory()
    {
        return $this->hasOne(PatientHistory::class, 'invoice_id');
    }
    public static function recentInvoices($doctorId, $limit = 10)
    {
        return self::where('doctor_id', $doctorId)
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }
    public static function getRecentInvoiceCounts($doctorId)
    {
        $recentInvoicesGroupCount = self::where('doctor_id', $doctorId)
            ->where('invoice_type', 2) // Adjust as per your database
            ->count();

        $recentInvoicesSingleCount = self::where('doctor_id', $doctorId)
            ->where('invoice_type', 1) // Adjust as per your database
            ->count();

        return [
            'group' => $recentInvoicesGroupCount,
            'single' => $recentInvoicesSingleCount
        ];
    }
}