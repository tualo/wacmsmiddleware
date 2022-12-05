<?php 
    namespace Tualo\Office\WaCmsMiddleware;
    use Tualo\Office\ContentManagementSystem\CMSMiddleware;
    use Tualo\Office\Basic\TualoApplication as App;

    class Action extends CMSMiddleware {
        public static function run(&$request,&$result){
            @session_start();
            try{
                $sessionDB  = App::get('session')->db;
                $mainVote=$sessionDB->singleRow('select  starttime,stoptime,interrupted from  wm_loginpage_settings');
                $ballotPapers= $sessionDB->direct('SELECT Json_Array(ridx,name,aktiv,unterbrochen) from view_website_stimmzettel');
                $result['mainVote']=$mainVote;
                $result['ballotPapers']=$ballotPapers;
            }catch(\Exception $e){
                
            }
            session_commit();
   }