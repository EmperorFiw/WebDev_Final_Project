<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;700&family=Prompt:wght@400;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 (JavaScript) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0s6kpOphQ9Y8IW6SO9WemV88Tz4p/9llZtIBeG0yJJsd33pX" crossorigin="anonymous"></script>
    <!-- Tailwind CSS with Plugins -->
    <script src="https://cdn.tailwindcss.com?plugins=typography,forms,aspect-ratio,line-clamp"></script>
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- QR CODE  -->
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/master/qrcode.min.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/snowFlake.css">
    <link rel="stylesheet" href="/assets/css/custom.css">
</head>
<body class="bg-[#1e1640]">
    <nav class="flex justify-between items-center border-b-2 border-white">
        <div class="l-box px-10">
            <h1 class="text-white text-2xl"><a href="/home">Activity</a></h1>
        </div>
        <div class="r-box flex flex-cols cursor-pointer px-10">
            <?php 
                echo '<h1 class="text-white p-2 hover:text-blue-600"><a href="/home">หน้าหลัก</a></h1>';
                if (!empty($_SESSION['username'])) {
                    $username = $_SESSION['username']; 
                    echo '
                        <div class="flex items-center relative">
                            <!-- ไอคอนผู้ใช้ -->
                            <i class="fas fa-user-circle text-white text-3xl ml-4 mr-2 cursor-pointer" onclick="openModal()"></i>
                            
                            <!-- ชื่อผู้ใช้ -->
                            <span class="text-white text-lg font-semibold p-2 hover:text-blue-600 cursor-pointer" onclick="openModal()">' . htmlspecialchars($username) . '</span>
                            
                            <!-- Modal ที่แสดงรายละเอียดผู้ใช้ -->
                            <div id="userModal" class="absolute top-full mt-2 right-0 bg-white p-6 rounded-lg w-64 hidden shadow-lg transform translate-x-full transition-all duration-300 z-50">
                            
                                <h2 class="text-xl font-bold mb-4 text-gray-700">ชื่อผู้ใช้: ' . htmlspecialchars($username) . '</h2>
                                <!-- ปุ่มสร้างกิจกรรม -->
                                <a href="/create_event" class="flex items-center text-white bg-blue-500 hover:bg-blue-600 px-4 py-2 mb-3 rounded-md transition duration-200">
                                    <i class="fas fa-plus-circle mr-2"></i> สร้างกิจกรรม
                                </a>
                                
                                <!-- ปุ่มกิจกรรมของฉัน -->
                                <a href="/my_events" class="flex items-center text-white bg-green-500 hover:bg-green-600 px-4 py-2 mb-3 rounded-md transition duration-200">
                                    <i class="fas fa-calendar-check mr-2"></i> กิจกรรมของฉัน
                                </a>
                                
                                <!-- ปุ่มออกจากระบบ -->
                                <form action="/logout" method="GET" style="display:inline;">
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md cursor-pointer w-full text-left hover:bg-red-600">
                                        <i class="fas fa-sign-out-alt mr-2"></i> ออกจากระบบ
                                    </button>
                                </form>
                                
                                <!-- ปุ่มปิด Modal -->
                                <button onclick="closeModal()" class="mt-4 bg-gray-500 text-white px-4 py-2 rounded-md cursor-pointer w-full hover:bg-gray-600">
                                    <i class="fas fa-times mr-2"></i> ปิด
                                </button>
                            </div>
                        </div>
                    ';
                } else {
                    echo '<h1 class="text-white p-2 hover:text-blue-600"><a href="/register">สมัครสมาชิก</a></h1>';
                    echo '<h1 class="text-white p-2 hover:text-blue-600"><a href="/login">เข้าสู่ระบบ</a></h1>';
                }
                ?>
        </div>
    </nav>
    <script src="assets/js/modalNavbar.js"></script>