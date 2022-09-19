<?php 

//수정 전 백업

    include 'db.php'; //비밀번호 보호차원에서 include로 불러옴

    //ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ
    // 1.닉네임 저장
    // 2.파일을 받아오고 원하는 폴더에 저장한다.
    // 3.기능명이 imgName은 사진과 닉네임 둘 다 db에 저장하고 기능명 onlyName은 닉네임만 저장하고 사진은 빈공간으로 남겨둔다.
    //ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ

    //안드로이드에서 사용자한테 받은 데이터
    $function = $_POST['ProfFunction']; //기능명 1.imgName 2.onlyName
    $email = $_POST['ProfEmail']; //사용자가 입력한 닉네임 : 모름
    $nickName = $_POST['ProfNickName']; //사용자가 입력한 닉네임 : 모름
    $data = $_POST['uploaded_file']; //통째로 post로 받음. 안에 여러개있음

    $따옴표제거function = preg_replace("/[\"\']/i", "", $function); //흑흑 쌍따옴표가 붙어서오는 것 때문에 if문이 ture가 아니었음.
    $따옴표제거email = preg_replace("/[\"\']/i", "", $email); 
    $따옴표제거nickName = preg_replace("/[\"\']/i", "", $nickName); 

    $imgUrl = 'http://15.164.129.103/profImg/'.$_FILES['uploaded_file']['name']; //내가 카톡처럼 사진띄우는 웹페이지를 만듦


    //프로필작성 저장(1.닉네임 2.사진)
    if($따옴표제거function == 'imgName') { //프로필작성한다는 변수가 담겨있으면 다음을 실행
        
        //1.닉네임 저장
        //닉네임을 저장한다. 응답은 true/false
        $sql="UPDATE Users SET UserNickName = '$따옴표제거nickName', UserImg ='$imgUrl' where UserEmail = '$따옴표제거email'"; //insert가 아니라 update를 해야했음

        if (mysqli_query($db,$sql)) { //이메일이 있다, true 응답을 보낸다.

            
            //2.사진파일 저장
            $uploads_dir="./profImg"; //저장할 폴더위치
            $file_path = "./"; //현재위치에서 저장할 폴더위치로 가기위한 경로
            $basename = basename($_FILES['uploaded_file']['name']);
            $file_path = $file_path . $basename; // ../han.jpg
            
            if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'],"../$uploads_dir/$file_path")) { //위치변경
                $response = 'true';

            } else { //여기해당
                $response = 'false파일저장위치변경실패'."../$uploads_dir/$file_path";
            }
            echo json_encode(array("response" => $response), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);


        } else { //이메일이 없다, false 응답을 보낸다.

            $response = 'false쿼리실패';
            echo json_encode(array("response" => $response), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
        }

    //프로필작성 저장(1.닉네임만)    
    } else if($따옴표제거function == 'onlyName') {

        $sql="UPDATE Users SET UserNickName = '$따옴표제거nickName' where UserEmail = '$따옴표제거email'"; //insert가 아니라 update를 해야했음

        if (mysqli_query($db,$sql)) { //저장 성공한다면..

            $response = 'true';
            echo json_encode(array("response" => $response), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
            
        } else { //쿼리 실패한다면

            $response = 'false';
            echo json_encode(array("response" => $response), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
        }
        
    } else {

        $response = 'false~~~';
        echo json_encode(array("response" => "어쩌구폴스임다"), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    }
    
    mysqli_close($db);  
    

    // 에러 "JSON document was not fully consumed."
    // 에러난 이유 : json_encode를 여러번 사용해서 얘가 json이 여러개 못 보낸거였음. 최종값 하나만 보내기.
    
    //파일을 안드로이드에 보낼 때 어떻게 보내지? url로 보는건가?
    //나의공간 만들 때 다시 여기서 코드작성하자


?>