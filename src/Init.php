<?php

namespace Tualo\Office\WaCmsMiddleware;
use Tualo\Office\ContentManagementSystem\CMSMiddleware;

class Init extends CMSMiddleWare{
    public static function run(&$request,&$result){
        @session_start();
        try{
            if(! isset($_SESSION['wa_session'])) $_SESSION['wa_session']=[];
            if(! isset($_SESSION['wa_session']['login'])) $_SESSION['wa_session']['login']=['loggedIn'=>true,'loginFormID'=>uniqid('', true),'loginFormError'=>0,'formId'=>''];
            $_SESSION['wa_session']['login']['lastformId']=$_SESSION['wa_session']['login']['formId'];
            $_SESSION['wa_session']['login']['formId']=uniqid('', true);
            $result['formId']=$_SESSION['wa_session']['login']['formId'];
            $result['abc']='BLUB';
        }catch(\Exception $e){
            
        }
        session_commit();
        
    }
}