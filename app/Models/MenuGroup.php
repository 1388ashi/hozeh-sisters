<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'label',
        'name',
    ];
    protected $guarded = [
        'id', 
        'created_at', 
        'updated_at', 
    ];

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }
    
}
