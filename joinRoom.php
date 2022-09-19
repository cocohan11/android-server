<?php
    include 'db.php'; //비밀번호 보호차원에서 include로 불러옴

    //위치공유방에 참여자가 입장가능한지 물어보는 곳

    // 1. From 안드
    // 2. 쿼리에 넣을 데이터 생성
    // 3. 쿼리 만들기
    // 4. 쿼리 날리기
    // 5. 응답
    

    // 1. From 안드
    $Room_name = $_POST['Room_name']; //참여하려는 방 이름
    $Room_pw = $_POST['Room_pw']; //참여하려는 방의 비번
    $UserEmail = $_POST['UserEmail']; //참여하려는 방의 비번


    // 3. 쿼리 만들기 - select문
    $sql_select="select * from Room 
                where Room_name = '$Room_name' and Room_activate = '1' and Room_pw = '$Room_pw' "; //3개 해당되어야 함
                //방이름과 방비번 일치, 현재 활성화된 방인지 확인

    
    // 4. 쿼리 날리기
    $result=mysqli_query($db,$sql_select); //방이름 중복체크
    $row = mysqli_fetch_array($result);
    $방번호 = $row['Room_no']; //방넘버 겟
    $방장이멜 = $row['Room_president_email']; //방넘버 겟
    $num = mysqli_num_rows($result); //같은 방이름 갯수


    // 5. 방장 닉네임 알아내기
    $select="select * from Users where UserEmail = '$방장이멜' "; //방이름 중복체크

    $방장이름_결과 = mysqli_query($db,$select); 
    $방장row = mysqli_fetch_array($방장이름_결과);
    $방장닉넴 = $방장row['UserNickName']; //방장 닉넴 겟


    if ($num == 1) { //1개 나오면 응답으로 성공이라고하기

        // 5. 응답
        echo json_encode(array("response" => "$방번호", "UserNickName" => "$방장닉넴"), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    
        // 명단에 추가하기
        $sql_명단추가="INSERT INTO RoomUser(Room_no, UserEmail) VALUES('$방번호', '$UserEmail')";
        mysqli_query($db,$sql_명단추가);

    } else {
        
        echo json_encode(array("response" => "1개가아님"), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    }







?>
