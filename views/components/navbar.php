<header>
    <?php 
        require_once __DIR__. '/links.php';
        require_once __DIR__. '/snowflake.php'; 
    ?>
    <nav class="bg-[#1e1640] flex justify-between items-center">
        <div class="l-box">
            <h1 class="text-white p-2">Activity</h1>
        </div>
        <div class="r-box flex flex-cols cursor-pointer">
            <?php 
                if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
                    echo '<h1 class="text-white p-2 hover:text-purple-200"><a href="index.php?action=register">สมัครสมาชิก</a></h1>';
                    echo '<h1 class="text-white p-2 hover:text-purple-200"><a href="index.php?action=login">เข้าสู่ระบบ</a></h1>';
                }
                else
                {

                }
                $homePag = 0;
                if (!$homePag)
                {
                    echo '<h1 class="text-white p-2 hover:text-purple-200"><a href="index.php?action=home">กลับสู่หน้าหลัก</a></h1>';
                }
              
            ?>
        </div>
    </nav>

</header>