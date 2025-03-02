<?php
    $event = $data;
?>
<Title>EDIT ACTIVITIES</Title>
<div class="container mx-auto p-8 flex justify-center">
    <div class="bg-[#301580] p-6 rounded-lg w-full max-w-5xl flex"> 
        <form action="/edit_event" method="POST" enctype="multipart/form-data" class="flex w-full">
            <input type="hidden" name="event_id" value="<?= htmlspecialchars($event['eid']) ?>">
            <div class="w-3/4 pr-4">
                <h2 class="text-3xl font-bold mb-6">แก้ไขกิจกรรม</h2> 
                <div class="grid gap-6 mb-4 md:grid-cols-2">
                    <div class="">        
                        <label for="event_name" class="block mb-2 text-sm font-medium text-white dark:text-white">ชื่อกิจกรรม</label>
                        <input type="text" name="event_name" value="<?= htmlspecialchars($event['event_name']) ?>" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>
                    
                    <div class="">
                        <label for="max_participants" class="block mb-2 text-sm font-medium text-white dark:text-white">จำนวนคนที่รับ</label>
                        <input type="text" name="max_participants" value="<?= htmlspecialchars($event['capacity']) ?>" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>

                    <div class="">
                        <label for="event_start_date" class="block mb-2 text-sm font-medium text-white dark:text-white">วันที่เริ่มกิจกรรม</label>
                        <input type="date" name="event_start_date" value="<?= htmlspecialchars($event['event_start_date']) ?>" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>

                    <div class="">
                        <label for="event_end_date" class="block mb-2 text-sm font-medium text-white dark:text-white">วันสิ้นสุดกิจกรรม</label>
                        <input type="date" name="event_end_date" value="<?= htmlspecialchars($event['event_end_date']) ?>" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>

                    <div class="">
                        <label for="event_start_time" class="block mb-2 text-sm font-medium text-white dark:text-white">เวลาเริ่มกิจกรรม</label>
                        <input type="time" name="event_start_time" value="<?= htmlspecialchars($event['event_start_time']) ?>" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>

                    <div class="">
                        <label for="event_end_time" class="block mb-2 text-sm font-medium text-white dark:text-white">เวลาสิ้นสุดกิจกรรม</label>
                        <input type="time" name="event_end_time" value="<?= htmlspecialchars($event['event_end_time']) ?>" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>

                    <div class="">  
                        <label for="reg_start_date" class="block mb-2 text-sm font-medium text-white dark:text-white">วันเปิดรับสมัคร</label>
                        <input type="date" name="reg_start_date" value="<?= htmlspecialchars($event['reg_start_date']) ?>" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>

                    <div class="">
                        <label for="reg_end_date" class="block mb-2 text-sm font-medium text-white dark:text-white">วันปิดรับสมัคร</label>
                        <input type="date" name="reg_end_date" value="<?= htmlspecialchars($event['reg_end_date']) ?>" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>
                </div>
                <label for="details" class="block mb-2 text-sm font-medium text-white dark:text-white">รายละเอียดกิจกรรม</label>
                <textarea name="details" class="p-2 rounded-lg bg-[#D9D9D9] w-full h-[150px] text-black"><?= htmlspecialchars($event['description'] ?? 'รายละเอียดกิจกรรม') ?></textarea>

                <div class="mt-auto w-full">
                    <button type="submit" class="bg-[#0A7500] mt-3 p-2 rounded-lg w-1/3 text-white font-bold hover:bg-[#1e7e34] transition">ยืนยัน</button>
                    <button type="button" onclick="btnBack()" class="bg-[#424242] mt-3 p-2 rounded-lg w-1/3 text-white font-bold hover:bg-[#343a40] transition">ย้อนกลับ</button>
                </div>

            </div>  
            <!-- assets/img/KKK_d52d6846f90cff34.png,assets/img/KKK_d101474a645d323f.jpg -->
            <!-- select image -->
            <div class="carousel-container w-1/2 h-[500px] flex flex-col items-center bg-gray-800 p-6 rounded-lg shadow-lg mt-12">
                <div id="image-container" class="carousel relative w-full h-full bg-gray-700 flex flex-col items-center justify-center text-gray-400 rounded-lg mb-4 border-2 border-dashed border-gray-500 cursor-pointer hover:bg-gray-600 transition overflow-hidden" ondragover="event.preventDefault()" ondrop="handleDrop(event)" onclick="triggerFileInput()">
                    <!-- <div id="image-slider" class="w-full h-full items-center object-cover justify-center" ondragover="event.preventDefault()" ondrop="handleImageReorder(event)"> -->
                    <div id="image-slider" class="w-full h-full relative  object-cover">
                        <?php
                            $images = explode(',', $event['image']);
                            foreach ($images as $index => $image) {
                                $activeClass = ($index === 0) ? 'block' : 'hidden'; // แสดงเฉพาะรูปแรก
                                echo '<div class="carousel-item absolute inset-0 w-full h-full ' . htmlspecialchars($activeClass) . '">
                                        <img src="' . htmlspecialchars($image) . '" alt="Image ' . ($index + 1) . '" class="w-full h-full object-cover">
                                    </div>';
                            } 
                        ?>
                    </div>
                    <button type="button" id="prev" class="prevBtn absolute left-2 top-1/2 transform -translate-y-1/2 text-red-500 hover:text-[#301580] text-2xl pointer-events-auto" onclick="prevImage(event)">‹</button>
                    <button type="button" id="next" class="nextBtn absolute right-2 top-1/2 transform -translate-y-1/2 text-red-500 hover:text-[#301580] text-2xl pointer-events-auto" onclick="nextImage(event)">›</button>
                </div>
                <input type="file" id="image-input" name="images[]" class="hidden" multiple>
                <button id="addImg" type="button" class="cursor-pointer bg-[#301580] mt-8 p-2 rounded-lg w-full text-center text-white font-bold hover:bg-[#151541] transition">
                    เพิ่มรูปภาพ
                </button>
                <button id="delete-image" type="button" class="bg-[#750002] mt-3 p-2 rounded-lg w-full text-white font-bold hover:bg-red-700 transition">ลบรูปภาพ</button>
            </div>

            <!-- <div class="w-1/2 h-[500px] flex flex-col items-center bg-gray-800 p-6 rounded-lg shadow-lg mt-12">
                <div id="image-container" class="relative w-full h-full bg-gray-700 flex flex-col items-center justify-center text-gray-400 rounded-lg mb-4 border-2 border-dashed border-gray-500 cursor-pointer hover:bg-gray-600 transition overflow-hidden" 
                        ondragover="event.preventDefault()" ondrop="handleDrop(event)" onclick="triggerFileInput()">
                    <div id="image-slider" class="w-full h-full items-center justify-center" ondragover="event.preventDefault()" ondrop="handleImageReorder(event)">

                        <span id="upload-text" class="text-sm">คลิ๊กเพื่ออัปโหลด</span>
                        <span class="text-xs">หรือลากเพื่อวาง</span>
                    </div>
                    <button type="button" onclick="event.stopPropagation();" class="absolute top-1/2 left-2 transform -translate-y-1/2 text-red-500 text-3xl prevBtn">‹</button>
                    <button type="button" onclick="event.stopPropagation();" class="absolute top-1/2 right-2 transform -translate-y-1/2 text-red-500 text-3xl nextBtn">›</button>
                </div>
                <label class="cursor-pointer bg-[#301580] mt-8 p-2 rounded-lg w-full text-center text-white font-bold hover:bg-[#151541] transition">
                    เพิ่มรูปภาพ
                    <input type="file" id="image-input" name="image[]" class="hidden" multiple>
                </label>
                <button id="delete-image" type="button" class="bg-[#750002] mt-3 p-2 rounded-lg w-full text-white font-bold hover:bg-red-700 transition">ลบรูปภาพ</button>
            </div> -->
        </form>
    </div>
<div> 

<script src="/assets/js/uploadImage.js"></script>
<script src="/assets/js/slide.js"></script>
<?php if (isset($data['alertScript'])): ?>
    <script>
        <?= $data['alertScript']?>
    </script>
<?php endif; ?>

<script>
    function btnBack() {
        window.location.href = 'my_events';
    }
</script>