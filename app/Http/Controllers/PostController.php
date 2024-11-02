<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{

    public function index()
    {
    $posts = Post::all()->sortByDesc('created_at');
    $categories = Category::all();
    return view('posts.index', compact('posts', 'categories'));
    }


    public function create()
    {
        // Load all categories to pass to the view
        $categories = Category::all();
        // Pass the categories to the 'posts.create' view
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
       //check that the fields are not empty
        $validatedData = $request->validate([
            'title' => 'required|min:3',
            'author' => 'required|min:3',
            'body' => 'required|min:10',
        ]);

        // Create and save a new post with the data from the request
        $post = Post::create([
            'title' => $request->title,
            'author' => $request->author,
            'body' => $request->body,
            // Ensure 'category_id' is added in the request and in the $fillable array of the Post model
            'category_id' => $request->category_id, 
        ]);

        // Redirect to the post details page after saving
        return redirect()->route('posts.show', $post->id);
    }



    public function show(string $id)
    {
    $post = Post::find($id);
    return view('posts.show', compact('post'));
    }

    public function edit(string $id)
    {
    $post = Post::find($id);
    $categories = Category::all();
    return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, string $id)
    {
    //very basic validation - there shold be at least some data in the fields
    if ($request->title == null || $request->author == null || $request->body == null) {
    //if you deleted everyting - go back and fill it!
    return redirect()->route('posts.edit', $id);
    }
    //all clear - updating the post!
    $post = Post::find($id);
    $post->title = $request->title;
    $post->author = $request->author;
    $post->body = $request->body;
    $post->save();
    return redirect()->route('posts.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    Post::findOrfail($id)->delete();
    return redirect()->route('posts.index');
    }
}
