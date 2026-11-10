<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'package_id',
        'name',
        'phone',
        'address',
        'package_price',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'package_price' => 'decimal:2',
        ];
    }

    public function internetPackage(): BelongsTo
    {
        return $this->belongsTo(
            InternetPackage::class,
            'package_id'
        );
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
