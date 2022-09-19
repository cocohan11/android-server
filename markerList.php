<?php
    include 'db.php'; //비밀번호 보호차원에서 include로 불러옴

    //마커 위도경도 값 저장


    // 1. From 안드
    // 2. 쿼리에 넣을 데이터 생성
    // 3. 쿼리 만들기 - insert문
    // 4. 쿼리 날리기
    // 5. 응답
    

    // 1. From 안드
    $위도리스트 = array();
    $경도리스트 = array(); //array_push나 foreach를만들어 value를 사용하면 된다. 
    $위도리스트 = $_POST['MarkerLatList']; //_POST 자체가 List로 변하기 때문에 []로 안 받고 array변수를만들어서 그대로 담음
    $경도리스트 = $_POST['MarkerLngList']; 
    $방이름 = $_POST['roomName']; //방이름으로 방번호 찾을거임
              
    
    // 2. 쿼리에 넣을 데이터 찾기
    $sql_select="select * from Room where Room_name = '$방이름' and Room_activate = '1' "; //방의 넘버를 알아내기 위해 select문 날림
    $result=mysqli_query($db,$sql_select); //방이름 중복체크
    $num = mysqli_num_rows($result); //같은 방이름 갯수

    if($num == 1) $row = mysqli_fetch_array($result); //1개여야만 함

    $찾아낸방번호 = $row['Room_no']; //방이름으로 방번호 알아냈고 이제 마커테이블에 외래키로 만들거임

    

    // 복붙한거임
    // 이 형태로 리스트안에 있는 데이터 쿼리로 insert하기
    // 그 전에 테이블 컬럼부터 확인하기 이렇게 해도 되는건지..

    $i = 0; //경도인덱스를 사용하기 위한 숫자변수
    foreach ($위도리스트 as $value){

        $마커자연수 = $i+1; //마커에 삽입된 자연수 1~10


        $query = "INSERT INTO RouteMarker(Room_no, MarkerNum, Lat, Lng) 
                  VALUES('$찾아낸방번호', '$마커자연수','$value','$경도리스트[$i]')";
        $res=mysqli_query($db,$query);
        

        $i ++;
    }

    echo json_encode(array("response" => "$찾아낸방번호"), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE); //test






    // // 2. 쿼리에 넣을 데이터 생성
    // $Room_createDate = date('Y/m/d h:i:s a', time()); //소요시간 계산을 위해 시작시간 필요
    // $Room_activate = true;


    // // 3. 쿼리 만들기 insert문
    // $sql_insert="INSERT INTO Room(Room_name, Room_pw, Room_president_email, Room_createDate, Room_activate) VALUES('$Room_name', '$Room_pw','$Room_president_email','$Room_createDate', '$Room_activate')";


    // // 4. 쿼리 날리기
    // $result=mysqli_query($db,$sql_select); //방이름 중복체크
    // $num = mysqli_num_rows($result); //같은 방이름 갯수


    // // 5. 응답
    // // 응답값으로 Room_activate가 true/false인지 알려주어야 나왔다가 재접속했을 때 해당 방에 그대로 들어갈 수 있음
    // if (mysqli_query($db,$sql_insert)) {

    //     echo json_encode(array("response" => "$sql_select", "Room_activate" => "$Room_activate"), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);

    // } else {

    //     echo json_encode(array("response" => "트루select, 폴스insert"), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    // }





?>
