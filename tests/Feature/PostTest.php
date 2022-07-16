<?php

namespace Tests\Feature;

use App\Models\Blogpost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Carbon;


class PostTest extends TestCase
{
    use RefreshDatabase;
    
    

    public function testSee1BlogPostWhenThereIs1()
    {
        //Arrange
        // $post = new Blogpost();
        // $post->title = 'New Title';
        // $post->content = 'Blog post content';
        // $post->save();

        $post = $this->createDummyBlogPost();

        //Act
        $response = $this->get('/posts');

        //Assert

        $response->assertSeeText('New Title');
        $response->assertSeeText('No comments yet!');

        $this->assertDatabaseHas('blogposts',[
            'title'=>'New Title'
        ]);
    }

    public function testStoreValid()
    {
        $params = [
            'title'=>'Valid title',
            'content'=>'At least 10 charachters long'
        ];

        $this->post('/posts',$params)->assertStatus(302)->assertSessionHas('status');

        $this->assertEquals(session('status'),'The blog post was created!');
        
    }

    public function testStoreFail()
    {
        $params = [
            'title'=>'x',
            'content'=>'2short'
        ];

        $this->post('/posts',$params)->assertStatus(302)->assertSessionHas('errors');

        $messages = session('errors')->getMessages();
        

        $this->assertEquals($messages['title'][0],'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0],'The content must be at least 10 characters.');
    }

    public function testUpdateValid()
    {
        //$post = new Blogpost();
        //$post->title = 'New title';
        //$post->content = 'Blog post content';
        //$post->updated_at = Carbon::now()->timestamp;
        //$post->created_at = Carbon::now()->timestamp;
        //$post->save();

        $post = $this->createDummyBlogPost();

        // $this->assertDatabaseHas('blogposts',$post->toArray()); // doda 00000z posle timestamps, nece biti isto

        $this->assertDatabaseHas('blogposts',[
            'title'=>'New Title'
        ]);

        $params = [
            'title'=>'A new named title',
            'content'=>'Content not too short changed'
            
        ];

        $this->put("/posts/{$post->id}" ,$params)->assertStatus(302)->assertSessionHas('status');

        $this->assertEquals(session('status'),'Blog post was updated!');

        $this->assertDatabaseMissing('blogposts',$post->toArray());
        $this->assertDatabaseHas('blogposts',[
            'title'=>'A new named title'
        ]);

        
    }

    public function testDelete()
    {
        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blogposts',[
            'title'=>'New Title'
        ]);


        $this->delete("/posts/{$post->id}")->assertStatus(302)->assertSessionHas('status');

        $this->assertEquals(session('status'),'Blog post was deleted !');
        $this->assertDatabaseMissing('blogposts',$post->toArray());




    }

    private function createDummyBlogPost(): Blogpost
    {
        $post = new Blogpost();
        $post->title = 'New Title';
        $post->content = 'Blog post content';
        $post->save();

        return $post;
    }

    public function testSee1BlogPostWithComments()
    {
        $post = $this->createDummyBlogPost();
        $reponse = $this->get('/posts');
    }


}
