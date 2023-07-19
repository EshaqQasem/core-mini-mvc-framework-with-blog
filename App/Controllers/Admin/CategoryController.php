<?php

namespace App\Controllers\Admin;

class CategoryController extends \myframework\Controller
{

    public function index()
    {
        $this->html->setTitle('Categories');
        $cats = $this->model('Admin/Category')->getAll();
        $view = $this->view->createView('admin/categories/list',['cats'=>$cats]);
        return $this->adminLayout->render($view);
    }

    public function add($params=[])
    {
        $data['target'] = 'add-category-form';

        $data['action'] = url('/admin/categories/submit');

        $data['heading'] = 'Add New Category';



       $data['name'] = null;
       $data['status'] = 'enabled';
       $data['categoryParent']=null;
        $cats = $this->model('Admin\\Category')->getAll();
        $data['cats'] = $cats;
        return $this->view->createView('admin/categories/form', $data);
    }

    public function submit(){

        $json = [];
        if($this->validator->required('name')->validate())
        {
            $name = $this->request->post('name');
            $status = $this->request->post('status');
            $parentCat = $this->request->post('categoryParent');
            $this->model('Admin/Category')->add($name,$parentCat,$status);
            $json['success'] = 'Category Has Been Created Successfully';

            $json['redirectTo'] = url('/admin/categories');
        } else {
            // it means there are errors in form validation
            $json['errors'] = implode('<br>',$this->validator->getErrors());
        }
        return json_encode($json);
    }

    public function edit($id){
        $model = $this->model('Admin/Category');
        $category = $model->getById($id[0]);
        if(!$category){
           $this->url->redirectTo('/404');
        }
        $data['target'] = 'edit-category-' . $category->id;

        $data['action'] = url('/admin/categories/save/' . $category->id);

        $data['heading'] = 'Edit ' . $category->name;
        $data['name'] =  $category->name ;
        $data['status'] =  'disabled';
        $data['cats'] = $model->getAll();
        $data['categoryParent'] = $category->parent_id;
        return $this->view->createView('admin/categories/form', $data);

    }

    public function save($id){
        $json = [];
        if($this->validator->required('name')->validate())
        {
            $name = $this->request->post('name');
            $status = $this->request->post('status');
            $parentCat = $this->request->post('categoryParent');
            if($this->model('Admin/Category')->update($id[0],$name,$parentCat,$status)) {
                $json['success'] = 'Category Has Been Updated Successfully';

                $json['redirectTo'] = url('/admin/categories');
            }else{
                $json['errors'] = 'get problem with update';
            }
        } else {
            // it means there are errors in form validation
            $json['errors'] = implode('<br>',$this->validator->getErrors());
        }
        return json_encode($json);
    }

    public function delete($id){
        $json=[];
        $model = $this->model('Admin/Category');
        $category = $model->getById($id[0]);
        if(!$category){
            //$this->url->redirectTo('/404');
            $json['fail'] = 'Roung';
        }

        if($model->delete($id[0])){
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
        $data['status'] = /*$category ? $category->status :*/ 'enabled';

        return $this->view->createView('admin/categories/form', $data);
    }
}