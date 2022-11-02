<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminSendMailRequest;
use App\Mail\AdminContactFormMail;
use Carbon\Carbon;
use Illuminate\Foundation\Http\MaintenanceModeBypassCookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Inertia;
use PragmaRX\Health\Service;

class AdminsController extends Controller
{

    public function health(Service $healthService)
    {
        return Inertia::render('Admin/Health/Show', [
            'initial_resources' => $healthService->getResources(),
            'health' => app('config')->get('health')
        ]);
    }

    /**
     * Show admin dashboard
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Home/Index');
    }

    /**
     * Show form for specific resource
     * @return \Inertia\Response
     */
    public function maintenance()
    {
        return Inertia::render('Admin/Maintenance/Show', [
            'is_maintenance' => app()->isDownForMaintenance(),
            'maintenance' => cache()->get('maintenance:mode:data')
        ]);
    }

    /**
     * Put App in maintenance mode
     */
    public function down(Request $request)
    {
        if(app()->isDownForMaintenance()) {

            return redirect()->back()->with('error', 'Aplikacija se već nalazi u modu Održavanja!');
        }

        $request->validate(['secret' => 'nullable|string|min:12']);

        $secret = $request->get('secret') ?: Str::uuid();

        Artisan::call("down --refresh=60 --secret=$secret");

        cache()->put('maintenance:mode:data', [
            'secret' => $secret,
            'maintenance_started' => Carbon::now()
        ]);

        $cookie = MaintenanceModeBypassCookie::create($secret);

        return response()->json([
            "name" => $cookie->getName(),
            "value" => $cookie->getValue(),
            "expire" => $cookie->getExpiresTime(),
        ],200);
    }

    /**
     * Bring App up from maintenance mode
     *
     */
    public function up()
    {
        if( ! app()->isDownForMaintenance()) {

            return redirect()->back()->with('error', 'Aplikacija se nije ni nalazila u modu Održavanja!');
        }

        Artisan::call('up');
        cache()->delete('maintenance:mode:data');

        return redirect(route('admin.home'))->with('success', 'Aplikacija se više ne nalazi u modu Održavanja');
    }

    /**
     * Show List of current sitemap
     *
     * @return \Inertia\Response
     */
    public function sitemap()
    {
        $sitemap = $this->sitemapToArray();

        return Inertia::render('Admin/Sitemap/Show', compact('sitemap'));
    }

    /**
     * Send command to update sitemap
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sitemapUpdate()
    {
        Artisan::call('sitemap:generate');

        return back()->with('success', 'Mapa sajta je uspešno generisana.');
    }

    /**
     * Show form to send a mail
     * @return \Inertia\Response
     */
    public function mail()
    {
        return Inertia::render('Admin/Mail/Create');
    }

    /**
     * Perform email send
     *
     * @param AdminSendMailRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send(AdminSendMailRequest $request)
    {
        Mail::to($request->email)->send(new AdminContactFormMail($request));

        return redirect()->back()->with(['success' => 'Email je uspešno poslat!']);
    }

    /**
     * @return mixed
     */
    protected function sitemapToArray()
    {
        $json = json_encode([]);

        try {
            $xmlString = file_get_contents(public_path('sitemap.xml'));

            $xmlObject = simplexml_load_string($xmlString);

            $json = json_encode($xmlObject);
        } catch (\Exception $e) {
            report('Cannot find sitemap or failed while loading or encoding');
        }

        return json_decode($json, true);
    }
}
