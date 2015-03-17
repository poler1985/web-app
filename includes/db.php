<?php

/* ===================================================================
   FIELD EXISTS IN COLUMN
   ================================================================ */
function fieldExistsInColumn ( $needle, $haystack, $table )
{
   try {
      include_once "config.php";

      $db = new PDO("mysql:host=".DBHOST."; dbname=".DBNAME.";charset=utf8", DBUSER, DBPASS,
         array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

      $statement = $db -> prepare( "SELECT $haystack FROM $table" );
      $statement -> execute();

      $found = false;

      while( ($row = $statement->fetch()) )
         if( $needle == $row[$haystack] ) {
            $found = true;

            break;
         }

      $statement = null;

      return $found;
   }
   catch( PDOException $e ) {
      echo "Error message generated: $e";

      exit;
   }
}

/* ===================================================================
   SELECT
   ================================================================ */
function select ( $field, $table, $query_field, $query )
{
   try {
      require_once "config.php";

      $db = new PDO("mysql:host=".DBHOST."; dbname=".DBNAME, DBUSER, DBPASS );

      $statement = $db->prepare("SELECT $field FROM $table WHERE $query_field = :q");

      $statement->execute( array( 'q' => $query ) );

      $row = $statement->fetch();

      $statement = null;

      return $row[$field];
   }
   catch( PDOException $e ) {
      include "error_message.inc";
      exit;
   }
}

/* ===================================================================
   UPDATE
   ================================================================ */
function update( $table, $field, $new_field_value, $field_of_interest, $field_of_interest_value )
{
   try {
      require_once "config.php";

      $db = new PDO("mysql:host=".DBHOST."; dbname=".DBNAME, DBUSER, DBPASS );

      $statement = $db->prepare("UPDATE $table SET $field = :new_field_value WHERE $field_of_interest = :field_of_interest_value");

      $statement->execute( array(
         'new_field_value' => $new_field_value,
         'field_of_interest_value' => $field_of_interest_value ) );

      $statement = null;
   }
   catch( PDOException $e ) {
      include "error_message.inc";
      exit;
   }
}

/* ===================================================================
   DELETE
   ================================================================ */
function delete( $table, $field, $query )
{
   try {
      require_once "config.php";

      $db = new PDO("mysql:host=".DBHOST."; dbname=".DBNAME, DBUSER, DBPASS );

      $statement = $db->prepare("DELETE FROM $table WHERE $field = :query");

      $statement->execute( array( 'query' => $query ) );

      $statement = null;
   }
   catch( PDOException $e ) {
      include "error_message.inc";
      exit;
   }
}

/* ===================================================================
   DELETE FILE
   ================================================================ */
function delete_file( $filepath )
{
   unlink( $filepath );
}

/* ===================================================================
   GET ALL FILE LINKS FOR
   ================================================================ */
function get_all_file_links_for( $username )
{
   try {
      require_once "config.php";

      $db = new PDO( "mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS );
      $statement = $db->prepare("SELECT path, name FROM file WHERE username = :username");
      $statement->execute( array( 'username' => $username ) );

      $index = 0;

      while( $row = $statement->fetch() )
         $links[ $index++ ] = $row['name'];

      $statement = null;

      if( !isset( $links ) )
         $links = 0;

      return $links;
   }
   catch( PDOException $e ) {
      include "error_message.inc";
      exit;
   }
}
