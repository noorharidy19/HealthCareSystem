<?php include 'DB.php'; ?>
<?php

class User{
public $name;
public $email;
public $password;
public $phone;
public $address;
public $ID;
public $userType;
public $DOb
function __construct($id){
if($id != 0){
    $sql="select * from users where 	ID=$id";
    $result = mysqli_query($GLOBALS['conn'], $sql);
    if($row = mysqli_fetch_assoc($result)){
        $this->ID = $row['ID'];
        $this->name = $row['name'];
        $this->email = $row['email'];
        $this->password = $row['password'];
        $this->phone = $row['phone'];
        $this->address = $row['address'];
        $this->userType = $row['userType']; //admin , doctor, patient
        $this->DOb = $row['DOb'];
    }

      }
  }
}
?>