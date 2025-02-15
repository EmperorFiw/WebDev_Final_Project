
<title>Home</title>
<form action="/home" method="POST">
    <div class="w-full grid grid-cols-3 gap-4 px-10 py-4">
        <div class="left">
            <h1 class="text-xl font-semibold">กิจกรรม</h1>
        </div>
        <div class="center flex items-center justify-end">
            <div class="relative w-full">
                <input type="text" name="keyword" placeholder="ค้นหากิจกรรม" class="px-4 py-2 bg-[#3E3E3E] rounded-lg text-white placeholder-white focus:outline-none focus:ring-2 focus:ring-white focus:border-white transition-all w-full pr-10">
                <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                    <i class="fas fa-search"></i>
                </span>
            </div>
        </div>
        <div class="right flex items-center space-x-2">
            <input type="date" name="date" class="px-4 py-2 bg-[#3E3E3E] rounded-lg text-white placeholder-white focus:outline-none focus:ring-2 focus:ring-white focus:border-white transition-all rounded-md pr-10">
            <button class="bg-[#301580] text-white px-4 py-2 rounded-2xl hover:bg-blue-600">ค้นหา</button>
        </div>
    </div>
</form>

<div class="mt-8">
    <div class="relative flex items-center px-10">
        <i class="fas fa-bullhorn text-xl text-[#B5CFF8] mr-2"></i>
        <span class="text-white text-lg">กิจกรรมทั้งหมดที่กำลังเผยแพร่</span>
    </div>
</div>
<div class="grid grid-cols-3 gap-4 mt-8 mb-10 px-10">
    <?php 
        if (!empty($data['not_found'])) {
            echo "<p class='text-white'>ไม่พบข้อมูล</p>";
        } else if (empty($data['data'])) {
            echo "<p class='text-white'>ขณะนี้ยังไม่มีกิจกรรม</p>";
        } else {
            foreach ($data['data'] as $event) {
    ?>
    <div class="bg-[#301580] rounded-lg shadow-lg p-4 flex text-white">
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
                <!-- Slider controls -->
                <button class="absolute top-1/2 left-2 transform -translate-y-1/2 text-red-500 text-3xl prevBtn">‹</button>
                <button class="absolute top-1/2 right-2 transform -translate-y-1/2 text-red-500 text-3xl nextBtn">›</button>
            </div>
        </div>
        
        <div class="pl-4 flex-grow">
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
                <form action="/event_details" method="POST">
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
