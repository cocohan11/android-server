<?php
    include 'db.php'; //비밀번호 보호차원에서 include로 불러옴


    //ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ
    // 방장이 방을 만들고 등산시작버튼을 누르면 두 테이블에 쿼리를 날린다. 방 정보 and 방에 참여한 명단
    //ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ


    // 1. From 안드
    // 2. 쿼리에 넣을 데이터 생성
    // 3. 쿼리 만들기 - UPDATE문
    // 4. 쿼리 날리기
    // 5. 응답
    

    // 1. From 안드
    $Room_no = $_POST['startTracking']; //방번호로 분별
    $UserEmail = $_POST['UserEmail']; //방번호로 분별
    $Room_address = $_POST['Room_address']; //방번호로 분별


    // 2. 쿼리에 넣을 데이터 생성
    date_default_timezone_set('Asia/Seoul'); //한국시간기준
    $StartTrackingTime = date('Y-m-d h:i', time()); //소요시간 계산을 위해 시작시간 필요
    

    // 3. 쿼리 만들기 - UPDATE문
    $sql_룸=" UPDATE Room 
            SET Room_startDate = '$StartTrackingTime', Room_address ='$Room_address' 
            where Room_no = '$Room_no' "; //등산시작시간 업뎃

    // $sql_룸유저="INSERT INTO RoomUser(Room_no, UserEmail, StartTrackingTime) 
    //             VALUES('$Room_no', '$UserEmail','$StartTrackingTime')";

    $sql_룸유저update= " UPDATE RoomUser 
            SET StartTrackingTime = '$StartTrackingTime'
            where Room_no = '$Room_no' "; // 등산시작시간 업뎃

    // 4. 쿼리 날리기 (개)
    if (mysqli_query($db,$sql_룸) && mysqli_query($db,$sql_룸유저update) ) { //DB에 쿼리2개 다 성공해야 응답해줌

        // 5. 응답
        echo json_encode(array("response" => "성공이유 ...".$StartTrackingTime), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);

    } else {

        echo json_encode(array("response" => "실패유...".$sql_룸), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    }





?>