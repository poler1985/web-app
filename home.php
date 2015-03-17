<?php
session_start();

if( isset( $_SESSION['valid'] ) ) {
   if( $_SESSION['valid'] !== TRUE )
      header( "Location: ./index.php" );
}
else
   header( "Location: ./index.php" );

require_once "includes/db.php";

// $filepath = select( "path", "file", "username", $_SESSION['username'] );
// $filename = select( "name", "file", "username", $_SESSION['username'] );
$username = select( "username", "user", "username", $_SESSION['username'] );

$links = get_all_file_links_for( $_SESSION['username'] );
$amount_of_links = count( $links );

?>
<!DOCTYPE HTML>
<html>
   <head>
      <meta charset="utf-8">
      <title>Web Application (v0.0.1) — Home</title>
      <link rel="stylesheet" href="css/normalize.css">
      <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
   </head>
   <body>
      <header>
         <h1>Home</h1>
      </header>
      <p><a href="./logout.php">Logout</a></p>
      <p>Hello, <strong><?php echo $username; ?></strong>. How’s it hanging?</p>
      <dl>
<?php
   for( $index = 0; $index < $amount_of_links; $index++ )
      echo "         <dd><a href=\"uploads/$links[$index]\">$links[$index]</a></dd>\n";
?>
      </dl>
      <section id="upload">
         <form method="post" action="upload.php" enctype="multipart/form-data">
            <p><input type="file" name="document"></p>
            <p><input type="submit" id="send_file" value="Send File"></p>
         </form>
      </section>
   </body>
</html>
