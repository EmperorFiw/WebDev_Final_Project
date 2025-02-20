<title>Register</title>
 <div class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-lg bg-[#151541] text-white p-8 rounded-lg shadow-lg">
        <form action="/register" method="POST">
            <h2 class="text-center text-3xl font-bold">Register</h2>
            <div class="mt-6 space-y-4">
                <div>
                    <label for="username" class="block text-sm font-medium">Username</label>
                    <input type="text" id="username" name="username" class="w-full mt-1 p-3 bg-gray-700 text-white rounded-md focus:ring focus:ring-gray-400 outline-none" placeholder="Enter username" required>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium">Password</label>
                    <input type="password" id="password" name="password" class="w-full mt-1 p-3 bg-gray-700 text-white rounded-md focus:ring focus:ring-gray-400 outline-none" placeholder="Enter password" required>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium">Email</label>
                    <input type="email" id="email" name="email" class="w-full mt-1 p-3 bg-gray-700 text-white rounded-md focus:ring focus:ring-gray-400 outline-none" placeholder="Enter email" required>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium">เบอร์โทรศัพท์</label>
                    <input type="text" id="phone" name="phone" class="w-full mt-1 p-3 bg-gray-700 text-white rounded-md focus:ring focus:ring-gray-400 outline-none" placeholder="Enter phone number" required>
                </div>

                <div class="flex justify-center mt-4">
                    <button type="submit" class="w-full bg-[#301580] text-white py-2 rounded-md hover:bg-purple-800 text-lg">สมัครสมาชิก</button>
                </div>

                <div class="text-center mt-3">
                    <a href="/login" class="text-gray-300 hover:underline">มีบัญชีแล้ว</a>
                </div>
            </div>
        </form>
    </div>
</div>
<?php if (isset($data['alertScript'])): ?>
    <script>
        <?= $data['alertScript']?>
    </script>
<?php endif; ?>

