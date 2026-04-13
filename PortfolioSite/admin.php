<?php
session_start();

// --- CONTROLLER ---
$pageTitleText = "Alec.dev | Admin";
$htmlLang = "en";
$metaCharset = "UTF-8";
$metaViewport = "width=device-width, initial-scale=1.0";

// Navigation
$navBrandName = "ALEC.DEV";
$navHomeText = "HOME";
$navAboutText = "ABOUT";
$navContactText = "CONTACT";
$navAdminText = "ADMIN";
$navHomeLink = "index.php";
$navAboutLink = "about.php";
$navContactLink = "contact.php";
$navAdminLink = "admin.php";

$footerText = "&copy; " . date("Y") . " ALEC PORTFOLIO. ALL RIGHTS RESERVED.";
$tailwindCDN = "https://cdn.tailwindcss.com";

// Login Variables
$loginHeadingText = "AUTHORIZED PERSONNEL ONLY";
$passwordLabelText = "ACCESS KEY";
$passwordPlaceholderText = "••••••••";
$loginButtonText = "LOGIN";
$loginErrorText = "ACCESS DENIED. INVALID KEY.";

// Dashboard Variables
$adminHeadingText = "";
$logoutButtonText = "TERMINATE SESSION";
$logoutLink = "admin.php?logout=true";
$noRecordsText = "DATABASE EMPTY. NO RECORDS FOUND.";
$dbErrorFetchingText = "DATABASE OFFLINE. FETCH FAILED.";

$thNameText = "NAME";
$thEmailText = "EMAIL";
$thMessageText = "MESSAGE";
$thDateText = "TIMESTAMP";
$thActionsText = "ACTIONS";

$actionReplyText = "REPLY";
$actionDeleteText = "DELETE";
$deleteConfirmText = "WARNING: IRREVERSIBLE DELETION. PROCEED?";

$formAction = $_SERVER['PHP_SELF'];
$methodPost = "POST";

// Authentication & Logic
$sessionKey = "is_admin_logged_in";
$adminPassword = "admin123";
$showLoginError = false;

// Handle Logout
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    session_unset();
    session_destroy();
    header("Location: admin.php");
    exit();
}

$isLoggedIn = isset($_SESSION[$sessionKey]) && $_SESSION[$sessionKey] === true;

// Handle Form Submissions (Login / Delete)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';

    if ($action === 'login') {
        $password = $_POST['password'] ?? '';
        if ($password === $adminPassword) {
            $_SESSION[$sessionKey] = true;
            header("Location: admin.php");
            exit();
        } else {
            $showLoginError = true;
        }
    } elseif ($action === 'delete' && $isLoggedIn) {
        $idToDelete = $_POST['id'] ?? null;
        if ($idToDelete) {
            require_once 'db.php';
            try {
                $stmt = $pdo->prepare("DELETE FROM messages WHERE id = :id");
                $stmt->execute([':id' => $idToDelete]);
                header("Location: admin.php");
                exit();
            } catch (PDOException $e) {
                // Ignore for now
            }
        }
    }
}

// Fetch Contacts if logged in
$contactsData = [];
$dbFetchError = false;

if ($isLoggedIn) {
    require_once 'db.php';
    try {
        $stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
        $contactsData = $stmt->fetchAll();
    } catch (PDOException $e) {
        $dbFetchError = true;
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

    <!-- Navigation -->
    <nav class="bg-yellow-300 border-b-4 border-black relative z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-center">
            <a href="<?php echo $navHomeLink; ?>" class="text-4xl font-bold tracking-tighter uppercase mb-4 md:mb-0 hover:bg-black hover:text-white transition-none px-2">
                <?php echo $navBrandName; ?>
            </a>
            <div class="flex space-x-4 md:space-x-8 text-lg font-bold uppercase overflow-x-auto w-full md:w-auto">
                <a href="<?php echo $navHomeLink; ?>" class="hover:bg-blue-400 border-2 border-transparent hover:border-black transition-none px-3 py-1"><?php echo $navHomeText; ?></a>
                <a href="<?php echo $navAboutLink; ?>" class="hover:bg-pink-400 border-2 border-transparent hover:border-black transition-none px-3 py-1"><?php echo $navAboutText; ?></a>
                <a href="<?php echo $navContactLink; ?>" class="hover:bg-yellow-300 border-2 border-transparent hover:border-black transition-none px-3 py-1"><?php echo $navContactText; ?></a>
                <a href="<?php echo $navAdminLink; ?>" class="bg-black text-white px-3 py-1"><?php echo $navAdminText; ?></a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow py-20 px-6 <?php echo !$isLoggedIn ? 'flex items-center justify-center relative' : ''; ?>">
        
        <?php if (!$isLoggedIn): ?>
            <!-- Login Form -->
            <div class="max-w-md w-full bg-blue-400 p-8 border-8 border-black shadow-[16px_16px_0px_0px_rgba(0,0,0,1)] relative z-10 text-center">
                <h1 class="text-3xl font-black uppercase text-white bg-black p-4 border-4 border-black mb-8 inline-block shadow-[8px_8px_0px_0px_white] -rotate-2"><?php echo $loginHeadingText; ?></h1>
                
                <?php if ($showLoginError): ?>
                    <div class="bg-red-500 border-4 border-black text-white px-4 py-4 mb-8 font-black text-xl shadow-[8px_8px_0px_0px_black] rotate-1 uppercase">
                        <?php echo $loginErrorText; ?>
                    </div>
                <?php endif; ?>

                <form action="<?php echo $formAction; ?>" method="<?php echo $methodPost; ?>" class="space-y-8 text-left">
                    <input type="hidden" name="action" value="login">
                    <div>
                        <label for="password" class="block text-2xl font-black text-black mb-2 uppercase"><?php echo $passwordLabelText; ?></label>
                        <input type="password" id="password" name="password" required placeholder="<?php echo $passwordPlaceholderText; ?>" class="w-full px-6 py-4 bg-white border-4 border-black text-xl font-bold focus:outline-none focus:bg-yellow-300 focus:shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] transition-none rounded-none text-center tracking-[1em]">
                    </div>
                    <button type="submit" class="w-full bg-black text-white border-4 border-black text-2xl font-black uppercase py-4 px-6 hover:bg-yellow-300 hover:text-black shadow-[8px_8px_0px_0px_rgba(255,255,255,1)] hover:shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] hover:-translate-y-1 hover:translate-x-1 transition-all duration-75">
                        <?php echo $loginButtonText; ?>
                    </button>
                </form>
            </div>
        <?php else: ?>
            <!-- Admin Dashboard -->
            <div class="max-w-[90rem] mx-auto space-y-12">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6 bg-pink-400 p-8 border-8 border-black shadow-[16px_16px_0px_0px_rgba(0,0,0,1)]">
                    <h1 class="text-4xl md:text-5xl font-black uppercase tracking-tighter bg-white px-4 py-2 border-4 border-black"><?php echo $adminHeadingText; ?></h1>
                    <a href="<?php echo $logoutLink; ?>" class="bg-black text-white hover:bg-red-500 hover:text-black border-4 border-black font-black uppercase py-3 px-8 transition-none shadow-[8px_8px_0px_0px_rgba(255,255,255,1)] hover:shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] hover:-translate-y-1">
                        <?php echo $logoutButtonText; ?>
                    </a>
                </div>

                <div class="bg-white border-8 border-black shadow-[16px_16px_0px_0px_rgba(0,0,0,1)] overflow-hidden">
                    <?php if ($dbFetchError): ?>
                        <div class="p-16 text-center bg-red-500 text-white text-3xl font-black uppercase">
                            <?php echo $dbErrorFetchingText; ?>
                        </div>
                    <?php elseif (empty($contactsData)): ?>
                        <div class="p-16 text-center text-2xl font-black uppercase bg-gray-200 border-b-8 border-black">
                            <?php echo $noRecordsText; ?>
                        </div>
                    <?php else: ?>
                        <div class="overflow-x-auto w-full">
                            <table class="w-full text-left border-collapse min-w-max">
                                <thead>
                                    <tr class="bg-black text-white">
                                        <th class="p-6 font-black uppercase text-xl border-r-4 border-b-4 border-black"><?php echo $thDateText; ?></th>
                                        <th class="p-6 font-black uppercase text-xl border-r-4 border-b-4 border-black"><?php echo $thNameText; ?></th>
                                        <th class="p-6 font-black uppercase text-xl border-r-4 border-b-4 border-black"><?php echo $thEmailText; ?></th>
                                        <th class="p-6 font-black uppercase text-xl border-r-4 border-b-4 border-black"><?php echo $thMessageText; ?></th>
                                        <th class="p-6 font-black uppercase text-xl border-b-4 border-black text-center"><?php echo $thActionsText; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($contactsData as $index => $record): ?>
                                        <!-- Zebra Striping with harsh brutalist colors: White and Yellow -->
                                        <tr class="<?php echo $index % 2 === 0 ? 'bg-white' : 'bg-green-100'; ?> hover:bg-yellow-300 transition-none border-b-4 border-black">
                                            <td class="p-6 font-bold text-lg border-r-4 border-black whitespace-nowrap bg-black text-green-400 font-mono">
                                                > <?php echo date("Y-m-d H:i:s", strtotime($record['created_at'])); ?>
                                            </td>
                                            <td class="p-6 font-black text-xl border-r-4 border-black uppercase text-black">
                                                <?php echo htmlspecialchars($record['name']); ?>
                                            </td>
                                            <td class="p-6 font-bold text-lg border-r-4 border-black">
                                                <a href="mailto:<?php echo htmlspecialchars($record['email']); ?>" class="bg-blue-400 text-black px-2 py-1 border-2 border-black hover:bg-black hover:text-white transition-none uppercase">
                                                    <?php echo htmlspecialchars($record['email']); ?>
                                                </a>
                                            </td>
                                            <td class="p-6 font-bold text-lg border-r-4 border-black max-w-2xl leading-tight">
                                                <?php echo nl2br(htmlspecialchars($record['message'])); ?>
                                            </td>
                                            <td class="p-6 text-center align-middle">
                                                <div class="flex items-center justify-center space-x-4">
                                                    <!-- Reply Mailto Link -->
                                                    <a href="reply.php?id=<?php echo $record['id']; ?>" class="bg-blue-400 text-black border-4 border-black font-black uppercase py-2 px-4 hover:bg-black hover:text-white hover:-translate-y-1 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-none">
                                                        <?php echo $actionReplyText; ?>
                                                    </a>
                                                    
                                                    <!-- Delete Form -->
                                                    <form action="<?php echo $formAction; ?>" method="<?php echo $methodPost; ?>" onsubmit="return confirm('<?php echo $deleteConfirmText; ?>');" class="inline">
                                                        <input type="hidden" name="action" value="delete">
                                                        <input type="hidden" name="id" value="<?php echo $record['id']; ?>">
                                                        <button type="submit" class="bg-red-500 text-black border-4 border-black font-black uppercase py-2 px-4 hover:bg-black hover:text-red-500 hover:-translate-y-1 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-none">
                                                            <?php echo $actionDeleteText; ?>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer class="bg-black text-white py-8 border-t-8 border-black text-center font-bold text-xl uppercase mt-auto z-10 relative">
        <p><?php echo $footerText; ?></p>
    </footer>

</body>
</html>
