<?php

namespace App\Http\Controllers;

use App\Events\MessageShown;
use App\Events\NbMessages;
use App\Events\ThreadsDeleted;
use App\Http\Requests\MessageRequest;
use App\Http\Resources\MessageResource;
use App\Http\Resources\ThreadResource;
use App\Models\Listing;
use App\Models\Participant;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('participant', ['only' => ['show', 'update']]);
        $this->middleware('owner.forbidden', ['only' => ['store']]);
    }

    /**
     * Get all message threads for current user
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $threads = Auth::user()->threads()->with(['messages.user', 'participants.user', 'listing'])->paginate(config('app_settings.values.threads_paginate_by'));

        return Inertia::render('Message/Index', [
            'threads' => MessageResource::collection($threads)
        ]);
    }

    /**
     * Get all message threads for current user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function unread()
    {
        $threads = Auth::user()->threads()->with(['messages.user', 'participants.user', 'listing'])->unread()->get();

        return response()->json([
            'threads' => MessageResource::collection($threads)
        ]);
    }

    /**
     * Store new message and create new thread with participants
     *
     * @param MessageRequest $request
     * @param Listing $listing
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MessageRequest $request, Listing $listing = null)
    {
        if ($listing) {
            $thread = $listing->threads()->create(['subject' => $request->get('subject')]);
        } else {
            $thread = Thread::create(['subject' => $request->get('subject')]);
        }

        $recipient = User::findOrFail(request()->get('recipient'));
        $thread->sendInitialMessage($request->message, Auth::user(), $recipient);

        return redirect()->back()->with('success', 'Poruka je uspešno poslata.');
    }

    /**
     * Reply on current thread
     *
     * @param MessageRequest $request
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(MessageRequest $request, Thread $thread)
    {
        $thread->sendReply($request->message, Auth::user());

        return redirect()->back()->with('success', 'Poruka je uspešno poslata.');
    }

    /**
     * Show thread with all messages and participants
     *
     * @param Thread $thread
     * @return \Inertia\Response
     */
    public function show(Thread $thread)
    {
        $thread->readByAuth();
        $thread->load('messages.user');

        MessageShown::dispatch($thread->id, Auth::id());
        NbMessages::dispatch(Participant::unread()->count(), Auth::id());

        return Inertia::render('Message/Show', [
            'thread' => new ThreadResource($thread)
        ]);
    }

    /**
     * Remove participant from resource
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $ids = $request->validate([
            'id' => 'array|min:1',
            'id.*' => 'numeric'
        ]);
        Participant::whereUserId(Auth::id())
            ->whereIn('thread_id', $ids['id'])
            ->delete();

        ThreadsDeleted::dispatch($ids['id'], Auth::id());
        NbMessages::dispatch(Participant::unread()->count(), Auth::id());

        return redirect()->back();
    }
}
