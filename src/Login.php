<?php 
    namespace Tualo\Office\WaCmsMiddleware;
    use Tualo\Office\ContentManagementSystem\CMSMiddleware;

    class Login extends CMSMiddleware {
        public static function run(&$request,&$result){
            @session_start();
            $result['sbo'] = time();
            $result['loginstart']=$_SESSION['wa_session']['login']['formID'].'-----'.$_REQUEST['formID'];
            if( 
                isset($_REQUEST[$_SESSION['wa_session']['login']['usrOldID']]) 
                    && isset($_REQUEST[$_SESSION['wa_session']['login']['pwOldID']])
            ){  
                // checking USR DATA
                if( $_REQUEST[$_SESSION['wa_session']['login']['usrOldID']] == 'ABCDEFGH' // USR
                        &&  $_REQUEST[$_SESSION['wa_session']['login']['pwOldID']]== 'ABCDEFGH' // PW
                ) {
                    $_SESSION['wa_session']['login']['loggedIn']=TRUE;
                    $_SESSION['wa_session']['login']['user']='Karl Knall';
                    $_SESSION['wa_session']['login']['role']='OberAdmin';
                    $result['message']=$result['message'].'<br> Eingaben OK -';
                    header('Location: ./wa');
                } else {
                    $_SESSION['wa_session']['login']['loginFormError']++;
                    $result['message']=$result['message'].'<br> Eingaben NICHT OK -';
                }

                $result['message']=$result['message'].'<br> Formularfelder vorhanden -> passt -';

            } else {
                $result['message']=' Formularfelder NICHT vorhanden -> passt NICHT -';
                $_SESSION['wa_session']['login']['loginFormError']++;
            }
           /* if ($_SESSION['wa_session']['login']['loggedIn']===false){
                // isset 
                if (
                    isset($_REQUEST['formID']) 
                        && ($_SESSION['wa_session']['login']['formID']==$_REQUEST['formID'])
                ){
                    // $result['message']=' Formfeld passt -'.$_SESSION['wa_session']['login']['formID'].' vs. '.$_REQUEST['formID'];
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
                   $_SESSION['wa_session']['login']['loginFormError']++;
                   // $result['message']=' Formfeld passt NICHT!-'.$_SESSION['wa_session']['login']['formID'].' vs. '.$_REQUEST['formID'];
                } 
            }*/
            $result['loginFormError']=$_SESSION['wa_session']['login']['loginFormError'];
        }
    } 
