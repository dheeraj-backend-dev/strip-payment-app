<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Panel</title>

    <!-- Tailwind CDN (replace with PostCSS build later) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">

    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 z-30 bg-white dark:bg-gray-800 border-b dark:border-gray-700">
        <div class="flex items-center h-16">

            <!-- Logo section (same width as sidebar) -->
            <div class="w-64 flex items-center gap-2 px-4 font-semibold text-lg border-r dark:border-gray-700">
                <span class="text-indigo-600">⚡</span>
                <span>MyAdmin</span>
            </div>

            <!-- Menu toggle (after logo) -->
            <div class="flex items-center px-4">
                <button id="sidebarToggle" class="px-3 py-1 border rounded text-sm bg-white dark:bg-gray-800">
                    ☰ Menu
                </button>
            </div>

            <!-- Right section -->
            <div class="ml-auto flex items-center gap-4 px-4">
                <!-- Dark mode toggle -->
                <button id="themeToggle" class="px-2 py-1 border rounded text-sm">
                    🌙
                </button>

                <img src="https://i.pravatar.cc/40" class="w-8 h-8 rounded-full" />
            </div>

        </div>
    </header>


    <!-- Layout -->
    <div class="flex pt-16">

        <!-- Sidebar -->
        <aside id="sidebar" class="fixed lg:static z-20 w-64 h-[calc(100vh-4rem)]
        bg-white dark:bg-gray-800 border-r dark:border-gray-700
        transform -translate-x-full lg:translate-x-0
        transition-transform duration-300">

            <nav class="p-4 space-y-2">

                <!-- Plain menu -->
                <a href="#" class="block px-3 py-2 rounded bg-gray-100 dark:bg-gray-700 font-medium">
                    Dashboard
                </a>

                <!-- Dropdown menu -->
                <div>
                    <button id="dropdownBtn" class="flex justify-between items-center w-full px-3 py-2 rounded
                    hover:bg-gray-100 dark:hover:bg-gray-700">
                        <span>Users</span>
                        <span>▾</span>
                    </button>

                    <div id="dropdownMenu" class="hidden ml-3 mt-1 space-y-1">
                        <a href="#" class="block px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-sm">
                            All Users
                        </a>
                        <a href="#" class="block px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-sm">
                            Add User
                        </a>
                    </div>
                </div>

            </nav>
        </aside>

        <!-- Main content -->
        <main class="flex-1 p-4 transition-all duration-300">

            <!-- Content header (toggle button moved here) -->
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold">User Management</h2>

                <!-- Sidebar toggle -->

            </div>

            <!-- Card -->
            <div class="bg-white dark:bg-gray-800 rounded shadow p-4">

                <h3 class="font-semibold mb-3">User List</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full border dark:border-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 border dark:border-gray-700 text-left">ID</th>
                                <th class="px-4 py-2 border dark:border-gray-700 text-left">Name</th>
                                <th class="px-4 py-2 border dark:border-gray-700 text-left">Email</th>
                                <th class="px-4 py-2 border dark:border-gray-700 text-left">Role</th>
                                <th class="px-4 py-2 border dark:border-gray-700 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-2 border dark:border-gray-700">1</td>
                                <td class="px-4 py-2 border dark:border-gray-700">John Doe</td>
                                <td class="px-4 py-2 border dark:border-gray-700">john@example.com</td>
                                <td class="px-4 py-2 border dark:border-gray-700">Admin</td>
                                <td class="px-4 py-2 border dark:border-gray-700 text-green-500">Active</td>
                            </tr>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-2 border dark:border-gray-700">2</td>
                                <td class="px-4 py-2 border dark:border-gray-700">Jane Smith</td>
                                <td class="px-4 py-2 border dark:border-gray-700">jane@example.com</td>
                                <td class="px-4 py-2 border dark:border-gray-700">User</td>
                                <td class="px-4 py-2 border dark:border-gray-700 text-red-500">Inactive</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script>
        // Apply theme before page loads (prevents flicker)
        if (
            localStorage.theme === 'dark' ||
            (!('theme' in localStorage) &&
                window.matchMedia('(prefers-color-scheme: dark)').matches)
        ) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const dropdownBtn = document.getElementById('dropdownBtn');
        const dropdownMenu = document.getElementById('dropdownMenu');
        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;

        // Sidebar toggle
        const logoSection = document.getElementById('logoSection');
        const sidebarTexts = document.querySelectorAll('.sidebar-text');

        sidebarToggle.addEventListener('click', () => {

            // MOBILE
            if (window.innerWidth < 1024) {
                sidebar?.classList.toggle('-translate-x-full');
                return;
            }

            // DESKTOP
            sidebar?.classList.toggle('lg:w-64');
            sidebar?.classList.toggle('lg:w-16');

            logoSection?.classList.toggle('lg:w-64');
            logoSection?.classList.toggle('lg:w-16');

            sidebarTexts.forEach(text => {
                text.classList.toggle('hidden');
            });
        });

        // Dropdown
        dropdownBtn.addEventListener('click', () => {
            dropdownMenu.classList.toggle('hidden');
        });

        // Dark mode
        // themeToggle.addEventListener('click', () => {
        //     html.classList.toggle('dark');
        //     themeToggle.textContent = html.classList.contains('dark') ? '☀️' : '🌙';
        // });
    </script>

</body>

</html>
