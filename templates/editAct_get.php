
<Title>EDIT ACTIVITIES</Title>

<div class="container mx-auto p-8 flex justify-center">
    <div class="bg-[#301580] p-6 rounded-lg w-full max-w-5xl flex"> 
        <div class="w-3/4 pr-4">
            <h2 class="text-3xl font-bold mb-6">แก้ไขกิจกรรม</h2> 
            <form method="POST">
                <div class="grid gap-6 mb-4 md:grid-cols-2">
                    <div class="">        
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ชื่อกิจกรรม</label>
                        <input type="text" name="event_name" value="Default event description" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>
                    
                    <div class="">
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">จำนวนคนที่รับ</label>
                        <input type="text" name="event_name" value="100" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>

                    <div class="">
                        <label for="event_start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">วันที่เริ่มกิจกรรม</label>
                        <input type="date" name="event_start_date" value="วันที่เริ่มกิจกรรม" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>
 
                    <div class="">
                        <label for="event_end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">วันสิ้นสุดกิจกรรม</label>
                        <input type="date" name="event_end_date" value="วันสิ้นสุดกิจกรรม" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>

                    <div class="">
                        <label for="event_start_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">เวลาเริ่มกิจกรรม</label>
                        <input type="time" name="event_start_time" value="09:00:00" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>

                    <div class="">
                        <label for="event_end_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">เวลาสิ้นสุดกิจกรรม</label>
                        <input type="time" name="event_end_time" value="17:00:00" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>

                    <div class="">  
                        <label for="reg_start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">วันเปิดรับสมัคร</label>
                        <input type="date" name="reg_start_dat" value="วันเปิดรับสมัคร" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>

                    <div class="">
                        <label for="reg_end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">วันปิดรับสมัคร</label>
                        <input type="date" name="reg_end_dat" value="วันเปิดรับสมัคร" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>
                </div>
                <label for="details" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">รายละเอียดกิจกรรม</label>
                <textarea name="details" value="รายละเอียดกิจกรรม" class="p-2 rounded-lg bg-[#D9D9D9] w-full h-[150px] text-black"></textarea>
            </form>
            <div class="mt-auto w-full">
                <button type="button" class="bg-[#0A7500] mt-3 p-2 rounded-lg w-1/3 text-white font-bold hover:bg-[#1e7e34] transition">ยืนยัน</button>
                <button type="button" class="bg-[#424242] mt-3 p-2 rounded-lg w-1/3 text-white font-bold hover:bg-[#343a40] transition">ย้อนกลับ</button>
            </div>

        </div>

        <!-- select image -->
        <div class="w-1/2 h-[500px] flex flex-col items-center bg-gray-800 p-6 rounded-lg shadow-lg mt-12">
            <div id="image-container" class="relative w-full h-full bg-gray-700 flex flex-col items-center justify-center text-gray-400 rounded-lg mb-4 border-2 border-dashed border-gray-500 cursor-pointer hover:bg-gray-600 transition overflow-hidden" ondragover="event.preventDefault()" ondrop="handleDrop(event)" onclick="triggerFileInput()">
                <div id="image-slider" class="flex w-full h-full items-center justify-center" ondragover="event.preventDefault()" ondrop="handleImageReorder(event)">
                    <span id="upload-text" class="text-sm">คลิ๊กเพื่ออัปโหลด</span>
                    <span class="text-xs">หรือลากเพื่อวาง</span>
                </div>
                <button id="prev" class="absolute left-2 top-1/2 transform -translate-y-1/2 text-red-500 text-2xl hidden">&#9665;</button>
                <button id="next" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-red-500 text-2xl hidden">&#9655;</button>
            </div>
            <label class="cursor-pointer bg-[#301580] mt-8 p-2 rounded-lg w-full text-center text-white font-bold hover:bg-[#151541] transition">
                เพิ่มรูปภาพ
                <input type="file" id="image-input" name="image" class="hidden" multiple>
            </label>
            <button id="delete-image" type="button" class="bg-[#750002] mt-3 p-2 rounded-lg w-full text-white font-bold hover:bg-red-700 transition">ลบรูปภาพ</button>
        </div>

    </div>
<div> 

<script src="/assets/js/uploadImage.js"></script>