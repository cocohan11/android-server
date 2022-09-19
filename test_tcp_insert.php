<?php

    // iamhere스키마 말고 test_tcp스키마로 접속
    $db = mysqli_connect('iamhere.cdf5mmjsw63q.ap-northeast-2.rds.amazonaws.com', 'han', 'jo811275', 'test_tcp');
    if (!$db) //db접속되지 않는다면 echo로 상태알려줌
    {  
        echo "MySQL 접속 에러 : ";
        echo mysqli_connect_error();
        exit();  
    }  
    mysqli_set_charset($db,"utf8"); //한글안깨지려고?

    // 1. From 안드
    // 2. 쿼리 만들기 - insert문
    // 3. 쿼리 날리기
    // 4. 응답
    

    // 1. From 안드
    $roomName = $_POST['roomName']; // 방이름으로 방번호 알아내기

    if($roomName != null) {

            
        // 2. 쿼리 만들기 - select문
        
        $sql_insert = "INSERT INTO Users (name) VALUES ('$roomName')"; //방이름 중복체크

        
        // 3 쿼리 날리기
        $result=mysqli_query($db,$sql_insert); 

        // 4. 응답
        if ($result) {

            $id = mysqli_insert_id($db); // insert후 Primary key가져오는 함수
            echo json_encode(array("roomNum" => $id), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);

        } else {
            
            echo json_encode(array("roomNum" => '실패'), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
        }
    
    }






?>
