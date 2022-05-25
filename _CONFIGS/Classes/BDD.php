<?php

namespace App;

use PDO;
use PDOException;

/*
$_SESSION['expire'] = time() + 15*60;

if(time() > $_SESSION['expire']){
    session_destroy();
    session_write_close();
    session_unset();
    $_SESSION = array();
}else {
    $_SESSION['expire'] = time() + 15*60;
}
*/


class BDD
{
    private $host   = '159.203.18.87';
    private $user   = 'techouse_user';
    private $pass   = 'TecH@use#2@2Deux';
    private $dbname = "techouse_ouagolo_db";
    private PDO $bdd;


    public function __construct($host = null, $user = null, $pass = null, $dbname = null)
    {
        if ($host != null) {
            $this->host = $host;
            $this->user = $user;
            $this->pass = $pass;
            $this->dbname = $dbname;
        }
        try {
            $this->bdd = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname, $this->user, $this->pass, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
                PDO::MYSQL_ATTR_LOCAL_INFILE => true
            ));
        } catch (PDOException $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }

    public function query($sql, $data = array())
    {
        $req = $this->bdd->prepare($sql);
        $req->execute($data);
        return $req->fetchAll(PDO::FETCH_OBJ);
    }

    public function getBdd(): PDO
    {
        return $this->bdd;
    }
}