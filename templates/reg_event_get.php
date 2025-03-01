<?php
    if (isset($eventData[0])) {
        $eventData = $eventData[0];
    }
?>

<title><?= $data['event_name'] ?></title>

<div class="container px-10 text-white">
    <h2 class="text-3xl mt-8 ">ต้องการเข้าร่วมกิจกรรม <?= $data['event_name'] ?></h2> 
</div>
<div class="container px-10 mt-6 flex justify-center">
    <div class="bg-[#301580]  rounded-lg w-full flex"> 
        <form action="" method="POST" enctype="multipart/form-data" class="flex w-full">
            <input type="hidden" name="eid" value="<?= $data['eid'] ?>">
            <?php
                $imageUrl = $data['image'];
                $imageUrlParts = explode(',', $imageUrl);
                $finalImageUrl = $imageUrlParts[0];
                ?>
            <img src="<?= $finalImageUrl ?>" class="w-full h-[512px] object-cover rounded-lg">
        <div class="w-3/4 pl-4 pr-3">
            <div class="grid gap-6 mb-4 grid-cols-2">
                <div class="">        
                    <label for="fname" class="block mb-2 text-sm font-medium text-white dark:text-white">ชื่อจริง</label>
                    <input type="text" name="fname" placeholder="ชื่อจริง" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                </div>
                
                <div class="">
                    <label for="lname" class="block mb-2 text-sm font-medium text-white dark:text-white">นามสกุล</label>
                    <input type="text" name="lname" placeholder="นามสกุล" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                </div>

                <div class="">        
                    <label for="phone" class="block mb-2 text-sm font-medium text-white dark:text-white">เบอร์มือถือ</label>
                    <input type="text" name="phone" placeholder="เบอร์มือถือ" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                </div>
                
                <div class="">
                    <label for="age" class="block mb-2 text-sm font-medium text-white dark:text-white">อายุ</label>
                    <input type="text" name="age" placeholder="อายุ" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                </div>

                <div class="">
                    <label for="gender" class="block mb-2 text-sm font-medium text-white dark:text-white">เพศ</label>
                    <select name="gender" id="dropdown" class="form-select custom-dropdown p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                        <option value="">เลือกเพศ</option>
                        <option value="ชาย">ชาย</option>
                        <option value="หญิง">หญิง</option>
                    </select> 
                </div>

                <div class="">
                    <label for="role" class="block mb-2 text-sm font-medium text-white dark:text-white">ประเภทของผู้เข้าร่วม</label>
                    <select name="role" id="dropdown" class="form-select custom-dropdown p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                        <option value="">เลือกประเภท</option>
                        <option value="ผู้เข้าร่วมงานทั่วไป">ผู้เข้าร่วมงานทั่วไป</option>
                        <option value="วิทยากร">วิทยากร</option>
                        <option value="ผู้จัดงาน">ผู้จัดงาน</option>
                    </select> 
                </div>
            </div> 
            <button type="submit" class="bg-[#0A7500] mt-3 p-2 rounded-lg w-full text-white  hover:bg-[#32CD32] transition ">ยืนยัน</button>
        </form>
        <form action="/event_details" method="get">
            <input type="hidden" name="eid" value="<?= $data['eid'] ?>">
            <button type="submit" class="bg-[#750002] mt-3 p-2 rounded-lg w-full text-white  hover:bg-[#FF0000] transition ">ยกเลิก</button>
        </form>
    </div>
<div> 

<script src="/assets/js/uploadImage.js"></script>
<?php if (isset($data[0]['alertScript'])): ?>
    <script>
        <?= $data[0]['alertScript']?>
    </script>
<?php endif; ?>
