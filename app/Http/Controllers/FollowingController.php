<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Followers;
use DB;
class FollowingController extends Controller
{
    public function index()
    {

        //$post = DB::table('users')->where('id', '1')->first();
        $post = DB::select("CALL splistuser()");
        //$post = auth('api')->user()->get();        
        return response()->json([
            'success' => true,
            'data' => $post
        ], 400);
    }

    public function show($id)
    {
        //$post = auth('api')->user()->find($id); 
        //$post = DB::select('call splistuserbyid(?)',array($id));
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
 
    public function store(Request $request)
    {
        $this->validate($request, [
            'followerid'       => 'required'            
        ]);
        $userInfo   = auth('api')->user(); 
        if (auth('api')->user())
        {
            $follow = Followers::create([               
               'follower_id'    => $request->followerid,
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

    public function update(Request $request, $id)
    {
        $userInfo   = auth('api')->user(); 
        $condition1 = $id;
        $condition2 = $userInfo->id;
        if (auth('api')->user())
        {
            $follow = Followers::where('follower_id', $condition1)
            ->where('user_id', $condition2)                 
            ->delete(); 
            return response()->json([
                'success'   => true,
                'data'      => "UnFollowed Successfully"
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
