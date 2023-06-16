<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use App\Models\TshirtImage;
use App\Models\Category;
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
        $tshirtImages = $tshirtImagesQuery->paginate(29);
        return view('tshirt_images.index', compact('categories',
            'filterByCategory',
            'filterByName',
            'filterByDescription',
            'tshirtImages'
        ));
    }

    public function show(Request $request, int $imageID): View
    {
        $image = TshirtImage::find($imageID);
        $bases = Color::all();
        $colorCode = $request->input('color') ?? '00a2f2';
        $basePreview = Color::where('code', $colorCode)->first();
        return view('tshirt_images.show', compact('image','bases', 'basePreview'))->withImageId($imageID);
    }


}
