<?php
namespace Tests\Feature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class AuthenticationTest extends TestCase
{
    use RefreshDatabase;
    public function test_customer_can_register(): void { $this->post('/register',['name'=>'Salam','email'=>'sal@example.com','password'=>'Password123','password_confirmation'=>'Password123'])->assertRedirect('/'); $this->assertAuthenticated(); $this->assertDatabaseHas('users',['email'=>'sal@example.com','role'=>User::ROLE_USER]); }
    public function test_admin_area_rejects_customers(): void { $this->actingAs(User::factory()->create())->get('/admin')->assertForbidden(); }
    public function test_admin_can_open_dashboard(): void { $this->actingAs(User::factory()->admin()->create())->get('/admin')->assertOk(); }
}
