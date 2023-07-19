<?php

namespace App\Controllers\Main\Common;

use myframework\View\IView;

class LayoutController extends \myframework\Controller
{

    public function render(IView $view)
    {
        $parts['content'] = $view;
        $parts['header'] = $this->load->controller('Main/Common/Header')->index();
        $parts['sidebar'] = $this->load->controller('Main/Common/Sidebar')->index();
        $parts['footer'] = $this->load->controller('Main/Common/Footer')->index();

        return $this->view->createView('main/common/layout',$parts);
    }
}