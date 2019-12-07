<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }


    public function index()
    {
        //$posts = Post::all(); // its a part of eloquent/ORM ,which will fetch all the data from the Post model.
        //$posts = DB::select('select * from posts');
        // $posts = Post::orderBy('title','desc')->take(1)->get();
        //$posts = Post::orderBy('title','desc')->take(1)->get();
        $posts = Post::orderBy('title','desc')->paginate(10);
        return view('posts.index')->with('posts',$posts); 
        // with('posts',$posts) - here 'posts' is the context variable name which we will use in the template 
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
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        // handle file upload

        if($request->hasFile('cover_image')){
            // Get filename with the Extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get the filename
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //Upload Image
            $path = $request->file('cover_image')->storeAs('public/cover_image',$fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        // Create Post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body  = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();

        return redirect('/posts')->with('success','Post Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post =  Post::find($id);
        return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post =  Post::find($id);

        //Check for correct user
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error','Unauthorized Page'); 
        }
        return view('posts.edit')->with('post',$post);
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
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);


        // handle file upload

        if($request->hasFile('cover_image')){
            // Get filename with the Extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get the filename
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //Upload Image
            $path = $request->file('cover_image')->storeAs('public/cover_image',$fileNameToStore);
        }
        // Create Post
        $post =  Post::find($id);
        $post->title = $request->input('title');
        $post->body  = $request->input('body');
        if($request->hasFile('cover_image')){
            $post->cover_image = $fileNameToStore;
        }
        $post->save();

        return redirect('/posts')->with('success','Post Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete 
        $post = Post::find($id);
         //Check for correct user
         if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error','Unauthorized Page'); 
        }

        // Delete image when the post is deleted
        if($post->cover_image != 'noimage.jpg'){
            Storage::delete(['public/cover_image/'.$post->cover_image]);
        }
        $post->delete();
        return redirect('/posts')->with('success','Post Deleted Successfully');
    }
}
