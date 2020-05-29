<?php

namespace WHMCS\Module\Addon\AddonModule\Client;
use Illuminate\Database\Capsule\Manager as DB;
use WHMCS\Database\Capsule;

class Controller {
    public function index($vars)
    {
        if (!preg_match('/\d+/',$_GET["pid"]) && $_GET["pid"] != "all") die("Are you trying to hack?");
        $pdo = DB::connection()->getPdo();
        //Get the hash
        $query = $pdo->prepare("SELECT value FROM tbladdonmodules WHERE module = :mod AND setting = :setting");
        $query->execute(array(":mod"=>"liveinventory",":setting"=>"hash"));
        $query = $query->fetch( \PDO :: FETCH_ASSOC );

        if ($query["value"] == "" || $query["value"] == $_GET["hash"]){
            if ($_GET["pid"] == "all"){
                $query = $pdo->prepare("SELECT id,name,stockcontrol,qty FROM tblproducts");
                $query->execute();
                $query = $query->fetchall( \PDO :: FETCH_ASSOC );

                echo json_encode($query);
                die();
            }else{
                $query = $pdo->prepare("SELECT stockcontrol,qty FROM tblproducts WHERE id = :id");
                $query->execute(array(":id"=>$_GET["pid"]));
                $query = $query->fetch( \PDO :: FETCH_ASSOC );

                echo json_encode($query);
                die();
            }
        }else if ($query["value"] != $_GET["hash"]) die("Are you trying to hack?");

    }

}
