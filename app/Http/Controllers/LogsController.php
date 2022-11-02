<?php

namespace App\Http\Controllers;

use Arcanedev\LogViewer\Contracts\LogViewer as LogViewerContract;
use Arcanedev\LogViewer\Entities\LogEntry;
use Arcanedev\LogViewer\Entities\LogEntryCollection;
use Arcanedev\LogViewer\Exceptions\LogNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Inertia\Inertia;

class LogsController extends Controller
{
    /* -----------------------------------------------------------------
 |  Properties
 | -----------------------------------------------------------------
 */

    /**
     * The log viewer instance
     *
     * @var \Arcanedev\LogViewer\Contracts\LogViewer
     */
    protected $logViewer;

    /** @var int */
    protected $perPage = 30;

    /** @var string */
    protected $showRoute = 'log-viewer::logs.show';

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * LogViewerController constructor.
     *
     * @param  \Arcanedev\LogViewer\Contracts\LogViewer  $logViewer
     */
    public function __construct(LogViewerContract $logViewer)
    {
        $this->logViewer = $logViewer;
        $this->perPage = config('log-viewer.per-page', $this->perPage);
    }

    /**
     * List all logs.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $stats   = $this->logViewer->statsTable();
        $headers = $stats->header();
        $rows    = $this->paginate($stats->rows(), $request);

        return Inertia::render('Admin/Log/Index', compact('headers', 'rows'));
    }

    /**
     * Show the log.
     *
     * @param Request $request
     * @param $date
     * @return \Inertia\Response
     */
    public function show(Request $request, $date)
    {
        $level   = 'all';
        $log     = $this->getLogOrFail($date);
        $query   = $request->get('query');
        $levels  = $this->logViewer->levelsNames();
        $entries = $log->entries($level)->paginate($this->perPage);

        return Inertia::render('Admin/Log/Show', compact('level', 'log', 'query', 'levels', 'entries'));
    }

    /**
     * Filter the log entries by level.
     *
     * @param Request $request
     * @param $date
     * @param $level
     * @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    public function filter(Request $request, $date, $level)
    {
        if ($level === 'all')
            return redirect()->route($this->showRoute, [$date]);

        $log     = $this->getLogOrFail($date);
        $query   = $request->get('query');
        $levels  = $this->logViewer->levelsNames();
        $entries = $this->logViewer->entries($date, $level)->paginate($this->perPage);

        return Inertia::render('Admin/Log/Show', compact('level', 'log', 'query', 'levels', 'entries'));
    }

    /**
     * Show the log with the search query.
     *
     * @param Request $request
     * @param $date
     * @param $level
     * @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    public function search(Request $request, $date, $level = 'all')
    {
        $query   = $request->get('query');

        if (is_null($query))
            return redirect()->route('admin.log.show',[$date,$level]);

        $log     = $this->getLogOrFail($date);
        $levels  = $this->logViewer->levelsNames();
        $needles = array_map(function ($needle) {
            return Str::lower($needle);
        }, array_filter(explode(' ', $query)));
        $entries = $log->entries($level)
            ->unless(empty($needles), function (LogEntryCollection $entries) use ($needles) {
                return $entries->filter(function (LogEntry $entry) use ($needles) {
                    return Str::containsAll(Str::lower($entry->header), $needles);
                });
            })
            ->paginate($this->perPage);

        return Inertia::render('Admin/Log/Show', compact('level', 'log', 'query', 'levels', 'entries'));
    }

    /**
     * Download the log
     *
     * @param  string  $date
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($date)
    {
        return $this->logViewer->download($date);
    }

    /**
     * Delete a log.
     *
     * @param Request $request
     * @return mixed
     * @throws \Arcanedev\LogViewer\Exceptions\FilesystemException
     */
    public function delete(Request $request, $date)
    {
        $redirect = redirect()->route('admin.log.index');
        return $this->logViewer->delete($date) ? $redirect->with('success', 'Uspešno ste obrisali Log fajl') : $redirect->with('error', 'Greška. Log fajl nije obrisan!');
    }

    /**
     * Paginate logs.
     *
     * @param  array                     $data
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function paginate(array $data, Request $request)
    {
        $data = new Collection($data);
        $page = $request->get('page', 1);
        $path = $request->url();

        return new LengthAwarePaginator(
            $data->forPage($page, $this->perPage),
            $data->count(),
            $this->perPage,
            $page,
            compact('path')
        );
    }

    /**
     * Get a log or fail
     *
     * @param  string  $date
     *
     * @return \Arcanedev\LogViewer\Entities\Log|null
     */
    protected function getLogOrFail($date)
    {
        $log = null;

        try {
            $log = $this->logViewer->get($date);
        }
        catch (LogNotFoundException $e) {
            abort(404, $e->getMessage());
        }

        return $log;
    }
}
