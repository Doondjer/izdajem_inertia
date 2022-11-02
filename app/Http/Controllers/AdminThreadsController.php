<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessageForThreadResource;
use App\Http\Resources\MessageResource;
use App\Models\Thread;
use Inertia\Inertia;

class AdminThreadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index()
    {
        $perPage = request()->get('per_page')?:10;
        $query = request()->get('q', '');

        $threads = Thread::where('subject', 'LIKE', "%{$query}%")
            ->with('messages.participants.user')
            ->when(request()->get('trashed') === 'with', function($q){
                return $q->withTrashed();
            })
            ->when(request()->get('trashed') === 'only', function($q){
                return $q->onlyTrashed();
            })
            ->paginate($perPage)
            ->withQueryString()
            ->through(fn($thread) => [
                'id' => $thread->id,
                'subject' => $thread->subject,
                'listing_id' => $thread->listing_id,
                'is_trashed' => !!$thread->deleted_at,
                'updated_at' => $thread->updated_at->format('M d Y H:i'),
                'messages' => [
                    new MessageForThreadResource($thread->messages->last())
                ],
                'participants' => $thread->participants->map(function($participant) {
                    return [
                        'user_id' => $participant->user_id,
                        'name' => $participant->user->name,
                        'profile_image' => $participant->user->profile_image
                    ];
                })
            ]);

        return Inertia::render('Admin/Thread/Index', [
            'threads' => $threads,
            'filters' => [
                'q' => $query,
                'per_page' => $perPage,
                'trashed' => request()->get('trashed')
            ]
        ]);
    }

    /**
     * Display specified resource
     *
     * @param Thread $thread
     * @return \Inertia\Response
     */
    public function show(Thread $thread)
    {
        $thread->load('messages.user')->load([
            'listing'=> function ($query) {
                $query->withTrashed();
            },
        ]);

        return Inertia::render('Admin/Thread/Show', [
            'thread' => new MessageResource($thread)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Thread $thread)
    {
        $thread->delete();

        return redirect()->route('admin.thread.index')->with(['success' => "Konverzacija #$thread->id je uspešno obrisana!"]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function undelete(Thread $thread)
    {
        $thread->restore();

        return redirect()->route('admin.thread.index')->with(['success' => "Konverzacija #$thread->id je uspešno vraćena!"]);
    }
}
