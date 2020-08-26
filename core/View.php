<?php
namespace core;

class View
{

    public function generate($content_view, $template_view, $data = null) {

        if(is_array($data)) {
            extract($data,EXTR_OVERWRITE);
        }
        include 'views/' .$template_view;
    }
}