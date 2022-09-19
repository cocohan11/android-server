<?php
    include 'db.php'; //비밀번호 보호차원에서 include로 불러옴

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
    

    $경로마커들 = array();
    
    while($row = mysqli_fetch_array($result)){ //row 한 줄 한 줄 반복해서 배열에 담는다.

        array_push($경로마커들, array('arrLat'=>$row['Lat'],
                                     'arrLng'=>$row['Lng'] ));
    }

    if($num > 0) {

        echo json_encode($경로마커들, JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    
    } else {

        array_push($경로마커들, array('Room_mapCapture'=>"없음")); //배열의 첫번째에 "없음"을 넣는다.
        echo json_encode($경로마커들, JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);

    }


?>
