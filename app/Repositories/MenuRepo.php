<?php
namespace App\Repositories;

use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class MenuRepo
{


    public function getMenus()
    {
        $menus = DB::table('menus')
            ->whereNull('parent_id')
            ->orderBy('position')
            ->get();

        foreach ($menus as $menu) {
            $menu->children = DB::table('menus')
                ->where('parent_id', $menu->id)
                ->orderBy('position')
                ->get();
        }

        return $menus;
    }
}
