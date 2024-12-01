<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class UpdatePermissionSeeder extends Seeder
{
    public function run(): void
    {
        Permission::where('name', 'add property')->update(['name' => 'create property']);
    }
}
