<?php
    include 'db.php'; //비밀번호 보호차원에서 include로 불러옴

    //ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ
    // 방장!! ) 위치공유방 참여 기록을 조회한다. 응답값으로 배열을 보낸다?
    //ㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡㅡ

    // 1. From 안드
    // 2. 이메일로 RoomUser테이블에서 방번호들 조회 (여러개일거임) : JOIN select문
    // 3. 쿼리 날리기
    // 4. 위치공유방에 참여한 횟수 확인
    // 5. 응답
    

    // 1. From 안드
    $UserEmail = $_POST['UserEmail']; //명단에 추가  /ok
    $Selected_YYYY = $_POST['Selected_YYYY']; //지정한 년도
    $Selected_M = $_POST['Selected_M']; //지정한 월에 대한 자료만 보내라


    // 원하는 데이터로 만들기
    if($Selected_M=="1"||$Selected_M=="3"||$Selected_M=="5"||$Selected_M=="7"||$Selected_M=="8"||$Selected_M=="10"||$Selected_M=="12") {
        $끝일30또는31일 = "31";

    }else if($Selected_M == "2") {
        $끝일30또는31일 = "28";

    } else {
        $끝일30또는31일 = "30";
    } //월에 따라 일수가 다른데 31로 통일하면 에러남


    $지정1일 = $Selected_YYYY."-".$Selected_M."-01";  // "2022-07-01"
    $지정nn일 = $Selected_YYYY."-".$Selected_M."-".$끝일30또는31일; // "2022-07-31", 끝일은 월마다 다름
    

    $시작일추출 = "date_format(StartTrackingTime, '%y.%m.%d  %H시 %i분')"; //"분"까지만 보고싶어서 조작
    $종료일추출 = "date_format(FinishedTrackingTime, '%y.%m.%d  %H시 %i분')";

    // $시작일추출 = "date_format(Room_startDate, '%y.%m.%d  %H시 %i분')"; //"분"까지만 보고싶어서 조작
    // $종료일추출 = "date_format(Room_finishedDate, '%y.%m.%d  %H시 %i분')";


    // 2. 쿼리 만들기 - 두 테이블의 공통된 방번호를 추출. [ Room + RoomUser ]테이블

    // $sql_조인select = "SELECT * FROM RoomUser
    //                    WHERE UserEmail = '$UserEmail' and FinishedTrackingTime is not null and User_Delete_record is not true                     
    //                    and StartTrackingTime > '$지정1일' and StartTrackingTime < '$지정nn일'
    //                    ORDER BY Room_no DESC";


    // $sql_조인select= "SELECT RU.Room_no, UserEmail, Room_name, $시작일추출, $종료일추출, Room_leadTime, Room_address, Room_mapCapture
    //                 FROM Room R JOIN RoomUser RU ON (R.Room_no = RU.Room_no)
    //                 WHERE UserEmail = '$UserEmail' and Room_finishedDate is not null and User_Delete_record is not true
    //                 and Room_startDate > '$지정1일' and Room_startDate < '$지정nn일' 
    //                 ORDER BY RU.Room_no DESC"; //내림차순(최신정보가 위로 오게), 날짜지정은 부등호로

    // $sql_조인select= "SELECT RU.Room_no, UserEmail, Room_name, $시작일추출, $종료일추출, RU.leadTime, Room_address, Room_mapCapture
    //                     FROM Room R JOIN RoomUser RU ON (R.Room_no = RU.Room_no)
    //                     WHERE UserEmail = '$UserEmail' and Room_finishedDate is not null and User_Delete_record is not true
    //                     and Room_startDate > '$지정1일' and Room_startDate < '$지정nn일' 
    //                     ORDER BY RU.Room_no DESC"; //내림차순(최신정보가 위로 오게), 날짜지정은 부등호로
    $sql_조인select= "SELECT RU.Room_no, UserEmail, Room_name, $시작일추출, $종료일추출, RU.leadTime, Room_address, Room_mapCapture
                        FROM Room R JOIN RoomUser RU ON (R.Room_no = RU.Room_no)
                        WHERE UserEmail = '$UserEmail' and FinishedTrackingTime is not null and User_Delete_record is not true
                        and Room_startDate > '$지정1일' and Room_startDate < '$지정nn일' 
                        ORDER BY RU.Room_no DESC"; //내림차순(최신정보가 위로 오게), 날짜지정은 부등호로

    // echo json_encode($지정nn일, JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE); //test


    // 3. 쿼리 날리기
    $result=mysqli_query($db,$sql_조인select); //row추출하기
    $num = mysqli_num_rows($result); //위치공유방에 참여한 횟수


    // 배열 만들기
    $arr위치공유참여기록 = array(); //빈 배열을 만들어서 여기에 데이터를 담을거임


    // 4. 위치공유방에 참여한 횟수 확인
    if($num > 0) { //조회되는 data가 있으면 응답하기. 처음 이용하는 사람은 없을 수도 있으니까.


        while($row = mysqli_fetch_array($result)){ //row 한 줄 한 줄 반복해서 배열에 담는다.


            $방번호 = $row['Room_no']; // 방번호에 참여한 사람들의 숫자를 센다. 
            $select_방인원 = "SELECT UserEmail 
                             FROM RoomUser
                             WHERE Room_no = $방번호 "; // UserEmail이 아니어도 상관없다. 

            $res = mysqli_query($db,$select_방인원); 
            $방참여인원 = mysqli_num_rows($res);
            // $방참여인원 = mysqli_num_rows($mysqli_query($db,$select_방인원)); // 쿼리문을 별도로 만들어 반복문 안에서 한 번 한 번 보낸다. 


            $Room_startEndTime = $row[$시작일추출]." ~ ".$row[$종료일추출]; //2022.3.18 14:34 ~ 2022.3.18 18:10


            array_push($arr위치공유참여기록, array(  'Room_mapCapture'=>$row['Room_mapCapture'], // 컬럼명 주의. 테이블 2개를 합쳤는데 같은 내용이라도 컬럼이름이 다름.. 다음엔 통일해야지
                                                    'Room_name'=>$row['Room_name'],
                                                    'Room_address'=>$row['Room_address'],
                                                    'Room_startEndTime'=>$Room_startEndTime,
                                                    'Room_leadTime'=>$row['leadTime'],
                                                    'Room_no'=>$방번호,
                                                    'peopleNum'=>$방참여인원 
                                                ));
        }

        $row = mysqli_fetch_array($res);

        echo json_encode($arr위치공유참여기록, JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
        // echo json_encode(array("Room_mapCapture" => $sql_조인select), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE); // test


    } else { //조회된게 없다.

        array_push($arr위치공유참여기록, array('Room_mapCapture'=>"없음")); //배열의 첫번째에 "없음"을 넣는다.
        echo json_encode($arr위치공유참여기록, JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);

    }

    
        //Json으로 받아서 키값으로 찾아내는 거잖아. 
        //우선 키밸류로 하려면 json이 필요..?
        //직렬화를 json으로 해서 키밸류 형태를 취함 -----Gson----- 역직렬화로 키를통해 밸류를 찾아냄
        //어레이로 감쌀필요없이 어레이를 만들 때 키밸류 형태를 취한 상태로 배열을 보낸다면? 똑같이 보내지 않을까?
        //보내기 직전에 하나, 미리하나 같으니까

?>
