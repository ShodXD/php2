<?php 


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ss";


// // Create connection
// $conn = new mysqli($servername, $username, $password);

// // Check connection
// if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// }
// echo "Connected successfully \n";


// $sql = "CREATE DATABASE ss";
// if ($conn->query($sql) === TRUE) {
//   echo "Database created successfully";
// } else {
//   echo "Error creating database: " . $conn->error;
// }
// $conn->close();

// $conn = new mysqli($servername, $username, $password,$dbname);


// // sql to create table
// $sql = "CREATE TABLE users (
// username VARCHAR(40),
// age INT(3) NOT NULL,
// gender VARCHAR(30) NOT NULL,
// email VARCHAR(50) PRIMARY KEY ,
// addrress VARCHAR(50) 
// )";

// if ($conn->query($sql) === TRUE) {
//   echo "Table usres created successfully";
// } else {
//   echo "Error creating table: " . $conn->error;
// }


// $conn->close();

$name = $email = $gender = $age = $address = "";
$nameErr = $emailErr = $ageErr  = "";

$tname = $temail  = $tage  = "";




?>

<?php 





function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "* "."Name is required";
  } else {
    $tname = test_input($_POST["name"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$tname)) {
      $nameErr = "* "."Only letters and white space allowed";
    }
    else {
      $name = $tname;
    }
  }

  if (empty($_POST["email"])) {
    $emailErr = "* "."Email is required";
  } else {
    $temail = test_input($_POST["email"]);
    if (!filter_var($temail, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "* "."Invalid email format";
    }else{
      $email = $temail;
    }
  }

  if (empty($_POST["address"])) {
    $address = "";
  } else {
    $address = test_input($_POST["address"]);
  }

  if (empty($_POST["age"])) {
    $ageErr = "* "."age is required";
    
  } else {
    $tage = test_input($_POST["age"]);
    if ($tage > 10  && $tage <30) {
      $age = $tage;
    }
    else {
      $ageErr = "* "."age is not valied";
      }
  }

  if (empty($_POST["gender"])) {
    $gender = "male";
  } else {
    $gender = test_input($_POST["gender"]);
  }
  ; //clears all POST

}

// echo "<h1>$name</h1>";
// echo "<h1>$age</h1>";
// echo "<h1>$gender</h1>";
// echo "<h1>$email</h1>";
// echo "<h1>$address</h1>";



?>


<html>
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
    <style>
      body{
width: 98%;
height: 96vh;
display: flex;
align-items: center;
justify-content: space-around;
font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
}
.f{}

span{
    display: block;
    color: red;
}
h1{
    font-size: 20px;
}
.i{
    width: 300px;
    height: 45px;
    background-color: #ededed;
    border: 2px; 
    font-size:22px;
    border-radius: 5px;
}
.g {
font-size: 20px;
margin: 13.4px 0;
font-weight: bold;
display: inline-block;
color: black;
}
.s{
    width: 100px;
    height: 40px;
    margin: 30px 106px;
    border: 0;
    background-color: #129367;
    cursor:pointer;
    border-radius: 10px;
    font-size:19px;

}

    </style>


</head>
<body>

<div class="f">


<form method="post" action="" >  
  <h1>NAME *</h1>
  <input class = "i" type="text" name="name" value="<?php echo $tname ?>">
   <span><?php echo $nameErr;?></span>

  <h1>EMAIL *</h1>
   <input class = "i" type="text" name="email" value="<?php echo $temail ?>">
   <span > <?php echo $emailErr;?></span>
  <h1>AGE *</h1>
   <input class = "i" type="text" name="age" value="<?php echo $tage ?>">
   <span > <?php echo $ageErr;?></span>

  <h1>ADDRESS </h1>
   <input class = "i" type="text" name="address" value="<?php echo $address ?>">
  <br>
  <span class = 'g'>GENDER </span>
  <input type="radio" name="gender" value="male" checked>Male
  <input type="radio" name="gender" value="female">Female
  <br>
  <input class = "s" type="submit" name="submit" value="Submit">  
</form>
</div>

</body>
</html>

<?php 


if (($name != "" && $email !="" && $age != '')&&($nameErr === ""&& $emailErr === ""&& $ageErr ==='')) {
  // echo "<h1>asd</h1>";
  $conn = new mysqli($servername, $username, $password,$dbname);
    // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
    // echo "Connected successfully \n";

  $stmt = $conn->prepare("INSERT INTO users (username, age, gender,email,addrress) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sisss", $name, $age,$gender ,  $email, $address);
  $stmt->execute();
  header('Location: index.php');
  $stmt->close();
  $conn->close();
}


?>