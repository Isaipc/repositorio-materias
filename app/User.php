<?php

namespace App;

use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Direccion;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use Notifiable, HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password',
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

    public function alias()
    {
        return $this->username;
    }

    /**
     * Get all of the alumnoEnMateria for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alumnoEnMateria(): HasMany
    {
        return $this->hasMany(AlumnoEnMateria::class, 'usuario_id', 'id');
    }

    /**
     * The materias that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function materias(): BelongsToMany
    {
        return $this->belongsToMany(Materia::class, 'usuario_materias', 'usuario_id', 'materia_id');
    }
}
