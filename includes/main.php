<?php

/**
 * WHITELIST
 *
 * Returns true if this white list verifies its predefined variables against a
 * $_POST variables’ form values, or, false otherwise.
 *
 * @access public
 * @return Boolean representing the valid or invalid nature of this white list
 */
function whiteList()
{
   /* $validated maintains the state of this function. It’s set to true if the
      conditions validating the following white list are true. */
   $validated = false;

   /* $white_list represents the names of items that must be matched by HTML
      form name values. Note: If you’re using an image as a submit button
      (<input type="image">, then you must remember to add “x” and “y” to
      the following array. */
   $white_list = array( "username", "password", "submitted" );

   /* $amount_of_form_input_names_found_in_white_list keeps a count of items in the
      white list array (defined above) that are also found in the $_POST
      array. */
   $amount_of_form_input_names_found_in_white_list = 0;

   if (isset($_POST)) {
      /*
         Cycle through every item in the $_POST array so I can inspect every
         $key for a match in the $white_list.
      */
      foreach ($_POST as $key => $value) {
         /*
             Perform a case-sensitive test of whether $key is found in
             $white_list. (A $key is the string-based index in the $_POST
             associative array. For example, the $key in $_POST["username"]
             would be "username." Similarly, the $key in $_POST["submitted"]
             would be "submitted.")  If it is, increase
             $amount_of_form_input_names_found_in_white_list.
         */
         if (in_array($key, $white_list)) {
            $amount_of_form_input_names_found_in_white_list++;
         }
      }

      /*
          This is the final step in checking whether the white list is valid. If
          the amount of form input names matching the white list equals the
          amount of items found in the $_POST array, and the amount of form
          input names does not equal 0, then the white list is valid.
      */
      if ($amount_of_form_input_names_found_in_white_list == count($_POST) &&
          $amount_of_form_input_names_found_in_white_list != 0 ) {
         $validated = true;
      }
   }

   return $validated;
}

/* ===================================================================
   DOES USER EXIST
   ================================================================ */
function does_user_exist( $username )
{
   try {
      require_once "config.php";

      $user_exists = FALSE;

      $db = new PDO("mysql:host=".DBHOST."; dbname=".DBNAME, DBUSER, DBPASS );

      $statement = $db->prepare("SELECT username FROM user WHERE username = :username");
      $statement->execute( array( 'username' => $username ) );

      while( $row = $statement->fetch() ) {
         if( $row['username'] == $username ) {
            $user_exists = TRUE;
            break;
         }
      }

      $statement = null;

      return $user_exists;
   }
   catch( PDOException $e ) {
      echo "<div>Error thrown in function <code>does_user_exist</code></div>";
      echo $e->getMessage();

      exit;
   }
}

/* ===================================================================
   AUTHENTICATE USER
   ================================================================ */
function authenticate_user( $username, $password )
{
   try {
      require_once "config.php";

      $db = new PDO( "mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS );
      $statement = $db->prepare("SELECT password, salt FROM user WHERE username=:username");
      $statement->execute( array( 'username' => $username ) );
      $row = $statement->fetch();
      $statement = null;

      if( md5( $password . $row['salt'] ) == $row['password'] )
         $state = TRUE;
      else
         $state = FALSE;

      return $state;
   }
   catch( PDOException $e ) {
       echo "<div>Error thrown in <code>authenticate_user</code></div>";
       echo $e->getMessage();

       exit;
   }
}

/* ===================================================================
   INSERT NEW FILE
   ================================================================ */
function insert_new_file( $username, $path, $name, $type )
{
   try {
      require_once "config.php";

      $connection = new PDO( "mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS );
      $statement = $connection -> prepare( "INSERT INTO file (username,path,name,format) VALUES (:username,:path,:name,:format)" );
      $statement -> execute( array(
         'username' => $username,
         'path'     => $path,
         'name'     => $name,
         'format'   => $type ) );

      $statement = null;
   }
   catch( PDOException $e ) {
       echo "<div>Error thrown in <code>insert_new_file</code></div>";
       echo $e->getMessage();

       exit;
   }
}

/* ===================================================================
   REGISTER NEW USER
   ================================================================ */
function register_new_user( $username, $password )
{
   try {
      require_once "config.php";

      $salt = substr( md5( rand( 0, 65536 ) ), 0, 8 );

      $connection = new PDO( "mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS );

      $statement = $connection->prepare( "INSERT INTO user (username,salt,password) VALUES (:username,:salt,:password)" );

      $statement->execute(
         array( 'username' => $username,
                'salt'     => $salt,
                'password' => md5( $password . $salt ))
      );

      $statement = null;
   }
   catch( PDOException $e ) {
       echo "<div>Error thrown in <code>register_new_user</code></div>";
       echo $e->getMessage();

       exit;
   }
}
