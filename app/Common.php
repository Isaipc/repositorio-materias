<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

trait Common 
{
    public function isArchived()
    {
        return $this->estatus == 0;
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
        $rows = self::where('estatus', '!=', 0)->orderBy('nombre', 'ASC');
        return $rows;
    }

    public static function archived()
    {
        $rows = self::where('estatus', 0)->orderBy('nombre', 'ASC');
        return $rows;
    }
}
