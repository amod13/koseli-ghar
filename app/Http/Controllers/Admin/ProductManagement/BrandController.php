<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\brand\create;
use App\Repositories\BrandRepo;
use App\Repositories\CategoryRepo;
use App\Repositories\SettingRepo;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    private $view;

    protected $repo,$categoryRepo,$settingRepo;
    public function __construct(BrandRepo $repo,CategoryRepo $categoryRepo,SettingRepo $settingRepo)
    {
        $this->middleware('check.permission');
        $this->repo = $repo;
        $this->categoryRepo = $categoryRepo;
        $this->settingRepo = $settingRepo;
        $this->view = 'admin.page.product_management.brand.';
    }

    /**
     * Display a listing of brands.
     *
     * This method sets the header title and retrieves all brands from the repository.
     * It then returns the view for displaying the brand list.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data['header_title'] = 'Brand List';
        $data['brands'] = $this->repo->getAllBrands();

        $data['categories'] = $this->categoryRepo->getAll();
        $data['setting'] = $this->settingRepo->getFirstData();

        return view($this->view . 'index', ['data' => $data]);
    }

    /**
     * Store a newly created brand in storage.
     *
     * This method validates the request data for creating a brand and saves the record to the database.
     * If the request contains a logo image, it is stored in the 'uploads/images/product/brand' directory.
     * The method then redirects back to the previous page with a success or error message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(create $request)
    {
          // Validate the request
          $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:brands,slug',
            'category_id' => 'required|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,avif,webp,webp,svg|max:2048',
            'status' => 'required|in:1,0',
        ]);

        $data = $request->only($this->repo->getModel()->getFillable());

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageExtension = $image->getClientOriginalExtension();
            $imageFilename = time() . '_brand.' . $imageExtension;

            // Directory for storing logo images
            $imageDirectory = public_path('uploads/images/product/brand');
            if (!file_exists($imageDirectory)) {
                mkdir($imageDirectory, 0777, true);
            }

            // Move the image to the directory
            $image->move($imageDirectory, $imageFilename);

            // Save the image path in the data array
            $data['image'] = $imageFilename;
        }

         // Convert Category ID arrays to comma-separated strings
         if ($request->filled('category_id')) {
            $data['category_id'] = implode(',', $request->category_id);
        }

        $result = $this->repo->createRecord($data);
        if ($result) {
            return redirect()->back()->with('success', 'Brand created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create brand.');
        }
    }

    /**
     * Edit a brand
     *
     * This method retrieves a brand by its ID and its associated category.
     * It renders the brand edit view with the data and returns the rendered HTML as a JSON response.
     *
     * @param int $id The ID of the brand to edit.
     * @return \Illuminate\Http\JsonResponse JSON response containing the rendered HTML.
     */
    public function edit($id)
    {
        $data['header_title'] = 'Edit Brand';
        $data['brand'] = $this->repo->editRecord($id);

        // Ensure Category ID are converted to arrays if they are comma-separated strings
        if (!empty($data['brand'])) {
            $data['brand']->category_id = !empty($data['brand']->category_id) ? explode(',', $data['brand']->category_id) : [];
        } else {
            $data['brand'] = (object) ['category_id' => []]; // Fallback in case product is null
        }

        $data['categories'] = $this->categoryRepo->getAll();

        if (!$data['brand']) {
            return response()->json(['error' => 'Brand not found'], 404);
        }

        $BrandEdit = view($this->view . 'edit', ['data' => $data])->render();

        return response()->json(['html' => $BrandEdit]);
    }

    /**
     * Update the specified brand in storage.
     *
     * This method handles the update of a brand's details in the database. It first
     * retrieves the fillable attributes from the request. If an image file is provided in
     * the request, it processes and stores the image in the designated directory, updating
     * the image path in the data array. The brand's record is then updated via the repository.
     * On successful update, it redirects to the brand index page with a success message.
     * Otherwise, it redirects back with an error message.
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request object containing brand data.
     * @param  int  $id  The ID of the brand to update.
     * @return \Illuminate\Http\Response The HTTP response object with a redirect.
     */
    public function update(create $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,avif,webp,webp,svg|max:2048',
            'status' => 'required|in:1,0',
        ]);

        $data = $request->only($this->repo->getModel()->getFillable());

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageExtension = $image->getClientOriginalExtension();
            $imageFilename = time() . '_brand.' . $imageExtension;

            // Directory for storing logo images
            $imageDirectory = public_path('uploads/images/product/brand');
            if (!file_exists($imageDirectory)) {
                mkdir($imageDirectory, 0777, true);
            }

            // Move the image to the directory
            $image->move($imageDirectory, $imageFilename);

            // Save the image path in the data array
            $data['image'] = $imageFilename;
        }

         // Handle selected Category ID and sizes
         if ($request->filled('category_id')) {
            $data['category_id'] = implode(',', $request->category_id);
        }

        $result = $this->repo->updateRecord($id, $data);
        if ($result) {
            return redirect()->route('brand.index')->with('success', 'brand Updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Handle search for brands by name.
     *
     * This method retrieves the search query from the request, fetches brands
     * matching the search query using the repository, and renders the brand
     * index view with the search results.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object.
     * @return \Illuminate\Http\Response The HTTP response with the rendered view.
     */
    public function brandSearchByName(Request $request)
    {
        $name = $request->get('search');
        $categoryId = $request->get('category');

        // Use the repository to fetch categories matching the search query
        $data['brands'] = $this->repo->searchByBrandName($name, $categoryId);
        $data['categories'] = $this->categoryRepo->getAll();
        $data['setting'] = $this->settingRepo->getFirstData();

        return view($this->view . 'index', ['data' => $data, 'search' => $name]);
    }

    /**
     * Delete a brand
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
     {
         // Find the Brand by ID
         $brand = $this->repo->editRecord($id);

         // Check if the Brand exists
         if (!$brand) {
            return redirect()->back()->with('error', 'Brand not found');
         }

         // Check if the Brand has an image and delete it
         if ($brand->image) {
             $imagePath = public_path('uploads/images/product/brand/' . $brand->image);
             if (file_exists($imagePath)) {
                 unlink($imagePath); // Delete the image file
             }
         }

         // Delete the Brand record
         $result = $this->repo->deleteRecord($id);

         if ($result) {
             return redirect()->back()->with('success', 'Brand deleted successfully.');
         } else {
             return redirect()->back()->with('error', 'Something went wrong.');
         }
     }
}
