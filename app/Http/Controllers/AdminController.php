<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Repositories\ResourceRepository;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = UserRepository::getAllUsersWithStorage(10);
        $resources = ResourceRepository::getAllResourcesWithUser(10);

        // Calculate global statistics
        $stats = [
            'totalUsers' => \Illuminate\Support\Facades\DB::table('users')->count(),
            'activeUsers' => \Illuminate\Support\Facades\DB::table('users')->where('status', 'active')->count(),
            'totalResources' => \Illuminate\Support\Facades\DB::table('resources')->whereNull('deleted_at')->count(),
            'runningResources' => \Illuminate\Support\Facades\DB::table('resources')->whereNull('deleted_at')->where('status', 'running')->count(),
        ];

        return view('admin.dashboard', [
            'users' => $users,
            'resources' => $resources,
            'stats' => $stats,
        ]);
    }
}
