<?php
declare(strict_types=1);

class Statistic {
    private $db;
    public function __construct() {
        $this->db = new DB();
    }
    public function getStatistics(int $eventID): array {
        $conn = $this->db->getConnection();
        
        $query = "SELECT age, gender FROM history WHERE eID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $eventID);
        $stmt->execute();
        $result = $stmt->get_result();
    

        $ageData = [0, 0, 0, 0];
        $genderData = [0, 0]; 
    
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
            if ($gender == 'ชาย') {
                $genderData[0]++;  // ชาย
            } elseif ($gender == 'หญิง') {
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

}

