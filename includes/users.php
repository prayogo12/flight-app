<?php
Flight::route( 'POST /users/add', function(){
	$db = Flight::db();

	$username = $_POST['username'];
	$password = $_POST['password'];

	 $data = array(
	 	'username' => $username,
	 	'password' => md5($password)
	 );

	 $id = $db->insert('users', $data);
	 if ($id)
	 	    Flight::redirect ( get_url('users'));
	    

	 else
	     echo 'insert failed: ' . $db->getLastError();
});
Flight::route('GET /users/add', function(){
	Flight::view()->set('title', 'Add_User');
	Flight::render('add_user');
});

Flight::route( 'GET /users/edit/@name', function($name){
	//$db = Flight::db();
echo $name;
	// $data = array(
	// 	'username' => 'somenone',
	// 	'password' => md5('password')
	// );

	// $id = $db->insert('users', $data);
	// if ($id)
	//     echo 'user was created. Id=' . $id;
	// else
	//     echo 'insert failed: ' . $db->getLastError();
});

Flight::route( 'GET /users(/page/@page:[0-9]+)', function($page){
	Flight::view()->set('title', 'Users');

	if ( empty($page) ){
		$page = 1;
	}

	$db = Flight::db();
	$db->pageLimit = 10; // set limit per page

	$users = $db->arraybuilder()->paginate('users', $page);
    Flight::render( 'users', array(
    	'users' => $users,
    	'page' => $page,
    	'total_pages' => $db->totalPages
    ) );
});