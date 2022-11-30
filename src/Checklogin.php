<?php
namespace Tualo\Office\WaCmsMiddleware;
use Tualo\Office\ContentManagementSystem\CMSMiddleware;

class Checklogin extends CMSMiddleWare{
    public static function run(&$request,&$result){
        @session_start();
        try{
            if ($_SESSION['wa_session']['login']['loggedIn']===false){
                header('Location: ./wa/login');
                exit();
            }
        }catch(\Exception $e){
            
        }
        session_commit();
        
    }
}