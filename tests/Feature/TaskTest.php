<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TaskTest extends TestCase
{
    private string $email = '19nikolai9223@gmail.com';
    /**
     * A basic feature test example.
     */
    public function test_task_list(): void
    {
        $user = User::query()->where('email', $this->email)->first();
        Sanctum::actingAs($user, ['*']);
        $response = $this->get('/api/tasks');
        $response->assertStatus(200);
    }

    public function test_task_store(): void
    {
        $user = User::query()->where('email', $this->email)->first();
        Sanctum::actingAs($user, ['*']);
        $data = [
            'title'       => 'Test task',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
            'status'      => 'completed',
            'user_id'     => $user->id,
        ];
        $response = $this->post('/api/tasks', $data);
        $response->assertStatus(200);
    }

    public function test_task_show(): void
    {
        $user = User::query()->where('email', $this->email)->first();
        Sanctum::actingAs($user, ['*']);
        $response = $this->get('/api/tasks/1');
        $response->assertStatus(200);
    }
}
