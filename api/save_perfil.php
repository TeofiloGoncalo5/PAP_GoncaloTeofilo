<?php 

 session_start();

 include '../db.php';

 $status = 'error';
 $message = 'Ocorreu um erro';
 $tipo = $conn->query("SELECT id, username , email, img FROM users");

 $username = mysqli_real_escape_string($conn,$_POST['username']);
 $email = mysqli_real_escape_string($conn,$_POST['email']);
 $img = $_POST['img'];

 while ($row = $tipo->fetch_assoc()) {
    if ($username == $row['username'] && $email == $row['email']) {
        $status = "success";
        $message = "Edit com sucesso";
    } else if ($username != $row['username'] && $email != $row['email']) {
        $status = 'error';
        $message = 'something is wrong';
    }
}

 if ($img != null) {
    $imgData = $_POST['img'];
    $image = str_replace('data:' . $imgData['type'] . ';base64,', '', $imgData['dataURL']);
    $image = str_replace(' ', '+', $image);
    $imgName = time() . ".png";
    //echo $image;
    file_put_contents('../assets/img/' .  $imgName, base64_decode($image));

    $tipo2 = $conn->query("UPDATE users SET username ='" . $username . "',email ='" . $email . "', img='" . $imgName . "' WHERE id = " . $_SESSION['theId']);
} else {
    $tipo2 = $conn->query("UPDATE users SET username ='" . $username . "',email ='" . $email . "' WHERE id = " . $_SESSION['theId']);
}

$tipo3 = $conn->query("SELECT id, username, email, img FROM users WHERE id = " . $_SESSION['theId']);
 if($tipo3){
    $status = 'success';
    $message = 'Eitado com sucesso';
 }

while ($row = $tipo3->fetch_assoc()) {
    $_SESSION['username'] = $row['username'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['img'] = $row['img'];
}

echo json_encode(["status" => $status, "message" => $message]);
?>