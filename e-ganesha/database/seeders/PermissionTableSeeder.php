<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Role, Permission};

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $authorities = config('permission.authorities');

        $listPermission = [];
        $adminPermission = [];
        $teacherPermission = [];
        $studentPermission = [];

        foreach ($authorities as $label => $permissions) {

            foreach ($permissions as $permission) {
                $listPermission[] = [
                    'name' => $permission,
                    'guard_name' => 'web',
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ];

                // admin
                $adminPermission[] = $permission;

                // teacher
                if (in_array(
                    $label,
                    [
                        'Manajemen daftar guru',
                        'Manajemen daftar murid',
                        'Manajemen tahun angkatan'
                    ]
                )) {
                    $teacherPermission[] = $permission;
                }

                // student
                if (in_array($label, ['Manajemen daftar murid'])) {
                    $studentPermission[] = $permission;
                }
            }
        }

        // insert permissions
        Permission::insert($listPermission);

        // insert roles
        // admin
        $admin = Role::create([
            'name' => 'Admin',
            'guard_name' => 'web',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        // teacher
        $teacher = Role::create([
            'name' => 'Teacher',
            'guard_name' => 'web',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        // // student
        $student = Role::create([
            'name' => 'Student',
            'guard_name' => 'web',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        // // Role -> Permisssion
        $admin->givePermissionTo($adminPermission);
        $teacher->givePermissionTo($teacherPermission);
        $student->givePermissionTo($studentPermission);

        $userAdmin = User::find(1)->assignRole('Admin');
    }
}
