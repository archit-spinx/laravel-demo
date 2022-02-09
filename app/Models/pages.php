<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    use HasFactory;


    protected $fillable = [
        'page_title',
        'pagecontent',
        'slug'
    ];

    public function setTitleAttribute($value): void
    {
        $this->attributes['slug'] = \Illuminate\Support\Str::slug($value);
        $this->attributes['title'] = $value;
    }

}
