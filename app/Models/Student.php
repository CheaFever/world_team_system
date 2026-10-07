<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'dorm_group_id',
        'student_ID',
        'name_khmer',
        'name_english',
        'gender',
        'date_of_birth',
        'place_of_birth',
        'phone_number',
        'full_time',
        'absent',
        'permission',
        'email',
        'family',
        'have_sibling',
        'mother_name',
        'mother_phone',
        'mother_job',
        'father_name',
        'father_phone',
        'father_job',
        'profile_image',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'have_sibling' => 'boolean',
        'full_time' => 'integer',
        'absent' => 'integer',
        'permission' => 'integer',
    ];

    // Each student belongs to one dorm group
    public function dormGroup(): BelongsTo
    {
        return $this->belongsTo(DormGroup::class, 'dorm_group_id');
    }
}
