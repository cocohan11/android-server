<?php
    include 'db.php'; //비밀번호 보호차원에서 include로 불러옴


    //ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ
    // 방장!! ) 방을 퇴장/ 어플실행 중 강제종료) Room, RoomUser테이블 업뎃
    //ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ

    // 1. From 안드
    // 2. 쿼리에 넣을 데이터 생성
    // 3. 쿼리 만들기 - UPDATE문
    // 4. 쿼리 날리기
    // 5. 응답
    

    // 1. From 안드
    $Room_no = $_POST['Room_no']; //방번호와
    $UserEmail = $_POST['UserEmail']; //이메일로 업데이트할 row추출함

    
    // 2. 쿼리에 넣을 데이터 생성
        

    // 3. 쿼리 만들기 - UPDATE문
    $sql_룸유저=" UPDATE RoomUser 
            SET User_Delete_record = 1
            where Room_no = '$Room_no' and UserEmail = '$UserEmail' "; //등산시작시간 방정보에 업뎃


    // 4. 쿼리 날리기
    if (mysqli_query($db,$sql_룸유저)) { //DB에 시간추가가 성공하면 성공했다고 응답

        // 5. 응답
        echo json_encode(array("response" => "성공쓰"), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);

    } else {

        echo json_encode(array("response" => "폴스다"), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    }


?>
