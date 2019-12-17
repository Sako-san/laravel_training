<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePost;
use App\BlogPost;
use App\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
// use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // DB::connection()->enableQueryLog();
        // $posts = BlogPost::with('comments')->get();
        // foreach ($posts as $post){
        //     foreach($post->comments as $comment){
        //         echo $comment->content;
        //     }
        // }

        // dd(DB::getQueryLog());
        $mostControversial = Cache::remember('most_commented', 60, function() {
            return BlogPost::Controversial()->take(5)->get();
        });

        $mostActive = Cache::remember('most_active', 60, function() {
            return User::WithMostBlogPosts()->take(5)->get();
        });

        $mostActiveLastMonth = Cache::remember('most_active_lastmonth', 60, function() {
            return User::MostActiveUsers()->take(5)->get();
        });

        return view('posts.index', 
        [
        'posts' => BlogPost::latest()->withCount('comments')->with('user')->get(),
        'most_commented' => $mostControversial,
        'most_active' => $mostActive,
        'most_active_lastmonth' => $mostActiveLastMonth 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->authorize('posts.create');
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
        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id;
        $blogPost = BlogPost::create($validatedData);
        $request->session()->flash('status', 'Blog post was created!');

        return redirect()->route('posts.show', ['post' => $blogPost->id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       return view('posts.show', [
           'post' => BlogPost::with('comments')->findOrFail($id)]);

        // return view('posts.show', [
        // 'post' => BlogPost::with(['comments' => function ($query) {
        //     return $query->latest();
        // }])->findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);
        $this->authorize( $post);

        // if(Gate::denies('update-post', $post)){
        //     abort(403, "THAT'S NOT YOUR POST DUMMY!");
        // };
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize( $post);
        // if(Gate::denies('update-post', $post)){
        //     abort(403, "THAT'S NOT YOUR POST DUMMY!");
        // };

        $validatedData = $request->validated();

        $post->fill($validatedData);
        $post->save();
        $request->session()->flash('status', 'Blog post was updated!');

        return redirect()->route('posts.show', ['post' => $post->id]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize( $post);

        // Gate::denies('delete-post', $post){
        //     abort(403, "THAT'S NOT YOURS TO DELETE DUMMY!")
        // };

        $post->delete();

        $request->session()->flash('status', 'Blog post was deleted!');

        return redirect()->route('posts.index');
    }
}
