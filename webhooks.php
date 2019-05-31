<?php
    //LB sent messaging
    #$accessToken = "2+kmr9U8Sxdh//ZfzYzBI6COrngOo8ly7dCDl0aOU3DzRiPs2W0uX7GkwnuidzyizfWMD8XjlOFn7K3AcncUQ+cH9ZV07Fh/bxq8Dd0HMrDHOZfz8JBq3slQCAjmcZtCJzKUbdCMmb/QhSm+BDyGYgdB04t89/1O/w1cDnyilFU=";//copy Channel access token ตอนที่ตั้งค่ามาใส่
    // ThaiFishingPort
    $accessToken = "bzoR1o7SGTiW08M+fEh2yZKE0uDh3sz+WAFn1tnD9jQgtb/ZTrB72dyRz31j2XgOd1T1WLdqBgWgvxXd0GwYPqWgQKxcSDlXQ9C5mTgKcNt2tK5E8ig/IooS/kl+uMRnquQ8lFBMArent3hDwpx52wdB04t89/1O/w1cDnyilFU=";//copy Channel access token ตอนที่ตั้งค่ามาใส่
    
    $content = file_get_contents('php://input');
    $arrayJson = json_decode($content, true);
    
    $arrayHeader = array();
    $arrayHeader[] = "Content-Type: application/json";
    $arrayHeader[] = "Authorization: Bearer {$accessToken}";
    

    //รับข้อความจากผู้ใช้
    $message = $arrayJson['events'][0]['message']['text'];
    //รับ id ของผู้ใช้ ใช้ส่งไป fisheries กับ function pushMsg
    $id = $arrayJson['events'][0]['source']['userId'];

    $request = "format=csv&by=member&rs=hour&rk=productivity&rb=".$month_first_date."&re=".$cur_date = date('Y-m-d');
    /*$urlWithoutProtocol = "http://fishlanding.fisheries.go.th/LbVmsErr/api/post/readTotalCheck.php?shipcode=".$message; 
    $isRequestHeader = FALSE;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $urlWithoutProtocol);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $followboat = array(); 
    $followboat = curl_exec($ch);
    

    curl_close($ch);*/
    if($message)
    {
    $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = $followboat;//"สวัสดีจ้าาา";//"สวัสดีจ้าาา";
        replyMsg($arrayHeader,$arrayPostData);
    }
   $id = $arrayJson['events'][0]['source']['userId'];
#ตัวอย่าง Message Type "Text"
    if($message == "สวัสดี"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = $message;//$followboat;//"สวัสดีจ้าาา";//"สวัสดีจ้าาา";
        replyMsg($arrayHeader,$arrayPostData);
    }
    else if($message == "กฎหมาย"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = "ก1 การขอทะเบียนและการรับจดทะเบียนท่าเทียบเรือประมง  https://drive.google.com/file/d/1yFb6XvuNVrRCGHsp4tZp7_qt2lel0KDF/view?usp=sharing";
        $arrayPostData['messages'][0]['text'] .= "  ก2 การขอทะเบียนและการรับจดทะเบียนท่าเทียบเรือประมงฉบับที่ 2 : https://drive.google.com/file/d/1JI8m_Btm5EyUTQ2O71gaOid2XAgRxULf/view?usp=sharing";
        $arrayPostData['messages'][0]['text'] .= "  ก3 แบบคำขอจดทะเบียนท่าเทียบเรือประมง : https://drive.google.com/file/d/1Eqghocn5wUr9itiWX8ESy3WzjYsgm4d0/view?usp=sharing";
        replyMsg($arrayHeader,$arrayPostData);
        /*$arrayPostData['to'] = $id;
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = "ทดสอบการส่งซ้ำ";
        pushMsg($arrayHeader,$arrayPostData);*/
    }
    #ตัวอย่าง Message Type "Sticker"
    else if($message == "ฝันดี"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "sticker";
        $arrayPostData['messages'][0]['packageId'] = "2";
        $arrayPostData['messages'][0]['stickerId'] = "46";
        replyMsg($arrayHeader,$arrayPostData);
    }
    else if(preg_match("/\*\d{12}\#/", $message)){
        //web service ไปที่ fisheries
        $portlicense = substr($message,1,12);
        $urlWithoutProtocol = "http://fishlanding.fisheries.go.th/auditport/webservice/regisnum.php?portlicense=".$portlicense."&lineid=".$arrayJson['events'][0]['source']['userId'];//.$messagejson; 
        $isRequestHeader = FALSE;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlWithoutProtocol);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $portdata = array(); 
        $portdata = curl_exec($ch);
        curl_close($ch);
        $portobjrecive = json_decode($portdata,false);
        //
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        if($portobjrecive->id == "1")
        {
        $arrayPostData['messages'][0]['text'] = "สวัสดีครับท่านผู้ประกอบการท่าเทียบเรือ:".$portobjrecive->port_name."  ทะเบียนท่า:".$portobjrecive->port_license;//"สวัสดีจ้าาา";
        }
        else if($portobjrecive->id == "2")
        {
        $arrayPostData['messages'][0]['text'] = "คุณได้แจ้งท่าเทียบเรือไว้แล้ว ท่าเทียบเรือ:".$portobjrecive->port_name."  ทะเบียนท่า:".$portobjrecive->port_license;//"สวัสดีจ้าาา";    
        }
        else
        {
        $arrayPostData['messages'][0]['text'] = "ไม่พบหมายเลขทะเบียนท่าเทียบเรือนี้ กรุณาทดสอบอีกครั้ง";
        }
        //$arrayPostData['messages'][0]['text'] = "userId:".$arrayJson['events'][0]['source']['userId']."/n ทะเบียนท่า:".substr($message,1,12);//"สวัสดีจ้าาา";
        replyMsg($arrayHeader,$arrayPostData);
    }

    else if(preg_match("/\#\d{12}\#/", $message)){
        //web service ไปที่ fisheries
        $portlicense = substr($message,1,12);
        $urlWithoutProtocol = "http://fishlanding.fisheries.go.th/auditport/webservice/updatenum.php?portlicense=".$portlicense."&lineid=".$arrayJson['events'][0]['source']['userId'];//.$messagejson; 
        $isRequestHeader = FALSE;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlWithoutProtocol);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, "1");
        $portdata = array(); 
        $portdata = curl_exec($ch);
        curl_close($ch);
        $portobjrecive = json_decode($portdata,false);
        //
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        if($portobjrecive->id == 1)
        {
        $arrayPostData['messages'][0]['text'] = "สวัสดีครับท่านผู้ประกอบการท่าเทียบเรือ:".$portobjrecive->port_name."  ทะเบียนท่า:".$portobjrecive->port_license;//"สวัสดีจ้าาา";
        }
        else
        {
        $arrayPostData['messages'][0]['text'] = "ไม่พบหมายเลขทะเบียนท่าเทียบเรือนี้ กรุณาทดสอบอีกครั้ง";
        }
        //$arrayPostData['messages'][0]['text'] = "userId:".$arrayJson['events'][0]['source']['userId']."/n ทะเบียนท่า:".substr($message,1,12);//"สวัสดีจ้าาา";
        replyMsg($arrayHeader,$arrayPostData);
    }
    #ตัวอย่าง Message Type "Image"
    else if($message == "รูปน้องแมว"){
        $image_url = "https://i.pinimg.com/originals/cc/22/d1/cc22d10d9096e70fe3dbe3be2630182b.jpg";
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "image";
        $arrayPostData['messages'][0]['originalContentUrl'] = $image_url;
        $arrayPostData['messages'][0]['previewImageUrl'] = $image_url;
        replyMsg($arrayHeader,$arrayPostData);
    }
    #ตัวอย่าง Message Type "Location"
    else if($message == "ที่อยู่"){
        //web service ไปที่ fisheries
        $urlWithoutProtocol = "http://fishlanding.fisheries.go.th/auditport/webservice/selectpoint.php?lineid=".$arrayJson['events'][0]['source']['userId'];//.$messagejson; 
        $isRequestHeader = FALSE;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlWithoutProtocol);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, "1");
        $portdata = array(); 
        $portdata = curl_exec($ch);
        curl_close($ch);
        $portobjrecive = json_decode($portdata,false);
        //
        if($portobjrecive->id == 1)
        {
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "location";
        $arrayPostData['messages'][0]['title'] = $portobjrecive->port_name;
        $arrayPostData['messages'][0]['address'] =   $portobjrecive->lat.",".$portobjrecive->long;
        $arrayPostData['messages'][0]['latitude'] = $portobjrecive->lat;
        $arrayPostData['messages'][0]['longitude'] = $portobjrecive->long;
        replyMsg($arrayHeader,$arrayPostData);
        }
        else
        {
        $arrayPostData['messages'][0]['text'] = "ไม่พบการลงทะเบียน กรุณาลงทะเบียนโดยการพิมพ์ เครื่องหมาย ดอกจันทร์ ตามด้วยเลขทะเบียนท่า และเครื่องหมายสี่เหลี่ยม และกดส่งเพื่อลงทะเบียน";       
        }
    }
    #ตัวอย่าง Message Type "Text + Sticker ใน 1 ครั้ง"
    else if($message == "ลาก่อน"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = "อย่าทิ้งกันไป";
        $arrayPostData['messages'][1]['type'] = "sticker";
        $arrayPostData['messages'][1]['packageId'] = "1";
        $arrayPostData['messages'][1]['stickerId'] = "131";
        replyMsg($arrayHeader,$arrayPostData);
    }
function replyMsg($arrayHeader,$arrayPostData){
        $strUrl = "https://api.line.me/v2/bot/message/reply";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$strUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);    
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arrayPostData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close ($ch);
    }

    function pushMsg($arrayHeader,$arrayPostData){
      $strUrl = "https://api.line.me/v2/bot/message/push";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$strUrl);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrayPostData));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      $result = curl_exec($ch);
      curl_close ($ch);
    }
   exit;
?>
