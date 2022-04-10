<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Common extends Model
{

    public function alias()
    {
        return $this->nombre;
    }

    public function isArchived()
    {
        return $this->estatus == 0;
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format(config('constants.timestamps_format'));
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format(config('constants.timestamps_format'));
    }

    public function getEstatusName()
    {
        switch ($this->estatus) {
            case 0:
                $r = 'Eliminado';
                break;
            case 1:
                $r = 'Habilitado';
                break;
            case 2:
                $r = 'Deshabilitado';
                break;
            default:
                $r = 'Sin estado';
                break;
        }
        return $r;
    }

    public static function actives()
    {
        $rows = self::where('estatus', '!=', 0)->orderBy('updated_at');
        return $rows;
    }

    public static function archived()
    {
        $rows = self::where('estatus', 0)->orderBy('updated_at');
        return $rows;
    }
}
