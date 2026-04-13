<?php
session_start();

// --- CONTROLLER ---
require_once 'db.php';

// CONFIGURATION: Replace with your actual keys
$recaptchaSiteKey = "6LezHLUsAAAAAGdw2G8DgT6ewGxl9Fb-DX0iNh6k";
$recaptchaSecretKey = "6LezHLUsAAAAALOeG2AJ1qmswLi65-MGYB9KF9Dl";

$pageTitleText = "Alec.dev | Contact";
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

// Content Variables
$headingText = "CONTACT ME!";
$subHeadingText = "SEND ME A MESSAGE. I'LL GET IN TOUCH.";
$nameLabelText = "NAME";
$emailLabelText = "EMAIL";
$messageLabelText = "MESSAGE";
$submitButtonText = "SEND";
$successMessageText = "THANK YOU FOR SENDING A MESSAGE.";
$errorMessageText = "CAPTCHA ERROR.";
$dbErrorMessageText = "DATABASE CONNECTION FAILED.";
$captchaErrorMessageText = "ROBOT VERIFICATION FAILED. TRY AGAIN.";
$namePlaceholderText = "JUAN CRUZ";
$emailPlaceholderText = "JUANCRUZ@EMAIL.COM";
$messagePlaceholderText = "HELLO THERE!";
$formAction = $_SERVER['PHP_SELF'];
$formMethod = "POST";

$footerText = "&copy; " . date("Y") . " ALEC PORTFOLIO. ALL RIGHTS RESERVED.";
$tailwindCDN = "https://cdn.tailwindcss.com";

// Form Processing Logic
$showSuccess = false;
$showError = false;
$showDbError = false;
$showCaptchaError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $message = trim($_POST["message"] ?? "");
    // Check for the Google reCAPTCHA token instead of the math answer
    $recaptchaResponse = $_POST['g-recaptcha-response'] ?? "";

    // 1. Verify all fields are filled
    if (!empty($name) && !empty($email) && !empty($message) && !empty($recaptchaResponse)) {
        
        // 2. Verify reCAPTCHA with Google via cURL (Safer for localhost)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'secret'   => $recaptchaSecretKey,
            'response' => $recaptchaResponse
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        
        $verifyResponse = curl_exec($ch);
        curl_close($ch);
        
        $responseData = json_decode($verifyResponse);

        if ($responseData && $responseData->success) {
            try {
                // 3. Save to Database
                $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (:name, :email, :message)");
                $stmt->execute([
                    ':name' => $name,
                    ':email' => $email,
                    ':message' => $message
                ]);
                $showSuccess = true;
            } catch (PDOException $e) {
                $showDbError = true;
            }
        } else {
            // Captcha failed verification
            $showCaptchaError = true;
        }
    } else {
        // One of the inputs or the captcha checkbox was missed
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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
            <div class="flex space-x-4 md:space-x-8 text-lg font-bold uppercase overflow-x-auto w-full md:w-auto">
                <a href="<?php echo $navHomeLink; ?>" class="hover:bg-blue-400 border-2 border-transparent hover:border-black transition-none px-3 py-1"><?php echo $navHomeText; ?></a>
                <a href="<?php echo $navAboutLink; ?>" class="hover:bg-pink-400 border-2 border-transparent hover:border-black transition-none px-3 py-1"><?php echo $navAboutText; ?></a>
                <a href="<?php echo $navContactLink; ?>" class="bg-black text-white px-3 py-1"><?php echo $navContactText; ?></a>
                <a href="<?php echo $navAdminLink; ?>" class="hover:bg-green-400 border-2 border-transparent hover:border-black transition-none px-3 py-1"><?php echo $navAdminText; ?></a>
            </div>
        </div>
    </nav>

    <main class="flex-grow py-20 px-6 flex items-center justify-center relative">
        <div class="w-full max-w-3xl space-y-10 relative z-10">
            
            <div class="bg-black text-white p-6 border-8 border-black shadow-[16px_16px_0px_0px_rgba(0,0,0,1)] inline-block rotate-1 mb-8">
                <h1 class="text-6xl font-black uppercase tracking-tighter"><?php echo $headingText; ?></h1>
            </div>
            
            <p class="text-2xl font-bold bg-white border-4 border-black inline-block p-4 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] -rotate-1">
                <?php echo $subHeadingText; ?>
            </p>

            <div class="bg-blue-400 p-8 md:p-12 border-8 border-black shadow-[16px_16px_0px_0px_rgba(0,0,0,1)] mt-8">
                
                <?php if ($showSuccess): ?>
                    <div class="bg-green-400 border-4 border-black text-black px-6 py-6 font-black text-2xl uppercase mb-8 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
                        <?php echo $successMessageText; ?>
                    </div>
                <?php endif; ?>

                <?php if ($showError): ?>
                    <div class="bg-red-500 border-4 border-black text-white px-6 py-6 font-black text-2xl uppercase mb-8 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
                        <?php echo $errorMessageText; ?>
                    </div>
                <?php endif; ?>

                <?php if ($showDbError): ?>
                    <div class="bg-red-500 border-4 border-black text-white px-6 py-6 font-black text-2xl uppercase mb-8 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
                        <?php echo $dbErrorMessageText; ?>
                    </div>
                <?php endif; ?>

                <?php if ($showCaptchaError): ?>
                    <div class="bg-orange-500 border-4 border-black text-white px-6 py-6 font-black text-2xl uppercase mb-8 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
                        <?php echo $captchaErrorMessageText; ?>
                    </div>
                <?php endif; ?>

                <?php if (!$showSuccess): ?>
                <form action="<?php echo $formAction; ?>" method="<?php echo $formMethod; ?>" class="space-y-8">
                    <div>
                        <label for="name" class="block text-2xl font-black text-black mb-2 uppercase"><?php echo $nameLabelText; ?></label>
                        <input type="text" id="name" name="name" required placeholder="<?php echo $namePlaceholderText; ?>" class="w-full px-6 py-4 bg-white border-4 border-black text-xl font-bold focus:outline-none focus:bg-yellow-300 focus:shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] transition-none uppercase selection:bg-black selection:text-white rounded-none">
                    </div>
                    <div>
                        <label for="email" class="block text-2xl font-black text-black mb-2 uppercase"><?php echo $emailLabelText; ?></label>
                        <input type="email" id="email" name="email" required placeholder="<?php echo $emailPlaceholderText; ?>" class="w-full px-6 py-4 bg-white border-4 border-black text-xl font-bold focus:outline-none focus:bg-yellow-300 focus:shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] transition-none uppercase selection:bg-black selection:text-white rounded-none">
                    </div>
                    <div>
                        <label for="message" class="block text-2xl font-black text-black mb-2 uppercase"><?php echo $messageLabelText; ?></label>
                        <textarea id="message" name="message" rows="5" required placeholder="<?php echo $messagePlaceholderText; ?>" class="w-full px-6 py-4 bg-white border-4 border-black text-xl font-bold focus:outline-none focus:bg-pink-400 focus:shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] transition-none uppercase resize-none selection:bg-black selection:text-white rounded-none"></textarea>
                    </div>

                    <div class="bg-[#f4f4f0] p-6 border-4 border-black border-dashed flex flex-col items-center">
                        <label class="block text-2xl font-black text-black mb-4 uppercase text-center">Are you a robot?</label>
                        <div class="g-recaptcha shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]" data-sitekey="<?php echo $recaptchaSiteKey; ?>"></div>
                    </div>

                    <button type="submit" class="w-full bg-yellow-300 text-black border-8 border-black text-3xl font-black uppercase py-6 px-8 hover:bg-black hover:text-white hover:translate-x-2 hover:translate-y-2 hover:shadow-[0px_0px_0px_0px_rgba(0,0,0,1)] hover:border-yellow-300 shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] transition-all duration-75">
                        <?php echo $submitButtonText; ?>
                    </button>
                </form>
                <?php endif; ?>
            </div>

        </div>
    </main>

    <footer class="bg-black text-white py-8 border-t-8 border-black text-center font-bold text-xl uppercase mt-auto">
        <p><?php echo $footerText; ?></p>
    </footer>

</body>
</html>