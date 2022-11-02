<?php

namespace App\Acme\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image as Intervention;

trait UploadTrait {

    /**
     * Generate more unique name then hashName()
     *
     * @param UploadedFile $upload
     * @param string|null $extension
     * @param bool $disableExtension
     * @return string
     */
    public function generateName(UploadedFile $upload, string $extension = null, bool $disableExtension = false)
    {
        if($disableExtension) {
            $extension = null;
        } else {
            if (! $extension && $ext = $upload->guessExtension()) {
                $extension = ".$ext";
            } else {
                $extension = ".$extension";
            }
        }


        return Str::orderedUuid()->toString() . $extension;
	}

    /**
     * @param $upload
     * @return array
     */
    protected function storeToDisk($upload, string $filename = null, string $extension = 'jpg')
    {
        if( ! $filename) {
            $filename = $this->generateName($upload, $extension);
        }

        $originalFilename = $upload->getClientOriginalName();
     //   $size = $upload->getSize();
        $image = Intervention::make($upload)->orientate();
        $image->resize(null,1080, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        // $image->fit(1920,1080);
        //$watermark = Intervention::make(public_path('watermark.png'));
        //$image->insert($watermark, 'center');

        $stored = Storage::disk('images')->put($filename,$image->encode($extension));

        if($stored) {

            return [
                'filename' => $filename,
                'original_filename' => $originalFilename,
                'mime' => $image->mime(),
                'size' => $image->filesize(),
            ];
        }

        return [];
    }
}
