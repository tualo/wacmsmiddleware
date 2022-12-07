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
                    if ( isset($_REQUEST['comment']) ){
                        if (trim($_REQUEST['comment'])==''){
                            $comment=' Der Benutzer hat keinen Kommentar hinterlassen!';
                        }else{
                            $comment=$_REQUEST['comment'];
                        }
                        if ( isset($_REQUEST['mainVote']) // gesamte Wahl unterbrechen/fortsetzen
                            && isset($_REQUEST['toggle'])
                        ){
                            $db->direct('update wm_loginpage_settings set interrupted={toggle} where id={id}',['toggle'=>$_REQUEST['toggle'],'id'=>$_REQUEST['mainVote']]);
                            $action='Gesamte Online-Wahl ';
                            if ($_REQUEST['toggle']==1){
                                $action = $action.' unterbrochen'; 
                            }else{
                                $action = $action.' fortgesetzt';
                            }
                        }
                        if ( isset($_REQUEST['mainVote']) // gesamte Wahl starten/stoppen
                            && isset($_REQUEST['setStatus'])
                        ){
                            $action='Gesamte Online-Wahl ';
                            if ($_REQUEST['setStatus']==0){
                                $db->direct('update wm_loginpage_settings set stoptime=now() + interval - 1 second, interrupted=0  where id={id}',['id'=>$_REQUEST['mainVote']]);
                                $action = $action.' beendet';
                            }else{
                                $db->direct('update wm_loginpage_settings set starttime=now(), stoptime=now() + interval 200 day where id={id}',['id'=>$_REQUEST['mainVote']]);
                                $db->direct('update stimmzettel set unterbrochen=0 where aktiv=1',[]);
                                $action = $action.' gestartet';
                            }
                        }                    

                        if ( isset($_REQUEST['bltPp']) 
                            && isset($_REQUEST['toggle'])
                        ){
                            $db->direct('update stimmzettel set unterbrochen={toggle} where ridx={id}',['toggle'=>$_REQUEST['toggle'],'id'=>$_REQUEST['bltPp']]);
                            $action='Wahl für Stimmzettel '.$_REQUEST['bltPp'];                            
                            if ($_REQUEST['toggle']==1){
                                $action = $action.' unterbrochen'; 
                            }else{
                                $action = $action.' fortgesetzt';
                            }
                        }
                        $db->direct("insert into wa_action_log (user ,login , action, comment,ip_address) VALUES ('".$_SESSION['wa_session']['login']['vorname']." ".$_SESSION['wa_session']['login']['nachname']."','".$_SESSION['wa_session']['login']['user']."','".$action."','".$comment."','".$_SERVER['REMOTE_ADDR']."')" ,[]);
                    }else{
                        $result['forceComment']=1;
                        $result['oldRequest']=$_REQUEST;
                    }
                } else {
                    if ( isset($_REQUEST['usrid'])){
                        $result['message']=$result['message'].' Geschummelt -'; 
                        $db->direct("insert into wa_action_log (user ,login , action, comment,ip_address) VALUES ('".$_SESSION['wa_session']['login']['vorname']." ".$_SESSION['wa_session']['login']['nachname']."','".$_SESSION['wa_session']['login']['user']."','".$action."',' SCHUMMEL - VERSUCH','".$_SERVER['REMOTE_ADDR']."')" ,[]);
                    }
                }


                $mainVote=$db->singleRow("select  id, DATE_FORMAT(starttime,'%d.%m.%Y %H:%i:%s') starttime,DATE_FORMAT(stoptime,'%d.%m.%Y %H:%i:%s') stoptime,interrupted,if ( now() >= starttime and now() <= stoptime ,'running','not running' ) status from  wm_loginpage_settings",[]);
                $ballotPapers= $db->direct('SELECT ridx,name,aktiv,unterbrochen from view_website_stimmzettel',[]);
                $ballotPapersIndex= $db->direct('SELECT ridx,name,aktiv,unterbrochen from view_website_stimmzettel',[],'ridx');
                $result['mainVote']=  $mainVote;
                $result['ballotPapers']=$ballotPapers;
                $result['ballotPapersIndex']=$ballotPapersIndex;
            }catch(\Exception $e){
                 $result['message']=$result['message'].' -> DB not good -';
                 $result['message']=$result['message'].$e->getMessage();
            }
            session_commit();
        }
    }

