<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'protocol' => 'smtp',
    'smtp_host' => 'smtp.gmail.com',  // Remplacez par le serveur SMTP approprié
    'smtp_port' => 465,
    'smtp_user' => 'dimpexenterprise@gmail.com',  // Remplacez par votre adresse e-mail
    'smtp_pass' => 'dimpexentreprise',  // Remplacez par votre mot de passe
    'smtp_crypto' => 'ssl',  // Utilisez 'ssl' pour SSL, 'tls' pour TLS/STARTTLS
    'mailtype' => 'html',
    'charset' => 'utf-8',
    'wordwrap' => TRUE
);