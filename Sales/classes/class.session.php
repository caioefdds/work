<?php

session_start();

$__config = parse_ini_file("config.ini", true);

$_SESSION['ini_config'] = $__config;
$_SESSION['path'] = $__config['GERAL']['path'];
$_SESSION['href'] = $__config['GERAL']['href'];
$_SESSION['db'] = $__config['DATABASE']['db'];
$_SESSION['host'] = $__config['DATABASE']['host'];
$_SESSION['user'] = $__config['DATABASE']['user'];
$_SESSION['pass'] = '';

Class Session {

    public function __construct() {

        $__config = parse_ini_file("../config.ini", true);

        $_SESSION['ini_config'] = $__config;
        $_SESSION['path'] = $__config['GERAL']['path'];
        $_SESSION['href'] = $__config['GERAL']['href'];
        $_SESSION['db'] = $__config['DATABASE']['db'];
        $_SESSION['host'] = $__config['DATABASE']['host'];
        $_SESSION['user'] = $__config['DATABASE']['user'];
        $_SESSION['pass'] = '';
    }
}

?>