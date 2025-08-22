<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExampleCRUD extends Model
{
    /** @use HasFactory<\Database\Factories\ExampleCRUDFactory> */
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = "example_CRUDS";

    protected $fillable = [
        "name",
        "age",
        "email",
        "last_updated_by"
    ];

    protected function casts(): array
    {
        return [
            'age' => 'integer',
        ];
    }

    protected static function booted() {
        static::updating(function (ExampleCRUD $exampleCRUD) {
            $exampleCRUD->last_updated_by = auth()->id();
        });
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'last_updated_by', 'id');
    }
    
}
