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
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #f0f4f8, #cfe2f3);
            color: #333;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 24px;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 20px auto;
            width: 80%;
        }
        .button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            margin: 10px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
        }
        #search-bar {
            width: 100%;
            max-width: 600px;
            padding: 10px;
            margin-bottom: 20px;
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
            color: #007BFF;
        }
        .footer {
            text-align: center;
            padding: 10px;
            background-color: #333;
            color: white;
            margin-top: 20px;
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
        Welcome to My XAMPP Dashboard
    </header>

    <div class="container">
        <!-- Functional Buttons -->
        <button class="button" onclick="openPhpMyAdmin()">Open phpMyAdmin</button>
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

    <div class="footer">
        Сделано airmagicty @ 2024
    </div>
</body>
</html>
