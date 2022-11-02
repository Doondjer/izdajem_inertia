<?php

namespace App\Observers;

use App\Acme\Traits\UploadTrait;
use App\Models\Image;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\Facades\Image as Intervention;

class ImagesObserver
{
    use UploadTrait;

    public function creating(Image $image)
    {
        try {
            $imageFile = Intervention::make(Storage::disk('images')->path($image->filename));
            $imageFile->encode('webp');
            $imageName = head(explode('.', $image->filename)) . ".wepb";
            Storage::disk('images')->put("webp/$imageName",$imageFile);

            $image->webp_filename = $imageName;
        } catch (NotReadableException $exception) {
            Log::alert('Could not find image on path: ' . Storage::disk('images')->path($image->filename));
            report($exception);
        } catch (\Exception $exception) {
            report($exception);
        }
    }
}
