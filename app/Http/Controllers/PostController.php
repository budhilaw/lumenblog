<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use App\Post;
use App\User;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    public function index()
    {
        return Post::all();
    }

    public function test($id)
    {
        // Get user by id
        $user = User::find($id);
        // Retrive posts id from user
        foreach( $user->posts as $postId )
        {
            $post = Post::find($postId);
            echo $post->title . '<br />';
        }
        // Get Post detail from id
    }

    public function create(Request $request)
    {
        /*
         * @author Ericsson Budhilaw <budhilaw.mail@gmail.com>
         * -------------------
         * Validation process
         * -------------------
         */
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'posted_by' => 'required'
        ]);

        $user = User::find($request->input('posted_by'));

        /*
         * Check who posted the post
         */
        if( !$user ){
            return response()->json([
                'status' => 'The user is not registered!'
            ], 404);
        }

        /*
         * @author Ericsson Budhilaw <budhilaw.mail@gmail.com>
         * -------------------
         * Create a post first
         * -------------------
         */
        $fillable = [
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'posted_by' => $request->input('posted_by')
        ];

        $post = new Post($fillable);
        $post->save();

        /*
         * @author Ericsson Budhilaw <budhilaw.mail@gmail.com>
         * -----------------------
         * Update user posts list
         * -----------------------
         */

        $userPost = $user->posts;
        $postCreated = [ $post['_id'] ];

        /*
         * Check if the user has a post or not
         */
        if( $userPost == null ){
            $user->posts = $postCreated;
            $user->save();

            return response()->json([
                'status' => 'The post has been created!'
            ], 201);
        }

        $combinedPosts = array_merge($userPost, $postCreated);
        $user->posts = $combinedPosts;
        $user->save();

        return response()->json([
            'status' => 'The post has been created!'
        ], 201);
    }

    public function show($id)
    {
        /*
         * @author Ericsson Budhilaw <budhilaw.mail@gmail.com>
         * -------------------
         * Get a post by id
         * -------------------
         */
        $data = Post::find($id);

        if( !$data )
        {
            return response()->json([
                'status' => 'Post not found!'
            ], 404);
        }

        return response()->json(compact('data'), 200);
    }

    public function edit(Request $request, $id)
    {
        /*
         * @author Ericsson Budhilaw <budhilaw.mail@gmail.com>
         * -------------------
         * Validation process
         * -------------------
         */
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'posted_by' => 'required'
        ]);

        /*
         * @author Ericsson Budhilaw <budhilaw.mail@gmail.com>
         * -------------------
         * Saving process
         * -------------------
         */
        $post = Post::where('_id', $id)->first();

        if( $post->posted_by != $request->input('posted_by') )
        {
            return response()->json([
                'status' => "You doesn't have access to edit this post!"
            ], 403);
        }

        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->posted_by = $request->input('posted_by');
        $post->save();

        return response()->json([
            'status' => 'The user data successfuly edited!'
        ], 200);
    }

    public function delete($id)
    {
        $post = Post::where('_id', $id)->first();
        if( !$post )
        {
            return response()->json([
                'status' => 'Post not found!'
            ], 404);
        }
        $user = User::find($post->posted_by);
        $userPost = $user->posts;

        /*
         * @author Ericsson Budhilaw <budhilaw.mail@gmail.com>
         * -----------------------------
         * Check if has -one or more post
         * ----------------------------
         */

        if( !count($userPost) > 1 )
        {
            unset($userPost);
            $userPost = [];

            /*
            * @author Ericsson Budhilaw <budhilaw.mail@gmail.com>
            * -----------------------------
            * Delete post id from posted_by
            * -----------------------------
            */
            $user->posts = $userPost;
            $user->save();

            /*
            * @author Ericsson Budhilaw <budhilaw.mail@gmail.com>
            * -----------------------------
            * Delete post by id
            * -----------------------------
            */
            $post->delete();
            return response()->json([
                'status' => 'Post has been deleted!'
            ], 200);
        }

        /*
        * @author Ericsson Budhilaw <budhilaw.mail@gmail.com>
        * -----------------------------
        * Search element from array
        * -----------------------------
        */
        $key = array_search($id, $userPost);
        if( $key != false || $key === 0 )
        {
            unset($userPost[$key]);
            $userPost = array_values($userPost);

            /*
            * @author Ericsson Budhilaw <budhilaw.mail@gmail.com>
            * -----------------------------
            * Delete post id from posted_by
            * -----------------------------
            */
            $user->posts = $userPost;
            $user->save();

            /*
            * @author Ericsson Budhilaw <budhilaw.mail@gmail.com>
            * -----------------------------
            * Delete post by id
            * -----------------------------
            */
            $post->delete();
            return response()->json([
                'status' => 'Post has been deleted!'
            ], 200);
        }

        return response()->json([
            'status' => 'Post not found!'
        ], 404);
    }
}