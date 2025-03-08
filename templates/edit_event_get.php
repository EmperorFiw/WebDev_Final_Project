<?php
    $event = $data;
?>
<Title>EDIT ACTIVITIES</Title>
<div class="container mx-auto p-4 md:p-8 flex justify-center">
    <div class="bg-[#301580] p-4 md:p-6 rounded-lg w-full max-w-5xl flex flex-col md:flex-row"> 
        <form action="/edit_event" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row w-full">
            <input type="hidden" name="event_id" value="<?= htmlspecialchars($event['eid']) ?>">
            <div class="w-full md:w-3/4 md:pr-4">
                <h2 class="text-2xl md:text-3xl font-bold mb-6">แก้ไขกิจกรรม</h2> 
                <div class="grid gap-4 md:gap-6 mb-4 grid-cols-1 md:grid-cols-2">
                    <div class="">        
                        <label for="event_name" class="block mb-2 text-sm font-medium text-white">ชื่อกิจกรรม</label>
                        <input type="text" name="event_name" value="<?= htmlspecialchars($event['event_name']) ?>" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>
                    
                    <div class="">
                        <label for="max_participants" class="block mb-2 text-sm font-medium text-white">จำนวนคนที่รับ</label>
                        <input type="text" name="max_participants" value="<?= htmlspecialchars($event['capacity']) ?>" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>

                    <div class="">
                        <label for="event_start_date" class="block mb-2 text-sm font-medium text-white">วันที่เริ่มกิจกรรม</label>
                        <input type="date" name="event_start_date" value="<?= htmlspecialchars($event['event_start_date']) ?>" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>

                    <div class="">
                        <label for="event_end_date" class="block mb-2 text-sm font-medium text-white">วันสิ้นสุดกิจกรรม</label>
                        <input type="date" name="event_end_date" value="<?= htmlspecialchars($event['event_end_date']) ?>" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>

                    <div class="">
                        <label for="event_start_time" class="block mb-2 text-sm font-medium text-white">เวลาเริ่มกิจกรรม</label>
                        <input type="time" name="event_start_time" value="<?= htmlspecialchars($event['event_start_time']) ?>" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>

                    <div class="">
                        <label for="event_end_time" class="block mb-2 text-sm font-medium text-white">เวลาสิ้นสุดกิจกรรม</label>
                        <input type="time" name="event_end_time" value="<?= htmlspecialchars($event['event_end_time']) ?>" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>

                    <div class="">  
                        <label for="reg_start_date" class="block mb-2 text-sm font-medium text-white">วันเปิดรับสมัคร</label>
                        <input type="date" name="reg_start_date" value="<?= htmlspecialchars($event['reg_start_date']) ?>" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>

                    <div class="">
                        <label for="reg_end_date" class="block mb-2 text-sm font-medium text-white">วันปิดรับสมัคร</label>
                        <input type="date" name="reg_end_date" value="<?= htmlspecialchars($event['reg_end_date']) ?>" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>
                </div>
                <label for="details" class="block mb-2 text-sm font-medium text-white">รายละเอียดกิจกรรม</label>
                <textarea name="details" class="p-2 rounded-lg bg-[#D9D9D9] w-full h-[150px] text-black"><?= htmlspecialchars($event['description'] ?? 'รายละเอียดกิจกรรม') ?></textarea>

                <div class="mt-6 w-full flex flex-col md:flex-row gap-3">
                    <button type="submit" class="bg-[#0A7500] mt-3 p-2 rounded-lg w-full md:w-1/3 text-white font-bold hover:bg-[#1e7e34] transition">ยืนยัน</button>
                    <button type="button" onclick="btnBack()" class="bg-[#424242] mt-3 p-2 rounded-lg w-full md:w-1/3 text-white font-bold hover:bg-[#343a40] transition">ย้อนกลับ</button>
                </div>
            </div>  
            
            <!-- select image -->
            <div class="carousel-container w-full md:w-1/2 h-auto md:h-[500px] flex flex-col items-center bg-gray-800 p-4 md:p-6 rounded-lg shadow-lg mt-6 md:mt-12">
                <div id="image-container" class="carousel relative w-full h-64 md:h-full bg-gray-700 flex flex-col items-center justify-center text-gray-400 rounded-lg mb-4 border-2 border-dashed border-gray-500 cursor-pointer hover:bg-gray-600 transition overflow-hidden" ondragover="event.preventDefault()" ondrop="handleDrop(event)" onclick="triggerFileInput()">
                    <div id="image-slider" class="w-full h-full relative object-cover">
                        <?php
                            $images = explode(',', $event['image']);
                            foreach ($images as $index => $image) {
                                $activeClass = ($index === 0) ? '' : 'hidden'; // แสดงเฉพาะรูปแรก
                                if (!empty($image))
                                {
                                    echo '<div class="carousel-item absolute inset-0 w-full h-full ' . htmlspecialchars($activeClass) . '">
                                            <img src="' . htmlspecialchars($image) . '" alt="Image ' . ($index + 1) . '" class="w-full h-full object-cover">
                                        </div>';
                                }
                            } 
                        ?>
                    </div>
                    <button type="button" id="prev" class="prevBtn absolute left-2 top-1/2 transform -translate-y-1/2 text-red-500 hover:text-[#301580] text-2xl pointer-events-auto" onclick="prevImage(event)">‹</button>
                    <button type="button" id="next" class="nextBtn absolute right-2 top-1/2 transform -translate-y-1/2 text-red-500 hover:text-[#301580] text-2xl pointer-events-auto" onclick="nextImage(event)">›</button>
                </div>
                <input type="file" id="image-input" name="images[]" class="hidden" multiple>
                <button id="addImg" type="button" class="cursor-pointer bg-[#301580] mt-4 md:mt-8 p-2 rounded-lg w-full text-center text-white font-bold hover:bg-[#151541] transition">
                    เพิ่มรูปภาพ
                </button>
                <form action="" class="hidden"><p class="hidden">hiden</p></form>
                <form id="deleteForm" action="/delete_image" method="POST" class="w-full">
                    <input type="hidden" name="eid" value="<?= (int) $event['eid'] ?>">
                    <button type="submit" id="delete-image-edit" class="bg-[#750002] mt-3 p-2 rounded-lg w-full text-white font-bold hover:bg-red-700 transition">
                        ลบรูปภาพ
                    </button>
                </form>
            </div>
        </form>
    </div>
</div> 

<script src="/assets/js/editImage.js"></script>
<script>
    document.getElementById('delete-image-edit').addEventListener('click', function(event) {
        event.preventDefault(); // หยุดการส่งฟอร์มปกติ

        // ใช้ SweetAlert ถามผู้ใช้ก่อน
        Swal.fire({
            title: "คุณแน่ใจหรือไม่?",
            text: "คุณต้องการลบรูปภาพนี้จริงๆ หรือไม่?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: 'ลบ',
            cancelButtonText: 'ยกเลิก',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // ดึงฟอร์มที่ซ่อนอยู่
                var form = document.getElementById('deleteForm');

                if (form instanceof HTMLFormElement) {
                    // ดึง URL ของรูปภาพที่อยู่ใน div ที่มีคลาส active
                    var activeItem = document.querySelector('.carousel-item.active');

                    // เช็คว่าเจอ item หรือไม่
                    if (activeItem) {
                        var imageUrl = activeItem.querySelector('img').src; // ดึง src ของภาพที่อยู่ใน active div
                        // เพิ่ม URL ของภาพใน input ซ่อน
                        var imageUrlInput = document.createElement('input');
                        imageUrlInput.type = 'hidden';
                        imageUrlInput.name = 'imageUrl';
                        imageUrlInput.value = imageUrl; // ตั้งค่า URL ไปใน input ที่ซ่อน
                        // เพิ่ม input นี้ไปในฟอร์ม
                        form.appendChild(imageUrlInput);
                        // ส่งฟอร์มไปด้วย POST method
                        form.submit(); // ส่งฟอร์ม
                        Swal.fire({
                            title: "ลบรูปภาพสำเร็จ",
                            icon: "success",
                        });
                    } else {
                        console.error('ไม่พบรูปภาพที่มีคลาส active');
                        Swal.fire({
                            title: "ไม่พบรูปภาพที่ต้องการลบ!", 
                            icon: "error",
                        });
                    }
                } else {
                    console.error('Form not found or invalid');
                }
            } 
        });
    });
    function btnBack() {
        window.location.href = 'my_events';
    }
</script>

<?php if (isset($data['alertScript'])): ?>
    <script>
        <?= $data['alertScript']?>
    </script>
<?php endif; ?>
