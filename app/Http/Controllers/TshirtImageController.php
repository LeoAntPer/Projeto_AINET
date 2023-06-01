<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TshirtImage;
use Illuminate\View\View;

class TshirtImageController extends Controller
{
    public function index(): View
    {
        $tshirtImages = TshirtImage::whereNull('customer_id')
                                    ->paginate(29);
        return view('tshirt_images.index')->with('tshirtImages', $tshirtImages);
    }

    public function show(int $imageId): View
    {
        $image = $this->getImageById($imageId);
        return view('tshirt_images.show')->withImageId($imageId)->with('image', $image);
    }

    public function getImageById(int $imageId)
    {
        return TshirtImage::find($imageId);
    }
}
