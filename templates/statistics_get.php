
<title>สถิติอายุและเพศ</title>
<div class="statistics grid grid-cols-1 items-center justify-items-center min-h-[90vh]">
    <h1 class="text-3xl text-left w-full text-white">สถิติผู้เข้าร่วม</h1> 

    <div class="all-mem flex flex-col items-center justify-center space-y-0 h-auto flex-none">
        <h1 class="text-3xl text-white">สถิติโดยรวม</h1>
        <h1 class="text-2xl text-white"><?= $data['allMember']?> คน</h1>
    </div>

    <div class="st-con flex justify-evenly w-full gap-4">
        <div class="st-l w-1/2 flex flex-col items-center justify-center space-y-1">
            <h1 class="text-center text-2xl text-white">สถิติอายุ</h1>
            <canvas id="ageChart"></canvas>
        </div>
        <div class="st-r w-1/2 flex flex-col items-center justify-center space-y-1">
            <h1 class="text-center text-2xl text-white">สถิติเพศ</h1>
            <canvas id="genderChart"></canvas> 
        </div>
    </div>
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
                responsive: false,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: "white"
                        }
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
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: "white"
                        }
                    }
                }
            }
        });
    });
</script>


