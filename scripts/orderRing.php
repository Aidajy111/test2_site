<?php

// Задать вопрос

header('Content-type: text/html; charset=UTF-8');
 
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
global $wpdb;

if(!empty($_POST)) {

    $success = false;
    $output = '';
  
    // Post values
    $name = get_safe_post($_POST['name']);
    $phone = get_safe_post($_POST['phone']);
    
    
    if(!$name || !$phone){
        $output = 'Заполните, пожалуйста, все поля!';
    } 
    
    else{

        $from = get_option('from');
        $to = get_option('admin_email');
        $headers = "Content-Type: text/html; charset=UTF-8";
        $subject = 'Заказ звонка на сайте ' . get_bloginfo('name');  
      
        $msg = "<p>Имя: " . $name . "</p><p>Телефон: " . $phone . "</p>";
      
        $send_admin =  wp_mail( $to, $subject, $msg, $headers );  
           
        if($send_admin) {
            $success = true;
            $output = 'Спасибо! Ваше сообщение доставлено. Мы свяжемся с Вами в ближайшее время.';
        }
        else {
            $output = 'Что-то пошло не так. Попробуйте позже';
        }
    }
   
    echo json_encode(array('success'=>$success, 'output'=> $output));    
}    

die();
 
?>