<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My XAMPP Dashboard</title>
    <link href="data:image/x-icon;base64,AAABAAEAEBAQAAEABAAoAQAAFgAAACgAAAAQAAAAIAAAAAEABAAAAAAAgAAAAAAAAAAAAAAAEAAAAAAAAAAU/zkAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEREREREREREREREREREREREBEREQAAAREQAREREREREREAERERERERERABEREREREREQAREREREREREAEREREREREQAREREREREQAREREREREQAREREREREQAREREREREQARERERERERAREREREREREREREREREREREREREREREAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA" rel="icon" type="image/x-icon">
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
        .search-bar {
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
        .match-highlight {
            text-decoration: underline;
            color: #ffcc00; /* Optional: change highlight color */
        }
    </style>
</head>
<body>
<header>
        <div class="header-title">Welcome to My custom Dashboard </div>
        <div class="header-made">Made by airmagicty @ 2024 @ v0.3</div>
    </header>

    <div class="container">
        <div>
            <button class="button" onclick="openPhpMyAdmin()">php my admin</button>
            <button class="button" onclick="openXamppDashboard()">xampp dashboard</button>
            <button class="button" onclick="openServerInfo()">server info</button>
            <button class="button" onclick="reloadIndex()">↺</button>
        </div>
        <input type="text" id="search-bar" class="search-bar" placeholder="Search files and directories...">

        <div class="directory">
            <?php
            function convertPathToLocalhost($filePath) {
                $htdocsPos = strpos($filePath, 'htdocs' . DIRECTORY_SEPARATOR);
                if ($htdocsPos !== false) {
                    $relativePath = substr($filePath, $htdocsPos + strlen('htdocs' . DIRECTORY_SEPARATOR));
                    $convertedPath = 'http:'. DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . 'localhost' . DIRECTORY_SEPARATOR . $relativePath;
                    return $convertedPath;
                }
                return $filePath;
            }

            function scanDirectory($dir, $depth = 0, $maxDepth = 3, $searchTerm = '') {
                if ($depth > $maxDepth) return '<li class="directory-item">...</li>';

                $html = '<ul>';
                $files = scandir($dir);
                $directories = [];
                $regularFiles = [];

                // Separate directories and files
                foreach ($files as $file) {
                    if ($file === '.' || $file === '..') continue;
                    $path = $dir . DIRECTORY_SEPARATOR . $file;
                    if (is_dir($path)) {
                        $directories[] = $file;
                    } else {
                        $regularFiles[] = $file;
                    }
                }

                // Sort directories and files
                sort($directories);
                sort($regularFiles);

                // Process directories
                foreach ($directories as $directory) {
                    $path = $dir . DIRECTORY_SEPARATOR . $directory;
                    $html .= '<li class="directory-item"><span class="toggle-btn">[+]</span> ' . '<a target="_blank" href="' . convertPathToLocalhost($path) . '">' . highlightMatch($directory, $searchTerm) . '</a>';
                    $html .= scanDirectory($path, $depth + 1, $maxDepth, $searchTerm);
                    $html .= '</li>';
                }

                // Process files
                foreach ($regularFiles as $file) {
                    $html .= '<li class="directory-item">' . '<a target="_blank" href="' . convertPathToLocalhost($dir . DIRECTORY_SEPARATOR . $file) . '">' . highlightMatch($file, $searchTerm) . '</a>' . '</li>';
                }

                $html .= '</ul>';
                return $html;
            }

            function highlightMatch($text, $searchTerm) {
                if (empty($searchTerm)) {
                    return htmlspecialchars($text);
                }
                $highlighted = preg_replace('/(' . preg_quote($searchTerm, '/') . ')/i', '<span class="match-highlight">$1</span>', $text);
                return htmlspecialchars($highlighted);
            }

            // Scan current directory
            echo scanDirectory(__DIR__, 0, 3, '');
            ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.toggle-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const nextUl = this.nextElementSibling.nextElementSibling;
                    if (nextUl && nextUl.tagName === 'UL') {
                        nextUl.style.display = nextUl.style.display === 'block' ? 'none' : 'block';
                        this.innerHTML = this.innerHTML === '[+]' ? '[-]' : '[+]';
                    }
                });
            });

            // Search functionality
            const searchBar = document.getElementById('search-bar');
            searchBar.addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();
                document.querySelectorAll('.directory-item').forEach(item => {
                    const text = item.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        item.style.display = 'block';
                        let parent = item.parentElement;
                        while (parent.tagName === 'UL') {
                            parent.style.display = 'block';
                            parent = parent.parentElement.parentElement;
                        }
                    } else {
                        item.style.display = 'none';
                    }
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

        function reloadIndex() {
            location.reload();
        }
    </script>
</body>
</html>
