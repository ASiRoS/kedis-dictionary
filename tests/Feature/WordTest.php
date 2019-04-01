<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\User;
use App\Word;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;

class WordTest extends BaseTest
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(VerifyCsrfToken::class);
    }

    /** @test */
    function logged_user_can_see_own_words()
    {
        $user = $this->login();

        $words = factory(Word::class, 10)->state('published')->create([
            'user_id' => $user->id
        ]);

        $response = $this->get('/users/words');

        $response->assertStatus(200);

        foreach ($words as $word) {
            $response->assertSee($word->id);
            $response->assertSee($word->title);
        }
    }

    /** @test */
    public function logged_user_can_edit_own_word_and_it_becomes_unpublished()
    {
        $user = $this->login();

        $word = factory(Word::class)->state('published')->create([
            'user_id' => $user->id
        ]);

        $response = $this->put("/words/{$word->id}", [
            'title' => 'Hello',
            'description' => 'World'
        ]);

        $response->assertStatus(302);

        $word = Word::find($word->id);

        $this->assertEquals('Hello', $word->title);
        $this->assertEquals('World', $word->description);

        $this->assertEquals(0, $word->is_published);
    }

    /** @test */
    function get_published_words_by_specific_user()
    {
        $user = factory(User::class)->create();
        $words = factory(Word::class, 10)->state('published')->create([
            'user_id' => $user->id
        ]);

        $response = $this->get("users/{$user->id}/words");

        $response->assertStatus(200);

        foreach($words as $word) {
            $response->assertSee($word->title);
        }
    }

    /** @test */
    function unlogged_user_can_not_comment_words()
    {
        $word = factory(Word::class)->state('published')->create();

        $response = $this->post('comments/' . $word->id, [
            'text' => 'Hello',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('login');
    }

    /** @test */
    function logged_user_can_comment_published_word()
    {
        $this->login();

        $word = factory(Word::class)->state('published')->create();

        $response = $this->post('comments/' . $word->id, [
            'text' => 'Hello'
        ]);

        $response->assertStatus(302);

        $response = $this->get('words/'.$word->id);

        $response->assertStatus(200);
        $response->assertSee('Hello');
    }

    function logged_user_can_not_comment_unpublished_word()
    {
        $this->login();

        $word = factory(Word::class)->state('unpublished')->create();

        $response = $this->post('comments/' . $word->id, [
            'text' => 'Hello'
        ]);

        $response->assertStatus(302);
    }


    
    /** @test */
    function logged_user_can_add_word_with_image()
    {
        $this->login();

        $this->post('words', [
            'title' => 'Hello',
            'description' => 'World',
            'image' => $image = UploadedFile::fake()->image('avatar.jpg'),
        ]);

        \Storage::disk('public')->assertExists('words/' . $image->hashName());
    }

    /** @test */
    function user_can_search_published_words_by_title()
    {
        $title = 'Титан';

        $word = factory(Word::class)->state('published')->create(['title' => $title]);

        $response = $this->get('/search?q='. $title);

        $response->assertStatus(200);
        $response->assertSee($word->id);
        $response->assertSee($word->title);
    }

    function user_can_not_search_unpublished_words_by_title()
    {
        $title = 'Титан';

        factory(Word::class)->state('unpublished')->create(['title' => $title]);

        $response = $this->get('/search?q='. $title);

        $response->assertStatus(200);
        $response->assertSee('Ничего не найдено.');
    }

    /** @test */
    function user_can_see_all_published_words()
    {
        $words = [];

        for($i = 0; $i < 10; $i++) {
            $words[] = factory(Word::class)->state('published')->create();
        }

        $response = $this->get('/');

        $response->assertStatus(200);

        foreach ($words as $word) {
            $response->assertSee($word->title);
        }
    }

    /** @test **/
    function user_can_see_published_word()
    {
        $word = factory(Word::class)->create([
            'title' => 'Земля',
            'is_published' => true
        ]);

        $response = $this->get('words/' . $word->id);

        $response->assertStatus(200);
        $response->assertSee('Земля');
    }


    /** @test **/
    function user_can_not_see_unpublished_word()
    {
        $word = factory(Word::class)->state('unpublished')->create();

        $response = $this->get('words/' . $word->id);

        $response->assertStatus(404);
    }

    /** @test */
    function user_can_add_word()
    {
        $this->login();

        $data = [
            'title' => 'Hello',
            'description' => 'World',
        ];

        $response = $this->post('words', $data);

        $response->assertStatus(302);

        $word = Word::first();

        $this->assertIsObject($word);

        foreach ($data as $param => $value) {
            $this->assertEquals($value, $word->$param);
        }
    }
}