<?php 

    include 'db.php'; //비밀번호 보호차원에서 include로 불러옴

    //ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ
    //이메일 조회 후 값있는지
    //있으면 
        //'로그인' 응답 
    //없으면
        //회원가입하기. insert문으로 email,pw삽압
        //'회원가입' 응답
    //ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ

    //안드로이드에서 사용자한테 받은 데이터
    $email = $_POST['UserEmail']; //로그인하려 입력한 이메일
    $pw = $_POST['UserPwd']; //로그인하려고 입력한 비번
    $nickname = $_POST['UserNickName']; //닉네임 update
    $img = $_POST['UserImg']; //프사 update


    //query로 이메일 있는지 조회
    $sql="select * from Users where UserEmail = '$email'"; //이메일에 대한 해싱된 비번 셀렉트 후 사용자입력값과 동일한지 확인하기
    $result=mysqli_query($db,$sql); //접속해서 받아온 값
    $num = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);
    $date = $row['CreateDate']; //기존가입일
    $이미지 = $row['UserImg']; 
    $닉네임 = $row['UserNickName'];
    
    if ($num > 0) //이메일 있음
    {
        //로그인(update)
        // $sql="UPDATE Users SET UserNickName = '$nickname', UserImg= '$img' where UserEmail = '$email'"; //오랜만에 로그인해도 해당 사진이 보이게끔 update해주기
        //바보 계속 update해주니까 닉네임이 변경되지
        echo json_encode(array("response" => "noQuery", "CreateDate" => "$date", "imgUrl" => "$이미지", "nickName" => "$닉네임" ), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);

        
    }
    else //이메일 없음
    {
        //회원가입(insert)
        $date = date('Y/m/d h:i:s a', time());
        $sql="INSERT INTO Users(UserEmail, UserPwd, UserNickName, UserImg, CreateDate) VALUES('$email', '$pw','$nickname','$img', '$date')";

        if(mysqli_query($db,$sql)){
            echo json_encode(array("response" => "insert", "CreateDate" => "$date"), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);

        } else {
            echo json_encode(array("response" => "폴스insert"), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
        }

    }
    
    mysqli_close($db);  

?>