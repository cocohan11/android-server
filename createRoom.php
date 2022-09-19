<?php
    include 'db.php'; //비밀번호 보호차원에서 include로 불러옴


    // 1. From 안드
    // 2. 쿼리에 넣을 데이터 생성
    // 3. 쿼리 만들기 - insert문
    // 4. 쿼리 날리기
    // 5. 응답
    

    // 1. From 안드
    $Room_name = $_POST['Room_name']; //방장이 만든 방이름
    $Room_pw = $_POST['Room_pw']; //방장이 설정한 방비번
    $Room_president_email = $_POST['Room_president_email']; //방장 이메일(방장누군지 설정)


    // 2. 쿼리에 넣을 데이터 생성
    // $Room_startDate = date('Y/m/d h:i:s a', time()); // 방생성 직후엔 필요없음
    $Room_activate = true;


    // 3. 쿼리 만들기 - select, insert문
    $sql_select="select * from Room where Room_name = '$Room_name' and Room_activate = '1' "; //방이름 중복체크
    $sql_insert="INSERT INTO Room(Room_name, Room_pw, Room_president_email, Room_activate) VALUES('$Room_name', '$Room_pw','$Room_president_email', '$Room_activate')";

    
    // 4. 쿼리 날리기
    $result=mysqli_query($db,$sql_select); //방이름 중복체크
    $num = mysqli_num_rows($result); //같은 방이름 갯수


    if ($num == 0) { //0개면 진행(방생성, 활성화라는 뜻의 1응답)

        if (mysqli_query($db,$sql_insert)) { //방 추가함

            // 5. 방번호 알아내기
            $res = mysqli_query($db,$sql_select); //방을 추가했으니 1개 나올거임
            $row = mysqli_fetch_array($res);
            $Room_no = $row['Room_no']; //방넘버 겟
            $방장이멜 = $row['Room_president_email']; //방넘버 겟


            // 7. 응답
            // 응답값으로 Room_activate가 true/false인지 알려주어야 나왔다가 재접속했을 때 해당 방에 그대로 들어갈 수 있음
            echo json_encode(array("Room_no" => "$Room_no", "Room_activate" => "$Room_activate"), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    

            // 방장도 명단에 추가하기
            $sql_명단추가="INSERT INTO RoomUser(Room_no, UserEmail) VALUES('$Room_no', '$방장이멜')";
            mysqli_query($db,$sql_명단추가);


        } else {
    
            echo json_encode(array("Room_no" => "트루select, 폴스insert"), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
        }

    } else {
        
        echo json_encode(array("Room_no" => "폴스select, insert"), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    }











?>
