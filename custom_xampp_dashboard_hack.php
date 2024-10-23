<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My XAMPP Dashboard</title>
    <!-- Base64 favicon -->
    <link href="data:image/x-icon;base64,AAABAAEAEBAQAAEABAAoAQAAFgAAACgAAAAQAAAAIAAAAAEABAAAAAAAgAAAAAAAAAAAAAAAEAAAAAAAAAAU/zkAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEREREREREREREREREREREREBEREQAAAREQAREREREREREAERERERERERABEREREREREQAREREREREREAEREREREREQAREREREREQAREREREREQAREREREREQAREREREREQARERERERERAREREREREREREREREREREREREREREREAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA" rel="icon" type="image/x-icon">
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
</head>
<body>
<header>
        <div class="header-title">Welcome to My XAMPP Dashboard</div>
        <div class="header-made">Made by airmagicty @ 2024</div>
    </header>

    <div class="container">
        <!-- Functional Buttons -->
         <div>
             <button class="button" onclick="openPhpMyAdmin()">php my admin</button>
             <button class="button" onclick="openXamppDashboard()">xampp dashboard</button>
             <button class="button" onclick="openServerInfo()">server info</button>
         </div>
        <input type="text" id="search-bar" placeholder="Search files and directories...">

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
                    if (is_dir($path)) {
                        $html .= '<li class="directory-item"><span class="toggle-btn">[+]</span> ' . $file;
                        $html .= scanDirectory($path, $depth + 1, $maxDepth);
                        $html .= '</li>';
                    } else {
                        $html .= '<li class="directory-item">' . $file . '</li>';
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

    <!-- JavaScript for directory navigation and search -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Toggle visibility of nested directories
            document.querySelectorAll('.toggle-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const nextUl = this.nextElementSibling;
                    if (nextUl && nextUl.tagName === 'UL') {
                        nextUl.style.display = nextUl.style.display === 'block' ? 'none' : 'block';
                        this.innerHTML = this.innerHTML === '[+]' ? '[-]' : '[+]'
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

        function openXamppDashboard() {
            window.open('http://localhost/index.php', '_blank');
        }

        function openServerInfo() {
            window.open('http://localhost/dashboard/phpinfo.php', '_blank');
        }
    </script>
</body>
</html>
