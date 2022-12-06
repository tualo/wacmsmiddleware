<?php 
    namespace Tualo\Office\WaCmsMiddleware;
    use Tualo\Office\ContentManagementSystem\CMSMiddleware;
    use Tualo\Office\Basic\TualoApplication as App;

    class Action extends CMSMiddleware {
        public static function run(&$request,&$result){
            @session_start();
            try{
                $db  = App::get('session')->getDB();
                if ( isset($_REQUEST['usrid']) 
                    && $_REQUEST['usrid']==$_SESSION['wa_session']['login']['usrOldID'] 
                ){
                    if ( isset($_REQUEST['mainVote']) // gesamte Wahl 
                        && isset($_REQUEST['toggle'])
                    ){
                        $db->direct('update wm_loginpage_settings set interrupted={toggle} where id={id}',['toggle'=>$_REQUEST['toggle'],'id'=>$_REQUEST['mainVote']]);
                    }

                    if ( isset($_REQUEST['bltPp']) 
                        && isset($_REQUEST['toggle'])
                    ){
                        $db->direct('update stimmzettel set unterbrochen={toggle} where ridx={id}',['toggle'=>$_REQUEST['toggle'],'id'=>$_REQUEST['bltPp']]);
                    }
                }


                $mainVote=$db->singleRow("select  id,starttime,stoptime,interrupted,if ( now() >= starttime and now() <= stoptime ,'running','not running' ) status from  wm_loginpage_settings",[]);
                $ballotPapers= $db->direct('SELECT ridx,name,aktiv,unterbrochen from view_website_stimmzettel',[]);
                // $ballotPapersIndex= $db->direct('SELECT ridx,name,aktiv,unterbrochen from view_website_stimmzettel',[],'ridx');
                $result['mainVote']=  $mainVote;
                $result['ballotPapers']=$ballotPapers;
                // $result['ballotPapersIndex']=$ballotPapersIndex;
            }catch(\Exception $e){
                 $result['message']=$result['message'].' -> DB not good -';
                 $result['message']=$result['message'].$e->getMessage();
            }
            session_commit();
        }
    }

