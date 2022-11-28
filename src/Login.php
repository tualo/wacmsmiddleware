<?php 
    namespace Tualo\Office\WaCmsMiddleware;
    use Tualo\Office\ContentManagementSystem\CMSMiddleware;

    class Login extends CMSMiddleware {
        public static function run(&$request,&$result){
            $result['sbo'] = time();
        }
    } 
