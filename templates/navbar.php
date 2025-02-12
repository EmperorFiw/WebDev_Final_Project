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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;700&family=Prompt:wght@400;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 (JavaScript) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0s6kpOphQ9Y8IW6SO9WemV88Tz4p/9llZtIBeG0yJJsd33pX" crossorigin="anonymous"></script>
    <!-- Tailwind CSS with Plugins -->
    <script src="https://cdn.tailwindcss.com?plugins=typography,forms,aspect-ratio,line-clamp"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/snowFlake.css">
    <link rel="stylesheet" href="/assets/css/custom.css">
</head>
<body class="bg-[#1e1640]">
    <nav class=" flex justify-between items-center border-b-2 border-white">
        <div class="l-box">
            <h1 class="text-white p-2">Activity</h1>
        </div>
        <div class="r-box flex flex-cols cursor-pointer">
            <?php 
                echo '<h1 class="text-white p-2 hover:text-purple-200"><a href="/home">หน้าหลัก</a></h1>';
                if (!isLoggedIn()) {
                    echo '<h1 class="text-white p-2 hover:text-purple-200"><a href="/register">สมัครสมาชิก</a></h1>';
                    echo '<h1 class="text-white p-2 hover:text-purple-200"><a href="/login">เข้าสู่ระบบ</a></h1>';
                }
                else
                {
                    echo '<form action="/logout" method="POST" style="display:inline;">
                        <button type="submit" class="text-white p-2 hover:text-purple-200">ออกจากระบบ</button></form>';
                }
            ?>
        </div>
    </nav>