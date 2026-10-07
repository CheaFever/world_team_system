<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\DormGroup;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DormitorySystemTest extends TestCase
{
    use RefreshDatabase;

    // Helper: create an admin and log them in via the admin guard
    private function loginAdmin(): Admin
    {
        $admin = Admin::create([
            'full_name' => 'Test Admin',
            'username' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $this->actingAs($admin, 'admin');

        return $admin;
    }

    public function test_admin_routes_require_authentication(): void
    {
        $this->get(route('admin.students.index'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.dorm-groups.index'))->assertRedirect(route('admin.login'));
    }

    public function test_dorm_group_crud(): void
    {
        $this->loginAdmin();

        // Create
        $response = $this->post(route('admin.dorm-groups.store'), [
            'group_name' => 'Group A',
            'description' => 'Main building',
            'room_number' => '101',
            'maximum_capacity' => 35,
            'status' => 'active',
        ]);
        $response->assertRedirect(route('admin.dorm-groups.index'));
        $this->assertDatabaseHas('dorm_groups', ['group_name' => 'Group A', 'maximum_capacity' => 35]);

        $group = DormGroup::first();

        // Capacity may not exceed 35
        $this->post(route('admin.dorm-groups.store'), [
            'group_name' => 'Too Big',
            'maximum_capacity' => 36,
            'status' => 'active',
        ])->assertSessionHasErrors('maximum_capacity');

        // Update
        $this->put(route('admin.dorm-groups.update', $group), [
            'group_name' => 'Group A Updated',
            'description' => 'Updated',
            'room_number' => '102',
            'maximum_capacity' => 30,
            'status' => 'inactive',
        ])->assertRedirect(route('admin.dorm-groups.index'));
        $this->assertDatabaseHas('dorm_groups', ['group_name' => 'Group A Updated', 'status' => 'inactive']);

        // Delete
        $this->delete(route('admin.dorm-groups.destroy', $group))->assertRedirect(route('admin.dorm-groups.index'));
        $this->assertDatabaseCount('dorm_groups', 0);
    }

    public function test_student_crud_and_relationship(): void
    {
        $this->loginAdmin();
        $group = DormGroup::create(['group_name' => 'G1', 'maximum_capacity' => 35, 'status' => 'active']);

        // Create student with a profile image
        Storage::fake('public');
        $jpegBytes = base64_decode('/9j/4AAQSkZJRgABAQEASABIAAD/2wBDAP//////////////////////////////////////////////////////////////////////////////////////2wBDAf//////////////////////////////////////////////////////////////////////////////////////wAARCAABAAEDASIAAhEBAxEB/8QAFAABAAAAAAAAAAAAAAAAAAAAAv/EABQBAQAAAAAAAAAAAAAAAAAAAAD/2gQoAMABQABAf/EABQBAQAAAAAAAAAAAAAAAAAAAAD/2gAIAQEAAQUCf//Z');
        $image = UploadedFile::fake()->createWithContent('photo.jpg', $jpegBytes);

        $response = $this->post(route('admin.students.store'), [
            'dorm_group_id' => $group->id,
            'student_ID' => 'S001',
            'name_khmer' => 'សុខ សុភា',
            'name_english' => 'Sok Sophea',
            'gender' => 'female',
            'date_of_birth' => '2004-01-15',
            'phone_number' => '012345678',
            'email' => 'sophea@example.com',
            'profile_image' => $image,
        ]);
        $response->assertRedirect(route('admin.students.index'));

        $student = Student::first();
        $this->assertNotNull($student->profile_image);
        Storage::disk('public')->assertExists($student->profile_image);

        // Relationship: student belongs to group, group has many students
        $this->assertEquals($group->id, $student->dormGroup->id);
        $this->assertTrue($group->students->contains($student));
        $this->assertEquals(1, $group->fresh()->current_number_of_students);

        // Update (change group counter stays in sync)
        $this->put(route('admin.students.update', $student), [
            'dorm_group_id' => $group->id,
            'student_ID' => 'S001',
            'name_khmer' => 'សុខ សុភា',
            'name_english' => 'Sok Sophea Updated',
            'gender' => 'female',
            'date_of_birth' => '2004-01-15',
            'phone_number' => '012345678',
            'email' => 'sophea@example.com',
        ])->assertRedirect(route('admin.students.index'));
        $this->assertEquals('Sok Sophea Updated', $student->fresh()->name_english);

        // Delete
        $this->delete(route('admin.students.destroy', $student))->assertRedirect(route('admin.students.index'));
        $this->assertDatabaseCount('students', 0);
        $this->assertEquals(0, $group->fresh()->current_number_of_students);
    }

    public function test_student_validation_errors(): void
    {
        $this->loginAdmin();
        $group = DormGroup::create(['group_name' => 'G1', 'maximum_capacity' => 35, 'status' => 'active']);

        // Empty form -> validation errors for required fields
        $this->post(route('admin.students.store'), [])
            ->assertSessionHasErrors(['student_ID', 'name_khmer', 'name_english', 'gender', 'date_of_birth', 'phone_number', 'email', 'dorm_group_id']);

        // Invalid email + duplicate student_ID
        Student::create([
            'dorm_group_id' => $group->id, 'student_ID' => 'S001', 'name_khmer' => 'ក', 'name_english' => 'A',
            'gender' => 'male', 'date_of_birth' => '2000-01-01', 'phone_number' => '012345678', 'email' => 'a@example.com',
        ]);

        $this->post(route('admin.students.store'), [
            'dorm_group_id' => $group->id, 'student_ID' => 'S001', 'name_khmer' => 'ខ', 'name_english' => 'B',
            'gender' => 'male', 'date_of_birth' => '2000-01-01', 'phone_number' => '012345678', 'email' => 'not-an-email',
        ])->assertSessionHasErrors(['student_ID', 'email']);

        // Invalid image type
        $this->post(route('admin.students.store'), [
            'dorm_group_id' => $group->id, 'student_ID' => 'S002', 'name_khmer' => 'ខ', 'name_english' => 'B',
            'gender' => 'male', 'date_of_birth' => '2000-01-01', 'phone_number' => '012345678', 'email' => 'b@example.com',
            'profile_image' => UploadedFile::fake()->create('doc.pdf', 100),
        ])->assertSessionHasErrors('profile_image');
    }

    public function test_capacity_rule_blocks_36th_student(): void
    {
        $this->loginAdmin();

        // Small group: capacity 2 (rule: never allow more than maximum_capacity)
        $group = DormGroup::create(['group_name' => 'Small', 'maximum_capacity' => 2, 'status' => 'active']);

        foreach (['S1', 'S2'] as $i => $sid) {
            Student::create([
                'dorm_group_id' => $group->id, 'student_ID' => $sid, 'name_khmer' => 'ក', 'name_english' => 'N'.$sid,
                'gender' => 'male', 'date_of_birth' => '2000-01-01', 'phone_number' => '012345678', 'email' => $sid.'@example.com',
            ]);
        }

        // Third student must be rejected with the exact error
        $response = $this->post(route('admin.students.store'), [
            'dorm_group_id' => $group->id, 'student_ID' => 'S3', 'name_khmer' => 'គ', 'name_english' => 'Overflow',
            'gender' => 'male', 'date_of_birth' => '2000-01-01', 'phone_number' => '012345678', 'email' => 's3@example.com',
        ]);
        $response->assertSessionHasErrors(['dorm_group_id' => 'Cannot assign this student to the selected group because the dormitory group is full.']);

        $this->assertEquals(2, $group->students()->count());
    }

    public function test_moving_student_updates_group_counts(): void
    {
        $this->loginAdmin();
        $groupA = DormGroup::create(['group_name' => 'A', 'maximum_capacity' => 35, 'status' => 'active']);
        $groupB = DormGroup::create(['group_name' => 'B', 'maximum_capacity' => 35, 'status' => 'active']);

        $student = Student::create([
            'dorm_group_id' => $groupA->id, 'student_ID' => 'S1', 'name_khmer' => 'ក', 'name_english' => 'Mover',
            'gender' => 'male', 'date_of_birth' => '2000-01-01', 'phone_number' => '012345678', 'email' => 'm@example.com',
        ]);
        $groupA->syncStudentCount();
        $this->assertEquals(1, $groupA->fresh()->current_number_of_students);

        // Move student to group B
        $this->put(route('admin.students.update', $student), [
            'dorm_group_id' => $groupB->id, 'student_ID' => 'S1', 'name_khmer' => 'ក', 'name_english' => 'Mover',
            'gender' => 'male', 'date_of_birth' => '2000-01-01', 'phone_number' => '012345678', 'email' => 'm@example.com',
        ])->assertRedirect(route('admin.students.index'));

        $this->assertEquals(0, $groupA->fresh()->current_number_of_students);
        $this->assertEquals(1, $groupB->fresh()->current_number_of_students);
    }

    public function test_search_and_filter(): void
    {
        $this->loginAdmin();
        $group = DormGroup::create(['group_name' => 'G1', 'maximum_capacity' => 35, 'status' => 'active']);
        Student::create(['dorm_group_id' => $group->id, 'student_ID' => 'S100', 'name_khmer' => 'សុខ', 'name_english' => 'Sok', 'gender' => 'male', 'date_of_birth' => '2000-01-01', 'phone_number' => '011111111', 'email' => 'sok@example.com']);
        Student::create(['dorm_group_id' => $group->id, 'student_ID' => 'S200', 'name_khmer' => 'ចាន់', 'name_english' => 'Chan', 'gender' => 'female', 'date_of_birth' => '2000-01-01', 'phone_number' => '022222222', 'email' => 'chan@example.com']);

        $this->get(route('admin.students.index', ['search' => 'Sok']))->assertSee('Sok')->assertDontSee('Chan');
        $this->get(route('admin.students.index', ['gender' => 'female']))->assertSee('Chan')->assertDontSee('>Sok<', false);
        $this->get(route('admin.students.index', ['dorm_group_id' => $group->id]))->assertSee('Sok')->assertSee('Chan');
    }
}
