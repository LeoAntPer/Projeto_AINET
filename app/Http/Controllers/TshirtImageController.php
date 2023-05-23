<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TshirtImage;
use Illuminate\View\View;

class TshirtImageController extends Controller
{
    public function index(): View
    {
        $allTshirt_images = TshirtImage::all();
        return view('tshirt_images.index')->with('tshirt_images', $allTshirt_images);
    }
}
