<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'member_code',
        'name',
        'phone',
        'email',
        'date_of_birth',
        'gender',
        'address',
        'profile_image_path',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    protected static function booted()
    {
        static::creating(function (Member $member) {
            if (empty($member->member_code)) {
                $prefix = 'SK';
                $ym = now()->format('Ym');
                $count = self::whereYear('created_at', now()->year)
                    ->whereMonth('created_at', now()->month)
                    ->count();
                $seq = $count + 1;
                $member->member_code = sprintf('%s%s%04d', $prefix, $ym, $seq);
            }
        });
    }
}
