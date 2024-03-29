<?php

namespace App;

use Carbon\Carbon;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasRoles, Common;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'username', 'email', 'password',
    ];

    protected $with = ['materias', 'roles'];

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

    /**
     * Get all of the alumnoEnMateria for the Materia
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alumnoEnMateria(): HasMany
    {
        return $this->hasMany(AlumnoEnMateria::class, 'usuario_id', 'id');
    }

    /**
     * The alumnos that belong to the Materia
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function materias(): BelongsToMany
    {
        return $this->belongsToMany(Materia::class, 'usuario_materias', 'usuario_id', 'materia_id')->withTimestamps();
    }

    public static function actives()
    {
        return self::whereHas('roles', function (Builder $query) {
            $query->where('name', 'Alumno');
        })->where('estatus', '!=', config('constants.status_archived'));
    }

    public static function archived()
    {
        return self::whereHas('roles', function (Builder $query) {
            $query->where('name', 'Alumno');
        })->where('estatus', config('constants.status_archived'));
    }
}
