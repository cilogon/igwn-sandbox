<?php

class DATABASE_CONFIG {

  public $default = array(
    'persistent' => false,
    'prefix' => 'cm_',
    'datasource' => 'Database/Mysql',
    'host' => '127.0.0.1',
    'login' => 'registry_user',
    'password' => 'password',
    'database' => 'registry',
    );

  public $myligo = array(
    'datasource' => 'Database/Mysql',
    'persistent' => false,
    'host' => 'myligo3.ligo.caltech.edu',
    'login' => 'YOUR_LOGIN',
    'password' => 'YOUR_PASSWORD',
    'database' => 'myligo',
  );

}
