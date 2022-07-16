<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\Blogpost;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;

class PostController extends Controller
{

    private $posts = [
        1 => [
            'title' => 'Intro to Laravel',
            'content' => 'This is a short intro to Laravel',
            'is_new' => true,
            'has_comments' => true
        ],
        2 => [
            'title' => 'Intro to PHP',
            'content' => 'This is a short introa to PHP',
            'is_new' => false
        ],
        3 => [
            'title' => 'Intro to Golang',
            'content' => 'This is a short introa to Golang',
            'is_new' => false
        ]
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // DB::enableQueryLog();
        // $posts = Blogpost::with('comments')->get();
        // foreach($posts as $post)
        // {
        //     foreach($post->comments as $comment)
        //     {
        //         echo $comment->content;
        //     }
        // }
        // dd(DB::getQueryLog());
        
        return view('posts.index',['posts'=>Blogpost::withCount('comments')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {

        $validated = $request->validated();
        $post = BlogPost::create($validated);

        

        $request->session()->flash('status','The blog post was created!');

        return redirect()->route('posts.show',['post'=>$post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //abort_if(!isset($this->posts[$id]), 404);

        return view('posts.show',[
            'post' =>Blogpost::with('comments')->findOrFail($id)
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        return view('posts.edit', ['post'=>Blogpost::findOrFail($id)]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Blogpost::findOrFail($id);
        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();
        
        $request->session()->flash('status','Blog post was updated!');

        return redirect()->route('posts.show',['post'=>$post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Blogpost::findOrFail($id);
        $post->delete();

        session()->flash('status','Blog post was deleted !');
        return redirect()->route('posts.index');
    }
}
