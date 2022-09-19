<?php 

    include 'db.php'; //비밀번호 보호차원에서 include로 불러옴

    //선별하기 위해 서버로 보내온 기능명
    //1.emailCertify : 이메일중복체크
    //2.joinDone : 최종 회원가입
    //3.nickName : 닉네임 저장

    //안드로이드에서 받아온 데이터를 사용하기 좋게 변수에 담음
    $email = $_POST['JoinEmail']; //android에서 보내온 값
    $pw = $_POST['JoinPW']; //최종회원가입할 때 insert함
    // $nickName = $_POST['JoinNickName']; //해당email에 닉네임 저장
    $function = $_POST['JoinFunction']; //해당email에 닉네임 저장

    //1.emailCertify : 이메일중복체크
    if($function == 'emailCertify') { //pw값이 'pw'이면 그냥 이메일중복체크

        $sql="select * from Users where UserEmail = '$email'"; //이메일 중복확인
        $result=mysqli_query($db,$sql); //접속해서 받아온 값
        $num = mysqli_num_rows($result);
    
        if ($num == 0) {
    
            $response = 'false';
            echo json_encode(array("response" => $response, "sentence" => "해당 이메일로 인증번호를 보냈습니다."), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
            
        } else {
            
            $response = 'true';
            echo json_encode(array("response" => $response, "sentence" => "이미 존재하는 이메일입니다."), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
        }

    //2.joinDone : 최종 회원가입
    } else if($function == 'joinDone') { //pw값이 'pw'가 아닌 다른 문자열이면 쿼리문 insert

        // $pw = "2fj";
        $해시pw = password_hash($pw, PASSWORD_DEFAULT); //비번암호화
        date_default_timezone_set('Asia/Seoul'); //date함수 사용전 에러방지
        $date = date('Y/m/d h:i:s a', time());
        // echo $해시pw;

        $sql="INSERT INTO Users(UserEmail,UserPwd,CreateDate) VALUES('$email', '$해시pw', '$date')";
        
        if(mysqli_query($db,$sql)){ //쿼리받아온걸 if문안에 넣어서 true라면 원하는 코드를 실행함
            
            $response = 'true';
            echo json_encode(array("response" => $response), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
            
        } else {
            
            $response = 'false';
            echo json_encode(array("response" => $response), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
        }

    //3.nickName : 닉네임 저장
    }
    //  else if($function == 'nickName') { //3가지경우 중에 원하는 프로필작성란만 닉네임변수에 값을 넣어서 서버로 보냈음
    //     //닉네임을 저장한다. 응답은 true/false

    //     $sql="UPDATE Users SET UserNickName = '$nickName' where UserEmail = '$email'"; //insert가 아니라 update를 해야했음

    //     if (mysqli_query($db,$sql)) { //이메일이 있다, true 응답을 보낸다.

    //         $response = 'true';
    //         echo json_encode(array("response" => $response), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
              
    //     } else { //이메일이 없다, false 응답을 보낸다.

    //         $response = 'false';
    //         echo json_encode(array("response" => $response), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
         
    //     }
    // }


    mysqli_close($db);  

?>