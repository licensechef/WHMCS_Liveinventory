<?php

use WHMCS\Module\Addon\AddonModule\Admin\AdminDispatcher;
use WHMCS\Module\Addon\AddonModule\Client\ClientDispatcher;
use WHMCS\Database\Capsule;
use Illuminate\Database\Capsule\Manager as DB;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

function liveinventory_config()
{
    return [
        // Display name for your module
        'name' => 'Live Inventory API',
        // Description displayed within the admin interface
        'description' => 'This module provides live inventory of your inventory stock',
        // Module author name
        'author' => 'CodeBox.ca',
        // Default language
        'language' => 'english',
        // Version number
        'version' => '1.0',
        'fields' => [
            "hash" => array ("FriendlyName" => "Hash for checking", "Type" => "text", "Size" => "23", "Description" => "If you want to secure the api, fill in a random string", "Default" => "", ),

        ]
    ];
}


function liveinventory_activate(){
    try {
        return [
            'status' => 'success',
            'description' => 'Module activated',
        ];
    } catch (\Exception $e) {
        return [
            'status' => "error",
            'description' => 'Unable to activate ' . $e->getMessage(),
        ];
    }
}

function liveinventory_deactivate(){
    try {
        return [
            // Supported values here include: success, error or info
            'status' => 'success',
            'description' => 'Module deactivated',
        ];
    } catch (\Exception $e) {
        return [
            // Supported values here include: success, error or info
            "status" => "error",
            "description" => "Unable to deactivate: {$e->getMessage()}",
        ];
    }
}


function liveinventory_upgrade($vars){

}


function liveinventory_output($vars){


}


function liveinventory_sidebar($vars){
    // Get common module parameters
    $modulelink = $vars['modulelink'];
    $version = $vars['version'];
    $_lang = $vars['_lang'];

    return $sidebar;
}


function liveinventory_clientarea($vars){
    require (ROOTDIR."/modules/addons/liveinventory/lib/Client/ClientDispatcher.php");
    require (ROOTDIR."/modules/addons/liveinventory/lib/Client/Controller.php");

    /**
     * Dispatch and handle request here. What follows is a demonstration of one
     * possible way of handling this using a very basic dispatcher implementation.
     */

    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

    $dispatcher = new WHMCS\Module\Addon\AddonModule\Client\ClientDispatcher();
    return $dispatcher->dispatch($action, $vars);
}
