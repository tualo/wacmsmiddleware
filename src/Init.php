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
        try{
            if ( isset($_REQUEST['logout']) ) unset($_SESSION['wa_session']) ;            
            if(! isset($_SESSION['wa_session'])) $_SESSION['wa_session']=[];
            if(! isset($_SESSION['wa_session']['login'])) {
                $_SESSION['wa_session']['login']['usrID']=str_replace('.','',uniqid('', TRUE));
                $_SESSION['wa_session']['login']['pwID']=str_replace('.','',uniqid('', TRUE));
                $_SESSION['wa_session']['login']['loggedIn']=false; // ,'formId'=>str_replace('.','',uniqid('', TRUE)),'loginFormError'=>0];
                $_SESSION['wa_session']['login']['loginFormError']=0;
                $result['formId']=$_SESSION['wa_session']['login']['formId'];
                $result['wa_session']=$_SESSION['wa_session'];
            }
            $_SESSION['wa_session']['login']['usrOldID']=$_SESSION['wa_session']['login']['usrID'];
            $_SESSION['wa_session']['login']['pwOldID']=$_SESSION['wa_session']['login']['pwID'];
            $_SESSION['wa_session']['login']['usrID']=str_replace('.','',uniqid('', TRUE));
            $_SESSION['wa_session']['login']['pwID']=str_replace('.','',uniqid('', TRUE));
            $result['usrID']=$_SESSION['wa_session']['login']['usrID'];
            $result['pwID']=$_SESSION['wa_session']['login']['pwID'];
        }catch(\Exception $e){
            
        }
        session_commit();
        
    }
}