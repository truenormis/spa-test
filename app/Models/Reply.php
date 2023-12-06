<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reply extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function childReplies(): HasMany
    {
        return $this->hasMany(Reply::class, 'parent_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(File::class,'reply_id');
    }
}
