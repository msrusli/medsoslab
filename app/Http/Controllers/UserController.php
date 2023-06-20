<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Followers;
use DB;

class UserController extends Controller
{
    public function index()
    {
        $post = DB::select("CALL splistuser()");
        //$post = auth('api')->user()->get();        
        return response()->json([
            'success' => true,
            'data' => $post
        ], 400);
    }

    public function show($id)
    {
        $post = DB::select('call splistuserbyid('.$id.')');
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

}
