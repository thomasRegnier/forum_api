<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Http\Request;
use App\Http\Resources\ReplyResource;
use App\Http\Requests\ReplyRequest;
use App\Http\Resources\ReplyIn;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', []);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($thread_id, ReplyRequest $reply)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($thread_id, ReplyRequest $reply)
    {
        $thread = Thread::find($thread_id);
        if(!$thread){
            return response()->json(["errors" => []],404);
        }

        $newReply = $thread->replies()->create([
            "body" => $reply->body,
            "user_id" => auth()->user()->id
        ]);
        return response()->json(new ReplyResource($newReply));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show($thread_id, $reply_id)
    {
        $reply = Reply::find($reply_id);

        if(!$reply){
            return response()->json(["errors" => []],404);
        }

        return response()->json(new ReplyResource($reply));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update($thread_id, $reply_id, ReplyRequest $request)
    {
        $reply = Reply::find($reply_id);
        if(!$reply){
            return response()->json(["errors" => []],404);
        }

        if($reply->user_id != auth()->user()->id){
            return response()->json(["errors" => []],403);
        }

        $reply->update([$request]);

        return response()->json(new ReplyResource($reply));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy($thread_id, $reply_id)
    {
        //
        $reply = Reply::find($reply_id);
        if(!$reply){
            return response()->json(["errors" => []],404);
        };

        if($reply->user_id != auth()->user()->id){
            return response()->json(["errors" => []],403);
        }


        return response()->json([]);
    }
}
