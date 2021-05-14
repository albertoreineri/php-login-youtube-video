<?php 

/*-------------------------------
CONNESSIONE PDO
--------------------------------*/
//PDO Connection
$servername="localhost";
$username="root";
$passworddb="root";
$dbname="local";

try{
    $db = new PDO("mysql:=$servername;dbname=$dbname", $username, $passworddb);
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    print "Errore!: ". $e->getMessage() . "<br>";
    die();
}


/*-------------------------------
LOGIN
--------------------------------*/
$email=$_POST['email'];
$password=$_POST['password'];

//Query
$q = $db->prepare("SELECT * FROM utenti WHERE email = '$email'");
$q->execute();
$q->setFetchMode(PDO::FETCH_ASSOC);
$rows = $q->rowCount();
if($rows>0){
    while($row=$q->fetch()){
        if($row['password']===$password){
            session_start();
            $_SESSION['id'] = $row['id'];
            header("location: ../welcome.php");
        }else{
            header("location: ../error.php");
        }
    }
}else{
    echo "Utente non presente in archvio";

}
