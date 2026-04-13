<?php
session_start();
require_once 'db.php';

// Authentication Check: Only logged-in admins can access this page
$sessionKey = "is_admin_logged_in";
if (!isset($_SESSION[$sessionKey]) || $_SESSION[$sessionKey] !== true) {
    header("Location: admin.php");
    exit();
}

// --- CONTROLLER ---
$pageTitleText = "Alec.dev | Reply";
$htmlLang = "en";
$metaCharset = "UTF-8";
$metaViewport = "width=device-width, initial-scale=1.0";

// Navigation
$navBrandName = "ALEC.DEV";
$navHomeLink = "index.php";
$navAboutLink = "about.php";
$navContactLink = "contact.php";
$navAdminLink = "admin.php";

$footerText = "&copy; " . date("Y") . " ALEC PORTFOLIO. ALL RIGHTS RESERVED.";
$tailwindCDN = "https://cdn.tailwindcss.com";

// Content Variables
$headingText = "REPLY TO USER";
$subHeadingText = "DRAFTING RESPONSE TO DATABASE RECORD.";
$replyLabelText = "YOUR RESPONSE";
$submitButtonText = "SEND";
$successMessageText = "REPLY SENT SUCCESSFULLY.";
$errorMessageText = "REPLY FIELD CANNOT BE EMPTY.";

// Fetch User Data based on ID
$userID = $_GET['id'] ?? null;
$userData = null;

if ($userID) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM messages WHERE id = :id");
        $stmt->execute([':id' => $userID]);
        $userData = $stmt->fetch();
    } catch (PDOException $e) {
        // Handle error
    }
}

// Redirect if no valid user found
if (!$userData) {
    header("Location: admin.php");
    exit();
}

$showSuccess = false;
$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminReply = trim($_POST["admin_reply"] ?? "");

    if (!empty($adminReply)) {
        // Logic to send email or save reply to DB would go here
        $showSuccess = true;
    } else {
        $showError = true;
    }
}
?>
<!DOCTYPE html>
<html lang="<?php echo $htmlLang; ?>">
<head>
    <meta charset="<?php echo $metaCharset; ?>">
    <meta name="viewport" content="<?php echo $metaViewport; ?>">
    <title><?php echo $pageTitleText; ?></title>
    <script src="<?php echo $tailwindCDN; ?>"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap');
    </style>
</head>
<body class="bg-[#f4f4f0] text-black font-['Space_Mono'] antialiased min-h-screen flex flex-col selection:bg-black selection:text-white">

    <nav class="bg-yellow-300 border-b-4 border-black relative z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-center">
            <a href="<?php echo $navHomeLink; ?>" class="text-4xl font-bold tracking-tighter uppercase mb-4 md:mb-0 hover:bg-black hover:text-white transition-none px-2">
                <?php echo $navBrandName; ?>
            </a>
            <div class="flex space-x-4 md:space-x-8 text-lg font-bold uppercase">
                <a href="<?php echo $navHomeLink; ?>" class="hover:bg-blue-400 border-2 border-transparent hover:border-black transition-none px-3 py-1">HOME</a>
                <a href="<?php echo $navAboutLink; ?>" class="hover:bg-pink-400 border-2 border-transparent hover:border-black transition-none px-3 py-1">ABOUT</a>
                <a href="<?php echo $navContactLink; ?>" class="hover:bg-yellow-300 border-2 border-transparent hover:border-black transition-none px-3 py-1">CONTACT</a>
                <a href="<?php echo $navAdminLink; ?>" class="bg-black text-white px-3 py-1">ADMIN</a>
            </div>
        </div>
    </nav>

    <main class="flex-grow py-20 px-6 flex items-center justify-center relative">
        <div class="w-full max-w-4xl space-y-10 relative z-10">
            
            <div class="bg-black text-white p-6 border-8 border-black shadow-[16px_16px_0px_0px_rgba(0,0,0,1)] inline-block rotate-1 mb-8">
                <h1 class="text-6xl font-black uppercase tracking-tighter"><?php echo $headingText; ?></h1>
            </div>
            
            <p class="text-2xl font-bold bg-white border-4 border-black inline-block p-4 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] -rotate-1">
                <?php echo $subHeadingText; ?>
            </p>

            <div class="bg-pink-400 p-8 md:p-12 border-8 border-black shadow-[16px_16px_0px_0px_rgba(0,0,0,1)] mt-8">
                
                <?php if ($showSuccess): ?>
                    <div class="bg-green-400 border-4 border-black text-black px-6 py-6 font-black text-2xl uppercase mb-8 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
                        <?php echo $successMessageText; ?>
                        <br>
                        <a href="admin.php" class="text-lg underline mt-2 inline-block">RETURN TO DASHBOARD</a>
                    </div>
                <?php endif; ?>

                <?php if ($showError): ?>
                    <div class="bg-red-500 border-4 border-black text-white px-6 py-6 font-black text-2xl uppercase mb-8 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
                        <?php echo $errorMessageText; ?>
                    </div>
                <?php endif; ?>

                <?php if (!$showSuccess): ?>
                <form action="" method="POST" class="space-y-8">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                        <div class="bg-white p-6 border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
                            <label class="block text-xl font-black uppercase text-gray-500 mb-1">RECIPIENT NAME</label>
                            <p class="text-2xl font-black uppercase"><?php echo htmlspecialchars($userData['name']); ?></p>
                        </div>
                        <div class="bg-white p-6 border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
                            <label class="block text-xl font-black uppercase text-gray-500 mb-1">RECIPIENT EMAIL</label>
                            <p class="text-2xl font-black uppercase"><?php echo htmlspecialchars($userData['email']); ?></p>
                        </div>
                    </div>

                    <div class="bg-yellow-300 p-6 border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] mb-10">
                        <label class="block text-xl font-black uppercase text-black mb-2">ORIGINAL MESSAGE</label>
                        <p class="text-xl font-bold italic">"<?php echo nl2br(htmlspecialchars($userData['message'])); ?>"</p>
                    </div>

                    <div>
                        <label for="admin_reply" class="block text-2xl font-black text-black mb-2 uppercase"><?php echo $replyLabelText; ?></label>
                        <textarea id="admin_reply" name="admin_reply" rows="8" required placeholder="TYPE YOUR RESPONSE HERE..." class="w-full px-6 py-4 bg-white border-4 border-black text-xl font-bold focus:outline-none focus:bg-green-400 focus:shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] transition-none uppercase resize-none selection:bg-black selection:text-white rounded-none"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-black text-white border-8 border-black text-4xl font-black uppercase py-6 px-8 hover:bg-yellow-300 hover:text-black hover:translate-x-2 hover:translate-y-2 hover:shadow-[0px_0px_0px_0px_rgba(0,0,0,1)] shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] transition-all duration-75">
                        <?php echo $submitButtonText; ?>
                    </button>
                </form>
                <?php endif; ?>
            </div>

            <div class="text-center mt-10">
                <a href="admin.php" class="inline-block bg-white border-4 border-black px-6 py-2 font-black uppercase hover:bg-black hover:text-white transition-none shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
                    < BACK TO ADMIN
                </a>
            </div>
        </div>
    </main>

    <footer class="bg-black text-white py-8 border-t-8 border-black text-center font-bold text-xl uppercase mt-auto">
        <p><?php echo $footerText; ?></p>
    </footer>

</body>
</html>