
<head>
  <link rel="stylesheet" href="styles.css">

</head>
<body>
<?php

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);


$servername = "localhost";
$username = "hugo";
$dbname = "";

// Create connection
$conn =  mysqli_connect ($servername, $username, "", $dbname  ) ;
mysqli_select_db($conn, $dbname);


// Check connection
if ( !$conn ) {
  die("Connection failed: " . $conn->connect_error);
}

$result = mysqli_query($conn, "SELECT id,username,password FROM hugo2.users");

//make table to paste the Query to
echo "<table> <tr> <th>ID</th>  <th>Uname</th> <th>paswword</th></tr>";
while (  $line = mysqli_fetch_array ( $result ) )
{    
    echo "<tr>";
    echo "<td>{$line['id']}</td>"; 
    echo "<td>{$line['username']} </td>";  
    echo "<td>{$line['password']}</td>";
    echo "</tr>";   
}
echo "</table>";
mysqli_free_result ( $result );


$result = mysqli_query($conn, "SELECT prod_id,image,name_prod, prod_detail FROM hugo2.products");
while (  $line = mysqli_fetch_array ( $result ) )
{   
    echo "<div class=\"img-block\">";

    echo "{$line['prod_id']}"; 
    echo "{$line['name_prod']}"; 
    echo "{$line['prod_detail']}<br>";
    $image_src = $line['image'];
    $img_name = $line['name_prod'];
}


?> 


</body>




<head>
  <link rel="stylesheet" href="styles.css">

</head>
<body>
<form action="index.php" method="POST" enctype="multipart/form-data">
    <label>File: </label><input type="file" name="image" />
    <input type="submit" />
</form>
<?php

  ini_set('display_startup_errors', 1);
  ini_set('display_errors', 1);
  error_reporting(-1);


  $servername = "localhost";
  $username = "hugo";
  $dbname = "hugo2";

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
         $name = $_FILES['image']['name'];
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
            $sql = "INSERT INTO hugo2.products ( image, name_prod )
                    VALUES ( '{$data}', '{$name}' ) ";
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