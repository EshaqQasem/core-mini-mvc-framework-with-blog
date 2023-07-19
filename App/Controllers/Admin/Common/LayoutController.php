<?php

namespace App\Controllers\Admin\Common;

use myframework\View\IView;

class LayoutController extends \myframework\Controller
{

    public function render(IView $view)
    {
        $parts['content'] = $view;
        $parts['header'] = $this->load->controller('Admin/Common/Header')->index();
        $parts['sidebar'] = $this->load->controller('Admin/Common/Sidebar')->index();
        $parts['footer'] = $this->load->controller('Admin/Common/footer')->index();

        return $this->view->createView('admin/common/layout',$parts);
    }
}