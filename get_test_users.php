<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TEST USERS FOR MANUAL TESTING ===\n\n";

// Get users by role
$roles = ['Super Admin', 'Admin SKPD', 'Reviewer', 'Admin Lembaga'];

foreach ($roles as $roleName) {
    $users = \App\Models\User::whereHas('roles', function($q) use ($roleName) {
        $q->where('name', $roleName);
    })->take(2)->get();
    
    if ($users->count() > 0) {
        echo "Role: {$roleName}\n";
        echo str_repeat("-", 50) . "\n";
        
        foreach ($users as $user) {
            echo "Email: {$user->email}\n";
            echo "Name: {$user->name}\n";
            
            if ($user->skpd_id) {
                $skpd = \App\Models\Skpd::find($user->skpd_id);
                echo "SKPD: " . ($skpd ? $skpd->name : 'N/A') . "\n";
            }
            
            if ($user->lembaga_id) {
                $lembaga = \App\Models\Lembaga::find($user->lembaga_id);
                echo "Lembaga: " . ($lembaga ? $lembaga->name : 'N/A') . "\n";
            }
            
            echo "Password: password (default)\n";
            echo "\n";
        }
        echo "\n";
    }
}

// Get statistics
echo "\n=== DATABASE STATISTICS ===\n";
echo "Total Users: " . \App\Models\User::count() . "\n";
echo "Total Lembagas: " . \App\Models\Lembaga::count() . "\n";
echo "Total SKPDs: " . \App\Models\Skpd::count() . "\n";
echo "Total Permohonans: " . \App\Models\Permohonan::count() . "\n";
echo "Total Status Permohonan: " . \App\Models\Status_permohonan::count() . "\n";

// Get status permohonan
echo "\n=== STATUS PERMOHONAN ===\n";
$statuses = \App\Models\Status_permohonan::all();
foreach ($statuses as $status) {
    $count = \App\Models\Permohonan::where('status_permohonan_id', $status->id)->count();
    echo "{$status->name}: {$count} permohonan\n";
}
