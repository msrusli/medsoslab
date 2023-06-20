<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Post;
use DB;
class PostController extends Controller
{
    public function index()
    {
        $post = DB::select("CALL splistposts()");
        //$post = auth('api')->user()->get();        
        return response()->json([
            'success' => true,
            'data' => $post
        ], 400);
    }
 
    public function show($id)
    {
        $post = DB::select('call splistpostsbyid('.$id.')');
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found '
            ], 400);
        } 
        return response()->json([
            'success' => true,
            'data' => $post
        ], 400);
    }
 
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'         => 'required|min:4',
            'description'   => 'required|min:4',
            'image'         => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:20483',
        ]);

        $image_path = $request->file('image')->store('image', 'public');

        $userInfo   = auth('api')->user(); 
        if (auth('api')->user())
        {

            $varpost = Post::create([                
                'title'         => $request->title,
                'description'   => $request->description,
                'user_id'       => $userInfo->id,
                'image'         => $image_path                
            ]);            
            return response()->json([
                'success'   => true,
                'data'      => $varpost->toArray()
            ]);
        }
        else
        {
            return response()->json([
            'success' => false,
            'message' => 'Post not found'
            ], 500);
        }
    }
 
    public function update(Request $request, $id)
    {
        $post = auth()->user()->posts()->find($id);
 
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 400);
        }
 
        $updated = $post->fill($request->all())->save();
 
        if ($updated)
            return response()->json([
                'success' => true
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Post can not be updated'
            ], 500);
    }
 
    public function destroy($id)
    {
        $post = auth()->user()->posts()->find($id);
 
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 400);
        }
 
        if ($post->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post can not be deleted'
            ], 500);
        }
    }
}