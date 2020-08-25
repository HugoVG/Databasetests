
<head>
  <link rel="stylesheet" href="styles.css">

</head>
<body>
<form action="index.php" method="POST" enctype="multipart/form-data">
    <label>name product:</label><input type="text" name="name">
    <label>File: </label><input type="file" name="image" />
    <label>product details:</label><input type="text" name="details">
    <input type="submit" />
</form>
<?php

  ini_set('display_startup_errors', 1);
  ini_set('display_errors', 1);
  error_reporting(-1);


  $servername = "localhost";
  $username = "";
  $dbname = "";

  // Create connection
  $conn =  mysqli_connect ($servername, $username, "", $dbname  ) ;
  mysqli_select_db($conn, $dbname);


  // Check connection
  if ( !$conn ) {
    die("Connection failed: " . $conn->connect_error);
  }

   /* First Save, Reload page */
   
//    if ( is_uploaded_file ( $_FILES['userfile']['tmp_name'])
//         && getimagesize ( $_FILES['userfile']['tmp_name']) != false )
      if ( is_uploaded_file ( $_FILES['image']['tmp_name']) )
      {
         $size = getimagesize( $_FILES['image']['tmp_name'] );
         $type = $size['mime'];
         $size = $size[3];
         $name = $_POST['name'];
         $details = $_POST['details'];
         $maxsize = 99999999;

         $binary = file_get_contents($_FILES['image']['tmp_name']);
         list ( $width, $height ) = getimagesize( $_FILES['image']['tmp_name'] );
         if ( $width > $height )
            $orientation = 0; // Landscape
          else
            $orientation = 1; // Portrait or Square

         // Read the file
         $tmpName = $_FILES['image']['tmp_name'];
         $fp = fopen($tmpName, 'rb');
         $data1 = fread( $fp, filesize($tmpName) );
         $data = addslashes($data1 );
         fclose($fp);

         if ( $_FILES['image']['size'] < $maxsize )
         { 
            $sql = "INSERT INTO products ( image, name_prod, prod_detail )
                    VALUES ( '{$data}', '{$name}', '{$details}' ) ";
            mysqli_query ( $conn, $sql ) or die ( "{$sql}" . mysqli_error( $conn ) );
          
            $Iid = mysqli_insert_id( $conn );
            echo $Iid;
    
         }
         else
         {
           throw new Exception("File Size Error");
         }
      }
      else
      {
         throw new Exception("Unsupported Image Format!");
      }
   

?>



</body>