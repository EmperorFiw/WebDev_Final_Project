<?php
// print_r($data);
?>
<title>การจัดการผู้เข้าร่วม</title>

<div class="container mx-auto mt-2 p-5 text-white">
    <h2 class="text-2xl md:text-3xl pl-4 md:pl-14 ml-4 md:ml-20">การจัดการผู้เข้าร่วม</h2>
</div>
<div class="bg-[#5B5B5B] shadow-lg w-full max-w-[95%] md:max-w-[80%] mx-auto overflow-hidden min-h-[600px]">
    <div class="text-white">
        <div class="overflow-x-auto flex justify-center">
            <table class="w-full max-w-full border-collapse border-spacing-0">
                <thead class="bg-[#301580] rounded-t-lg text-sm md:text-base">
                    <tr>
                        <th class="py-2 font-normal w-[50px] md:w-[80px]">ลำดับที่</th>
                        <th class="py-2 font-normal">ชื่อกิจกรรม</th>
                        <th class="py-2 font-normal">ชื่อจริง</th>
                        <th class="py-2 font-normal">นามสกุล</th>
                        <th class="py-2 font-normal">เพศ</th>
                        <th class="py-2 font-normal">อายุ</th>
                        <th class="py-2 font-normal">โทรศัพท์</th>
                        <th class="py-2 font-normal w-[100px] md:w-[150px]">ประเภทผู้เข้าร่วม</th>
                        <th class="py-2 font-normal w-[120px] md:w-[150px]">อนุญาต / ปฏิเสธ</th>
                    </tr>
                </thead>

                <tbody class="pb-6 px-2 md:px-4 py-2 text-center border-b border-gray-300">
                    <?php if (!empty($data['participants'])): ?> 
                        <?php foreach ($data['participants'] as $index => $row): ?>
                            <tr class="hover:bg-gray-600 transition">
                                <td class="px-2 md:px-4 py-2 pt-4 text-center"><?= (int)$index + 1 ?></td>
                                <td class="px-2 md:px-4 py-2 pt-4 text-center"><?= htmlspecialchars($row['event_name']) ?></td>
                                <td class="px-2 md:px-4 py-2 pt-4 text-center"><?= htmlspecialchars($row['firstname']) ?></td>
                                <td class="px-2 md:px-4 py-2 pt-4 text-center"><?= htmlspecialchars($row['lastname']) ?></td>
                                <td class="px-2 md:px-4 py-2 pt-4 text-center"><?= htmlspecialchars($row['gender']) ?></td>
                                <td class="px-2 md:px-4 py-2 pt-4 text-center"><?= htmlspecialchars($row['age']) ?></td>
                                <td class="px-2 md:px-4 py-2 pt-4 text-center"><?= htmlspecialchars($row['tel']) ?></td>
                                <td class="px-2 md:px-4 py-2 pt-4 text-center"><?= htmlspecialchars($row['type']) ?></td>
                                <td class="px-2 md:px-4 py-2 pt-4 text-center">
                                    <form method="GET" action="/event_controller">
                                        <input type="hidden" name="uid" value="<?= $row['uid'] ?>">
                                        <input type="hidden" name="eid" value="<?= $row['eid'] ?>">

                                        <div class="inline-flex space-x-2 md:space-x-4">
                                            <button type="button" name="action" value="approveUser" class="actionBtn bg-green-700 hover:bg-green-600 text-white py-1 px-2 md:px-3 rounded text-xs md:text-sm">
                                                อนุมัติ
                                            </button>
                                            <button type="button" name="action" value="rejectUser" class="actionBtn bg-red-700 hover:bg-red-600 text-white py-1 px-2 md:px-3 rounded text-xs md:text-sm">
                                                ปฏิเสธ
                                            </button>
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
<script>
    // การยืนยันการอนุมัติหรือปฏิเสธ
    document.querySelectorAll('.actionBtn').forEach(button => {
        button.addEventListener('click', function() {
            const action = this.getAttribute('value');
            const uid = this.getAttribute('data-uid');
            const eid = this.getAttribute('data-eid');
            
            Swal.fire({
                title: `คุณแน่ใจหรือไม่?`,
                text: `คุณต้องการ${action === 'approveUser' ? 'อนุมัติ' : 'ปฏิเสธ'}ผู้ใช้นี้หรือไม่?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: action === 'approveUser' ? '#3085d6' : '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: action === 'approveUser' ? 'อนุมัติ' : 'ปฏิเสธ',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    // ส่งฟอร์ม
                    const form = this.closest('form');
                    const actionInput = document.createElement('input');
                    actionInput.setAttribute('type', 'hidden');
                    actionInput.setAttribute('name', 'action');
                    actionInput.setAttribute('value', action);
                    form.appendChild(actionInput);

                    form.submit();
                }
            });
        });
    });
</script>
<?php if (isset($data['alertScript'])): ?>
    <script>
        <?= $data['alertScript']?>
    </script>
<?php endif; ?>