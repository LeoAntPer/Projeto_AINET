<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\TshirtImage;
use Illuminate\View\View;

class TshirtImageController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::all();
        $filterByCategory = $request->category ?? '';
        $filterByName = $request->name ?? '';
        $filterByDescription = $request->description ?? '';
        $tshirtImagesQuery = TshirtImage::query();
        $tshirtImagesQuery->whereNull('customer_id');
        if ($filterByCategory !== '') {
            $tshirtImagesQuery->where('category_id', $filterByCategory);
        }
        if ($filterByName !== '') {
            //$tshirtImagesQuery->where('UPPER(name)','ILIKE','%'.strtoupper($filterByName).'%');
            $tshirtImagesQuery->where('name', 'LIKE', '%'.$filterByName.'%');
        }
        if ($filterByDescription !== '') {
            //$tshirtImagesQuery->where('UPPER(description)','ILIKE','%'.strtoupper($filterByDescription).'%');
            $tshirtImagesQuery->where('description', 'LIKE', '%'.$filterByDescription.'%');
        }
        $tshirtImages = $tshirtImagesQuery->get();
        return view('tshirt_images.index', compact('categories',
            'filterByCategory',
            'filterByName',
            'filterByDescription',
            'tshirtImages'
        ));
    }
}
