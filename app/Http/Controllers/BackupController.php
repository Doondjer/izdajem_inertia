<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Elastic\ScoutDriverPlus\Support\Arr;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Spatie\Backup\Tasks\Monitor\BackupDestinationStatusFactory;

class BackupController extends Controller
{

    /**
     * Display list of this resource
     *
     * @return \Inertia\Response
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index()
    {
        $driver = Storage::disk('google');

        return Inertia::render('Admin/Backup/Index', [
            'backup' => $driver->listContents('', true )->map(function ($file){
                return [
                    'id' => Arr::get($file,'extraMetadata.id'),
                    'filename' => Arr::get($file,'extraMetadata.filename') . '.' . Arr::get($file,'extraMetadata.extension'),
                    'diskName' => 'google',
                    'deletePath' => route('admin.backup.delete',['file_name' => Arr::get($file,'path'), 'disk' => 'google']),
                    'downloadPath' => route('admin.backup.download',['file_name' => Arr::get($file,'path'), 'disk' => 'google']),
                    'size' => round((int)Arr::get($file,'fileSize')/1048576, 2).' MB',
                    'updatedAt' => Carbon::createFromTimestamp(Arr::get($file,'lastModified'))->format('Y-m-d H:i'),
                ];
            })->toArray(),

        ]);
    }

    /**
     * Download specified Backup from storage
     */
    public function download($disk, $file)
    {
        $driver = Storage::disk($disk);

        try {
            $stream = $driver->readStream($file);

            return response()->stream(function() use($stream) {
                fpassthru($stream);
            }, 200, [
                "Content-Type" => $driver->mimeType($file),
                "Content-Length" => $driver->fileSize($file),//$disk->getSize($file),
                "Content-disposition" => "attachment; filename=\"" . $file . "\"",
            ]);
        } catch (FileNotFoundException $exception){
            report($exception);
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Backups Health Check
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function check()
    {
        $unhealthy = [];
        $healthy = [];

        $statuses = BackupDestinationStatusFactory::createForMonitorConfig(config('backup.monitor_backups'));

        foreach ($statuses as $backupDestinationStatus) {
            $diskName = $backupDestinationStatus->backupDestination()->diskName();

            if ($backupDestinationStatus->isHealthy()) {
                $healthy[] = $diskName;
                Log::info("The backups on {$diskName} are considered healthy.");
            } else {
                $unhealthy[] = $diskName;
                Log::error("The backups on {$diskName} are considered unhealthy!");
            }

        }

        if ($unhealthy) {
            return redirect()->back()->with('error', "The backups on {" . implode(', ', $unhealthy) . "} are considered unhealthy!");
        }

        return redirect()->back()->with('success', "The backups on {" . implode(', ', $healthy) . "} are considered healthy!");
    }

    /**
     * Store specified Backup of files and database to storage
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($type)
    {
        if( ! in_array($type, ['full', 'db', 'files'])) {

            return redirect()->back()->with('error', 'Invalid Backup Type');
        } else if($errorMessage = $this->handleBackup($type)){

            return redirect()->back()->with('error', $errorMessage);
        }

        return redirect()->back()->with('success', 'Backup je uspešno sačuvan!');
    }

    /**
     * Destroy specified Backup.
     *
     * @param $disk
     * @param $fileName
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($disk, $fileName)
    {
        $isDeleted = false;
        $disk = Storage::disk($disk);

        if($disk->exists($fileName)) {

            $isDeleted = $disk->delete($fileName);
        }

        if ( ! $isDeleted){
            return redirect()->back()->with('error', 'Ouups... Backup Nije obrisan!');
        }

        return redirect()->back()->with('success', 'Backup je uspešno obrisan!');
    }

    /**
     * This method handle actual backup for this class
     *
     * @param $backupType
     * @return string|null
     */
    protected function handleBackup($backupType = null)
    {
        $errorMessage = null;

        try {
            set_time_limit(340);
            // start the backup process
            Artisan::call('backup:run', [
                "--only-db" => $backupType == 'db',
                "--only-files" => $backupType == 'files',
            ]);

            $output = Artisan::output();
            // log the results
            Log::info("New backup started from admin interface \r\n".$output);
        } catch (\Exception $e) {
            report($e);
            $errorMessage = $e->getMessage();
        }

        return $errorMessage;
    }
}
