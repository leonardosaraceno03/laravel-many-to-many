<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Tag;
use App\Mail\SendNewMail;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //creo una variabile per recuperare il record dell'utente loggato

        $data = [
            'posts' => Post::with('category', 'tags')->get()
        ];

        return view('admin.post.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::All();
        $tags = Tag::All();

        return view('admin.post.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $posts = $request->all();

        $new_post = new Post();

        if(array_key_exists('image', $posts)){
            $image_url = Storage::put('post_images', $posts['image']);
            $posts['cover'] = $image_url;
        }
        $new_post->fill($posts);
        $new_post->save();

        if(array_key_exists('tags', $posts)){
            $new_post->tags()->sync($posts['tags']);
        }

        $mail = new SendNewMail($new_post);
        $userMail = Auth::user()->email;
        Mail::to($userMail)->send($mail);

        return redirect()->route('admin.post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $posts = Post::findOrFail($id);
        return view('admin.post.show', compact('posts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::All();
        $tags = Tag::All();

        return view('admin.post.edit', compact('post', 'categories', 'tags'));
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
        $data = $request->all();
        $posts = Post::findOrFail($id);

        $posts->update($data);

        // Per controllare checkbox selezionate dall'utente
        if(array_key_exists('tags', $data)){
            $posts->tags()->sync($data['tags']);
        } else{
            // Per checkbox non selezionate
            $posts->tags()->sync([]);
        }
        return redirect()->route('admin.post.index', $posts->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = Post::findOrFail($id);
        $posts->tags()->sync([]);
        $posts->delete();

        return redirect()->route('admin.post.index');
    }
}
