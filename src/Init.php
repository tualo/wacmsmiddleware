<?php
/*
* usrID -> formularfeld Username
* usrOldID -> formularfeld Username before
* pwID -> formularfeld Password
* pwOldID -> formularfeld Password before
*/
namespace Tualo\Office\WaCmsMiddleware;
use Tualo\Office\ContentManagementSystem\CMSMiddleware;

class Init extends CMSMiddleWare{
    public static function run(&$request,&$result){
        @session_start();
        $result['loginstart']=$_SESSION['wa_session']['login']['formID'].'-----'.$_REQUEST['formID'];
        try{
            if(! isset($_SESSION['wa_session'])) $_SESSION['wa_session']=[];
            // if(! isset($_SESSION['wa_session']['login'])) $_SESSION['wa_session']['login']=['loggedIn'=>false,'formId'=>uniqid('', FALSE),'loginFormError'=>0,'formId'=>''];
            if(! isset($_SESSION['wa_session']['login'])) {
                $_SESSION['wa_session']['login']['usrID']=uniqid('', FALSE);
                $_SESSION['wa_session']['login']['pwID']=uniqid('', FALSE);
                $_SESSION['wa_session']['login']['loggedIn']=false; // ,'formId'=>uniqid('', FALSE),'loginFormError'=>0];
                // $_SESSION['wa_session']['login']['lastformId']=$_SESSION['wa_session']['login']['formId'];
                // $_SESSION['wa_session']['login']['formId']=uniqid('', FALSE);
                $result['formId']=$_SESSION['wa_session']['login']['formId'];
                $result['wa_session']=$_SESSION['wa_session'];
            }
            $_SESSION['wa_session']['login']['usrOldID']=$_SESSION['wa_session']['login']['usrID'];
            $_SESSION['wa_session']['login']['pwOldID']=$_SESSION['wa_session']['login']['pwID'];
            $_SESSION['wa_session']['login']['usrID']=uniqid('', FALSE);
            $_SESSION['wa_session']['login']['pwID']=uniqid('', FALSE);
            $result['usrID']=$_SESSION['wa_session']['login']['usrID'];
            $result['pwID']=$_SESSION['wa_session']['login']['pwID'];
        }catch(\Exception $e){
            
        }
        session_commit();
        
    }
}