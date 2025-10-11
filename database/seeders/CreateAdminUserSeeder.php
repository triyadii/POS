<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Ramsey\Uuid\Uuid; // Pastikan untuk menggunakan UUID
  
class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat akun admin dengan UUID sebagai id
        $user = User::create([
            'id' => Uuid::uuid4()->toString(), // Generate UUID
            'name' => 'Rizky Chimo', 
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
        ]);
        
        $role = Role::create(['name' => 'Admin']);
         
        $permissions = Permission::pluck('id', 'id')->all();
       
        $role->syncPermissions($permissions);
         
        $user->assignRole([$role->id]);
    }
}
