<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    use HasFactory;
    protected $table = 'menus';
    protected $fillable = ['title', 'url', 'parent_id', 'position', 'type','status'];


    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('position', 'asc');
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }
}
