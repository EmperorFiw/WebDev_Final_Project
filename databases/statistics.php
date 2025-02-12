<?php
declare(strict_types=1);
function getStatistics(int $eventID) {
    $db = new db();
    $conn = $db->getConnection();
    
    $query = "SELECT age, gender FROM history WHERE eID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $eventID);
    $stmt->execute();
    $result = $stmt->get_result();

    // ตัวแปรเก็บข้อมูล
    $ageData = [0, 0, 0, 0];  // อายุ: 0-18, 19-36, 37-50, 51+
    $genderData = [0, 0];      // เพศ: ชาย, หญิง

    // ประมวลผลข้อมูลที่ดึงมา
    while ($row = $result->fetch_assoc()) {
        $age = (int)$row['age'];
        if ($age <= 18) {
            $ageData[0]++;  // 0-18
        } elseif ($age <= 36) {
            $ageData[1]++;  // 19-36
        } elseif ($age <= 50) {
            $ageData[2]++;  // 37-50
        } else {
            $ageData[3]++;  // 51+
        }

        $gender = $row['gender'];
        if ($gender == 'Male') {
            $genderData[0]++;  // ชาย
        } elseif ($gender == 'Female') {
            $genderData[1]++;  // หญิง
        }
    }

    $tMem = array_sum($ageData);

    return [
        'ageData' => $ageData,
        'genderData' => $genderData,
        'totalMembers' => $tMem
    ];
}

