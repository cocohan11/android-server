<?php
    include 'db.php'; //비밀번호 보호차원에서 include로 불러옴

    //어플 껐다가 다시 켜도 마커가 보이게끔
    //마커 위도경도 값을 어플에 보내주기


    // 1. From 안드
    // 2. 쿼리에 넣을 데이터 생성
    // 3. 쿼리 만들기
    // 4. 쿼리 날리기
    // 5. 응답
    

    // 1. From 안드
    $방번호 = $_POST['Room_no']; //방번호가 쉐어드에 저장되어있어서 꺼져도 꺼내서 서버로 받을 수 있음
              
    
    // 2. 쿼리에 넣을 데이터 찾기
    $sql_select="select * from RouteMarker where Room_no = '$방번호'"; //해당 방에 찍힌 마커들이 조회됨 (0~20개)
    // $sql_select="select * from RouteMarker where Room_no = '$방번호'"; //해당 방에 찍힌 마커들이 조회됨 (0~20개)
    $result=mysqli_query($db,$sql_select); //방이름 중복체크
    $num = mysqli_num_rows($result); //경로마커 갯수가 1개 이상이면 배열보내기
    


    $위도리스트 = array(); //mysqli_fetch_array()로 값을 배열에 대입한다. 
    $경도리스트 = array(); 

    while($row = mysqli_fetch_array($result)) {
        
        array_push($위도리스트, $row['Lat']);
        array_push($경도리스트, $row['Lng']);
        
    }

    $위도리스트 = json_encode($위도리스트);
    $경도리스트 = json_encode($경도리스트);

    
    echo json_encode(array("arrLat" => "$위도리스트", "arrLng" => "$경도리스트"), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE); //test



?>
