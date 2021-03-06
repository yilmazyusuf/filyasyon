<?php

namespace Garavel\Base\Model;

use App\Models\Neighborhood;
use App\Models\Village;
use Garavel\Base\Eloquent\Mutators;
use Garavel\Base\Eloquent\Scopes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 *
 *
 * @category Base
 * @package  TMD Core
 * @author   yusuf.yilmaz
 * @since    : 22.01.2020
 *
 * @method static Scopes status(int $status)
 */
class GaravelUserModel extends Authenticatable
{

    use Notifiable;
    use SoftDeletes;
    use Scopes;
    use Mutators;
    use HasRoles;

    protected $table = "users";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'village_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $guard_name = 'web';

    /**
     * Scope a query to only include active users.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeActive($query)
    {
        return $query->whereStatus(1)->whereNull('deleted_at');
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }


    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class);
    }


}
