<?php

namespace Modules\News\tests\Unit;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Testing\TestResponse;
use Modules\News\app\Models\Post;
use Modules\News\app\Models\Tag;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->prepareForTests();
    }

    // Migrate the database
    private function prepareForTests()
    {
        Artisan::call('migrate');
    }

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_get_news_with_pagination_request(): void
    {
        $response = $this->get('/news');

        $response->assertStatus(200);
    }

    public function test_add_news(): void
    {
        $parameters = $this->getParameters();
        $response = $this->createPost($parameters);

        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => ['translations' => ['ua' => ['title' => 'first ua post translation title']]],
            ]);
    }

    public function test_add_news_wrong_language(): void
    {
        $parameters = $this->getParameters();
        unset($parameters['translations']['fr']);
        $parameters['translations']['pl'] = [
            'title' => 'first pl post translation title',
            'description' => 'first pl post translation description',
            'content' => 'first pl post translation content'
        ];
        $response = $this->createPost($parameters);

        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['translations' => []],
            ]);
    }

    public function test_get_with_pagination_posts(): void
    {
        $parameters = $this->getParameters();
        $this->createPost($parameters);
        $this->createPost($parameters);
        $response = $this->get('/api/news/');

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [['translations' =>['en' => []]]]
            ]);
    }

    public function test_update_ua_news(): void
    {
        $parameters = $this->getParameters();
        $post = $this->createPost($parameters);
        $parameters['translations']['ua'] = [
            'title' => 'updated ua title',
            'description' => 'first ua post translation description',
            'content' => 'first ua post translation content'
        ];
        $response = $this->updatePost($post['data']['id'], $parameters);

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => ['translations' =>['ua' => ['title' => 'updated ua title']]],
            ]);
    }

    public function test_update_news_wrong_language(): void
    {
        $parameters = $this->getParameters();
        $post = $this->createPost($parameters);
        $parameters['translations']['pl'] = [
            'title' => 'updated pl title',
            'description' => 'first pl post translation description',
            'content' => 'first pl post translation content'
        ];
        $response = $this->updatePost($post['data']['id'], $parameters);

        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => ['translations' => []],
            ]);
    }

    public function test_delete_news(): void
    {
        $parameters = $this->getParameters();
        $post = $this->createPost($parameters);
        $response = $this->deletePost($post['data']['id']);
        $response
            ->assertStatus(Response::HTTP_NO_CONTENT);
    }
    private function deletePost(int $postId): TestResponse
    {
        return $this->deleteJson('/api/news/' . $postId);
    }

    private function createPost(array $parameters): TestResponse
    {
        return $this->postJson('/api/news', $parameters);
    }

    private function getParameters()
    {
        $tag1 = Tag::factory()->create();
        $tag2 = Tag::factory()->create();

        return [
            'translations' => [
                'en' => [
                    'title' => 'first en post translation title',
                    'description' => 'first en post translation description',
                    'content' => 'first en post translation content'
                ],
                'ua' => [
                    'title' => 'first ua post translation title',
                    'description' => 'first ua post translation description',
                    'content' => 'first ua post translation content'
                ],
                'fr' => [
                    'title' => 'first fr post translation title',
                    'description' => 'first fr post translation description',
                    'content' => 'first fr post translation content'
                ],
            ],
            'tags' => [$tag1->id, $tag2->id]
        ];
    }

    private function updatePost(int $postId, array $parameters): TestResponse
    {
        return $this->putJson('/api/news/' . $postId, $parameters);
    }
}
