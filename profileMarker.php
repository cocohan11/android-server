<?php 

    include 'db.php'; //비밀번호 보호차원에서 include로 불러옴

    //ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ
    // 프로필 변경 후 합성프사마커도 서버에 저장
    //ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ

    // From 안드
    $email = $_POST['ProfEmail']; // 이메일로 쿼리문 찾아내기
    $data = $_POST['uploaded_MarkerFile']; // 통째로 post로 받음. 안에 여러개있음. 
                                           // uploaded_MarkerFile이라는 이름으로 받아도 상관없을까?


    // 후 처리
    $따옴표제거email = preg_replace("/[\"\']/i", "", $email); 
    $MarkerimgUrl = 'http://15.164.129.103/profImg/'.$_FILES['uploaded_MarkerFile']['name']; // 내가 카톡처럼 사진띄우는 웹페이지를 만듦


    $sql = "UPDATE Users SET MarkerImg ='$MarkerimgUrl' where UserEmail = '$따옴표제거email'"; // 주의!! UserImg랑 헷갈림 

    if (mysqli_query($db,$sql)) { //이메일이 있다, true 응답을 보낸다.

        //2.사진파일 저장
        $basename = basename($_FILES['uploaded_MarkerFile']['name']); 
        $임시파일 = $_FILES['uploaded_MarkerFile']['tmp_name']; //임시저장파일의 이름
        $uploads_dir="../profImg/".$basename; //저장할 폴더위치 ../han.jpg
        $에러 = $_FILES["file"]["error"];
        

        if(move_uploaded_file($임시파일,$uploads_dir)) { //위치변경
            // $response = 'true';
            echo json_encode(array("response" => $MarkerimgUrl), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);

        } else { //파일 너무 큼(8MB 이상)
            // $response = 'false_사진8BM이상';

            // $response = 'false 파일저장위치변경 : '.$임시파일;
            // $response = "false 베스이네임 : ".$basename; // 20220523_170516.jpg
            // $response = "false 임시파일 : ".$임시파일." 에러 : ".$에러; // 낫띵
        }

        

    } else { //이메일이 없다, false 응답을 보낸다.

        $response = 'false쿼리실패';
        echo json_encode(array("response" => $response), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    }

    mysqli_close($db);  

?>