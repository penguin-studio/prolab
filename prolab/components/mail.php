<?php

$post = (!empty($_POST)) ? true : false;
if($post) {

	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$text = $_POST['text'];
	$mail_to = $_POST['mail_to'];

	$error = '';

	if(!$name) {$error .= 'Укажите свое имя. ';}
	if(!$error) {

					$mes = $order."Имя: ".$name."\n\nТелефон: ".$phone."\n\n"."Cообщение: ".$text."\n\n";

			$send =  mail ($mail_to,'Cообщение с сайта',$mes,"Content-type:text/plain; charset = UTF-8\r\nFrom:$email");
			if($send) {echo 'OK';}
	}
	else { echo $error;}
}

?>
