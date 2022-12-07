<?php 
    namespace Tualo\Office\WaCmsMiddleware;
    use Tualo\Office\ContentManagementSystem\CMSMiddleware;
    use Tualo\Office\Basic\TualoApplication as App;

    class History extends CMSMiddleware {
        public static function run(&$request,&$result){
            @session_start();
            try{
                $db  = App::get('session')->getDB();
                $history=$db->direct("select user,login,ip_address, DATE_FORMAT(createtime,'%d.%m.%Y %H:%i:%s') datum, action,comment from wa_action_log order by createtime desc limit 500",[]);
                $result['history']=$history;
            }catch(\Exception $e){
                 $result['message']=$result['message'].$e->getMessage();
            }
            session_commit();
        }
    }

