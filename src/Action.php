<?php 
    namespace Tualo\Office\WaCmsMiddleware;
    use Tualo\Office\ContentManagementSystem\CMSMiddleware;
    use Tualo\Office\Basic\TualoApplication as App;

    class Action extends CMSMiddleware {
        public static function run(&$request,&$result){
            @session_start();
            try{
                $sessionDB  = App::get('session')->db;
                $mainVote=$sessionDB->singleRow('select  starttime,stoptime,interrupted from  wm_loginpage_settings',[]);
                $ballotPapers= $sessionDB->direct('SELECT ridx,name,aktiv,unterbrochen from view_website_stimmzettel',[]);
                $ballotPapersIndex= $sessionDB->direct('SELECT ridx,name,aktiv,unterbrochen from view_website_stimmzettel',[],'ridx');
                $result['mainVote']=  $mainVote;
                $result['ballotPapers']=$ballotPapers;
                $result['ballotPapersIndex']=$ballotPapersIndex;
            }catch(\Exception $e){
                 $result['message']=$result['message'].' -> DB not good -';
            }
            session_commit();
        }
    }

