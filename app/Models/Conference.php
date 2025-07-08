<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conference extends Model
{
    /** @use HasFactory<\Database\Factories\ConferenceFactory> */
    use HasFactory;
    protected $guarded = ['id'];

    /** @return BelongsTo<User, Conference>  */
    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
