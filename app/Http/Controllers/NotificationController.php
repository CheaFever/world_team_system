<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead()
    {
        // កំណត់ notifications ទាំងអស់ដែលមិនទាន់អាន ឱ្យទៅជាអានរួច (is_read = true)
        AdminNotification::where('is_read', false)->update(['is_read' => true]);

        return response()->json(['status' => 'success']);
    }
}