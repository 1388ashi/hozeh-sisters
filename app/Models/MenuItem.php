<?php

namespace App\Models;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model implements Sortable
{
    use SortableTrait;

        protected $fillable = [
            'link',
            'title',
            'linkable_id',
            'linkable_type',
            'order',
            'new_tab',
            'status',
        ];
        protected $guarded = [
            'id', 
            'created_at', 
            'updated_at', 
        ];
        
        public $sortable = [
            'order_column_name' => 'order',
            'sort_when_creating' => true,
        ];
        const MODELS = [
            Category::class => 'دسته بندی'
        ];
        public static function AllCategories(){
            return Category::select(['id','name'])->get();
        }
    public function menuGroup()
    {
        return $this->belongsTo(MenuGroup::class);
    }
}