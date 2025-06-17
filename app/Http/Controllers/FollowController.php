<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;


class FollowController extends Controller
{


public function toggleFollow($id)
{
    $authUser = auth()->user();
    $targetUser = User::findOrFail($id);

    $existingFollow = $authUser->followings()->where('followed_id', $targetUser->id)->first();

    if ($existingFollow) {
        // Ya sigue: se hace unfollow
        $authUser->followings()->detach($targetUser->id);
        return back();
    }

    $status = $targetUser->is_private ? 'pending' : 'accepted';

    $authUser->followings()->attach($targetUser->id, ['status' => $status]);

    // Evita notificación duplicada
    if ($status === 'pending') {
        $alreadyNotified = \App\Models\Notification::where([
            ['sender_id', $authUser->id],
            ['receiver_id', $targetUser->id],
            ['type', 'follow']
        ])->first();

        if (!$alreadyNotified) {
            \App\Models\Notification::create([
                'sender_id' => $authUser->id,
                'receiver_id' => $targetUser->id,
                'type' => 'follow',
            ]);
        }
    }

    return back();
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Follow  $follow
     * @return \Illuminate\Http\Response
     */
    public function show(Follow $follow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Follow  $follow
     * @return \Illuminate\Http\Response
     */
    public function edit(Follow $follow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Follow  $follow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Follow $follow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Follow  $follow
     * @return \Illuminate\Http\Response
     */
    public function destroy(Follow $follow)
    {
        //
    }
}
