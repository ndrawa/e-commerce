<?php

namespace App\Helpers;

class StatusHelper
{
    public static function instance()
    {
        return new StatusHelper();
    }

    public function statusFormatter($status_value)
    {
        $status_lower = strtolower($status_value);
        $status = ucwords($status_value);
        switch ($status_lower) {
            case 'pending':
                return '<span class="badge rounded-pill bg-warning">' . $status . '</span>';
            case 'waiting':
                return '<span class="badge rounded-pill bg-success"> Registration Verified </span>';
                // return '<a class="btn d-block btn-success"> Pendaftaran Disetujui </a>';
            case 'ongoing':
                return '<span class="badge rounded-pill bg-primary">' . $status . '</span>';
            case 'scoring':
                return '<span class="badge rounded-pill bg-primary">' . $status . '</span>';
            case 'finished':
                return '<span class="badge rounded-pill bg-success">' . $status . '</span>';
            default:
                return 0;
        }
    }
}
