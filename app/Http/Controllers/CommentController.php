<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Comments;
use DB;
class CommentController extends Controller
{
    public function index()
    {
        $post = DB::select("select * from comments");     
        return response()->json([
            'success' => true,
            'data' => $post
        ], 400);
    }

    public function show($id)
    {        
        $post = DB::select('select * from comments where id = ('.$id.')');
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
            'postid'       => 'required',            
            'comment'       => 'required'            
        ]);
        $userInfo   = auth('api')->user(); 
        if (auth('api')->user())
        {
            $follow = Comments::create([               
               'post_id'    => $request->postid,
               'comment'    => $request->comment,
               'user_id'        => $userInfo->id
            ]);
            return response()->json([
                'success'   => true,
                'data'      => $follow->toArray()
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

}
