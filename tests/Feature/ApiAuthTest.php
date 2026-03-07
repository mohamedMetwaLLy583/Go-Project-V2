<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Nationality;
use App\Models\City;
use App\Models\Neighborhood;
use App\Models\Day;

class ApiAuthTest extends TestCase
{
    use RefreshDatabase;

    protected $country;
    protected $nationality;
    protected $city;
    protected $neighborhood;
    protected $day;

    protected function setUp(): void
    {
        parent::setUp();

        // Setup reference data
        $this->country = \App\Models\Country::create([
            'name_ar' => 'السعودية',
            'name_en' => 'Saudi Arabia',
            'code' => 'SA',
            'phone_code' => '966',
            'currency' => 'SAR',
            'currency_symbol' => 'ر.س',
            'is_active' => true
        ]);

        $this->nationality = Nationality::create(['name_ar' => 'سعودي', 'name_en' => 'Saudi']);
        
        $this->city = City::create([
            'name_ar' => 'الرياض', 
            'name_en' => 'Riyadh', 
            'country_id' => $this->country->id,
            'is_active' => true
        ]);
        
        $this->neighborhood = Neighborhood::create([
            'city_id' => $this->city->id,
            'name_ar' => 'الملز',
            'name_en' => 'Al Malaz',
            'is_active' => true
        ]);
        
        $this->day = Day::create([
            'name_ar' => 'السبت',
            'name_en' => 'Saturday',
            'order' => 1,
            'is_active' => true
        ]);
    }

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/auth/register/user', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'phone' => '0500000000',
            'age' => 25,
            'nationality_id' => $this->nationality->id,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['access_token', 'token_type', 'expires_in', 'user']);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'type' => 3, // User
        ]);
    }

    public function test_driver_can_register_with_availability()
    {
        $response = $this->postJson('/api/auth/register/driver', [
            'name' => 'Test Driver',
            'email' => 'driver@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'phone' => '0555555555',
            'age' => 30,
            'nationality_id' => $this->nationality->id,
            'availability' => [
                [
                    'neighborhood_id' => $this->neighborhood->id,
                    'day_id' => $this->day->id,
                    'start_time' => '08:00:00',
                    'end_time' => '16:00:00',
                ]
            ]
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'email' => 'driver@example.com',
            'type' => 2, // Driver
        ]);

        $driver = User::where('email', 'driver@example.com')->first();

        $this->assertDatabaseHas('driver_availability', [
            'driver_id' => $driver->id,
            'neighborhood_id' => $this->neighborhood->id,
            'day_id' => $this->day->id,
            'start_time' => '08:00:00',
            'end_time' => '16:00:00',
        ]);
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['access_token']);
    }

    public function test_authenticated_user_can_get_profile()
    {
        $user = User::factory()->create();
        $token = auth('api')->login($user);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/auth/me');

        $response->assertStatus(200)
            ->assertJson(['id' => $user->id]);
    }

    public function test_driver_registration_fails_with_invalid_availability()
    {
        $response = $this->postJson('/api/auth/register/driver', [
            'name' => 'Test Driver',
            'email' => 'driver2@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'phone' => '0555555556',
            'age' => 30,
            'nationality_id' => $this->nationality->id,
            'availability' => [] // Empty availability
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['availability']);
    }
}
