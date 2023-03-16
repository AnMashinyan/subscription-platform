<?php
namespace App\Http\Controllers;
use App\Events\PostCreate;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Sender;
use App\Models\Subscriber;
use Illuminate\Http\Request;


class PostController extends Controller
{
    public function index(Post $post)
    {
        $posts = Post::all();
        return response()->json([
            'status' => true,
            'message' => 'Posts fetched successfully.',
            'data' => [
                'posts' => $posts,
            ],
        ]);
    }

    public function create(PostRequest $request)
    {
        $title = $request->get('title');
        $description = $request->get('description');
        $website_id = $request ->get('website_id');
        $new_post = Post::create([
            'title' => $title,
            'description' => $description,
            'website_id' => $website_id
        ]);

        Subscriber::select("email")->where("website_id",$website_id)->chunk(1000,function ($subscribers) use ($website_id, $new_post) {
            foreach ($subscribers as $subscriber)
            {
                Sender::create([
                    'post_id' => $new_post->id,
                    'email' => $subscriber->email,
                    'website_id' => $website_id,
                    "is_send" => '0'
                ]);
            }
        });

    event(new PostCreate($new_post));


    return response('Post created successfully');
    }
    public function delete(Request $request)
    {
        $title = $request ->get('title');
        $website_id = $request->get('website_id');
        $request->validate([
            'title' => 'required',
            'website_id' => 'required'
        ]);
        $post= Post::where('title', $title)->
                     where('website_id',$website_id)->first();
        if ($post) {
            $post->delete();
            return response()->json(['message' => 'Successfully Deleted']);
        } else {
            return response()->json(['message' => 'Post not found']);
        }
    }

}

