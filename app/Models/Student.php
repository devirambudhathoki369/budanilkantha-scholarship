<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'school_id',
        'academic_year_id',
        'school_year_id',
        'student_name',
        'address',
        'parent_name',
        'contact_no',
        'email',
        'emis_no',
        'scholarship_type',
        'aarakshya_main_id',
        'school_type',
        'gpa',
        'entrance_exam_marks',
        'total_marks',
        'rank',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }

    public function aarakshyaMain()
    {
        return $this->belongsTo(AarakshyaMain::class);
    }
}
