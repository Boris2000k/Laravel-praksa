<?php

namespace Tests\Feature;

use App\Models\Blogpost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    
    

    public function testSee1BlogPostWhenThereIs1()
    {
        //Arrange
        $post = new Blogpost();
        $post->title = 'New Title';
        $post->content = 'Blog post content';
        $post->save();

        //Act
        $response = $this->get('/posts');

        //Assert

        $response->assertSeeText('New Title');

        $this->assertDatabaseHas('blogposts',[
            'title'=>'New Title'
        ]);
    }
}
