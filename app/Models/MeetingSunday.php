<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingSunday extends Model
{
    use HasFactory;

    protected $table = 'meetting_sunday';

    protected $primaryKey = 'meetting_id';

    public $timestamps = false; // Disable default created_at and updated_at if only using custom create_at

    protected $fillable = [
        'meetting_name',
        'start',
        'stop',
    ];

    protected $casts = [
        'start' => 'datetime',
        'stop' => 'datetime',
        'create_at' => 'datetime',
    ];
}