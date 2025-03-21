<?php
if (!empty($data['historyData']))
    $events_history = $data['historyData'];
else
    $events_history = [];
?>

<title>Home</title>
<form action="/home" method="POST">
    <div class="w-full flex flex-col md:flex-row justify-between items-center px-4 md:px-10 py-4 space-y-4 md:space-y-0">
        <div class="left">
            <h1 class="text-xl font-semibold">กิจกรรม</h1> 
        </div>
        <div class="center flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-2 w-full md:w-auto">
            <div class="relative w-full md:max-w-sm">
                <input type="text" name="keyword" placeholder="ค้นหากิจกรรม"
                    class="px-4 py-2 bg-[#3E3E3E] rounded-lg text-white placeholder-white focus:outline-none focus:ring-2 focus:ring-white focus:border-white transition-all w-full pr-10">
                <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                    <i class="fas fa-search"></i>
                </span>
            </div>
            <input type="date" name="date"
                class="px-4 py-2 bg-[#3E3E3E] rounded-lg text-white placeholder-white focus:outline-none focus:ring-2 focus:ring-white focus:border-white transition-all w-full md:w-auto pr-10">
                <span class="text-white">To</span>
            <input type="date" name="date2"
                class="px-4 py-2 bg-[#3E3E3E] rounded-lg text-white placeholder-white focus:outline-none focus:ring-2 focus:ring-white focus:border-white transition-all w-full md:w-auto pr-10">
            <button class="bg-[#301580] text-white px-4 py-2 rounded-2xl hover:bg-blue-600 w-full md:w-auto">ค้นหา</button>
        </div>
    </div>
</form> 
 
<!-- ประวัติเข้าร่วม  -->
<?php if (!empty($events_history) && !empty($_SESSION['username'])): ?>
<div class="container mx-auto px-4 md:px-10 mt-4 p-4 flex flex-col items-center">
    <!-- Table Header -->
    <table class="min-w-full table-auto border-collapse bg-white shadow-lg text-center">
        <thead>
            <tr class="bg-[#301580] text-white">
                <th class="px-4 md:px-6 py-3 text-start">กิจกรรมที่ขอเข้าร่วม</th>
                <th class="px-4 md:px-6 py-3">สถานะ</th>
            </tr>
        </thead>
        <tbody id="eventTableBody" class="bg-[#B5CFF8]">
            <!-- ข้อมูลตารางจะถูกเพิ่มที่นี่ -->
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-3 grid grid-cols-1 md:grid-cols-3 items-center w-full text-white">
        <div class="page text-lg text-start">
            <span id="pageNumber">หน้า <?= $data['currentPage'] ?></span>
            <span id="totalPages">จาก <?= $data['totalPages'] ?> หน้า</span>
        </div>

        <div></div> 

        <div class="flex justify-end gap-2 mt-4 md:mt-0">
            <button id="prevPage" class="bg-[#301580] text-white px-5 py-2 rounded-lg hover:bg-blue-700" disabled>
                ก่อนหน้า
            </button>
            <button id="nextPage" class="bg-[#301580] text-white px-5 py-2 rounded-lg hover:bg-blue-700">
                ถัดไป
            </button>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- ข้อมูลกิจกรรม  -->
<div class="mt-8">
    <div class="relative flex items-center px-4 md:px-10">
        <i class="fas fa-bullhorn text-xl text-[#B5CFF8] mr-2"></i>
        <span class="text-white text-lg">กิจกรรมทั้งหมดที่กำลังเผยแพร่</span>
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-8 mb-10 px-4 md:px-10">
    <?php 
        if (!empty($data['not_found'])) {
            echo "<p class='text-white'>ไม่พบข้อมูล</p>";
        } else if (empty($data['data'])) {
            echo "<p class='text-white'>ขณะนี้ยังไม่มีกิจกรรม</p>";
        } else {
            foreach ($data['data'] as $event) {
    ?>
    <div class="bg-[#301580] rounded-lg shadow-lg p-4 flex flex-col md:flex-row text-white">
        <div class="relative w-full h-[272px]">
            <div class="carousel relative">
                <div class="carousel-inner relative overflow-hidden w-full">
                        <?php
                            $images = explode(',', $event['image']); 
                            foreach ($images as $index => $image) {
                                $activeClass = ($index === 0) ? 'active' : ''; 
                        ?>
                        <div class="carousel-item <?= htmlspecialchars($activeClass); ?>">
                            <img src="<?= htmlspecialchars($image); ?>" alt="Image <?= $index + 1; ?>" class="w-full h-[282px] object-cover rounded-lg">
                        </div>
                        <?php } ?>
                </div>
  
                <button class="absolute top-1/2 left-2 transform -translate-y-1/2 text-red-500 text-3xl prevBtn">‹</button>
                <button class="absolute top-1/2 right-2 transform -translate-y-1/2 text-red-500 text-3xl nextBtn">›</button>
            </div>
        </div>
        
        <div class="pl-4 flex-grow mt-4 md:mt-0">
            <h3 class="text-xl font-semibold"><?= htmlspecialchars($event['event_name']); ?></h3>
            <?php
                $startTime = new DateTime($event['event_start_time']);
                $endTime = new DateTime($event['event_end_time']);
            ?>
            <p class="mt-4 text-sm">
                เวลา <?= $startTime->format('H:i') . " - " . $endTime->format('H:i'); ?>
            </p>
            <p class="mt-4 text-sm">เปิดรับสมัคร <?= htmlspecialchars($event['reg_start_date']); ?></p>
            <p class="mt-4 text-sm">จำนวนที่รับ <?= htmlspecialchars($event['capacity']); ?></p>
            <p class="mt-4 text-sm">ลงทะเบียนแล้ว <?= htmlspecialchars($event['registered']); ?></p>
            <div class="flex justify-center items-center mt-4">
                <form action="/event_details" method="GET">
                    <input type="hidden" name="eid" value="<?= $event['eid'] ?>">
                    <button class="mt-4 bg-[#151541] text-white px-4 py-2 rounded-lg hover:bg-blue-600">รายละเอียด</button>
                </form>
            </div>
        </div>
    </div>
    <?php 
            }
        }
    ?>
</div>
<script src="/assets/js/slide.js"></script>
<script>
const events_history = <?php echo json_encode($events_history); ?>;

let currentPage = 1;
const eventsPerPage = 5;

function renderTable() {
    const start = (currentPage - 1) * eventsPerPage;
    const end = start + eventsPerPage;
    const currentEvents = events_history ? events_history.slice(start, end) : [];

    const tableBody = document.getElementById("eventTableBody");
    tableBody.innerHTML = "";

    currentEvents.forEach(event => {
        const row = document.createElement("tr");
        row.classList.add("border-b");

        const nameCell = document.createElement("td");
        nameCell.classList.add("px-4", "py-2", "text-left", "text-black", "text-sm", "md:text-base");
        nameCell.textContent = event.event_name;
        row.appendChild(nameCell);

        const statusCell = document.createElement("td");
        statusCell.classList.add("px-4", "py-2", "text-center");

        const statusButton = document.createElement("button");
        statusButton.classList.add("w-full", "px-4", "py-2", "text-center", "rounded-2xl", "text-white", "text-sm", "md:text-base");

        let statusText, statusColor;
        switch (event.join_state) {
            case 0:
                statusText = "รอดำเนินการ";
                statusColor = "bg-yellow-500";
                break;
            case 1:
                statusText = "อนุมัติ";
                statusColor = "bg-green-500";
                break;
            case 2:
                statusText = "กิจกรรมจบแล้ว";
                statusColor = "bg-green-500";
                break;
            case 3:
                statusText = "ไม่ได้เข้าร่วม";
                statusColor = "bg-red-500";
                break;
            case 4:
                statusText = "ถูกปฏิเสธ";
                statusColor = "bg-red-500";
                break;
            default:
                statusText = "ไม่ทราบสถานะ";
                statusColor = "bg-gray-500";
        }

        statusButton.textContent = statusText;
        statusButton.classList.add(statusColor);

        statusCell.appendChild(statusButton);
        row.appendChild(statusCell);
        tableBody.appendChild(row);
    });

    document.getElementById("pageNumber").textContent = `หน้า ${currentPage}`;

    document.getElementById("prevPage").disabled = currentPage === 1;
    document.getElementById("nextPage").disabled = currentPage * eventsPerPage >= events_history.length;
}

document.getElementById("prevPage").addEventListener("click", () => {
    if (currentPage > 1) {
        currentPage--;
        renderTable();
    }
});

document.getElementById("nextPage").addEventListener("click", () => {
    if (currentPage * eventsPerPage < events_history.length) {
        currentPage++;
        renderTable();
    }
});

renderTable();
</script>
