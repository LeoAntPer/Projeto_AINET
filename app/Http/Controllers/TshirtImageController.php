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
                                    ->get();
        return view('tshirt_images.index')->with('tshirtImages', $tshirtImages);
    }
}
