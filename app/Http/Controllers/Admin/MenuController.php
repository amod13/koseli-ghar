<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission');
    }

    /**
     * Show the menu tree
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::whereNull('parent_id')
                    ->with('children')
                    ->orderBy('position')
                    ->get();

        return view('admin.page.menu.index', compact('menus'));
    }

    /**
     * Create a new menu item
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $menus = Menu::whereNull('parent_id')->get();
        $menus = Menu::all();
        return view('admin.page.menu.create', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'nullable|url',
            'parent_id' => 'nullable|exists:menus,id',
            'position' => 'nullable|integer',
            'status' => 'integer',
        ]);

        Menu::create($request->only(['title', 'url', 'parent_id', 'position', 'status']));

        return redirect()->route('menu.index')->with('success', 'Menu item created successfully');
    }

    /**
     * Edit a menu item
     *
     * @param Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        // Fetch top-level menus (parent menus)
        // $data['parent'] = Menu::whereNull('parent_id')->get();
        $data['parent'] = Menu::all();

        // Pass the specific menu being edited
        $data['menu'] = $menu;


        // Return the edit view with the necessary data
        return view('admin.page.menu.edit', ['data' => $data]);
    }

    /**
     * Update the specified menu item in storage.
     *
     * This method validates the incoming request data and updates the given menu
     * item with the provided attributes such as title, URL, parent menu, position, and status.
     * Upon successful update, it redirects to the menu index page with a success message.
     *
     * @param \Illuminate\Http\Request $request The request object containing the menu data.
     * @param \App\Models\Menu $menu The menu model instance to be updated.
     * @return \Illuminate\Http\RedirectResponse The response object with a redirect to the menu index.
     */

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'nullable|url',
            'parent_id' => 'nullable|exists:menus,id',
            'position' => 'nullable|integer',
            'status' => 'integer',
        ]);

        $menu->update($request->only(['title', 'url', 'parent_id', 'position', 'status']));

        return redirect()->route('menu.index')->with('success', 'Menu item updated successfully');
    }

    /**
     * Delete the specified menu item from storage.
     *
     * This method deletes the given menu item and its children from the database.
     * Upon successful deletion, it redirects to the menu index page with a success message.
     *
     * @param \App\Models\Menu $menu The menu model instance to be deleted.
     * @return \Illuminate\Http\RedirectResponse The response object with a redirect to the menu index.
     */
    public function destroy(Menu $menu)
    {
        // Delete the menu item and its children
        $menu->delete();

        return redirect()->route('menu.index')->with('success', 'Menu item deleted successfully');
    }


    /**
     * Update the order of menus.
     *
     * This method expects an array of menu objects with the keys 'id' and 'order'. The 'id' key
     * is the ID of the Menu record to update, and the 'order' key is the new order value
     * for that record. The method loops through the array and updates the order for each
     * Menu record in the database. The method returns a JSON response with a single key
     * 'success' set to true.
     *
     * @param  \Illuminate\Http\Request  $request The request object containing the menu order.
     * @return \Illuminate\Http\JsonResponse The response object with a JSON response.
     */
    public function updateOrder(Request $request)
    {
        $order = $request->input('order');
        $this->saveMenuOrder($order, null); // Start from root (parent_id = null)
        return response()->json(['success' => true]);
    }

    /**
     * Recursively updates the order and parent-child relationships of menu items.
     *
     * This method iterates over an array of menu data and updates the position and
     * parent_id of each menu item in the database. It also recursively processes
     * any child menus, ensuring that the entire menu hierarchy is correctly updated
     * with the provided order and parent-child structure.
     *
     * @param array $menus An array of menu data, where each element is an associative array
     *                     with keys 'id', 'position', and optionally 'children'.
     * @param int|null $parentId The ID of the parent menu item. This is used to update the
     *                           parent_id of each menu item. For top-level menus, this should be null.
     */
    private function saveMenuOrder($menus, $parentId)
    {
        foreach ($menus as $index => $menu) {
            $menuItem = Menu::find($menu['id']);
            $menuItem->parent_id = $parentId;
            $menuItem->position = $index + 1;
            $menuItem->save();

            // Recursive call for children
            if (!empty($menu['children'])) {
                $this->saveMenuOrder($menu['children'], $menuItem->id);
            }
        }
    }



}
