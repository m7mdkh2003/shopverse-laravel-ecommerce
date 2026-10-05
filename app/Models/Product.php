<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'price', 'compare_at_price',
        'stock', 'image', 'gallery', 'is_featured', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'compare_at_price' => 'decimal:2',
            'gallery' => 'array',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo { return $this->belongsTo(Category::class); }
    public function cartItems(): HasMany { return $this->hasMany(CartItem::class); }
    public function wishlistedBy(): BelongsToMany { return $this->belongsToMany(User::class)->withTimestamps(); }

    public function getRouteKeyName(): string { return 'slug'; }

    public function scopeVisible($query)
    {
        return $query->where('is_active', true)->where('stock', '>', 0);
    }
}
