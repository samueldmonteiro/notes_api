<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'color'];
    protected $hidden = ['updated_at', 'user_id'];
    protected $appends = ['creator'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => (new DateTime($value))->format('Y-m-d H:i:s')
        );
    }

    protected function creator(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->user_id
        );
    }
}
