<?php
namespace Tualo\Office\WaCmsMiddleware;
use Tualo\Office\ContentManagementSystem\CMSMiddleware;

class Checklogin extends CMSMiddleWare{
    public static function run(&$request,&$result){
        @session_start();
        try{
            if ($_SESSION['wa_session']['login']['loggedIn']===false){
                if($_SESSION['wa_session']['login']['loginFormError'] > 3){
                    header('Location: https://www.bsi.bund.de');
                    exit();
                }
                header('Location: ./wa/login');
                exit();
                }
        }catch(\Exception $e){
            
        }
        session_commit();
        
    }
}