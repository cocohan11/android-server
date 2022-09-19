<?php
    include 'db.php'; //비밀번호 보호차원에서 include로 불러옴


    //ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ
    // 참여자가 명단에 추가된다.
    //ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ


    // 1. From 안드
    // 2. 쿼리에 넣을 데이터 생성
    // 3. 쿼리 만들기 - UPDATE문
    // 4. 쿼리 날리기
    // 5. 응답
    

    // 1. From 안드
    $Room_no = $_POST['Room_no']; 
    $UserEmail = $_POST['UserEmail']; //방번호로 분별


    // 3. 쿼리 만들기 - UPDATE문
    $sql_룸유저="INSERT INTO RoomUser(Room_no, UserEmail) 
                VALUES('$Room_no', '$UserEmail')";


    // 4. 쿼리 날리기 (2개)
    if (mysqli_query($db,$sql_룸유저)) { 

        // 5. 응답
        echo json_encode(array("response" => "성공~ ..."), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);

    } else {

        echo json_encode(array("response" => "$sql_룸유저"), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    }





?>