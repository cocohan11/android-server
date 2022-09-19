<?php

    // iamhere스키마 말고 test_tcp스키마로 접속
    $db = mysqli_connect('iamhere.cdf5mmjsw63q.ap-northeast-2.rds.amazonaws.com', 'han', 'jo811275', 'test_tcp');
    if (!$db) //db접속되지 않는다면 echo로 상태알려줌
    {  
        echo "MySQL 접속 에러 : ";
        echo mysqli_connect_error();
        exit();  
    }  
    mysqli_set_charset($db,"utf8"); //한글안깨지려고?

    // 1. From 안드
    // 2. 쿼리 만들기 - insert문
    // 3. 쿼리 날리기
    // 4. 응답
    

    // 1. From 안드
    $showRoomList = $_POST['showRoomList']; //방목록 해달라는 파라미터...값이 꼭 하나는 있어야 된대서 추가함

    if($showRoomList != null) {

            
        // 2. 쿼리 만들기 - select문
        $sql_select="SELECT id, name FROM Users"; //방이름 중복체크

        
        // 3 쿼리 날리기
        $result=mysqli_query($db,$sql_select); //방이름 중복체크
        $num = mysqli_num_rows($result); //같은 방이름 갯수


        // 배열만들기 
        $arr방 = array(); //빈 배열을 만들어서 여기에 데이터를 담을거임

        // 4. 응답
        if ($num > 0) {

            while($row = mysqli_fetch_array($result)){ //row 한 줄 한 줄 반복해서 배열에 담는다.

                array_push($arr방, array('roomName'=>$row['name'],
                                        'roomNum'=>$row['id'] ));
            }

            echo json_encode($arr방, JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
        
        } else {
            
            echo json_encode($arr방, JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
        }
    
    }






?>
