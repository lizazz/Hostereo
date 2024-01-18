<?php

namespace Modules\News\tests\Unit;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Testing\TestResponse;
use Modules\News\app\Models\Tag;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->prepareForTests();
    }

    private function prepareForTests()
    {
        Artisan::call('migrate');
    }


    public function test_get_tags_with_pagination_request(): void
    {
        $response = $this->get('api/news/tags');

        $response->assertStatus(200);
    }

    public function test_get_with_pagination_tags(): void
    {
        Tag::factory()->create(['name' => 'test 1']);
        Tag::factory()->create(['name' => 'test 2']);
        $response = $this->get('/api/news/tags/');

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [['name' => 'test 1']],
            ]);
    }

    public function test_add_tag(): void
    {
        $response = $this->createTag(['name' => 'test']);

        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => ['name' => 'test'],
            ]);
    }

    public function test_add_dublicate_tag(): void
    {
        Tag::factory()->create(['name' => 'test']);
        $response = $this->createTag(['name' => 'test']);

        $response->assertStatus(422);
    }

    public function test_get_tag(): void
    {
        $tag = Tag::factory()->create(['name' => 'test']);
        $response = $this->getTag($tag->id);
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => ['name' => 'test'],
            ]);
    }

    public function test_get_wrong_tag(): void
    {
        $tag = Tag::factory()->create(['name' => 'test']);
        $tagId = $tag->id + 1;
        $response = $this->getTag($tagId);

        $response
            ->assertStatus(422);
    }

    public function test_update_tag_name(): void
    {
        $tag = Tag::factory()->create(['name' => 'test']);
        $tagId = $tag->id;
        $response = $this->updateTag($tagId, ['name' => 'test 2']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => ['name' => 'test 2'],
            ]);
    }

    public function test_update_wrong_tag_id(): void
    {
        $tag = Tag::factory()->create(['name' => 'test']);
        $tagId = $tag->id + 1;
        $response = $this->updateTag($tagId, ['name' => 'test 2']);

        $response
            ->assertStatus(422);
    }

    public function test_update_tag_dublicate_name(): void
    {
        Tag::factory()->create(['name' => 'test 1']);
        $tag = Tag::factory()->create(['name' => 'test 2']);
        $tagId = $tag->id;
        $response = $this->updateTag($tagId, ['name' => 'test 1']);

        $response
            ->assertStatus(422);
    }

    public function test_delete_tag(): void
    {
        $tag = Tag::factory()->create(['name' => 'test']);
        $response = $this->getTag($tag->id);
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => ['name' => 'test'],
            ]);
        $response = $this->deleteTag($tag->id);
        $response
            ->assertStatus(Response::HTTP_NO_CONTENT);
        $response = $this->getTag($tag->id);
        $response
            ->assertStatus(422);
    }

    private function createTag(array $parameters): TestResponse
    {
        return $this->postJson('/api/news/tags', $parameters);
    }

    private function getTag(int $tagId): TestResponse
    {
        return $this->getJson('/api/news/tags/' . $tagId);
    }

    private function updateTag(int $tagId, array $parameters): TestResponse
    {
        return $this->putJson('/api/news/tags/' . $tagId, $parameters);
    }

    private function deleteTag(int $tagId): TestResponse
    {
        return $this->deleteJson('/api/news/tags/' . $tagId);
    }
}
