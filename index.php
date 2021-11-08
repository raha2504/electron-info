p<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>connexion</title>
</head>

<body>

    <?php
    echo '<h1>Hello World !</h1>'; ?>
    <p>Ici un texte qui n'est pas généré en PHP.</p>

    <?php
    echo '<p>Inscrivez-vous</p>';
    $dsn='mysql:host=localhost;dbname=connecter';
    $server="localhost";
    $user="root";
    $password="";

//on verifie et securise les variables provenant du visiteur

if(isset($_POST['connecter'])&& $_POST['connecter'] =='connecter') {
$User=htmlspecialchars($_POST['User']);
$password=md5(htmlspecialchars($_POST['password']));
$connecter=$_POST['connecter'];

if ((isset($_POST['user']) && !empty($_POST['User'])
 && preg_match('/^([a-zA-Z0-9\'_]+) $/', $_POST['user'])
  && (isset($_POST['password']) && !empty($_POST['password'])
   && preg_match('/^([a-zA-Z0-9\'!@]+)$/', $_POST['password']))){

$conn = new PDO($dsn, $user, $password);
$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$req = $conn->prepare('SELECT COUNT(*) AS nb FROM member WHERE User = :user AND password =
:password');
$req-> execute (array ('user'=>$user, 'password'=>$password));
$data=$req->fetch();
$req->closeCursor();

if ($data['nb']== 1){
    session_start();
    $_SESSION['user'] = $_POST['user'];
    header('location: member.php');
    exit();
}
    elseif ($data['nb']==0) {
        $error = 'verifier votre compte utilisateur ou Mot de passe';
}

// sinon ,alors la il y a un gros problème

    else{
        $error = 'verifier votre compte utilisateur ou Mot de passe';
    }
}
else{
    $error='SVP Vous devez remplir tous les champs.';
}
}

?>


</body>

</html>
