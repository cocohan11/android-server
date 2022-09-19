<?php
    include 'db.php'; //비밀번호 보호차원에서 include로 불러옴

    //방중복검사

    // 1. From 안드
    // 2. 쿼리에 넣을 데이터 생성
    // 3. 쿼리 만들기 - insert문
    // 4. 쿼리 날리기
    // 5. 응답
    

    // 1. From 안드
    $Room_name = $_POST['Room_name']; //방장이 만든 방이름
    $Room_pw = $_POST['Room_pw']; //방장이 설정한 방비번
    $Room_president_email = $_POST['Room_president_email']; //방장 이메일(방장누군지 설정)


    // 3. 쿼리 만들기 - select문
    $sql_select="select * from Room where Room_name = '$Room_name' and Room_activate = '1' "; //방이름 중복체크

    
    // 4. 쿼리 날리기
    $result=mysqli_query($db,$sql_select); //방이름 중복체크
    $num = mysqli_num_rows($result); //같은 방이름 갯수


    if ($num == 0) { //0개면 중복된 값 없으니 지도액티비티로 이동한다.

        echo json_encode(array("response" => "$num"), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
        

    } else {
        
        echo json_encode(array("response" => "중복된 값이잖아"), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    }







?>
