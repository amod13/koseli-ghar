<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\category\create;
use App\Models\Category;
use App\Repositories\CategoryRepo;
use App\Repositories\SettingRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    private $view;
    protected $repo, $settingRepo;
    public function __construct(CategoryRepo $repo,SettingRepo $settingRepo)
    {
        $this->middleware('check.permission');
        $this->repo = $repo;
        $this->settingRepo = $settingRepo;
        $this->view = 'admin.page.product_management.category.';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['header_title'] = 'Add Category';
        // Fetch all categories to use as parent categories
        // $data['parentCategories'] = Category::whereNull('parent_id')->get();

        $data['categories'] = $this->repo->getMainCategoriesWithSubcategories();
        $data['setting'] = $this->settingRepo->getFirstData();


        return view($this->view . 'index', ['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(create $request)
    {
        $data = $request->only($this->repo->getModel()->getFillable());

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageExtension = $image->getClientOriginalExtension();
            $imageFilename = time() . '_category.' . $imageExtension;

            // Directory for storing logo images
            $imageDirectory = public_path('uploads/images/product/category');
            if (!file_exists($imageDirectory)) {
                mkdir($imageDirectory, 0777, true);
            }

            // Move the image to the directory
            $image->move($imageDirectory, $imageFilename);

            // Save the image path in the data array
            $data['image'] = $imageFilename;
        }
        if ($request->hasFile('slider_image')) {
            $sliderimage = $request->file('slider_image');
            $sliderimageExtension = $sliderimage->getClientOriginalExtension();
            $sliderimageFilename = time() . '_slider_image.' . $sliderimageExtension;

            // Directory for storing logo images
            $sliderimageDirectory = public_path('uploads/images/product/category/slider');
            if (!file_exists($sliderimageDirectory)) {
                mkdir($sliderimageDirectory, 0777, true);
            }

            // Move the image to the directory
            $sliderimage->move($sliderimageDirectory, $sliderimageFilename);

            // Save the image path in the data array
            $data['slider_image'] = $sliderimageFilename;
        }
        $result = $this->repo->createRecord($data);
        if ($result) {
            return redirect()->back()->with('success', 'Category Created Successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Edit a category
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['header_title'] = 'Edit Category';

        $data['categories'] = $this->repo->getMainCategoriesWithSubcategories();

        $data['category'] = $this->repo->editRecord($id);

        // $data['parentCategories'] = Category::whereNull('parent_id')->get();

        $data['setting'] = $this->settingRepo->getFirstData();

        return view($this->view . 'index', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(create $request, $id)
    {
        $data = $request->only($this->repo->getModel()->getFillable());


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageExtension = $image->getClientOriginalExtension();
            $imageFilename = time() . '_category.' . $imageExtension;

            // Directory for storing logo images
            $imageDirectory = public_path('uploads/images/product/category');
            if (!file_exists($imageDirectory)) {
                mkdir($imageDirectory, 0777, true);
            }

            // Move the image to the directory
            $image->move($imageDirectory, $imageFilename);

            // Save the image path in the data array
            $data['image'] = $imageFilename;
        }

        if ($request->hasFile('slider_image')) {
            $sliderimage = $request->file('slider_image');
            $sliderimageExtension = $sliderimage->getClientOriginalExtension();
            $sliderimageFilename = time() . '_slider_image.' . $sliderimageExtension;

            // Directory for storing logo images
            $sliderimageDirectory = public_path('uploads/images/product/category/slider');
            if (!file_exists($sliderimageDirectory)) {
                mkdir($sliderimageDirectory, 0777, true);
            }

            // Move the image to the directory
            $sliderimage->move($sliderimageDirectory, $sliderimageFilename);

            // Save the image path in the data array
            $data['slider_image'] = $sliderimageFilename;
        }

        $result = $this->repo->updateRecord($id, $data);
        if ($result) {
            return redirect()->route('category.index')->with('success', 'Category Updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Display the specified category along with its subcategories.
     *
     * This method fetches a category by its ID, including its subcategories, and renders the view
     * to return the HTML content as a JSON response.
     *
     * @param int $id The ID of the category to display.
     * @return \Illuminate\Http\JsonResponse JSON response containing the rendered HTML.
     */
    public function show($id)
    {
        // Fetch the category by ID
        $data['category'] = $this->repo->getCategoryIdBasedWithSubcategories($id);

        // Render the view and return the HTML
        $showData =  view($this->view . 'show', ['data' => $data])->render();

        return response()->json(['html' => $showData]); // Sending the rendered HTML
    }

    /**
     * Handles category search.
     *
     * This method retrieves the search query from the request, fetches categories
     * matching the search query using the repository, and renders the category
     * index view with the search results.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object.
     * @return \Illuminate\Http\Response The HTTP response with the rendered view.
     */
    public function getCategorySearch(Request $request)
    {
        $search = $request->get('search'); // Retrieve the search query

        // $data['parentCategories'] = Category::whereNull('parent_id')->get();

        // Use the repository to fetch categories matching the search query
        $data['categories'] = $this->repo->searchCategories($search);

        $data['setting'] = $this->settingRepo->getFirstData();

        return view($this->view . 'index', ['data' => $data, 'search' => $search]);
    }

    /**
     * Remove the specified category from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
     public function delete($id)
     {
         // Find the category by ID
         $category = $this->repo->editRecord($id);

         // Check if the category exists
         if (!$category) {
            return redirect()->back()->with('error', 'Category not found');
         }

         // Check if the category has an image and delete it
         if ($category->image) {
             $imagePath = public_path('uploads/images/product/category/' . $category->image);
             if (file_exists($imagePath)) {
                 unlink($imagePath); // Delete the image file
             }
         }

         // Delete the category record
         $result = $this->repo->deleteRecord($id);

         if ($result) {
             return redirect()->back()->with('success', 'Category deleted successfully.');
         } else {
             return redirect()->back()->with('error', 'Something went wrong.');
         }
     }


}
