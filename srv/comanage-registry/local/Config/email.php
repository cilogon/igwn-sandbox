<?php

class EmailConfig {
  public $default = array(
      'from' => array('your_account@gmail.com' => 'Registry'),
      'transport' => 'Smtp',
      'host' => 'tls://smtp.gmail.com',
      'port' => 465,
      'username' => 'your_account@gmail.com',
      'password' => 'your app password'
    );
}

