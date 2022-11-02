<?php

namespace App\Http\Controllers;

use App\Acme\Traits\UploadTrait;
use App\Http\Requests\ImageRequest;
use App\Models\Image;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImagesController extends Controller
{
    use UploadTrait;

    public function __construct()
    {
        $this->middleware('ownerOrAdmin',['only' => ['store', 'destroy']]);
    }
    /**
     * @param Listing $listing
     * @param ImageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Listing $listing, ImageRequest $request)
    {
        $upload = $request->file('image');
        $img = $this->storeToDisk($upload);

        if($img) {

            $image = $listing->images()->create($img);
            return response()->json([
                'serverId' => $image->filename
            ],200);
        } else {

            return response()->json([
                'error' => 'Slika nije sačuvana, pokušajte ponovo.'
            ],Response::HTTP_NOT_IMPLEMENTED);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Listing $listing
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Listing $listing)
    {
        $requestImage = request()->get('image');
        $image = $listing->images()->whereFilename($requestImage)->firstOrFail();
        $isDestroyed = $image->delete();

        $isDeleted = Storage::disk('images')->delete($requestImage);
        if( ! $isDeleted) {
            Log::error("Image $requestImage was not deleted from directory!");
        }

        return response()->json([
            'deleted' => $isDestroyed
        ],Response::HTTP_OK);
    }
}
