<?php
    include 'db.php'; //비밀번호 보호차원에서 include로 불러옴

    //ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ
    // 방장!! ) 어플종료 후 들어왔지만 이미 방은 없어진상태에서 끝난시간을 업뎃함
    //ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ

    // 1. From 안드
    // 2. 쿼리에 넣을 데이터 생성
    // 3. 쿼리 만들기 - UPDATE문
    // 4. 쿼리 날리기
    // 5. 응답
    

    // 1. From 안드
    $Room_no = $_POST['Room_no']; //방번호로 row변별
    $UserEmail = $_POST['UserEmail']; //명단에 추가
    $Room_finishedDate = $_POST['Room_finishedDate']; //방이 종료된 시간(날짜)
    $Room_leadTime = $_POST['Room_leadTime']; //소요시간 "h시간 m분 s초"
    

    // 2. 쿼리에 넣을 데이터 생성



    // 3. 쿼리 만들기 - UPDATE문 2개
    $sql_룸=" UPDATE Room 
            SET Room_activate = 0, Room_finishedDate = '$Room_finishedDate', Room_leadTime ='$Room_leadTime' 
            where Room_no = '$Room_no' "; //등산시작시간 업뎃

    $sql_룸유저="SET SQL_SAFE_UPDATES = 0;
            UPDATE RoomUser 
            SET FinishedTrackingTime = '$Room_finishedDate', leadTime ='$Room_leadTime' 
            where Room_no = '$Room_no' and UserEmail = '$UserEmail'; 
            SET SQL_SAFE_UPDATES = 1;"; //등산시작시간 업뎃
            //set sql_safe_updates=0; : 안전모드 해제(키로 업데이트하라고 에러나서 괜찮다는 쿼리문을 집어넣음)
    


    // 4. 쿼리 날리기
    if (mysqli_query($db,$sql_룸유저)) { //DB에 시간추가가 성공하면 성공했다고 응답

        // 5. 응답
        echo json_encode(array("response" => "sql_룸유저 성공"), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);

    } else {

        echo json_encode(array("response" => "ㄴㄴㄴ실패"), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    }


?>
