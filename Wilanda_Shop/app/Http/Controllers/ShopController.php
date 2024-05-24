<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request, $categorySlug = null, $subCategorySlug = null)
    {
        $categorySelected = '';
        $subCategorySelected = '';
        $brandsArray = [];


        $categories = Category::orderBy('name', 'ASC')->with('sub_category')->where('status', 1)->get();
        $brands = Brand::orderBy('name', 'ASC')->where('status', 1)->get();
        $products = Product::where('status', 1);
        // Apply Filters here
        if (!empty($categorySlug)) {
            $category = Category::where('slug', $categorySlug)->first();
            $products = $products->where('category_id', $category->id);
            $categorySelected = $category->id;
        }
        if (!empty($subCategorySlug)) {
            $subCategory = SubCategory::where('slug', $subCategorySlug)->first();
            $products = $products->where('sub_category_id', $subCategory->id);
            $subCategorySelected = $subCategory->id;
        }
        if (!empty($request->get('brand'))) {
            $brandsArray = explode(',', $request->get('brand'));
            $products = $products->whereIn('brand_id', $brandsArray);
        }
        if ($request->get('price_max') != '' && $request->get('price_min') != '') {
            if ($request->get('price_max') == 1000) {
                $products = $products->whereBetween(
                    'price',
                    [intval($request->get('price_min')), 99999999]
                );
            } else {
                $products = $products->whereBetween(
                    'price',
                    [intval($request->get('price_min')), intval($request->get('price_max'))]
                );
            }
        }
        if ($request->get('sort') != '') {
            if ($request->get('sort') == 'latest') {
                $products = $products->orderBy('id', 'DESC');
            } else if ($request->get('sort') == 'price_asc') {
                $products = $products->orderBy('price', 'ASC');
            } else {
                $products = $products->orderBy('price', 'DESC');
            }
        } else {
            $products = $products->orderBy('id', 'DESC');
        }
        $sort =  $request->get('sort');
        $priceMax = (intval($request->get('price_max')) == 0) ? 1000 : $request->get('price_max');
        $priceMin = intval($request->get('price_min'));
        $products = $products->paginate(6);
        return view(
            'front.shop',
            compact(
                'categories',
                'brands',
                'products',
                'subCategorySelected',
                'categorySelected',
                'brandsArray',
                'priceMax',
                'priceMin',
                'sort'
            )
        );
    }

    function product($slug)
    {
        $product = Product::where('slug', $slug)->with('product_image')->first();
        if ($product == null) {
            abort(400);
        }


        $relatedProducts = [];
        // fetch related products
        if ($product->related_products != '') {
            $productArray = explode(',', $product->related_products);
            $relatedProducts = Product::whereIn('id', $productArray)->with('product_image')->get();
        }
        return view('front.product', compact('product', 'relatedProducts'));
    }

    
}
