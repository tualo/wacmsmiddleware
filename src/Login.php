<?php 
    namespace Tualo\Office\WaCmsMiddleware;
    use Tualo\Office\ContentManagementSystem\CMSMiddleware;

    class Login extends CMSMiddleware {
        public static function run(&$request,&$result){
            $result['sbo'] = time();
            if ($_SESSION['wa_session']['login']['loggedIn']===false){
                // isset 
                if (
                    isset($_REQUEST['loginFormID']) 
                        && ($_SESSION['wa_session']['login']['loginFormID']==$_REQUEST['loginFormID'])
                ){
                    if (
                        isset($_REQUEST[$_SESSION['wa_session']['login']['lastformId']]) 
                        && ($_SESSION['wa_session']['login']['formId']==$_REQUEST[$_SESSION['wa_session']['login']['lastformId']])
                    ){
                        if ($_REQUEST[$_SESSION['wa_session']['login']['lastformId']] == 'ABCDEFGH'){
                            $_SESSION['wa_session']['login']['loggedIn']=true;   
                        } 
                    } else {
                        $_SESSION['wa_session']['login']['loginFormError']++;
                    }
                } else{
                   //  $_SESSION['wa_session']['login']['loginFormError']++;
                }
            }
            $result['loginFormError']=$_SESSION['wa_session']['login']['loginFormError'];
        }
    } 
