<title>Event Details</title>
<?php
if (isset($data['data']) && !empty($data['data'])):
    $event = $data['data'];
?>
<div class="mt-8">
    <div class="relative flex items-center px-10">
        <h1 class="text-2xl"><?= htmlspecialchars($event['event_name']) ?></h1>
    </div>
</div>
<div class="flex px-10 mt-8">
    <div class="bg-[#301580] rounded-lg shadow-lg flex text-white w-full">
        <div class="relative w-full h-[512px]">
            <div class="carousel relative">
                <div class="carousel-inner relative overflow-hidden w-full">
                    <?php
                        $images = explode(',', $event['image']); 
                        foreach ($images as $index => $image) {
                            $activeClass = ($index === 0) ? 'active' : ''; 
                    ?>
                    <div class="carousel-item <?= htmlspecialchars($activeClass); ?>">
                        <img src="<?= htmlspecialchars($image); ?>" alt="Image <?= $index + 1; ?>" class="w-full h-[512px] object-cover  rounded-lg">
                    </div>
                    <?php } ?>
                </div>
                <button type="button" id="prev" class="prevBtn absolute left-2 top-1/2 transform -translate-y-1/2 text-red-500 hover:text-[#301580] text-2xl pointer-events-auto" onclick="prevImage(event)">‹</button>
                <button type="button" id="next" class="nextBtn absolute right-2 top-1/2 transform -translate-y-1/2 text-red-500 hover:text-[#301580] text-2xl pointer-events-auto" onclick="nextImage(event)">›</button>
            </div>
        </div>
        
        <div class="pl-4 flex-grow w-full">
            <div class="flex justify-between items-center px-4">
                <h1 class="text-2xl font-semibold">รายละเอียดกิจกรรม</h1>
                <button class="mt-4 text-white px-4 py-2 rounded-2xl disabled <?= $event['status'] ? 'bg-green-500' : 'bg-red-500' ?>"><?= htmlspecialchars($event[1]['status']) ?></button>
            </div>
            <div class="px-4">
                <p class="mt-4 text-md">
                    <i class="fas fa-info-circle mr-2"></i>
                    <?= htmlspecialchars($event['description']); ?>
                </p>
                <?php
                    $startTime = new DateTime($event['event_start_time']);
                    $endTime = new DateTime($event['event_end_time']);
                ?>
                <p class="mt-4 text-sm">
                    <i class="fas fa-clock mr-2"></i>
                    เวลา <?= $startTime->format('H:i') . " - " . $endTime->format('H:i'); ?>
                </p>
                <p class="mt-4 text-sm">
                    <i class="fas fa-calendar-day mr-2"></i>
                    เปิดรับสมัครตั้งแต่ <?= (new DateTime($event['reg_start_date']))->format('d-m-Y'); ?> ถึง <?= (new DateTime($event['reg_end_date']))->format('d-m-Y'); ?>
                </p>
                <p class="mt-4 text-sm">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    วันที่เริ่ม <?= (new DateTime($event['event_start_date']))->format('d-m-Y'); ?> ถึง <?= (new DateTime($event['event_end_date']))->format('d-m-Y'); ?>
                </p>
                <p class="mt-4 text-sm">
                    <i class="fas fa-clock mr-2"></i>
                    ตั้งแต่เวลา <?= htmlspecialchars($event['event_start_time']); ?> ถึง <?= htmlspecialchars($event['event_end_time']); ?>
                </p>
                <p class="mt-4 text-sm">
                    <i class="fas fa-users mr-2"></i>
                    จำนวนที่รับสมัคร <?= htmlspecialchars($event['capacity']); ?> ลงทะเบียนแล้ว <?= htmlspecialchars($event[0]['registered']); ?>
                </p>
            </div>
            <div class="flex justify-between items-center px-4 mt-4">
                <form action="<?= !empty($_SESSION['username']) ? '/reg_event' : '/login' ?>" method="GET">
                    <?php 
                        if (!empty($_SESSION['username']))
                        {
                            echo "<input type='hidden' name='eid' value='" . htmlspecialchars($event['eid']) . "'>";
                            echo "<input type='hidden' name='name' value='" . htmlspecialchars($event['event_name']) . "'>";
                            echo "<input type='hidden' name='image' value='" . htmlspecialchars($event['image']) . "'>";
                        }
                    ?>

                    <button class="mt-4 bg-[#151541] text-white px-4 py-2 rounded-2xl bg-blue-400 hover:bg-blue-500"><?= !empty($_SESSION['username']) ? 'ลงทะเบียน' : 'เข้าสู่ระบบ'?></button>
                </form>
                <form action="/home" method="GET">
                    <button class="mt-4 bg-[#151541] text-white px-4 py-2 rounded-2xl bg-gray-600 hover:bg-gray-700">ย้อนกลับ</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
    <p class="text-red-500">ไม่พบข้อมูล</p>
<?php endif; ?>
<script src="/assets/js/slide.js"></script>
