
<title>Login</title>
 <div class="min-h-screen flex items-center justify-center">
    <div class="bg-[#151541] text-white p-8 rounded-xl shadow-lg w-full max-w-md ">
        <form action="" method="POST">
            <h2 class="text-center text-4xl font-bold">Login</h2>
            <div class="mt-4">
                <label for="username" class="block text-sm font-medium">ชื่อผู้ใช้</label>
                <input type="text" id="username" name="username" placeholder="Username"
                    class="w-full mt-1 p-2 bg-gray-700 text-white rounded-md focus:ring focus:ring-gray-400 outline-none" />
            </div>

            <div class="mt-4">
                <label for="password" class="block text-sm font-medium">รหัสผ่าน</label>
                <input type="password" id="password" name="password" placeholder="Password"
                    class="w-full mt-1 p-2 bg-gray-700 text-white rounded-md focus:ring focus:ring-gray-400 outline-none" />
            </div>

            <!-- <div class="flex items-center justify-center mt-3">
                <input type="checkbox" id="remember" class="mr-2">
                <label for="remember" class="text-sm">Remember me</label>
            </div> -->

            <button type="submit" class="w-full mt-4 p-2 bg-[#301580] text-white rounded-md hover:bg-purple-800">เข้าสู่ระบบ</button>

            <div class="text-center mt-3 text-sm">
                <!-- <a href="#" class="text-gray-300 hover:underline hover:text-blue-600">ลืมรหัสผ่าน</a> -->
                <a href="/register" class="text-gray-300 hover:underline hover:text-blue-600">ยังไม่มีบัญชี</a>
            </div>
        </form>
    </div>
</div>
<?php if (isset($data['alertScript'])): ?>
    <script>
        <?= $data['alertScript']?>
    </script>
<?php endif; ?>
