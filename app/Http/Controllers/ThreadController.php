<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\ThreadResource;
use App\Http\Requests\ThreadRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ThreadController extends Controller
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
        $threads = ThreadResource::collection(Thread::all());
        return  response()->json($threads);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThreadRequest $thread)
    {
        $user = User::find(auth()->user()->id);
        $newthread = $user->threads()->create([
            'title' => $thread->title,
            'body' => $thread->body,
            'channel_id' => $thread->channel_id,
            'slug' => Str::of($thread->title)->slug('-'),
        ]);

        return response()->json(new ThreadResource($newthread));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $thread = Thread::find($id);

        if(!$thread){
            return response()->json(["errors" => []],404);
        }

        return response()->json(new ThreadResource($thread));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }


    public function update(ThreadRequest $request, Thread $thread)
    {
        //

        $thread->update(
            [
                'title' => $request->title,
                'body' => $request->body,
                'channel_id' => $request->channel_id,
                'slug' => Str::of($thread->title)->slug('-'),
            ]
        );
        return response()->json(new ThreadResource($thread));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $thread = Thread::find($id);
        if(!$thread){
            return response()->json(["errors" => []],404);
        };

        if($thread->user_id != auth()->user()->id){
            return response()->json(["errors" => []],403);
        }


        return response()->json([]);
    }
}
