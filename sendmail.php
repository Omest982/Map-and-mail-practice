<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';

$mail = new PHPMailer(true);
$mail->CharSet = "UTF-8";
$mail->setLanguage('ru', 'phpmailer/language/');
$mail->isHTML(true);

//От кого письмо
$mail->setFrom('ingo@fls.guru', 'Ivan Poberezhets');
//Кому отправить
$mail->addAddress('omest982@gmail.com');
//Тема письма
$mail->Subject = "Привет! Это Я!";

//Рука
$hand = "Правая";
if ($_POST['hand'] == 'left') {
   $hand = "Левая";
}

//Тело письма
$body = '<h1>Супер письмо!</h1>';

if (trim(!empty($_POST['name']))) {
   $body = '<p><strong>Имя :</strong>' . $_POST['name'] . '</p>';
}
if (trim(!empty($_POST['email']))) {
   $body = '<p><strong>Email :</strong>' . $_POST['email'] . '</p>';
}
if (trim(!empty($_POST['hand']))) {
   $body = '<p><strong>Email :</strong>' . $hand . '</p>';
}
if (trim(!empty($_POST['age']))) {
   $body = '<p><strong>Email :</strong>' . $_POST['age'] . '</p>';
}
if (trim(!empty($_POST['message']))) {
   $body = '<p><strong>Email :</strong>' . $_POST['message'] . '</p>';
}

//Прикрепить файл
if (!empty($_Files['image']['tmp_name'])) {
   //Путь загрузки файла
   $filePath = __DIR__ . "/files/" . $_Files['image']['name'];
   if (copy($_Files['image']['tmp_name'], $filePath)) {
      $fileAttach = $filePath;
      $body = '<p><strong>Фото в приложении :</strong></p>';
      $mail->addAttachment($fileAttach);
   }
}

$mail->Body = $body;

//Отправляем
if (!$mail->send()) {
   $message = "Ошибка";
} else {
   $message = "Данные отправлены!";
}

$response = ['message' => $message];

header("Content-type: application/json");
echo json_encode($response);
