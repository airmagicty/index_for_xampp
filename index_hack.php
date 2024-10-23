<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My XAMPP Dashboard - Hacker Style</title>
    <!-- Base64 favicon -->
    <link rel="icon" href="data:image/png;base64,PUT_YOUR_BASE64_ENCODED_ICON_HERE">
    <!-- CSS styles -->
    <style>
        /* Основные стили */
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #0d0d0d;
            color: #00ff00;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        header {
            background-color: #111;
            color: #00ff00;
            padding: 20px;
            text-align: center;
            font-size: 26px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-title {
            font-size: 28px;
        }
        .header-made {
            font-size: 12px;
            opacity: 0.7;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 20px auto;
            width: 80%;
        }
        .button {
            background-color: #005500;
            border: 2px solid #00ff00;
            color: #00ff00;
            padding: 10px 20px;
            margin: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }
        .button:hover {
            background-color: #00ff00;
            color: #005500;
        }
        #search-bar {
            width: 100%;
            max-width: 600px;
            padding: 10px;
            margin-bottom: 20px;
            background-color: #111;
            color: #00ff00;
            border: 2px solid #00ff00;
        }
        .directory {
            margin-top: 20px;
            width: 100%;
        }
        .directory ul {
            list-style-type: none;
            padding-left: 20px;
        }
        .directory ul ul {
            display: none; /* Hidden by default */
        }
        .toggle-btn {
            cursor: pointer;
            color: #00ff00;
            font-weight: bold;
        }
        .directory-item {
            margin: 5px 0;
        }
        .directory-item a {
            color: #00ff00;
            text-decoration: none;
            font-size: 18px;
            transition: color 0.3s;
        }
        .directory-item a:hover {
            color: #33ff33;
        }
        .directory-item.directory a {
            font-weight: bold;
            font-size: 20px;
        }
        .directory-item.file a {
            font-style: italic;
        }
        .blinking-cursor {
            font-weight: bold;
            font-size: 18px;
            animation: blink 1s step-end infinite;
        }
        @keyframes blink {
            from, to { color: transparent; }
            50% { color: #00ff00; }
        }
    </style>
    <!-- JavaScript for directory navigation and search -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Toggle visibility of nested directories
            document.querySelectorAll('.toggle-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const nextUl = this.nextElementSibling;
                    if (nextUl && nextUl.tagName === 'UL') {
                        nextUl.style.display = nextUl.style.display === 'block' ? 'none' : 'block';
                        this.textContent = nextUl.style.display === 'block' ? '[-]' : '[+]';
                    }
                });
            });

            // Search functionality
            document.getElementById('search-bar').addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();
                document.querySelectorAll('.directory-item').forEach(item => {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(searchTerm) ? 'block' : 'none';
                });
            });
        });

        function openPhpMyAdmin() {
            window.open('http://localhost/phpmyadmin', '_blank');
        }
    </script>
</head>
<body>
    <header>
        <div class="header-title">Welcome to My XAMPP Dashboard</div>
        <div class="header-made">Сделано airmagicty @ 2024</div>
    </header>

    <div class="container">
        <!-- Functional Buttons -->
        <button class="button" onclick="openPhpMyAdmin()">Open phpMyAdmin</button>
        <input type="text" id="search-bar" placeholder="Type to search files and directories...">

        <!-- Directory Structure -->
        <div class="directory">
            <?php
            // PHP Function to Scan Directories and Generate HTML
            function scanDirectory($dir, $depth = 0, $maxDepth = 3) {
                if ($depth > $maxDepth) return '';

                $html = '<ul>';
                $files = scandir($dir);
                foreach ($files as $file) {
                    if ($file === '.' || $file === '..') continue;
                    $path = $dir . DIRECTORY_SEPARATOR . $file;
                    $relativePath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $path);
                    
                    if (is_dir($path)) {
                        $html .= '<li class="directory-item directory"><span class="toggle-btn">[+]</span> ';
                        $html .= '<a href="' . $relativePath . '">' . $file . '</a>';
                        $html .= scanDirectory($path, $depth + 1, $maxDepth);
                        $html .= '</li>';
                    } else {
                        $html .= '<li class="directory-item file"><a href="' . $relativePath . '">' . $file . '</a></li>';
                    }
                }
                $html .= '</ul>';
                return $html;
            }

            // Scan current directory
            echo scanDirectory(__DIR__);
            ?>
        </div>
    </div>
</body>
</html>
