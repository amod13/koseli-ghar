<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductImage;
use App\Repositories\BrandRepo;
use App\Repositories\CategoryRepo;
use App\Repositories\ProductRepo;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $view;
    protected $repo,$categoryRepo,$brandRepo;
    public function __construct(ProductRepo $repo,CategoryRepo $categoryRepo,BrandRepo $brandRepo)
    {
        $this->middleware('check.permission');
        $this->repo = $repo;
        $this->categoryRepo = $categoryRepo;
        $this->brandRepo = $brandRepo;
        $this->view = 'admin.page.product_management.product.';
    }

    /**
     * Display a listing of products.
     *
     * This method sets the header title and retrieves all products from the repository.
     * It then returns the view for displaying the product list.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data['header_title'] = 'Product List';
        $data['products'] = $this->repo->getAllProducts();
        $data['categories'] = $this->categoryRepo->getAll();
        // $data['products'] = collect([]);

        return view($this->view . 'index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['header_title'] = 'Add Product';
        $data['categories'] = $this->categoryRepo->getAll();
        $data['brands'] = $this->brandRepo->getAll();

        return view($this->view . 'create', ['data' => $data]);
    }

    /**
     * Store a newly created product in storage.
     *
     * This method validates the request data for creating a product and saves the record to the database.
     * If the request contains a thumbnail image, it is stored in the 'uploads/images/product/thumbnailImage' directory.
     * The method then redirects back to the previous page with a success or error message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:1,0',
            'is_featured' => 'nullable|boolean',
            'colors' => 'nullable|array',
            'sizes' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,avif,webp,webp,svg|max:2048',
            'brand_id' => 'nullable|exists:brands,id',
            'gender' => 'nullable|in:0,1,2',
            'gallery_image.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,avif,svg,webp|max:2048',
            'sku' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ]);

        // Collect only fillable data
        $data = $request->only($this->repo->getModel()->getFillable());

        // Handle thumbnail image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageFilename = time() . '_thumbnail.' . $image->getClientOriginalExtension();
            $imageDirectory = public_path('uploads/images/product/thumbnailImage');

            if (!file_exists($imageDirectory)) {
                mkdir($imageDirectory, 0777, true);
            }

            $image->move($imageDirectory, $imageFilename);
            $data['image'] = $imageFilename;
        }

        // Convert colors and sizes arrays to comma-separated strings
        if ($request->filled('colors')) {
            $data['colors'] = implode(',', $request->colors);
        }
        if ($request->filled('sizes')) {
            $data['sizes'] = implode(',', $request->sizes);
        }

        // Create product record
        $product = $this->repo->createRecord($data);

        // Check if product was successfully created
        if ($product) {
            // Handle gallery image uploads
            if ($request->hasFile('gallery_image')) {
                $uploadDirectory = public_path('uploads/images/product/gallery');
                if (!is_dir($uploadDirectory)) {
                    mkdir($uploadDirectory, 0755, true);
                }

                foreach ($request->file('gallery_image') as $image) {
                    $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move($uploadDirectory, $imageName);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'gallery_image' => $imageName,
                    ]);
                }
            }

            return redirect()->route('product.index')->with('success', 'Product Created Successfully');
        }

        return redirect()->back()->with('error', 'Something went wrong, please try again.');
    }


    /**
     * Edit a product
     *
     * This method retrieves a product by its ID and its associated category and brand.
     * It renders the product edit view with the data and returns the rendered HTML as a JSON response.
     *
     * @param int $id The ID of the product to edit.
     * @return \Illuminate\Http\JsonResponse JSON response containing the rendered HTML.
     */
    public function edit($id)
    {
        $data['header_title'] = 'Edit Product';
        $data['product'] = $this->repo->editRecord($id);
        $data['categories'] = $this->categoryRepo->getAll();
        $data['brands'] = $this->brandRepo->getAll();

        // Ensure sizes and colors are converted to arrays if they are comma-separated strings
        if (!empty($data['product'])) {
            $data['product']->sizes = !empty($data['product']->sizes) ? explode(',', $data['product']->sizes) : [];
            $data['product']->colors = !empty($data['product']->colors) ? explode(',', $data['product']->colors) : [];
        } else {
            $data['product'] = (object) ['sizes' => [], 'colors' => []]; // Fallback in case product is null
        }

        return view($this->view . 'edit', ['data' => $data]);
    }

    /**
     * Update a product
     *
     * This method validates the request and updates a product with the provided data.
     * It handles file upload for the image if a new image is provided, and deletes the old image if it exists.
     * It converts selected colors and sizes to comma-separated strings and stores them in the database.
     * It renders the product index view with a success message on successful update, or an error message if an error occurs.
     *
     * @param \Illuminate\Http\Request $request The request object with the product data.
     * @param int $id The ID of the product to update.
     * @return \Illuminate\Http\RedirectResponse The HTTP response object with a redirect.
     */
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:1,0',
            'is_featured' => 'nullable|boolean',
            'colors' => 'nullable|array',
            'sizes' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,avif,webp,webp,svg|max:2048',
            'brand_id' => 'nullable|exists:brands,id',
            'gender' => 'nullable|in:0,1,2',
            'sku' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ]);

        // Get the data from the request
        $data = $request->only([
            'name',
            'slug',
            'description',
            'price',
            'stock',
            'category_id',
            'status',
            'is_featured',
            'colors',
            'sizes',
            'brand_id',
            'gender',
            'sku',
            'meta_description',
        ]);

        // Retrieve the existing product
        $product = $this->repo->editRecord($id);

            // Handle file upload for the image if a new image is provided
        if ($request->hasFile('image')) {
            // Delete the old image if it exists and is a file
            $oldImagePath = public_path('uploads/images/product/thumbnailImage/' . $product->image);

            if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                unlink($oldImagePath); // Delete the old image file
            }

            // Handle the new image upload
            $image = $request->file('image');
            $imageExtension = $image->getClientOriginalExtension();
            $imageFilename = time() . '_product.' . $imageExtension;

            // Directory for storing images
            $imageDirectory = public_path('uploads/images/product/thumbnailImage/');
            if (!file_exists($imageDirectory)) {
                mkdir($imageDirectory, 0777, true);
            }

            // Move the image to the directory
            $image->move($imageDirectory, $imageFilename);

            // Save the new image path in the data array
            $data['image'] = $imageFilename;
        }


        // Handle selected colors and sizes
        if ($request->has('colors') && is_array($request->input('colors'))) {
            $data['colors'] = implode(',', $request->input('colors')); // Store as comma-separated
        }

        if ($request->has('sizes') && is_array($request->input('sizes'))) {
            $data['sizes'] = implode(',', $request->input('sizes')); // Store as comma-separated
        }

        // Update the product record
        $result = $this->repo->updateRecord($id, $data);

        // Redirect based on result
        if ($result) {
            return redirect()->route('product.index')->with('success', 'Product Updated Successfully');
        } else {
            return redirect()->route('product.index')->with('error', 'Something went wrong');
        }
    }


    /**
     * Display the specified product.
     *
     * This method retrieves a product by its ID and renders the product details view.
     * It returns the rendered HTML as a response.
     *
     * @param int $id The ID of the product to display.
     * @return \Illuminate\View\View The view containing the product details.
     */
    public function show($id)
    {
        $data['header_title'] = 'Product Details';
        // Fetch the product by ID
        $data['product'] = $this->repo->getProductDetailById($id);

        // Render the view and return the HTML
        return view($this->view . 'show', ['data' => $data]);
    }


    /**
     * Remove the specified product from storage.
     *
     * This method retrieves a product by its ID, checks if it has an image and deletes it,
     * and then deletes the product record.
     * It redirects to the product list page with a success message.
     *
     * @param int $id The ID of the product to delete.
     * @return \Illuminate\Http\RedirectResponse Redirect to product list page with success message.
     */
    public function delete($id)
    {
        // Fetch the product record
        $product = $this->repo->editRecord($id);

        // Check if the product has an image and delete it
        if ($product && $product->image) {
            // Define the path where the image is stored
            $imagePath = public_path('uploads/images/product/thumbnailImage/' . $product->image);

            // Check if the file exists and delete it
            if (file_exists($imagePath)) {
                unlink($imagePath); // Delete the file
            }
        }

        // Delete the product record
        $this->repo->deleteRecord($id);

        // Redirect with success message
        return redirect()->route('product.index')->with('success', 'Product deleted successfully');
    }

    /**
      * Get the view for uploading images for a product.
      *
      * @param int $id The ID of the product for which images are to be uploaded.
      * @return \Illuminate\View\View The view for uploading images.
      */
      public function getImageView($id)
      {
         // Fetch the record to get image details
         $data['productId'] = $id;

         $data['productName'] = $this->repo->editRecord($id)->name;

         $data['header_title'] = 'Product Image';
         $data['images'] = ProductImage::where('product_id', $id)->get();



         return view($this->view . 'add-image', ['data' => $data]);

      }
      /**
       * Return the partial row for adding a new file input field.
       *
       * @return \Illuminate\Http\JsonResponse JSON response with the rendered
       * partial view.
       */
      public function getFilePartialRow()
      {
         $data['header_title'] = 'partial file';
         $file = view('admin.page.product_management.product.partial-image', ['data' => $data])->render();

         // Return the view as a JSON response
         return response()->json(['html' => $file]);
      }

      /**
       * Store images for a product.
       *
       * @param \Illuminate\Http\Request $request The request containing the images
       * to be uploaded.
       * @return \Illuminate\Http\RedirectResponse Redirects back with a success
       * message.
       *
       * Validates the request to ensure the product ID exists in the products table
       * and the images are valid files with the allowed MIME types and within the
       * allowed size limits.
       *
       * Adds new images to the product files table and updates existing images.
       */
     public function storeFile(Request $request)
     {
         // Validation
         $request->validate([
             'product_id' => 'required|exists:products,id',
             'gallery_image.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,avif,svg,webp|max:2048',
             'update_images.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,avif,svg,webp|max:2048',
         ]);

         // Ensure the upload directory exists
         $uploadDirectory = public_path('uploads/images/product/gallery/');
         if (!is_dir($uploadDirectory)) {
             mkdir($uploadDirectory, 0755, true);  // Create directory if not exists
         }

         // Add new images
         if ($request->hasFile('gallery_image')) {
             foreach ($request->file('gallery_image') as $image) {
                 $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                 $image->move($uploadDirectory, $imageName);

                 ProductImage::create([
                     'product_id' => $request->product_id,
                     'gallery_image' => $imageName,
                 ]);
             }
         }

         // Update existing images
         if ($request->hasFile('update_images')) {
             foreach ($request->file('update_images') as $id => $image) {
                 $productFile = ProductImage::find($id);
                 if ($productFile) {
                     // Delete old image
                     $oldImagePath = $uploadDirectory . '/' . $productFile->gallery_image;
                     if (file_exists($oldImagePath)) {
                         unlink($oldImagePath); // Delete old image from storage
                     }

                     // Save new image
                     $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                     $image->move($uploadDirectory, $imageName);

                     $productFile->update(['gallery_image' => $imageName]);
                 } else {
                     // Handle the case when product file is not found (optional)
                     return back()->with('error', 'Image with ID ' . $id . ' not found.');
                 }
             }
         }

         return redirect()->back()->with('success', 'Images updated successfully!');
     }

     /**
      * Delete a specific image file associated with a product.
      *
      * @param \Illuminate\Http\Request $request The request containing the ID of the image to be deleted.
      * @return \Illuminate\Http\JsonResponse A JSON response indicating success or failure of the deletion process.
      *
      * This method finds the image file by ID, deletes the file from storage if it exists,
      * and removes the corresponding record from the database.
      */

      public function deleteFile(Request $request)
     {
         $productFile = ProductImage::find($request->id);


         if ($productFile) {
             $imagePath = public_path('uploads/images/product/gallery/' . $productFile->gallery_image);

             if (file_exists($imagePath)) {
                 unlink($imagePath); // Delete the file from storage
             }

             $productFile->delete(); // Remove from database

             return response()->json(['success' => true, 'message' => 'Image deleted successfully!']);
         }

         return response()->json(['success' => false, 'message' => 'Image not found!']);
     }


    /**
     * Retrieves a collection of products based on the given search criteria
    *
    * This method accepts an associative array of search criteria and applies
    * filters to the query based on the provided values. The search criteria
    * can include the following keys:
    *
    * - `category_id`: The ID of the category to filter by
    * - `brand_id`: The ID of the brand to filter by
    * - `keyword`: A keyword to search for in the product name, brand name,
    *              and category name
    *
    * The method returns a view with the filtered products, categories, and the
    * selected search criteria for form repopulation.
    *
    * @param \Illuminate\Http\Request $request The request containing the search criteria
    * @return \Illuminate\View\View The view with the filtered products and categories
    */
    public function getProductSearch(Request $request)
    {
         // Fetch search criteria from the request
         $searchCriteria = [
            'category_id' => $request->input('category_id'),
            'brand_id' => $request->input('brand_id'),
            'keyword' => $request->input('keyword'),
            'status' => $request->input('status'),
            'is_featured' => $request->input('is_featured'),
        ];


        // Get filtered businesses based on the search criteria
        $data['products'] = $this->repo->getAllProductsBySearchCriteria($searchCriteria);

        $data['categories'] = $this->categoryRepo->getAll();


        // Pass the selected search criteria back to the view for form repopulation
        $data['selected_category_id'] = $request->input('category_id');
        $data['selected_brand_id'] = $request->input('brand_id');
        $data['selected_keyword'] = $request->input('keyword');
        $data['selected_status'] = $request->input('status');
        $data['selected_is_featured'] = $request->input('is_featured');

        return view($this->view . '.index', ['data' => $data]);
    }

    /**
     * Retrieve brands based on the category ID.
     *
     * This method fetches all brands associated with the given category ID
     * and returns the result as a JSON response.
     *
     * @param int $category_id The ID of the category to filter brands by.
     * @return \Illuminate\Http\JsonResponse JSON response containing the brands.
     */
     public function getCategoryBaseBrand($category_id)
     {
         $brands = Brand::whereRaw("FIND_IN_SET(?, category_id)", [$category_id])->get();

         // Convert comma-separated category_id string to array for each brand
         foreach ($brands as $brand) {
             $brand->category_id = !empty($brand->category_id) ? explode(',', $brand->category_id) : [];
         }

         return response()->json($brands);
     }

}
