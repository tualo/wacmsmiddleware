<?php 
    namespace Tualo\Office\WaCmsMiddleware;
    use Tualo\Office\ContentManagementSystem\CMSMiddleware;

    class Login extends CMSMiddleware {
        public static function run(&$request,&$result){
            @session_start();
            $result['sbo'] = time();

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
                    header('Location: ../wa');
                    exit();
                } else {
                    $_SESSION['wa_session']['login']['loginFormError']++;
                    $result['message']=$result['message'].'<br> Eingaben NICHT OK -';
                }

                $result['message']=$result['message'].'<br> Formularfelder vorhanden -> passt -';

            } else {
                $result['message']=' Formularfelder NICHT vorhanden -> passt NICHT -';
                $_SESSION['wa_session']['login']['loginFormError']++;
                
            }
            if($_SESSION['wa_session']['login']['loginFormError'] > 3){
                header('Location: https://www.bsi.bund.de');
                exit();
            }
         }
    } 
