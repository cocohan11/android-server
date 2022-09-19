<?php
    include 'db.php'; //비밀번호 보호차원에서 include로 불러옴


    //ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ
    // 방장!! ) 방을 퇴장/ 어플실행 중 강제종료) Room, RoomUser테이블 업뎃
    //ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ
    // 주의!! ) 방장 개인 기록만 변경하기. 강제종료라고 나머지 참여자 기록을 변경하지 않기


    // 1. From 안드
    $Room_no = $_POST['Room_no']; //방번호로 row변별
    $UserEmail = $_POST['UserEmail']; //명단에 추가
    $Room_leadTime = $_POST['Room_leadTime']; //소요시간 "h시간 m분 s초"
    

    // 2. 쿼리에 넣을 데이터 생성
    date_default_timezone_set('Asia/Seoul'); //한국시간기준
    $Room_finishedDate = date('Y/m/d h:i', time()); //소요시간 계산을 위해 시작시간 필요
        

    // 3. 쿼리 만들기 - UPDATE문
    $sql_룸=" UPDATE Room 
            SET Room_activate = 0, Room_finishedDate = '$Room_finishedDate', Room_leadTime ='$Room_leadTime' 
            where Room_no = '$Room_no' "; //등산시작시간 방정보에 업뎃

    $sql_룸유저=" UPDATE RoomUser 
    SET FinishedTrackingTime = '$Room_finishedDate', leadTime ='$Room_leadTime' 
    where Room_no = '$Room_no' and UserEmail = '$UserEmail' "; // 방장에 대한 정보만 변경하기, 참여자는 exitTracking.php에서 변경함


    // 4. 쿼리 날리기
    if (mysqli_query($db,$sql_룸) && mysqli_query($db,$sql_룸유저)) { //DB에 시간추가가 성공하면 성공했다고 응답

        // 5. 응답
        echo json_encode(array("response" => "성공".$Room_leadTime), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);

    } else {

        echo json_encode(array("response" => "폴스".$Room_leadTime), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    }


?>

