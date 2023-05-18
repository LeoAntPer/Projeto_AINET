<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tshirt_image;
use Illuminate\View\View;

class Tshirt_imageController extends Controller
{
    public function index(): View
    {
        $allTshirt_images = Tshirt_image::all();
        return view('tshirt_images.index')->with('tshirt_images', $allTshirt_images);
    }
}
