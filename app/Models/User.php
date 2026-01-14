<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes, HasUuids;


    public const ADMIN = "admin";
    public const USER = "user";

    /**
    * The attributes that are mass assignable.
    *
    * @var list<string>
    */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'role',
        'last_updated_by'
    ];


    /**
    * The attributes that should be hidden for serialization.
    *
    * @var list<string>
    */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static function getRoles(): array
    {
        return [
            self::ADMIN,
            self::USER
        ];
    }

    /** 
    * Get the attributes that should be cast.
    *
    * @return array<string, string>
    */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted()
    {
        self::deleted(function (User $user) {
            try {
                if($user['image']) {
                    $image_name = explode('image/', $user['image']);
                    Storage::disk('public')->delete('image/'.$image_name[1]);
                }
            } catch (Throwable) {
            }
        });

        static::updating(function (User $user) {
            $user->last_updated_by = auth()->id();
        });

        static::creating(function (User $user) {
            if (! $user->id) {
                $user->id = (string) Str::uuid();
            }
        });

    }


    public function regenerateTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = rand(100000, 999999);
        $this->two_factor_expires_at = now()->addMinutes(10);
        $this->save();
    }

    public function updatedExamples()
    {
        return $this->hasMany(ExampleCRUD::class, 'last_updated_by', 'id');
    }
}
