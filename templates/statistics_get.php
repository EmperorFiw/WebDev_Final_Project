<div class="statistics grid grid-cols-1 items-center justify-items-center min-h-[90vh]">
    <?php if ($data['allMember'] > 0): ?>
    <h1 class="text-3xl text-left w-full text-white px-10">สถิติผู้เข้าร่วม</h1> 
    <div class="all-mem flex flex-col items-center justify-center space-y-4 h-auto flex-none mt-6">
        <h1 class="text-3xl text-white text-center">สถิติโดยรวม</h1>
        <h1 class="text-2xl text-white text-center"><?= $data['allMember'] ?> คน</h1>
    <?php else: ?>
    <div class="all-mem flex flex-col items-center justify-center space-y-4 h-auto flex-none">
        <h1 class="text-2xl text-white text-center">ไม่มีข้อมูลผู้เข้าร่วม</h1>
    <?php endif; ?>
</div>


    <?php if ($data['allMember'] > 0): ?>
    <div class="st-con flex flex-col md:flex-row justify-evenly w-full gap-4 mt-6">
        <div class="st-l flex flex-col items-center justify-center space-y-1">
            <h1 class="text-center text-2xl text-white">สถิติอายุ</h1>
            <div class="w-[400px] h-[400px]">
                <canvas id="ageChart" width="400" height="400"></canvas>
            </div>
        </div>
        <div class="st-r flex flex-col items-center justify-center space-y-1">
            <h1 class="text-center text-2xl text-white">สถิติเพศ</h1>
            <div class="w-[400px] h-[400px]">
                <canvas id="genderChart" width="400" height="400"></canvas>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let ageData = <?php echo json_encode($data['ageData']); ?>;
    let genderData = <?php echo json_encode($data['genderData']); ?>;

    document.addEventListener("DOMContentLoaded", function () {
        const ageCtx = document.getElementById("ageChart").getContext("2d");
        new Chart(ageCtx, {
            type: "pie",
            data: {
                labels: ["0-18", "18-36", "36-50", "50+"],
                datasets: [{
                    data: ageData,
                    backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56", "#4CAF50"]
                }]
            },
            options: {
                responsive: false, // ใช้ขนาด canvas ตามที่ระบุไว้
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        labels: { color: "white" }
                    }
                }
            }
        });

        const genderCtx = document.getElementById("genderChart").getContext("2d");
        new Chart(genderCtx, {
            type: "pie",
            data: {
                labels: ["ชาย", "หญิง"],
                datasets: [{
                    data: genderData,
                    backgroundColor: ["#42A5F5", "#FF4081"]
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        labels: { color: "white" }
                    }
                }
            }
        });
    });
</script>