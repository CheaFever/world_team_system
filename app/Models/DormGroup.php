<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DormGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name',
        'description',
        'room_number',
        'maximum_capacity',
        'current_number_of_students',
        'status',
    ];

    protected $casts = [
        'maximum_capacity' => 'integer',
        'current_number_of_students' => 'integer',
    ];

    // One dorm group has many students
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    // Check if this group still has space for another student
    public function hasAvailableSpace(): bool
    {
        return $this->students()->count() < $this->maximum_capacity;
    }

    // Recalculate and save the current student count from the relationship
    public function syncStudentCount(): void
    {
        $this->current_number_of_students = $this->students()->count();
        $this->save();
    }
}
