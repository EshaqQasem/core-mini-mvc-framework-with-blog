<?php


namespace App\Controllers\Admin;

class UserGroupController extends \myframework\Controller
{

    public function index()
    {
        $this->html->setTitle('User Groups');
        $groups = $this->model('Admin/UserGroup')->getAll();
        $view = $this->view->createView('admin/user-group/list', ['groups' => $groups]);
        return $this->adminLayout->render($view);
    }

    public function add($params = [])
    {
        $data['target'] = 'add-users-group-form';

        $data['action'] = url('/admin/users-groups/submit');

        $data['heading'] = 'Add New User Group';


        $data['name'] = null;
        //$data['status'] = 'enabled';

        $data['pages']=$this->route->getAdminPages();
        $data['users_group_pages'] = [];
        return $this->view->createView('admin/user-group/form', $data);
    }


    public function submit()
    {
        $json = [];
        $this->validator->required('name')->select('pages');
        if ($this->validator->validate()) {
            $name = $this->request->post('name');
             $pages = $this->request->post('pages');
            if($this->model('Admin/UserGroup')->add($name,$pages)) {
                $json['success'] = 'User Group Has Been Created Successfully';
                $json['redirectTo'] = url('/admin/users-groups');
            }
            else{
                $json['errors'] = 'Sorry! Adding User Group  Has Been Fialed';
            }
        } else {
            // it means there are errors in form validation
            $json['errors'] = implode('<br>', $this->validator->getErrors());
        }
        return json_encode($json);
    }

    public function edit($id)
    {
        $model = $this->model('Admin/UserGroup');
        $group = $model->getById($id[0]);
        if (!$group) {
            $this->url->redirectTo('/404');
        }
        $data['target'] = 'edit-users-group-' . $group->id;

        $data['action'] = url('/admin/users-groups/save/' . $group->id);

        $data['heading'] = 'Edit ' . $group->name;

        $data['name'] = $group->name;

        $data['pages']=$this->route->getAdminPages();
        $data['users_group_pages'] = $group->pages;
        return $this->view->createView('admin/user-group/form', $data);

    }

    public function save($id)
    {
        $json = [];
        $this->validator->required('name')->select('pages');
        if ($this->validator->validate()) {
            $name = $this->request->post('name');
            $pages = $this->request->post('pages');

            if ($this->model('Admin/UserGroup')->update($id[0], $name, $pages)) {
                $json['success'] = 'User Group Has Been Created Successfully';
                $json['redirectTo'] = url('/admin/users-groups');
            } else {
                $json['errors'] = 'Sorry! Adding User Group  Has Been Fialed';
            }
        } else {
            // it means there are errors in form validation
            $json['errors'] = implode('<br>', $this->validator->getErrors());
        }
        return json_encode($json);
    }

    public function delete($id)
    {
        $json = [];
        $model = $this->model('Admin/Category');
        $category = $model->getById($id[0]);
        if (!$category) {
            //$this->url->redirectTo('/404');
            $json['fail'] = 'Roung';
        }

        if ($model->delete($id[0])) {
            $json['success'] = 'Category Has Been Deleted Successfully';
        }
        return json_encode($json);
    }

    private function form($category = null)
    {
        if ($category) {
            // editing form
            $data['target'] = 'edit-category-' . $category->id;

            $data['action'] = $this->url->link('/admin/categories/save/' . $category->id);

            $data['heading'] = 'Edit ' . $category->name;
        } else {
            // adding form
            $data['target'] = 'add-category-form';

            $data['action'] = $this->url->fullLink('/admin/categories/submit');

            $data['heading'] = 'Add New Category';
        }

        $data['name'] = $category ? $category->name : null;
        $data['status'] = /*$category ? $category->status :*/
            'enabled';

        return $this->view->createView('admin/categories/form', $data);
    }
}