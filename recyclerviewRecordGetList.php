<?php
    include 'db.php'; //비밀번호 보호차원에서 include로 불러옴

    //ㅡㅡㅡㅡㅡㅡㅡ
    // 참여 명단
    //ㅡㅡㅡㅡㅡㅡㅡ

    

    // 1. From 안드
    $Room_no = $_POST['Room_no']; // 방번호로 명단 불러오기

    $sql_합 = "SELECT Room_no, U.UserNickName, U.UserImg
                FROM Users U JOIN RoomUser RU ON (U.UserEmail = RU.UserEmail)
                WHERE Room_no = '$Room_no'";


    $res=mysqli_query($db,$sql_합); //row추출하기
    $num = mysqli_num_rows($res); //같은 방이름 갯수


    // 배열 만들기
    $arr참여명단 = array(); //빈 배열을 만들어서 여기에 데이터를 담을거임


    //반복넣기
    while($row = mysqli_fetch_array($res)){ //row 한 줄 한 줄 반복해서 배열에 담는다.
    

        // if($row['UserImg'] == null) $row['UserImg'] ="img아직"; // 혹시 null이라 에러?
        array_push($arr참여명단, array( 'UserNickName'=>$row['UserNickName'],
                                        'UserImg'=>$row['UserImg'] ));


    }

    // echo json_encode(array("response" => $row['UserNickName']), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);

    if($num > 0) { // 혼자 등산한 경우도 있으니까 1이상

        echo json_encode($arr참여명단, JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    }









?>
