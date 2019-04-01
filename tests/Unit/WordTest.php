<?php

namespace Tests\Unit;

use App\Word;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class WordTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function get_full_path_to_image()
    {
        $word = factory(Word::class)->make([
            'image' => 'words/123.jpg'
        ]);

        $this->assertEquals('storage/words/123.jpg', $word->image);
    }

    /** @test */
    function can_get_formatted_date()
    {
        $word = factory(Word::class)->make([
            'created_at' => Carbon::parse('1 December 2019'),
        ]);

        $this->assertEquals('2019.12.01', $word->formatted_date);
    }

    /** @test */
    function published_word_is_visible()
    {
        $publishedWords = [
            factory(Word::class)->state('published')->create(['is_published' => true]),
            factory(Word::class)->state('published')->create(['is_published' => true]),
            factory(Word::class)->state('published')->create(['is_published' => true]),
        ];

        $words = Word::published()->get();

        foreach ($publishedWords as $word) {
            $this->assertTrue($words->contains($word));
        }
    }

    /** @test */
    function unpublished_word_is_invisible()
    {
        $unpublished = factory(Word::class)->state('unpublished')->create();

        $words = Word::published()->get();

        $this->assertFalse($words->contains($unpublished));
    }
}