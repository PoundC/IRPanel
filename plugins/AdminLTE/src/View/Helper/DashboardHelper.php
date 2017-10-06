<?php

namespace AdminLTE\View\Helper;

use Cake\View\Helper as Helper;
use Cake\View\View;

class DashboardHelper extends Helper
{
    public function FullWidget($count, $title, $link, $color, $icon)
    {
        return '<div class="col-lg-3 col-xs-6"><div class="small-box ' . $color . '"><div class="inner"><h3>' . number_format($count) . '</h3><p>' . $title . '</p></div><div class="icon"><i class="fa ' . $icon . '"></i></div><a href="' . $link . '" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div></div>';
    }
}