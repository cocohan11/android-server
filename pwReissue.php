<?php 

    include 'db.php'; //비밀번호 보호차원에서 include로 불러옴

    //ㅡㅡㅡㅡㅡㅡ회원탈퇴ㅡㅡㅡㅡㅡㅡㅡ
    //email로 조회하여 delete함
        //쿼리 결과가 성공이면
            //response:true
        //쿼리 결과가 실패면
            //response:false
    //ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ

    //ㅡㅡㅡㅡㅡㅡ비번변경ㅡㅡㅡㅡㅡㅡㅡ
    //pw자리에 update하기 
        //쿼리 결과가 성공이면
            //response:true
        //쿼리 결과가 실패면
            //response:false
    //ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ
        
    //안드로이드에서 사용자한테 받은 데이터
    $email = $_POST['UserEmail']; //로그인하려 입력한 이메일
    $pw = $_POST['UserPwd']; //이메일로 받은 5자리 임시비밀번호

    //비밀번호 hasing해서 저장하기
    $해시pw = password_hash($pw, PASSWORD_DEFAULT); //비번암호화

    //탈퇴
    if($pw == '탈퇴') { //안드 회원탈퇴기능에선 pw에 문자열로 '탈퇴'라고 실려보냄

        $sql="DELETE FROM Users WHERE UserEmail = '$email' "; //insert가 아니라 update를 해야했음
        
        //db DELETE 성공
        if(mysqli_query($db,$sql)){

            $response = 'true';
            echo json_encode(array("response" => $response), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
        }
        else //db DELETE 실패
        {
            $response = 'false';
            echo json_encode(array("response" => $response), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
        }

    //비번변경
    } else {

        //pw자리에 update하기
        $sql="UPDATE Users SET UserPwd = '$해시pw' where UserEmail = '$email' "; //insert가 아니라 update를 해야했음

        //db update 성공
        if(mysqli_query($db,$sql)){

            $response = 'true';
            echo json_encode(array("response" => $response), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
        }
        else //db update실패
        {
            $response = 'false';
            echo json_encode(array("response" => $response), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
        }
    }


    mysqli_close($db);  

?>