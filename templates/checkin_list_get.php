<title>การจัดการผู้เข้าร่วม</title>

<div class="container mx-auto mt-2 p-5 text-white">
    <h2 class="text-left text-3xl py-2">รายการผู้เช็คชื่อ</h2>
</div>
<div class="bg-[#5B5B5B] shadow-lg w-full max-w-[80%] mx-auto overflow-hidden min-h-[600px]">
    <div class="text-white">
        <div class="overflow-x-auto flex justify-center">
            <table class="w-full max-w-full border-collapse border-spacing-0">
                <thead class="bg-[#301580] rounded-t-lg text-base">
                    <tr>
                        <th class="py-2 font-normal w-[80px]">ลำดับที่</th>
                        <th class="py-2 font-normal">ชื่อกิจกรรม</th>
                        <th class="py-2 font-normal">ชื่อจริง</th>
                        <th class="py-2 font-normal">นามสกุล</th>
                        <th class="py-2 font-normal">เพศ</th>
                        <th class="py-2 font-normal">อายุ</th>
                        <th class="py-2 font-normal">โทรศัพท์</th>
                        <th class="py-2 font-normal w-[150px]">ประเภทผู้เข้าร่วม</th>
                        <th class="py-2 font-normal w-[150px]">สถานะ</th>
                    </tr>
                </thead>

                <tbody class="pb-6 px-4 py-2 text-center border-b border-gray-300">
                    <?php if (!empty($data['participants'])): ?> 
                        <?php foreach ($data['participants'] as $index => $row): ?>
                            <tr class="hover:bg-gray-600 transition">
                                <td class="px-4 py-2 pt-4 text-center"><?= (int)$index + 1 ?></td>
                                <td class="px-4 py-2 pt-4 text-center"><?= htmlspecialchars($row['event_name']) ?></td>
                                <td class="px-4 py-2 pt-4 text-center"><?= htmlspecialchars($row['firstname']) ?></td>
                                <td class="px-4 py-2 pt-4 text-center"><?= htmlspecialchars($row['lastname']) ?></td>
                                <td class="px-4 py-2 pt-4 text-center"><?= htmlspecialchars($row['gender']) ?></td>
                                <td class="px-4 py-2 pt-4 text-center"><?= htmlspecialchars($row['age']) ?></td>
                                <td class="px-4 py-2 pt-4 text-center"><?= htmlspecialchars($row['tel']) ?></td>
                                <!-- ตรงนี้ใส่ถานะเมื่อเช็คชื่อแล้ว -->
                                <td class="px-4 py-2 pt-4 text-center">
                                <form method="GET" action="/event_controller">
                                        <input type="hidden" name="uid" value="<?= $row['uid'] ?>">
                                        <input type="hidden" name="eid" value="<?= $row['eid'] ?>">

                                        <div class="inline-flex space-x-4">
                                            
                                        </div>
                                    </form>
                                </td> 
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="py-4 text-center text-gray-300">ไม่มีข้อมูลผู้เข้าร่วม</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                
            </table>
        </div>
    </div>
</div>