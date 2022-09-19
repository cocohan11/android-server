<?php 

    include 'db.php'; //비밀번호 보호차원에서 include로 불러옴

    //ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ
    //이메일 조회 후 값있는지
    //있으면 
        //비번비교해서 일치하는지 확인 
            //일치하면
                //response:true
            //불일치
                //response:false
    //없으면
        //response:false
    //ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ

    // $비번 = '123123a';
    // $해시pw = password_hash($비번, PASSWORD_DEFAULT); //비번암호화
    // echo "pw : ".$비번;
    // echo "\n해시pw : ".$해시pw;

    // if(password_verify($비번, $해시pw)) {
    //     echo 'success';
    // } else {
    //     echo 'fail';
    // }

        
    //안드로이드에서 사용자한테 받은 데이터
    $email = $_POST['UserEmail']; //로그인하려 입력한 이메일
    $pw = $_POST['UserPwd']; //로그인하려고 입력한 비번

    //query로 이메일 있는지 조회
    $sql="select * from Users where UserEmail = '$email'"; //이메일에 대한 해싱된 비번 셀렉트 후 사용자입력값과 동일한지 확인하기
    $result=mysqli_query($db,$sql); //접속해서 받아온 값
    $num = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);
    $hash = $row['UserPwd']; //해당 이메일에 대한 pw(hash). 이 값을 사용자가 보낸값이랑 비교할거임
    $Date = substr($row['CreateDate'],0,10);  //ex)2022/04/24 09:16:18 pm -> 2022/04/24
    $nickName = $row['UserNickName'];
    $imgUrl = $row['UserImg'];

    $pw일치 = password_verify($pw, $hash); //password_hash()로 암호화한 비밀번호가 사용자가 입력한 값과 같은지 확인하는 함수

    
    if ($num > 0) //이메일 있음
    {
        //비번이 일치한다면 로그인 true로 응답
        echo json_encode(array("CreateDate" => $Date,  "response" => $pw일치, "imgUrl" => $imgUrl,"nickName" => $nickName) //pw일치:true/false
        , JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);

    }
    else //이메일 없음
    {
        //비번이 일치한지 않는다면 로그인 false로 응답
        echo json_encode(array("CreateDate" => $Date,  "response" => "폴스다"), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    }
    
/*
    if($result){  //결과값이 있다면 실행하는 코드
    
        $row = mysqli_fetch_array($result);
        $data['UserNickName'] = $row[3]; //data라는 배열에 UserEmail이란 key값에 row[0]번째 값을 할당한다.
        // $data = mysqli_fetch_array($result);
        // while($row = mysqli_fetch_array($result)) {
            // array_push($data, array('UserEmail'=>$row[1])); //data라는 배열에 UserEmail이란 key값에 row[0]번째 값을 할당한다. 
        //해당 컬럼을 모두 꺼내야 while문을 탈출함

        header('Content-Type: application/json; charset=utf8'); 
        //header함수 : 가공하지 않은 http헤더를 송신(주의: header함수 전에 출력함수를 사용하면 안됨)
        //여기선 content-type을 text/html이 아닌 application/json형태로 바꾸기위함인듯

        // $json = json_encode(array("webnautes"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE); 
        //webnaues가 이 데이터의 이름이 되는듯.. 모르겠지만 넘어가자
        $json = json_encode($data, JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE); 
        echo $json;

    } else{  //결과값이 없다면 실행되는 코드
        echo "SQL문 처리중 에러 발생 : "; 
        echo mysqli_error($db);
    } 
*/
    mysqli_close($db);  


?>