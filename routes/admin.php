<?php

$app->route->add('/login','Admin/Login');
$app->route->add('/login/submit','Admin/Login@submit','POST')->name('loginSubmit');

$app->route->add('/logout','Admin/Login@logout');

// dashboard
$app->route->add('/admin','Admin/Dashboard');
$app->route->add('/admin/dashboard','Admin/Dashboard');

// admin => users
$app->route->add('/admin/users','Admin/User');
$app->route->add('/admin/users/add','Admin/User@add');
$app->route->add('/admin/users/submit','Admin/User@submit','POST');
$app->route->add('/admin/users/edit/:id','Admin/User@edit');
$app->route->add('/admin/users/save/:id','Admin/User@save','POST');
$app->route->add('/admin/users/delete/:id','Admin/User@delete');

// admin => posts
$app->route->add('/admin/posts','Admin/Post');
$app->route->add('/admin/posts/add','Admin/Post@add');
$app->route->add('/admin/posts/submit','Admin/Post@submit','POST');
$app->route->add('/admin/posts/edit/:id','Admin/Post@edit');
$app->route->add('/admin/posts/save/:id','Admin/Post@save','POST');
$app->route->add('/admin/posts/delete/:id','Admin/Post@delete');

// admin => categories
$app->route->add('/admin/categories','Admin/Category');
$app->route->add('/admin/categories/add','Admin/Category@add','POST');
$app->route->add('/admin/categories/submit','Admin/Category@submit','POST');
$app->route->add('/admin/categories/edit/:id','Admin/Category@edit');
$app->route->add('/admin/categories/save/:id','Admin/Category@save','POST');
$app->route->add('/admin/categories/delete/:id','Admin/Category@delete');


// admin => users-group
$app->route->add('/admin/users-groups','Admin/UserGroup');
$app->route->add('/admin/users-groups/add','Admin/UserGroup@add','POST');
$app->route->add('/admin/users-groups/submit','Admin/UserGroup@submit','POST');
$app->route->add('/admin/users-groups/edit/:id','Admin/UserGroup@edit','POST');
$app->route->add('/admin/users-groups/save/:id','Admin/UserGroup@save','POST');
$app->route->add('/admin/users-groups/delete/:id','Admin/UserGroup@delete','POST');

// admin => settings
$app->route->add('/admin/settings','Admin/Settings');
$app->route->add('/admin/settings/save','Admin/Settings@save','POST');

// admin => contacts
$app->route->add('/admin/contacts','Admin/Contacts');
$app->route->add('/admin/contacts/replay/:id','Admin/Contacts@replay');
$app->route->add('/admin/contacts/send /:id','Admin/Contacts@replay');

