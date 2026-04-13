<?php
session_start();

// --- CONTROLLER ---
$pageTitleText = "Alec.dev | Home";
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

// Hero Content
$headlineText = "HI,<br>I'M<br>ALEC.";
$subHeadlineText = "BUILDING QUALITY, HIGH-PERFORMANCE DIGITAL SPACES USING HTML, CSS, PHP, JS, & MYSQL.";
$ctaButtonText = "VIEW WORK";
$ctaButtonLink = "about.php";

$footerText = "&copy; " . date("Y") . " ALEC PORTFOLIO. ALL RIGHTS RESERVED.";

// CDNs
$tailwindCDN = "https://cdn.tailwindcss.com";
$gsapCDN = "https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js";
?>
<!DOCTYPE html>
<html lang="<?php echo $htmlLang; ?>">
<head>
    <meta charset="<?php echo $metaCharset; ?>">
    <meta name="viewport" content="<?php echo $metaViewport; ?>">
    <title><?php echo $pageTitleText; ?></title>
    <script src="<?php echo $tailwindCDN; ?>"></script>
    <script src="<?php echo $gsapCDN; ?>"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap');
    </style>
</head>
<body class="bg-[#f4f4f0] text-black font-['Space_Mono'] antialiased flex flex-col min-h-screen selection:bg-pink-400 selection:text-black">

    <!-- Navigation -->
    <nav class="bg-yellow-300 border-b-4 border-black relative z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-center">
            <a href="<?php echo $navHomeLink; ?>" class="text-4xl font-bold tracking-tighter uppercase mb-4 md:mb-0 hover:bg-black hover:text-white transition-none px-2">
                <?php echo $navBrandName; ?>
            </a>
            <div class="flex space-x-4 md:space-x-8 text-lg font-bold uppercase overflow-x-auto w-full md:w-auto">
                <a href="<?php echo $navHomeLink; ?>" class="bg-black text-white px-3 py-1"><?php echo $navHomeText; ?></a>
                <a href="<?php echo $navAboutLink; ?>" class="hover:bg-blue-400 border-2 border-transparent hover:border-black transition-none px-3 py-1"><?php echo $navAboutText; ?></a>
                <a href="<?php echo $navContactLink; ?>" class="hover:bg-pink-400 border-2 border-transparent hover:border-black transition-none px-3 py-1"><?php echo $navContactText; ?></a>
                <a href="<?php echo $navAdminLink; ?>" class="hover:bg-green-400 border-2 border-transparent hover:border-black transition-none px-3 py-1"><?php echo $navAdminText; ?></a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center relative overflow-hidden py-20 px-6">
        <div class="z-10 w-full max-w-5xl">
            <!-- Staggered wrapper containers for GSAP clipping mask effect if desired, or pure slide in -->
            <div class="overflow-hidden mb-6">
                <h1 id="gsap-headline" class="text-7xl md:text-9xl font-black uppercase leading-[0.85] tracking-tighter invisible">
                    <?php echo $headlineText; ?>
                </h1>
            </div>
            
            <div class="overflow-hidden mb-12">
                <p id="gsap-subheadline" class="text-2xl md:text-4xl bg-black text-white p-4 font-bold max-w-3xl border-4 border-black inline-block invisible">
                    <?php echo $subHeadlineText; ?>
                </p>
            </div>
            
            <div class="overflow-hidden">
                <div id="gsap-cta" class="invisible inline-block">
                    <a href="<?php echo $ctaButtonLink; ?>" class="inline-block px-12 py-6 text-3xl font-black bg-pink-400 text-black border-8 border-black shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] hover:translate-x-2 hover:translate-y-2 hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all duration-75 ease-out uppercase">
                        <?php echo $ctaButtonText; ?>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Harsh Decorative Accents -->
        <div class="absolute top-20 right-10 w-32 h-32 bg-blue-400 border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] rotate-12 hidden md:block z-0"></div>
        <div class="absolute bottom-20 left-10 w-48 h-48 bg-green-400 rounded-full border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] hidden md:block z-0"></div>
    </main>

    <!-- Footer -->
    <footer class="bg-black text-white py-8 border-t-8 border-black text-center font-bold text-xl uppercase">
        <p><?php echo $footerText; ?></p>
    </footer>

    <!-- GSAP Animation Block -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            gsap.set(["#gsap-headline", "#gsap-subheadline", "#gsap-cta"], { autoAlpha: 1, x: "-100%" });
            
            gsap.to(["#gsap-headline", "#gsap-subheadline", "#gsap-cta"], {
                x: "0%",
                duration: 0.3,
                stagger: 0.15,
                ease: "power1.in", // Hard, fast slide-in with little ease out
                delay: 0.1
            });
        });
    </script>
</body>
</html>
