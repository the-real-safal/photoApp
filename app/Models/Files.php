<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'user_id', 'description',
    ];

    /**
     * Get the user that owns the file.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
