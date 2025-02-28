<title>festival</title>
<div class="container mx-auto  text-white">
    <h2 class="text-3xl  mt-6 ml-16 pl-14">ต้องการเข้าร่วมกิจกรรม Festival</h2> 
</div>

<div class="container mx-auto p-8 flex justify-center">
    
    <div class="bg-[#301580] py-6 pl-4 rounded-lg w-full max-w-7xl flex"> 
        <form action="" method="POST" enctype="multipart/form-data" class="flex w-full">

             <!-- image -->
            <div class="w-1/2 h-[600px] flex flex-col items-center bg-gray-800 p-6 rounded-lg shadow-lg mt-0 m-5">
                <div id="image-container" class="bg-gray-700 flex flex-col items-center justify-center  rounded-lg mb-4   overflow-hidden">
                </div>
               
            </div>

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
                        <select id="dropdown" class="form-select custom-dropdown p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                            <option></option>
                            <option>ชาย</option>
                            <option>หญิง</option>
                           <!-- <option>สาวสอง</option>  -->
                            <!-- <option>ทอม</option>  -->
                        </select> 
                    </div>

                    <div class="">
                        <label for="age" class="block mb-2 text-sm font-medium text-white dark:text-white">ประเภทของผู้เข้าร่วม</label>
                        <input type="text" name="age" placeholder="วิทยากร/ผู้จัดงาน/ผู้เข้าร่วมงานทั่วไป" class="p-2 rounded-lg bg-[#D9D9D9] w-full text-black">
                    </div>
                    <div class="flex gap-5">
                        <button type="submit" class="bg-[#0A7500] mt-3 p-2 rounded-lg w-1/3 text-white  hover:bg-[#32CD32] transition ">ยืนยัน</button>
                        <button type="submit" class="bg-[#750002] mt-3 p-2 rounded-lg w-1/3 text-white  hover:bg-[#FF0000] transition ">ยกเลิก</button>
                    </div>
            </div> 
        </form>
        
    </div>
<div> 

<script src="/assets/js/uploadImage.js"></script>
<?php if (isset($data['alertScript'])): ?>
    <script>
        <?= $data['alertScript']?>
    </script>
<?php endif; ?>
