<?php 

    include 'db.php'; //비밀번호 보호차원에서 include로 불러옴

    //ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ
    // 1. 안드에서 사용자가 보낸 사진, 방번호 받기
    // 2. 쿼리로 저장할 DB 셀렉트
    // 3. 사진파일 저장
    // 4. 저장한 사진의 주소를 DB에 업뎃
    // 5. 응답
    //ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ

    // 1. 안드에서 t사용자가 보낸 사진, 방번호 받기
    $Room_no = $_POST['Room_no']; //Room_no로 식별해서 업뎃
    $data = $_POST['uploaded_file']; //통째로 post로 받음. 안에 여러개있음


    $따옴표제거Room_no = preg_replace("/[\"\']/i", "", $Room_no); //@Multipart는 따옴표까지 따라붙네
    $imgUrl = 'http://15.164.129.103/profImg/'.$_FILES['uploaded_file']['name']; //내가 카톡처럼 사진띄우는 웹페이지를 만듦


    $sql_select="select * from Room where Room_no = '$따옴표제거Room_no' and Room_activate = '1' "; //따옴표 제거된 방번호를 삽입해야 함
    $result=mysqli_query($db,$sql_select); 
    $num = mysqli_num_rows($result); //갯수가 1이어야 함



    // 2. 쿼리로 저장할 DB 셀렉트
    if ($num == 1) { //row가 1개면 저장, DB업뎃 진행


        
        // 3.사진파일 저장
        $basename = basename($_FILES['uploaded_file']['name']); 
        $임시파일 = $_FILES['uploaded_file']['tmp_name']; //임시저장파일의 이름  "/tmp/phpZDVA4u"
        $uploads_dir="../profImg/".$basename; //저장할 폴더위치 ../han.jpg
        $에러 = $_FILES["file"]["error"];


        if(move_uploaded_file($임시파일,$uploads_dir)) { //위치변경

            
            //저장한 사진의 주소를 Room테이블에 업뎃
            $sql_update=" UPDATE Room 
                        SET Room_mapCapture = '$imgUrl'
                        where Room_no = '$따옴표제거Room_no' and Room_activate = '1' "; 


            // 4. 쿼리 날리기
            if (mysqli_query($db,$sql_update)) { //DB에 시간추가가 성공하면 성공했다고 응답

                // 5. 응답
                echo json_encode(array("response" => "썸네일 저장 성공 : ".$imgUrl), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);

            } else {

                echo json_encode(array("response" => "sql_update 실패"), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
            }


        } else { //파일 너무 큼(8MB 이상)
            $response = 'false_사진8BM이상';

            // $response = 'false 파일저장위치변경 : '.$임시파일;
            // $response = "false 베스이네임 : ".$basename; // 20220523_170516.jpg
            // $response = "false 임시파일 : ".$임시파일." 에러 : ".$에러; // 낫띵
        }

    }


    // 에러 "JSON document was not fully consumed."
    // 에러난 이유 : json_encode를 여러번 사용해서 얘가 json이 여러개 못 보낸거였음. 최종값 하나만 보내기.
    
?>