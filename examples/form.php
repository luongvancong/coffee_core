<?php
   require_once('../app/classes/error.php');
   require_once('../app/classes/str.php');
   require_once('../app/classes/Validator.php');
   require_once('../app/classes/input.php');
   require_once('../app/classes/Statement.php');

   $action = Input::get("action");
   if ($action == "action") {
      // print_r(Input::all());
      // echo Input::get('fullname');
      // print_r(Input::except('action', 're-password'));
      // print_r(Input::only('username', 'email'));
      Input::cleanXSS(true);
      Input::escapeString(true);
      // var_dump(Input::has('fname'));

      $form_data = Input::except('action', 're-password');
      $signup = new Statement;
      foreach ($form_data as $key => $value) {
         $signup->$key = $value;
      }
      $signup->setTable('users');
      echo $signup->getInsertSql();
   }
?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
   <title></title>
   <meta name="description" content="AlvinTran" />
   <meta name="keyword" content="AlvinTran"/>
   <meta name="viewport" content="width=device-width" />
</head>
<body>
   <form action="" method="post">
      <input type="text" name="username" placeholder="User name">
      <br>
      <input type="text" name="email" placeholder="Email">
      <br>
      <input type="password" name="password" placeholder="Password">
      <br>
      <input type="password" name="re-password" placeholder="Re-Password">
      <br>
      <select name="gender" id="gender">
         <option value="0">Male</option>
         <option value="0">Female</option>
      </select>
      <br>
      <input type="submit" value="submit">
      <input type="hidden" name="action" value="action">
   </form>
</body>
</html>