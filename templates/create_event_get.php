<Title>CREATE ACTIVITIES</Title>

<div class="container mx-auto p-4 md:p-8 flex justify-center">
    <div class="bg-[#301580] p-4 md:p-6 rounded-lg w-full max-w-5xl flex flex-col md:flex-row"> 
        <form action="" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row w-full">
            <div class="w-full md:w-3/4 md:pr-4">
                <h2 class="text-2xl md:text-3xl font-bold mb-6">สร้างกิจกรรม</h2> 
                <div class="grid gap-4 md:gap-6 mb-4 grid-cols-1 md:grid-cols-2">
                    <div class="">        
                        <label for="event_name" class="block mb-2 text-sm font-medium text-white">ชื่อกิจกรรม</label>
                        <input type="text" name="event_name" placeholder="ชื่อกิจกรรม" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>
                    
                    <div class="">
                        <label for="max_participants" class="block mb-2 text-sm font-medium text-white">จำนวนคนที่รับ</label>
                        <input type="number" name="max_participants" placeholder="จำนวนคนที่รับ" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>

                    <div class="">
                        <label for="event_start_date" class="block mb-2 text-sm font-medium text-white">วันที่เริ่มกิจกรรม</label>
                        <input type="date" name="event_start_date" placeholder="วันที่เริ่มกิจกรรม" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>
 
                    <div class="">
                        <label for="event_end_date" class="block mb-2 text-sm font-medium text-white">วันสิ้นสุดกิจกรรม</label>
                        <input type="date" name="event_end_date" placeholder="วันสิ้นสุดกิจกรรม" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>

                    <div class="">
                        <label for="event_start_time" class="block mb-2 text-sm font-medium text-white">เวลาเริ่มกิจกรรม</label>
                        <input type="time" name="event_start_time" placeholder="เวลาเริ่มกิจกรรม" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>

                    <div class="">
                        <label for="event_end_time" class="block mb-2 text-sm font-medium text-white">เวลาสิ้นสุดกิจกรรม</label>
                        <input type="time" name="event_end_time" placeholder="เวลาสิ้นสุดกิจกรรม" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>

                    <div class="">  
                        <label for="reg_start_date" class="block mb-2 text-sm font-medium text-white">วันเปิดรับสมัคร</label>
                        <input type="date" name="reg_start_date" placeholder="วันเปิดรับสมัคร" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>

                    <div class="">
                        <label for="reg_end_date" class="block mb-2 text-sm font-medium text-white">วันปิดรับสมัคร</label>
                        <input type="date" name="reg_end_date" placeholder="วันปิดรับสมัคร" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>
                </div>
                <label for="details" class="block mb-2 text-sm font-medium text-white">รายละเอียดกิจกรรม</label>
                <textarea name="details" placeholder="รายละเอียดกิจกรรม" class="p-2 rounded-lg bg-[#D9D9D9] w-full h-[150px] text-black"></textarea>

                <div class="mt-6 w-full flex justify-center">
                    <button type="submit" id="confirmButton" class="bg-[#0A7500] mt-3 p-2 rounded-lg w-full md:w-1/3 text-white font-bold hover:bg-[#32CD32] transition">ยืนยัน</button>
                </div>
            </div>  
            
            <!-- select image -->
            <div class="w-full md:w-1/2 h-auto md:h-[500px] flex flex-col items-center bg-gray-800 p-4 md:p-6 rounded-lg shadow-lg mt-6 md:mt-12">
                <div id="image-container" class="relative w-full h-64 md:h-full bg-gray-700 flex flex-col items-center justify-center text-gray-400 rounded-lg mb-4 border-2 border-dashed border-gray-500 cursor-pointer hover:bg-gray-600 transition overflow-hidden" ondragover="event.preventDefault()" ondrop="handleDrop(event)" onclick="triggerFileInput()">
                    <div id="image-slider" class="flex w-full h-full items-center justify-center object-cover w-full h-full" ondragover="event.preventDefault()" ondrop="handleImageReorder(event)">
                        <span id="upload-text" class="text-sm">คลิ๊กเพื่ออัปโหลด</span>
                        <span class="text-xs">หรือลากเพื่อวาง</span>
                    </div>
                    <button type="button" id="prev" class="absolute left-2 top-1/2 transform -translate-y-1/2 text-red-500 hover:text-[#301580] text-2xl hidden pointer-events-auto" onclick="prevImage(event)">‹</button>
                    <button type="button" id="next" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-red-500 hover:text-[#301580] text-2xl hidden pointer-events-auto" onclick="nextImage(event)">›</button>
                </div>
                <input type="file" id="image-input" name="images[]" class="hidden" multiple>
                <button id="addImg" type="button" class="cursor-pointer bg-[#301580] mt-4 md:mt-8 p-2 rounded-lg w-full text-center text-white font-bold hover:bg-[#151541] transition">
                    เพิ่มรูปภาพ
                </button>
                <button id="delete-image" type="button" class="bg-[#750002] mt-3 p-2 rounded-lg w-full text-white font-bold hover:bg-red-700 transition hidden">ลบรูปภาพ</button>
            </div>
        </form>
    </div>
</div> 

<script src="/assets/js/uploadImage.js"></script>
<?php if (isset($data['alertScript'])): ?>
    <script>
        <?= $data['alertScript']?>
    </script>

<script>
    let clickCount = 0;

    document.getElementById('confirmButton').addEventListener('click', function(event) {
        clickCount++;

        if (clickCount > 1) {
            alert('กรุณาหยุดกดปุ่มยืนยันซ้ำ');
            event.preventDefault();
        } else {
            this.form.submit();
        }
    });
</script>
<?php endif; ?>