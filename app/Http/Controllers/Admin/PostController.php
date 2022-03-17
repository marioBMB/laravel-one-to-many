<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected function slug($title, $idToExclude=""){
        $tmp = Str::slug($title);
        $count = 1;
        while(Post::where('slug', $tmp)
        -> where('id', '!=', $idToExclude) /* stesso ruolo del validate unique */
        -> first()){
            $tmp = Str::slug($title). "-" . $count;
            $count++;
        }
        return $tmp;
    }

    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => "required|string|between:5,255",
            'content' => "required|string",
            'published' => "required|boolean",
            // 'thumb' => "nullable|url",
        ]);


        $form_data = $request->all();
        $form_data['slug'] = $this->slug($form_data['title']);

        $newPost = new Post();
        $newPost = Post::create($form_data);
        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {   
        if (!$post){
            abort(404);
        }
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => "required|string|between:5,100",
            'content' => "required|string",
            'published' => "required|boolean",
            // 'thumb' => "nullable|url",
        ]);
        $form_data = $request->all();
        /* va ricalcolato lo slug solo se cambia il titolo */
        $form_data['slug'] = ($post->title == $data['title']) ? $post->slug : $this->slug($data['title'], $post->id);
        
        $post->update($form_data);
        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index');
    }
}
