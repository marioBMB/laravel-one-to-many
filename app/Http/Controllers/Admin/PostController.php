<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\User;
use App\Category;

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
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
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
            'category_id'=> "nullable|exists:categories,id",
            'image' => "nullable|image|mimes:jpg,bmp,png|max:2048",
            // 'thumb' => "nullable|url",
        ]);

        $form_data = $request->all();

        if (isset($form_data['image'])){
            $img_path = Storage::put('uploads', $form_data['image']);
            $form_data['image'] = $img_path;
        }

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
    public function show(Post $post) /* N.B. dobbiamo per forza chiamarlo post perché è come lo abbiamo chiamato nella rotta, post:slug */
    {   
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
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
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
            'title' => "required|string|between:5,255",
            'content' => "required|string",
            'published' => "required|boolean",
            'category_id'=> "nullable|exists:categories,id",
            'image' => "nullable|image|mimes:jpg,bmp,png|max:2048",
            // 'thumb' => "nullable|url",
        ]);
        $form_data = $request->all();
        
        if (isset($form_data['image'])){
            $img_path = Storage::put('uploads', $form_data['image']);
            $form_data['image'] = $img_path; //sovrascrittura
        }
        /* va ricalcolato lo slug solo se cambia il titolo */
        $form_data['slug'] = ($post->title == $form_data['title']) ? $post->slug : $this->slug($form_data['title'], $post->id);

        
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
