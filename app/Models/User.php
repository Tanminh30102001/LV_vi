<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\CustomVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ten',
        'email',
        'mat_khau',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'mat_khau',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function totalTongTien()
    {
        return $this->orders()->sum('tong_tien');
    }

    public function totalOrders()
    {
        return $this->orders()->count();
    }

    public function totalCanceledOrders()
    {
        return $this->orders()->where('tinh_trang_giao_hang', 'canceled')->count();
    }
    public function scopeWithOrderStats($query)
    {
        return $query->withSum('orders', 'tong_tien')
                     ->withCount('orders')
                     ->withCount(['orders as total_canceled_orders' => function ($query) {
                         $query->where('tinh_trang_giao_hang', 'canceled');
                     }]);
    }
}
