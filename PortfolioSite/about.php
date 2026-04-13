<?php
session_start();

// --- CONTROLLER ---
$pageTitleText = "Alec.dev | About";
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
$mainHeadingText = "ABOUT ME!";
$fullNameText = "ALEC / DEV";
$bioHeadlineText = "Biography";
$biographyText = "Hi, I am Alec Dela Pena. Full stack developer with proficiency in 
HTML, CSS, PHP, JS, and Python. For hire and available for freelance work.";

// Skills
$skillsHeadlineText = "SKILLS";
$skillsArray = [
    ["name" => "HTML", "level" => "EXPERT", "color" => "bg-blue-400"],
    ["name" => "CSS", "level" => "EXPERT", "color" => "bg-pink-400"],
    ["name" => "JS", "level" => "INTERMEDIATE", "color" => "bg-yellow-300"],
    ["name" => "MYSQL", "level" => "INTERMEDIATE", "color" => "bg-green-400"],
    ["name" => "PYTHON", "level" => "BEGINNER", "color" => "bg-[#f4f4f0]"],
    ["name" => "BOOTSTRAP", "level" => "BEGINNER", "color" => "bg-orange-400"]
];

// Education
$educationHeadlineText = "EDUCATION";
$educationArray = [
    [
        "date" => "2024-2026",
        "title" => "BACHELOR OF SCIENCE IN COMPUTER SCIENCE",
        "institution" => "ANGELES UNIVERSITY FOUNDATION",
        "description" => "GAINED A FOUNDATIONAL UNDERSTANDING OF SOFTWARE AND WEB DEVELOPMENT."
    ]
];

$footerText = "&copy; " . date("Y") . " ALEC PORTFOLIO. ALL RIGHTS RESERVED.";
$tailwindCDN = "https://cdn.tailwindcss.com";
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
            <a href="<?php echo $navHomeLink; ?>" class="text-4xl font-bold tracking-tighter uppercase mb-4 md:mb-0 hover:bg-black hover:text-yellow-300 transition-none px-2">
                <?php echo $navBrandName; ?>
            </a>
            <div class="flex space-x-4 md:space-x-8 text-lg font-bold uppercase overflow-x-auto w-full md:w-auto">
                <a href="<?php echo $navHomeLink; ?>" class="hover:bg-blue-400 border-2 border-transparent hover:border-black transition-none px-3 py-1"><?php echo $navHomeText; ?></a>
                <a href="<?php echo $navAboutLink; ?>" class="bg-black text-white px-3 py-1"><?php echo $navAboutText; ?></a>
                <a href="<?php echo $navContactLink; ?>" class="hover:bg-pink-400 border-2 border-transparent hover:border-black transition-none px-3 py-1"><?php echo $navContactText; ?></a>
                <a href="<?php echo $navAdminLink; ?>" class="hover:bg-green-400 border-2 border-transparent hover:border-black transition-none px-3 py-1"><?php echo $navAdminText; ?></a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow py-20 px-6">
        <div class="max-w-6xl mx-auto space-y-24">

            <!-- Header Section -->
            <div class="inline-block bg-black text-white p-4 border-4 border-black shadow-[8px_8px_0px_0px_pink] rotate-2">
                <h1 class="text-6xl md:text-8xl font-black uppercase tracking-tighter"><?php echo $mainHeadingText; ?></h1>
            </div>

            <!-- Bio Section -->
            <div class="bg-blue-400 p-8 md:p-12 border-8 border-black shadow-[16px_16px_0px_0px_rgba(0,0,0,1)] flex flex-col lg:flex-row gap-12 items-stretch">
                <!-- Avatar block -->
                <div class="w-full lg:w-1/3 flex items-center justify-center bg-yellow-300 border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] hover:bg-pink-400 transition-none">
                    <div class="text-[10rem] font-black leading-none py-10">
                        <?php echo mb_substr($fullNameText, 0, 1); ?>
                    </div>
                </div>
                <div class="w-full lg:w-2/3 space-y-6 flex flex-col justify-center">
                    <h2 class="text-5xl font-black uppercase bg-white inline-block px-4 py-2 border-4 border-black"><?php echo $fullNameText; ?></h2>
                    <h3 class="text-3xl bg-black text-white px-4 py-2 uppercase font-bold inline-block"><?php echo $bioHeadlineText; ?></h3>
                    <p class="text-2xl font-bold leading-tight border-l-8 border-black pl-6 py-2 bg-white">
                        <?php echo $biographyText; ?>
                    </p>
                </div>
            </div>

            <!-- Skills Section -->
            <div>
                <h2 class="text-6xl font-black uppercase tracking-tighter mb-10 inline-block bg-green-400 border-4 border-black px-6 py-2 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]"><?php echo $skillsHeadlineText; ?></h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-0 border-t-4 border-l-4 border-black bg-black">
                    <?php foreach ($skillsArray as $skill): ?>
                        <div class="<?php echo $skill['color']; ?> border-r-4 border-b-4 border-black p-8 text-center hover:bg-black hover:text-white transition-none group cursor-crosshair h-full flex flex-col justify-center">
                            <h4 class="text-3xl md:text-5xl font-black uppercase mb-4">
                                <?php echo $skill['name']; ?>
                            </h4>
                            <p class="text-xl font-bold tracking-widest bg-white text-black px-2 py-1 inline-block mx-auto border-4 border-black group-hover:bg-yellow-300">
                                <?php echo $skill['level']; ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Education / Experience Section -->
            <div>
                <h2 class="text-6xl font-black uppercase tracking-tighter mb-10 inline-block bg-pink-400 border-4 border-black px-6 py-2 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]"><?php echo $educationHeadlineText; ?></h2>
                <div class="space-y-12">
                    <?php foreach ($educationArray as $index => $item): ?>
                        <div class="bg-white border-8 border-black shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] p-8 relative hover:-translate-y-2 transition-all group">
                            <!-- Brutalist receipt barcode decoration -->
                            <div class="absolute right-8 top-8 bottom-8 w-16 border-l-4 border-dashed border-black hidden md:block">
                                <div class="h-full w-full flex flex-col justify-between py-2 items-center opacity-50">
                                    <div class="h-1 bg-black w-8"></div><div class="h-4 bg-black w-12"></div><div class="h-2 bg-black w-10"></div><div class="h-8 bg-black w-8"></div><div class="h-1 bg-black w-12"></div><div class="h-6 bg-black w-10"></div>
                                </div>
                            </div>

                            <div class="md:pr-24">
                                <span class="bg-yellow-300 text-black border-4 border-black px-4 py-1 text-2xl font-black uppercase inline-block mb-4">
                                    <?php echo $item['date']; ?>
                                </span>
                                <h4 class="text-5xl font-black uppercase mb-2"><?php echo $item['title']; ?></h4>
                                <h5 class="text-2xl font-bold uppercase underline decoration-4 mb-6">ORG: <?php echo $item['institution']; ?></h5>
                                <p class="text-xl font-bold bg-[#f4f4f0] p-4 border-4 border-black inline-block">
                                    > <?php echo $item['description']; ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-black text-white py-8 border-t-8 border-black text-center font-bold text-xl uppercase mt-auto">
        <p><?php echo $footerText; ?></p>
    </footer>

</body>
</html>
