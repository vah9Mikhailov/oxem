<?php

namespace App\Models;

use App\Dto\UpdateCategoryDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['name','parent_id','external_id'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }


}


