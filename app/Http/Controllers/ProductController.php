<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Product;
use App\Models\CategoryProduct;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Crypt;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();
        return view('welcome', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = "";
        $categories = Category::where('parent_id', '0')->get();
        foreach($categories as $value){
            $data .= '<div class="category_item mt-2" data-id="'.$value->id.'">
                    <label class="mb-1"><input type="checkbox" class="category_item" name="category[]" value="'.$value->id.'" />'.$value->name.'</label>';
            $count = Category::where('parent_id', $value->id)->count();
            if($count > 0){
                $data .= $this->getCategories($value->id);
            }
            $data .= '</div>'; 
        }
        return view('create', compact('data'));
    }

    public function getCategories($category_id){
        $data = "";
        $categories = Category::where('parent_id', $category_id)->get();
        foreach($categories as $value){
            $data .= '<div class="subcategory_list_'.$value->parent_id.'" data-id="'.$value->id.'" style="margin-left: 20px;display:none;">
            <label class="mb-1"><input type="checkbox" class="category_item" name="category[]" value="'.$value->id.'" />'.$value->name.'</label>';
            $count = Category::where('parent_id', $value->id)->count();
            if($count > 0){
                $data .= $this->getCategories($value->id);
            }
            $data .= '</div>';
        }
        return $data;
    }

    public function getEditCategories($category_id, $categoryArray){
        $data = "";
        $categories = Category::where('parent_id', $category_id)->get();
        foreach($categories as $value){
            $data .= '<div class="subcategory_list_'.$value->parent_id.'" data-id="'.$value->id.'" style="margin-left: 20px;';
            if(!in_array($value->parent_id, $categoryArray)){
                $data .= 'display:none;">';
            }
            $data .= '<label class="mb-1"><input type="checkbox" class="category_item" name="category[]" value="'.$value->id.'" ';
            if(in_array($value->id, $categoryArray)){
                $data .= ' checked="checked" ';
            }
            $data .= ' />'.$value->name.'</label>';
            $count = Category::where('parent_id', $value->id)->count();
            if($count > 0){
                $data .= $this->getEditCategories($value->id, $categoryArray);
            }
            $data .= '</div>';
        }
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request){
        DB::beginTransaction();
        try {
            $objProduct = new Product();
            $objProduct->product_name = $request->product_name;
            $objProduct->save();
            
            $categories = $request->category;
            foreach($categories as $value){
                $objProductCategory = new CategoryProduct();
                $objProductCategory->product_id = $objProduct->id;
                $objProductCategory->category_id = $value;
                $objProductCategory->save();
            }
            DB::commit();
            return redirect()->route('products')->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request){
        $product_id = Crypt::decrypt($request->id);
        $product_data = Product::find($product_id);
        $categoryArray = CategoryProduct::where('product_id', $product_id)->pluck('category_id')->toArray();
        $data = "";
        $categories = Category::where('parent_id', '0')->get();
        foreach($categories as $value){
            $data .= '<div class="category_item mt-2" data-id="'.$value->id.'">
                    <label class="mb-1"><input type="checkbox" class="category_item" name="category[]" value="'.$value->id.'" ';
            if(in_array($value->id, $categoryArray)){
                $data .= ' checked="checked" ';
            }
            $data .= ' />'.$value->name.'</label>';
            $count = Category::where('parent_id', $value->id)->count();
            if($count > 0){
                $data .= $this->getEditCategories($value->id, $categoryArray);
            }
            $data .= '</div>'; 
        }
        return view('edit', compact('data','product_data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request)
    {
        DB::beginTransaction();
        try {
            $product_id = $request->product_id;
            $objProduct = Product::find($product_id);
            $objProduct->product_name = $request->product_name;
            $objProduct->update();

            CategoryProduct::where('product_id', $product_id)->delete();
            
            $categories = $request->category;
            foreach($categories as $value){
                $objProductCategory = new CategoryProduct();
                $objProductCategory->product_id = $objProduct->id;
                $objProductCategory->category_id = $value;
                $objProductCategory->save();
            }
            DB::commit();
            return redirect()->route('products')->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request){
        CategoryProduct::where('product_id', $request->product_id)->delete();
        Product::where('id', $request->product_id)->delete();

        return 1;
    }
}
