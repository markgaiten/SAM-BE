<?php
include("db.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Persona Isle of Mark</title>
    <meta charset="UTF-8">
    <link rel="icon" href="../image/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        :root {
            --bg: #fefac0;
            --surface: #e9edc9;
            --border: #ccd5ae;
            --ink: #4a3728;
            --muted: #8a7560;
            --accent: #d4a373;
            --warm: #d4a373;
            --accent-glow: rgba(212, 163, 115, 0.35);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body,
        html {
            margin: 0;
            padding: 0;
            font-family: "Raleway", 'Segoe UI', sans-serif;
            background-color: var(--bg);
            color: var(--ink);
            line-height: 1.8;
        }

        /* NAVBAR */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background-color: var(--bg);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            height: 62px;
            box-shadow: 0 2px 12px rgba(74, 55, 40, 0.08);
            transition: box-shadow 0.3s, background-color 0.3s;
        }

        .navbar-scrolled {
            box-shadow: 0 4px 24px rgba(74, 55, 40, 0.16);
            background-color: rgba(254, 250, 224, 0.97);
            backdrop-filter: blur(6px);
        }

        .navbar-brand {
            color: var(--ink);
            font-size: 1.1rem;
            font-weight: 700;
            text-decoration: none;
            letter-spacing: 0.04em;
            transition: color 0.2s;
        }

        .navbar-brand:hover {
            color: var(--accent);
        }

        .navbar-links {
            display: flex;
            gap: 4px;
        }

        .navbar-links a {
            color: var(--muted);
            text-decoration: none;
            padding: 8px 13px;
            border-radius: 6px;
            font-size: 0.92rem;
            transition: color 0.25s, background-color 0.25s;
            position: relative;
        }

        .navbar-links a::after {
            content: '';
            position: absolute;
            bottom: 4px;
            left: 13px;
            right: 13px;
            height: 2px;
            background-color: var(--accent);
            border-radius: 2px;
            transform: scaleX(0);
            transition: transform 0.25s ease;
        }

        .navbar-links a:hover,
        .navbar-links a.active {
            color: var(--ink);
        }

        .navbar-links a:hover::after,
        .navbar-links a.active::after {
            transform: scaleX(1);
        }

        .navbar-links a i {
            margin-right: 5px;
        }

        .hamburger {
            display: none;
            background: none;
            border: 1px solid var(--border);
            color: var(--ink);
            font-size: 1.1rem;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .hamburger:hover {
            background-color: var(--surface);
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 240px;
            height: 100%;
            background-color: var(--surface);
            border-right: 1px solid var(--border);
            z-index: 2000;
            padding-top: 16px;
            flex-direction: column;
            transform: translateX(-100%);
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
        }

        .sidebar.open {
            transform: translateX(0);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(74, 55, 40, 0.3);
            z-index: 1999;
            opacity: 0;
            transition: opacity 0.35s;
        }

        .sidebar-overlay.open {
            display: block;
            opacity: 1;
        }

        .sidebar a {
            display: block;
            padding: 14px 24px;
            color: var(--ink);
            text-decoration: none;
            border-bottom: 1px solid var(--border);
            font-size: 0.95rem;
            transition: color 0.2s, background-color 0.2s, padding-left 0.2s;
        }

        .sidebar a:hover {
            color: var(--accent);
            background-color: rgba(212, 163, 115, 0.1);
            padding-left: 30px;
        }

        .sidebar .close-btn {
            color: var(--muted);
        }

        @media (max-width: 768px) {
            .navbar-links {
                display: none;
            }

            .hamburger {
                display: block;
            }
        }

        /* HERO */
        .hero {
            background-image: linear-gradient(rgba(253, 250, 224, 0.6), rgba(233, 237, 201, 0.75)), url("/w3images/mac.jpg");
            background-position: center;
            background-size: cover;
            min-height: 58vh;
            display: flex;
            align-items: center;
            padding: 100px 60px 70px;
            margin-top: 62px;
            border-bottom: 1px solid var(--border);
        }

        .hero-text h1 {
            font-size: clamp(2rem, 5vw, 3.4rem);
            color: var(--ink);
            margin: 0 0 14px;
            letter-spacing: 0.03em;
            font-weight: 800;
            opacity: 0;
            transform: translateY(24px);
            animation: fadeUp 0.8s 0.2s ease forwards;
        }

        .hero-text p {
            font-size: 1.05rem;
            color: var(--muted);
            max-width: 540px;
            margin: 0;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 0.8s 0.45s ease forwards;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ISLAND */
        .island-section {
            padding: 80px 60px;
            background-color: var(--bg);
        }

        .island-section.alt {
            background-color: var(--surface);
        }

        .island-section h1 {
            text-align: center;
            font-size: clamp(1.7rem, 3vw, 2.4rem);
            letter-spacing: 0.03em;
            margin-bottom: 10px;
        }

        .island-section h4 {
            text-align: center;
            color: var(--muted);
            font-size: 1.05rem;
            font-weight: 400;
            margin-bottom: 14px;
        }

        .island-section p.desc {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 16px;
            color: var(--muted);
            font-size: 0.97rem;
        }

        .section-divider {
            width: 56px;
            height: 3px;
            background-color: var(--accent);
            border-radius: 2px;
            margin: 0 auto 48px;
            transition: width 0.4s ease;
        }

        .island-section:hover .section-divider {
            width: 100px;
        }

        /* CARDS */
        .cards-row-wrapper {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 48px;
        }

        .cards-row {
            display: flex;
            gap: 24px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding-bottom: 12px;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        .cards-row::-webkit-scrollbar {
            display: none;
        }

        .row-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-60%);
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 1px solid var(--border);
            background-color: var(--bg);
            color: var(--ink);
            font-size: 0.9rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(74, 55, 40, 0.1);
            transition: background-color 0.2s, border-color 0.2s, transform 0.2s, box-shadow 0.2s;
            z-index: 1;
        }

        .row-btn:hover {
            background-color: var(--accent);
            border-color: var(--accent);
            color: var(--bg);
            transform: translateY(-60%) scale(1.1);
            box-shadow: 0 4px 14px var(--accent-glow)
        }

        .row-btn.left {
            left: 0;
        }

        .row-btn.right {
            right: 0;
        }

        .island-section.alt .row-btn {
            background-color: var(--surface);
        }

        .cards-row-wrapper.no-controls {
            padding: 0;
        }

        /* CONTENT CARDS */
        .content-card {
            flex: 0 0 260px;
            background-color: var(--bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.35s ease, border-color 0.3s ease;
            cursor: default;
        }

        .island-section.alt .content-card {
            background-color: var(--bg);
        }

        .content-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 12px 32px rgba(74, 55, 40, 0.14);
            border-color: var(--accent);
        }

        .content-card img {
            width: 100%;
            height: 170px;
            object-fit: cover;
            display: block;
            border-bottom: 2px solid var(--border);
            transition: border-color 0.3s, transform 0.4s ease;
        }

        .content-card:hover img {
            border-color: var(--accent);
            transform: scale(1.04);
        }

        .card-img-wrap {
            overflow: hidden;
        }

        .content-card .card-body {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            text-align: center;
        }

        .content-card .card-body h3 {
            font-size: 0.97rem;
            color: var(--ink);
            margin: 0;
            font-weight: 600;
            line-height: 1.5;
            transition: color 0.2s;
        }

        .content-card:hover .card-body h3 {
            color: var(--accent);
        }

        .no-content {
            text-align: center;
            color: var(--muted);
            font-style: italic;
            padding: 20px 0;
        }

        /* FOOTER */
        footer {
            background-color: var(--surface);
            border-top: 1px solid var(--border);
            text-align: center;
            padding: 48px 20px;
        }

        .back-to-top {
            display: inline-block;
            padding: 10px 24px;
            background-color: var(--accent);
            color: var(--bg);
            text-decoration: none;
            border-radius: 6px;
            font-size: 0.95rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            transition: background-color 0.25s, box-shadow 0.25s, transform 0.25s;
        }

        .back-to-top:hover {
            background-color: var(--ink);
            color: var(--bg);
            box-shadow: 0 4px 16px var(--accent-glow);
            transform: translateY(-2px);
        }

        .back-to-top i {
            margin-right: 6px;
        }

        footer p {
            margin-top: 16px;
            color: var(--muted);
            font-size: 0.85rem;
        }

        @media (max-width: 600px) {
            .island-section {
                padding: 50px 24px;
            }

            .hero {
                padding: 100px 24px 60px;
            }

            .navbar {
                padding: 0 20px;
            }

            .cards-row-wrapper {
                padding: 0 36px;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar" id="mainNav">
        <a href="#home" class="navbar-brand"> Persona Isle of Mark </a>
        <div class="navbar-links">
            <a href="#home"><i class="fa fa-home"></i> Home </a>
            <a href="#Camaraderie"><i class="fa fa-handshake-o"></i> Camaraderie </a>
            <a href="#Game"><i class="fa fa-gamepad"></i> Game Over </a>
            <a href="#Fur"><i class="fa fa-paw"></i> Fur-tastic </a>
            <a href="#Haven"><i class="fa fa-leaf"></i> Harmony Haven </a>
        </div>
        <button class="hamburger" onclick="toggleSidebar()"><i class="fa fa-bars"></i></button>
    </nav>

    <!-- SIDEBAR -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
    <nav class="sidebar" id="mySidebar">
        <a href="javascript:void(0)" onclick="toggleSidebar()" class="close-btn"><i class="fa fa-times"></i> Close </a>
        <a href="#home" onclick="toggleSidebar()"><i class="fa fa-home"></i> Home </a>
        <a href="#Camaraderie" onclick="toggleSidebar()"><i class="fa fa-handshake-o"></i> Camaraderie </a>
        <a href="#Game" onclick="toggleSidebar()"><i class="fa fa-gamepad"></i> Game Over </a>
        <a href="#Fur" onclick="toggleSidebar()"><i class="fa fa-paw"></i> Fur-tastic </a>
        <a href="#Haven" onclick="toggleSidebar()"><i class="fa fa-leaf"></i> Harmony Haven </a>
    </nav>

    <!-- HERO -->
    <header class="hero" id="home">
        <div class="hero-text">
            <h1> Persona Isle of Mark </h1>
            <p> Step into the world of my persona, where every layer reveals a story, a passion, and a unique spark.
            </p>
        </div>
    </header>

    <?php
    function renderIsland($islandID, $sectionID, $altBg = false, $showControls = true)
    {
        $altClass = $altBg ? ' alt' : '';
        $rowID = 'row-' . $sectionID;

        $headerResult = executeQuery("SELECT * FROM `islandsOfPersonality` WHERE islandOfPersonalityID = $islandID");
        $header = mysqli_fetch_assoc($headerResult);
        if (!$header)
            return;
        ?>

        <!-- ISLAND  -->
        <section class="island-section<?php echo $altClass; ?>" id="<?php echo htmlspecialchars($sectionID); ?>">
            <h1 style="color: <?php echo htmlspecialchars($header['color']); ?>">
                <?php echo htmlspecialchars($header['name']); ?>
            </h1>
            <h4>
                <?php echo htmlspecialchars($header['shortDescription']); ?>
            </h4>
            <p class="desc">
                <?php echo htmlspecialchars($header['longDescription']); ?>
            </p>
            <div class="section-divider"></div>
            <?php

            $contentResult = executeQuery("SELECT * FROM islandcontents WHERE islandOfPersonalityID = $islandID");
            if ($contentResult && mysqli_num_rows($contentResult) > 0): ?>
                <div class="cards-row-wrapper<?php echo !$showControls ? ' no-controls' : ''; ?>">
                    <?php if ($showControls): ?><button class="row-btn left"
                            onclick="scrollRow('<?php echo $rowID; ?>', -1)">&#10094;</button>
                    <?php endif; ?>
                    <div class="cards-row" id="<?php echo $rowID; ?>">
                        <?php while ($row = mysqli_fetch_assoc($contentResult)): ?>
                            <div class="content-card">
                                <div class="card-img-wrap">
                                    <img src="<?php echo htmlspecialchars($row['image']); ?>"
                                        alt="<?php echo htmlspecialchars($row['content']); ?>">
                                </div>
                                <div class="card-body">
                                    <h3>
                                        <?php echo htmlspecialchars($row['content']); ?>
                                    </h3>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <?php if ($showControls): ?><button class="row-btn right"
                            onclick="scrollRow('<?php echo $rowID; ?>', 1)">&#10095</button>
                    <?php endif; ?>

                </div>
            <?php else: ?>
                <p class="no-content"> No content available for this island. </p>
            <?php endif; ?>
        </section>

        <?php
    }

    renderIsland(1, 'Camaraderie', false, false);
    renderIsland(2, 'Game', true, false);
    renderIsland(3, 'Fur', false);
    renderIsland(4, 'Haven', true);
    ?>

    <!-- FOOTER -->
    <footer>
        <a href="#home" class="back-to-top"><i class="fa fa-arrow-up"></i> Back to Top </a>
        <p> Persona Isle of Mark &mdash;
            <?php echo date('Y'); ?>
        </p>
    </footer>
</body>

<script>
    const mainNav = document.getElementById('mainNav');
    const navLinks = document.querySelectorAll('.navbar-links a');
    const sections = document.querySelectorAll('.island-section, header.hero');

    window.addEventListener('scroll', () => {
        mainNav.classList.toggle('scrolled', window.scrollY > 10);

        let current = '';
        sections.forEach(section => {
            if (window.scrollY >= section.offsetTop - 80) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === '#' + current) {
                link.classList.add('active');
            }
        });
    });

    function scrollRow(rowID, direction) {
        const row = document.getElementById(rowID);
        row.scrollBy({ left: direction * 300, behavior: 'smooth' });
    }

    function toggleSidebar() {
        const sidebar = document.getElementById('mySidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const isOpen = sidebar.classList.contains('open');
        sidebar.classList.toggle('open', !isOpen);
        overlay.classList.toggle('open', !isOpen);
    }

</script>

</html>