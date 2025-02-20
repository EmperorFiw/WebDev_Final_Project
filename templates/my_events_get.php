
<title>My Events</title>
<div class="container mx-auto p-4">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 px-10 py-2">
        <div class="actname">
            <h1 class="text-2xl font-bold">กิจกรรมของฉัน</h1>
        </div>
        <div class="event w-full md:w-auto">
            <form action="/event_controller" method="POST" class="flex flex-wrap gap-2 justify-center">
                <input type="hidden" name="eid" value="<?= htmlspecialchars($_SESSION['selected_event'] ?? '') ?>">

                <button type="submit" name="action" value="approve"
                    class="flex items-center gap-2 bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-blue-600 transition">
                    <i class="fas fa-check-circle"></i> การอนุมัติ
                </button>

                <button type="submit" name="action" value="checklist"
                    class="flex items-center gap-2 bg-green-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-green-600 transition">
                    <i class="fas fa-list-check"></i> รายการเช็คชื่อ
                </button>

                <button type="submit" name="action" value="statistics"
                    class="flex items-center gap-2 bg-purple-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-purple-600 transition">
                    <i class="fas fa-chart-bar"></i> ดูสถิติ
                </button>

                <button type="submit" name="action" value="edit"
                    class="flex items-center gap-2 bg-yellow-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-yellow-600 transition">
                    <i class="fas fa-edit"></i> แก้ไข
                </button>

                <button type="submit" name="action" value="delete"
                    class="flex items-center gap-2 bg-red-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-red-600 transition">
                    <i class="fas fa-trash"></i> ลบ
                </button>
            </form>
        </div>
    </div>

    <div class="w-full p-4">
    <?php if (!empty($data) && isset($data[0]['event_name']) && $data[0]['event_name'] != ''): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <?php foreach ($data as $event) { ?>
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="<?= htmlspecialchars(explode(',', $event['image'])[0] ?? '') ?>" alt="<?= htmlspecialchars($event['event_name'] ?? 'ไม่พบชื่อกิจกรรม') ?>" class="w-full h-[282px] object-cover">
                    <div class="p-4">
                        <div class="flex justify-center">
                            <h2 class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($event['event_name'] ?? 'ไม่พบชื่อกิจกรรม') ?></h2>
                        </div>
                        <div class="mt-3 flex justify-between">
                            <form action="" method="GET">
                                <input type="hidden" name="selectID" value="<?= (int) $event['eid'] ?>">
                                <button type="submit" id="select-btn-<?= $event['eid'] ?>" class="flex items-center justify-center gap-2 w-full <?= (isset($_SESSION['selected_event']) && $_SESSION['selected_event'] == $event['eid']) ? 'bg-green-500' : 'bg-blue-500' ?> text-white py-2 px-5 rounded-lg shadow-md hover:bg-opacity-80 transition-all duration-300">
                                    <i id="check-icon-<?= $event['eid'] ?>" class="fas fa-check <?= (isset($_SESSION['selected_event']) && $_SESSION['selected_event'] == $event['eid']) ? '' : 'hidden' ?>"></i>
                                    <?= (isset($_SESSION['selected_event']) && $_SESSION['selected_event'] == $event['eid']) ? 'เลือกแล้ว' : 'เลือก' ?>
                                </button>
                            </form>
                            <form action="/event_details" method="POST">
                                <input type="hidden" name="eid" value="<?= (int) $event['eid'] ?>">
                                <button type="submit" class="flex items-center gap-2 bg-gray-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-gray-600 transition">
                                    <i class="fas fa-info-circle"></i> รายละเอียด
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php else: ?>
        <div class="text-center py-6">
            <h2 class="text-xl font-semibold text-white">คุณยังไม่ได้สร้างกิจกรรม</h2>
        </div>
    <?php endif; ?>
</div>

<?php if (isset($data[0]['alertScript'])): ?>
    <?php if (isset($data[0]['deleteID'])): ?>
    <form id="deleteForm" action="delete_event" method="POST" class="hidden">
        <input type="hidden" name="eid" value="<?= $data[0]['deleteID'] ?>">
    </form>
    <?php endif; ?>
    <script>
        <?= $data[0]['alertScript']?>
    </script>
<?php endif; ?>
