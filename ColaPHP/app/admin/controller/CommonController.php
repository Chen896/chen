<?php
class CommonController extends Cola_Controller
{

    public function init()
    {


        try{
            if($_GET['a']!="index"){
                throw new Exception("你没有权限");
            }
        }catch (Exception $e){
            //echo $e->getMessage();
           // exit;
        //    header("HTTP/1.0 404 Not Found");
        //    header("Status: 404 Not Found");
        //    header("Location:".B_ROOT."/404.html");
        }
    }


    public  function getABCD(){
       return "aaaaaaaaaaaaaaaaaaaaaaa";
    }


}
?>
