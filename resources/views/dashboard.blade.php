<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rel Jay Tugahan CRUD & AI File Management Dashboard</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f0f7ff',
                            100: '#e0effe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a',
                        }
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'float': 'float 4s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-6px)' },
                        }
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(156, 163, 175, 0.5);
            border-radius: 4px;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .dark .glass-panel {
            background: rgba(17, 24, 39, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 dark:bg-slate-950 dark:text-slate-100 min-h-screen flex flex-col transition-colors duration-300">

    <!-- Top Header -->
    <header class="sticky top-0 z-30 glass-panel border-b border-slate-200 dark:border-slate-800 shadow-sm transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between gap-4">
            <!-- Logo & Title -->
            <div class="flex items-center space-x-3">
                <div class="relative group cursor-pointer">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition-transform duration-200">
                        <i class="fa-solid fa-cube text-xl"></i>
                    </div>
                    <span class="absolute -bottom-1 -right-1 flex h-3.5 w-3.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-emerald-500"></span>
                    </span>
                </div>
                <div>
                    <h1 class="text-lg font-bold bg-gradient-to-r from-slate-900 to-slate-700 dark:from-white dark:to-slate-300 bg-clip-text text-transparent flex items-center gap-2">
                        Rel Jay Tugahan CRUD
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/60 dark:text-blue-300">Pro v2.5</span>
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1.5">
                        <i class="fa-solid fa-layer-group text-blue-500"></i> Smart Item & File Management Dashboard
                    </p>
                </div>
            </div>

            <!-- Search & Actions Bar -->
            <div class="flex items-center gap-3">
                <!-- Clock & Status -->
                <div class="hidden md:flex flex-col items-end text-xs text-slate-500 dark:text-slate-400 border-r border-slate-200 dark:border-slate-800 pr-4">
                    <span id="current-date" class="font-medium text-slate-700 dark:text-slate-300"></span>
                    <span id="current-time" class="text-slate-400 dark:text-slate-500"></span>
                </div>

                <!-- AI Key Settings Modal Trigger -->
                <button onclick="toggleKeyModal()" title="Gemini API Settings" class="p-2.5 text-slate-600 hover:text-blue-600 dark:text-slate-300 dark:hover:text-blue-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-all relative">
                    <i class="fa-solid fa-key"></i>
                    <span id="api-key-badge" class="hidden absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-emerald-500"></span>
                </button>

                <!-- Theme Toggle -->
                <button onclick="toggleTheme()" class="p-2.5 text-slate-600 hover:text-amber-500 dark:text-slate-300 dark:hover:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-all">
                    <i id="theme-icon" class="fa-solid fa-moon"></i>
                </button>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6 flex-1 w-full">

        <!-- Banner Flash Notification -->
        <div id="flash-message" class="hidden transform transition-all duration-300 bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                <span id="flash-text" class="text-sm font-medium">Operation completed successfully!</span>
            </div>
            <button onclick="closeFlash()" class="text-emerald-500 hover:text-emerald-700 dark:hover:text-emerald-300">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Dashboard Stats Overview Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Stat 1 -->
            <div class="glass-panel p-4 rounded-xl border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-md transition-all flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Total Items</p>
                    <h3 id="stat-total-items" class="text-2xl font-bold text-slate-800 dark:text-white mt-1">0</h3>
                    <span class="text-[11px] text-emerald-600 dark:text-emerald-400 font-medium flex items-center gap-1 mt-1">
                        <i class="fa-solid fa-arrow-up"></i> Active Inventory
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
            </div>

            <!-- Stat 2 -->
            <div class="glass-panel p-4 rounded-xl border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-md transition-all flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Storage Files</p>
                    <h3 id="stat-total-files" class="text-2xl font-bold text-slate-800 dark:text-white mt-1">0</h3>
                    <div class="w-24 bg-slate-200 dark:bg-slate-700 h-1.5 rounded-full mt-2 overflow-hidden">
                        <div id="storage-bar" class="bg-indigo-500 h-full rounded-full transition-all duration-500" style="width: 25%"></div>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
            </div>

            <!-- Stat 3 -->
            <div class="glass-panel p-4 rounded-xl border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-md transition-all flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400">AI Analyses</p>
                    <h3 id="stat-ai-runs" class="text-2xl font-bold text-slate-800 dark:text-white mt-1">0</h3>
                    <span class="text-[11px] text-purple-600 dark:text-purple-400 font-medium flex items-center gap-1 mt-1">
                        <i class="fa-solid fa-sparkles"></i> Gemini 3 Flash Powered
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center text-xl animate-pulse-slow">
                    <i class="fa-solid fa-brain"></i>
                </div>
            </div>

            <!-- Stat 4 -->
            <div class="glass-panel p-4 rounded-xl border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-md transition-all flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Database Sync</p>
                    <h3 class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-1 flex items-center gap-2">
                        Online
                    </h3>
                    <span class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 block">Live CRUD operational</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-arrows-rotate animate-spin" style="animation-duration: 8s;"></i>
                </div>
            </div>
        </div>

        <!-- Search & Control Navigation Bar -->
        <div class="glass-panel p-4 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm flex flex-col md:flex-row gap-4 items-center justify-between">
            <!-- Tabs -->
            <div class="flex items-center p-1 bg-slate-200/60 dark:bg-slate-900/80 rounded-xl w-full md:w-auto">
                <button onclick="switchTab('items')" id="tab-btn-items" class="flex-1 md:flex-none px-4 py-2 text-xs font-semibold rounded-lg transition-all flex items-center justify-center gap-2 bg-white dark:bg-slate-800 text-blue-600 dark:text-blue-400 shadow-sm">
                    <i class="fa-solid fa-list-check"></i> Items Inventory
                </button>
                <button onclick="switchTab('files')" id="tab-btn-files" class="flex-1 md:flex-none px-4 py-2 text-xs font-semibold rounded-lg transition-all flex items-center justify-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white">
                    <i class="fa-solid fa-folder"></i> File Manager
                </button>
                <button onclick="switchTab('ai')" id="tab-btn-ai" class="flex-1 md:flex-none px-4 py-2 text-xs font-semibold rounded-lg transition-all flex items-center justify-center gap-2 text-slate-600 dark:text-slate-400 hover:text-purple-600 dark:hover:text-purple-400">
                    <i class="fa-solid fa-wand-magic-sparkles text-purple-500"></i> AI Assistant Hub
                </button>
            </div>

            <!-- Universal Global Search Input -->
            <div class="relative w-full md:w-96">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="text" id="global-search-input" oninput="handleGlobalSearch()" placeholder="Search items, descriptions, tags, files..." class="w-full pl-10 pr-10 py-2 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                <button onclick="clearSearch()" id="clear-search-btn" class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <i class="fa-solid fa-circle-xmark text-xs"></i>
                </button>
            </div>
        </div>

        <!-- TAB 1: ITEMS INVENTORY VIEW -->
        <div id="tab-content-items" class="space-y-6">
            <!-- Add Item Form Accordion/Card -->
            <div class="glass-panel p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm relative overflow-hidden">
                <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-200/60 dark:border-slate-800">
                    <h2 class="text-sm font-bold text-slate-800 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-plus-circle text-blue-500"></i> Add New Item
                    </h2>
                    <span class="text-xs text-slate-400">Create new item record</span>
                </div>

                <form id="add-item-form" onsubmit="handleAddItem(event)" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Item Name *</label>
                            <input type="text" id="item-name-input" required placeholder="e.g. Wireless Ergonomic Mouse" class="w-full px-3 py-2 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Category</label>
                            <select id="item-category-input" class="w-full px-3 py-2 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="Electronics">Electronics</option>
                                <option value="Hardware">Hardware</option>
                                <option value="Office Supplies">Office Supplies</option>
                                <option value="Documents">Documents</option>
                                <option value="Software">Software</option>
                                <option value="General">General</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Priority</label>
                            <select id="item-priority-input" class="w-full px-3 py-2 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="Low">Low Priority</option>
                                <option value="Medium" selected>Medium Priority</option>
                                <option value="High">High Priority</option>
                                <option value="Urgent">Urgent</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Tags (Comma separated)</label>
                            <input type="text" id="item-tags-input" placeholder="e.g. tech, peripheral, office" class="w-full px-3 py-2 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-medium text-slate-700 dark:text-slate-300">Description</label>
                            <button type="button" onclick="aiAutoGenerateDescription()" class="text-[11px] text-purple-600 dark:text-purple-400 font-semibold hover:underline flex items-center gap-1">
                                <i class="fa-solid fa-wand-magic-sparkles"></i> AI Generate Description
                            </button>
                        </div>
                        <textarea id="item-description-input" rows="2" placeholder="Brief details about the item..." class="w-full px-3 py-2 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-blue-500 outline-none resize-none"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="reset" class="px-4 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors">
                            Reset
                        </button>
                        <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs rounded-xl shadow-md shadow-blue-500/20 flex items-center gap-2 transition-all active:scale-95">
                            <i class="fa-solid fa-plus"></i> Add Item
                        </button>
                    </div>
                </form>
            </div>

            <!-- Items Table Component -->
            <div class="glass-panel rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden">
                <!-- Filters & Controls header -->
                <div class="p-4 border-b border-slate-200/80 dark:border-slate-800 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-2">
                        <h3 class="text-sm font-bold text-slate-800 dark:text-white">Items List</h3>
                        <span id="items-count-badge" class="px-2 py-0.5 text-xs font-semibold rounded-full bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300">0</span>
                    </div>

                    <!-- Category Filter Dropdown & Sorting -->
                    <div class="flex items-center gap-2">
                        <select id="category-filter" onchange="applyFilters()" class="px-3 py-1.5 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl text-xs text-slate-700 dark:text-slate-300 focus:outline-none">
                            <option value="ALL">All Categories</option>
                            <option value="Electronics">Electronics</option>
                            <option value="Hardware">Hardware</option>
                            <option value="Office Supplies">Office Supplies</option>
                            <option value="Documents">Documents</option>
                            <option value="Software">Software</option>
                            <option value="General">General</option>
                        </select>

                        <select id="sort-order" onchange="applyFilters()" class="px-3 py-1.5 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl text-xs text-slate-700 dark:text-slate-300 focus:outline-none">
                            <option value="newest">Sort: Newest First</option>
                            <option value="oldest">Sort: Oldest First</option>
                            <option value="name">Sort: Name A-Z</option>
                        </select>
                    </div>
                </div>

                <!-- Responsive Data Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-100/70 dark:bg-slate-900/60 text-slate-600 dark:text-slate-400 text-[11px] uppercase tracking-wider font-semibold border-b border-slate-200/80 dark:border-slate-800">
                                <th class="p-3.5 pl-5">Item & Details</th>
                                <th class="p-3.5">Category</th>
                                <th class="p-3.5">Priority</th>
                                <th class="p-3.5">Tags</th>
                                <th class="p-3.5">Created Date</th>
                                <th class="p-3.5 pr-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="items-table-body" class="divide-y divide-slate-200/60 dark:divide-slate-800/60 text-xs">
                            <!-- Items populated dynamically -->
                        </tbody>
                    </table>
                </div>

                <!-- Empty State -->
                <div id="items-empty-state" class="hidden p-8 text-center">
                    <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-900 text-slate-400 flex items-center justify-center mx-auto mb-3">
                        <i class="fa-solid fa-inbox text-xl"></i>
                    </div>
                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400">No items found matching criteria</p>
                    <p class="text-xs text-slate-400 mt-1">Try adding a new item or clearing filters.</p>
                </div>
            </div>
        </div>

        <!-- TAB 2: FILE MANAGER VIEW -->
        <div id="tab-content-files" class="hidden space-y-6">
            <!-- File Drag & Drop Upload Zone -->
            <div id="drop-zone" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)" ondrop="handleDrop(event)" class="border-2 border-dashed border-slate-300 dark:border-slate-700 hover:border-blue-500 dark:hover:border-blue-400 rounded-2xl p-8 text-center glass-panel transition-all duration-200 cursor-pointer group" onclick="document.getElementById('file-upload-input').click()">
                <input type="file" id="file-upload-input" multiple class="hidden" onchange="handleFileInputChange(event)">
                <div class="w-14 h-14 rounded-2xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-cloud-arrow-up text-2xl"></i>
                </div>
                <h3 class="text-sm font-bold text-slate-800 dark:text-white">Drag & Drop files here or click to browse</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Supports PDF, PNG, JPG, CSV, DOCX, Code files up to 25MB</p>
            </div>

            <!-- File Category Filter & Storage Info -->
            <div class="glass-panel p-4 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                    <button onclick="filterFiles('ALL')" class="file-filter-btn active px-3 py-1.5 text-xs rounded-xl bg-blue-600 text-white font-medium shadow-sm">All Files</button>
                    <button onclick="filterFiles('image')" class="file-filter-btn px-3 py-1.5 text-xs rounded-xl bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-medium hover:bg-slate-300 transition-all">Images</button>
                    <button onclick="filterFiles('document')" class="file-filter-btn px-3 py-1.5 text-xs rounded-xl bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-medium hover:bg-slate-300 transition-all">Documents</button>
                    <button onclick="filterFiles('code')" class="file-filter-btn px-3 py-1.5 text-xs rounded-xl bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-medium hover:bg-slate-300 transition-all">Code/Data</button>
                </div>

                <div class="flex items-center gap-3 w-full md:w-auto justify-end">
                    <span id="storage-used-text" class="text-xs font-semibold text-slate-600 dark:text-slate-400">0 KB / 100 MB Used</span>
                </div>
            </div>

            <!-- File Grid Display -->
            <div id="file-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- File Cards dynamically generated -->
            </div>

            <!-- Files Empty State -->
            <div id="files-empty-state" class="hidden p-12 text-center glass-panel rounded-2xl border border-slate-200/80 dark:border-slate-800">
                <i class="fa-regular fa-folder-open text-4xl text-slate-300 dark:text-slate-600 mb-3"></i>
                <p class="text-sm font-medium text-slate-600 dark:text-slate-400">No files uploaded yet</p>
                <p class="text-xs text-slate-400 mt-1">Upload files using the drag-and-drop area above.</p>
            </div>
        </div>

        <!-- TAB 3: AI ASSISTANT HUB -->
        <div id="tab-content-ai" class="hidden space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- AI Utilities Panel -->
                <div class="space-y-4">
                    <!-- AI Summary Tool -->
                    <div class="glass-panel p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-8 h-8 rounded-lg bg-purple-500/10 text-purple-600 flex items-center justify-center text-sm">
                                <i class="fa-solid fa-list-check"></i>
                            </div>
                            <h3 class="text-sm font-bold text-slate-800 dark:text-white">Inventory Summarizer</h3>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-3">
                            Generate an executive summary and analysis of all items and files in your database.
                        </p>
                        <button onclick="aiSummarizeDatabase()" class="w-full py-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-medium text-xs rounded-xl shadow-md shadow-purple-500/20 flex items-center justify-center gap-2 transition-all">
                            <i class="fa-solid fa-sparkles"></i> Summarize Current Database
                        </button>
                    </div>

                    <!-- AI Category Predictor Tool -->
                    <div class="glass-panel p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-600 flex items-center justify-center text-sm">
                                <i class="fa-solid fa-tags"></i>
                            </div>
                            <h3 class="text-sm font-bold text-slate-800 dark:text-white">Smart Tagging & Audit</h3>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-3">
                            Auto-scan existing items without tags and generate smart metadata recommendations.
                        </p>
                        <button onclick="aiAuditAndTag()" class="w-full py-2 bg-slate-800 dark:bg-slate-700 hover:bg-slate-900 text-white font-medium text-xs rounded-xl transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-wand-magic"></i> Auto-Tag & Audit Items
                        </button>
                    </div>

                    <!-- API Status Card -->
                    <div class="glass-panel p-4 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm bg-gradient-to-br from-slate-900 to-slate-800 text-white">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold text-slate-300">Gemini Engine API</span>
                            <span id="ai-engine-status" class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">Active</span>
                        </div>
                        <p class="text-xs text-slate-400">Model: <code class="text-purple-300">gemini-3-flash-preview</code></p>
                        <button onclick="toggleKeyModal()" class="mt-3 text-xs text-blue-400 hover:underline flex items-center gap-1 font-medium">
                            <i class="fa-solid fa-sliders"></i> Configure API Key Settings
                        </button>
                    </div>
                </div>

                <!-- AI Chatbot & Output Display Window -->
                <div class="lg:col-span-2 glass-panel rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm flex flex-col h-[520px] overflow-hidden">
                    <!-- Chat Header -->
                    <div class="p-4 border-b border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-purple-600 to-indigo-600 flex items-center justify-center text-white text-xs">
                                <i class="fa-solid fa-robot"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800 dark:text-white">Gemini Inventory Assistant</h3>
                                <p class="text-[11px] text-slate-500">Ask questions regarding dashboard items & files</p>
                            </div>
                        </div>
                        <button onclick="clearChatLog()" class="text-xs text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                            Clear Log
                        </button>
                    </div>

                    <!-- Chat Message Area -->
                    <div id="ai-chat-messages" class="flex-1 p-4 overflow-y-auto space-y-4">
                        <!-- Welcome message -->
                        <div class="flex gap-3">
                            <div class="w-7 h-7 rounded-lg bg-purple-600 text-white flex items-center justify-center text-xs shrink-0">
                                <i class="fa-solid fa-sparkles"></i>
                            </div>
                            <div class="bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 p-3 rounded-2xl rounded-tl-none text-xs leading-relaxed max-w-[85%]">
                                Hello! I am your AI Inventory & File Assistant. Ask me anything about your CRUD items, request reports, or let me summarize your stored documents!
                            </div>
                        </div>
                    </div>

                    <!-- Chat Input Area -->
                    <form onsubmit="handleAIChatSubmit(event)" class="p-3 border-t border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex items-center gap-2">
                        <input type="text" id="ai-chat-input" placeholder="Type a prompt or question (e.g., 'Which items need high priority action?')..." class="flex-1 px-4 py-2 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-purple-500 outline-none">
                        <button type="submit" id="ai-chat-send-btn" class="p-2.5 bg-purple-600 hover:bg-purple-700 text-white rounded-xl transition-all shadow-md shadow-purple-500/20 active:scale-95">
                            <i class="fa-solid fa-paper-plane text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </main>

    <!-- EDIT ITEM MODAL -->
    <div id="edit-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
        <div class="glass-panel w-full max-w-lg rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xl overflow-hidden transform transition-all">
            <div class="p-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-800 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-indigo-500"></i> Edit Item Details
                </h3>
                <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form id="edit-item-form" onsubmit="handleSaveEditedItem(event)" class="p-5 space-y-4">
                <input type="hidden" id="edit-item-id">
                <div>
                    <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Item Name</label>
                    <input type="text" id="edit-item-name" required class="w-full px-3 py-2 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl text-xs outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Category</label>
                        <select id="edit-item-category" class="w-full px-3 py-2 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl text-xs outline-none">
                            <option value="Electronics">Electronics</option>
                            <option value="Hardware">Hardware</option>
                            <option value="Office Supplies">Office Supplies</option>
                            <option value="Documents">Documents</option>
                            <option value="Software">Software</option>
                            <option value="General">General</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Priority</label>
                        <select id="edit-item-priority" class="w-full px-3 py-2 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl text-xs outline-none">
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                            <option value="Urgent">Urgent</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Tags</label>
                    <input type="text" id="edit-item-tags" class="w-full px-3 py-2 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl text-xs outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Description</label>
                    <textarea id="edit-item-description" rows="3" class="w-full px-3 py-2 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl text-xs outline-none focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
                </div>
                <div class="flex justify-end gap-3 pt-2 border-t border-slate-200 dark:border-slate-800">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-xs rounded-xl shadow-md transition-all">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- API KEY SETTINGS MODAL -->
    <div id="key-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
        <div class="glass-panel w-full max-w-md rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xl overflow-hidden">
            <div class="p-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-800 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-key text-amber-500"></i> Gemini API Settings
                </h3>
                <button onclick="toggleKeyModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="p-5 space-y-4">
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                    Provide your Gemini API Key to enable direct live AI model interactions. If left blank, the app uses standard runtime proxy or fallback mode.
                </p>
                <div>
                    <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">API Key</label>
                    <input type="password" id="user-gemini-key" placeholder="AIzaSy..." class="w-full px-3 py-2 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-xl text-xs outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button onclick="saveApiKey()" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium text-xs rounded-xl shadow-md transition-all">
                        Save API Key
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global Application State & Storage
        let state = {
            items: [
                {
                    id: '1',
                    name: 'Logitech MX Master 3S',
                    category: 'Electronics',
                    description: 'Wireless Performance Mouse with Ultra-fast Scroll Wheel and Quiet Clicks.',
                    priority: 'High',
                    tags: ['hardware', 'peripherals', 'office'],
                    createdAt: '2026-10-05'
                },
                {
                    id: '2',
                    name: 'Project Architecture Blueprint',
                    category: 'Documents',
                    description: 'Detailed system diagram and database schema for Laravel Blade CRUD module.',
                    priority: 'Urgent',
                    tags: ['design', 'architecture', 'pdf'],
                    createdAt: '2026-10-06'
                },
                {
                    id: '3',
                    name: 'Ergonomic Desk Mat',
                    category: 'Office Supplies',
                    description: 'Waterproof felt desk protector mat with non-slip backing.',
                    priority: 'Low',
                    tags: ['desk', 'accessory'],
                    createdAt: '2026-10-07'
                }
            ],
            files: [
                {
                    id: 'f1',
                    name: 'System_Report_Q3.pdf',
                    type: 'document',
                    size: '2.4 MB',
                    sizeBytes: 2400000,
                    uploadedAt: '2026-10-04',
                    icon: 'fa-file-pdf text-red-500'
                },
                {
                    id: 'f2',
                    name: 'logo_reljay.png',
                    type: 'image',
                    size: '850 KB',
                    sizeBytes: 850000,
                    uploadedAt: '2026-10-05',
                    icon: 'fa-file-image text-emerald-500'
                },
                {
                    id: 'f3',
                    name: 'inventory_data.csv',
                    type: 'code',
                    size: '120 KB',
                    sizeBytes: 120000,
                    uploadedAt: '2026-10-07',
                    icon: 'fa-file-csv text-blue-500'
                }
            ],
            aiRunsCount: 0,
            activeTab: 'items',
            geminiApiKey: localStorage.getItem('gemini_api_key') || '',
            searchQuery: '',
            categoryFilter: 'ALL',
            fileFilter: 'ALL',
            sortBy: 'newest'
        };

        // Initialize App on DOM Ready
        window.addEventListener('DOMContentLoaded', () => {
            updateClock();
            setInterval(updateClock, 1000);
            renderStats();
            renderItems();
            renderFiles();
            checkApiKeyBadge();
        });

        // Clock Function
        function updateClock() {
            const now = new Date();
            const dateStr = now.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
            const timeStr = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            
            const dateEl = document.getElementById('current-date');
            const timeEl = document.getElementById('current-time');
            if (dateEl) dateEl.innerText = dateStr;
            if (timeEl) timeEl.innerText = timeStr;
        }

        // Theme Toggle
        function toggleTheme() {
            const html = document.documentElement;
            const themeIcon = document.getElementById('theme-icon');
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                html.classList.add('light');
                themeIcon.className = 'fa-solid fa-moon';
            } else {
                html.classList.remove('light');
                html.classList.add('dark');
                themeIcon.className = 'fa-solid fa-sun';
            }
        }

        // Flash Notification Toast
        function showFlash(message) {
            const flash = document.getElementById('flash-message');
            const flashText = document.getElementById('flash-text');
            flashText.innerText = message;
            flash.classList.remove('hidden');
            setTimeout(() => {
                flash.classList.add('hidden');
            }, 4000);
        }

        function closeFlash() {
            document.getElementById('flash-message').classList.add('hidden');
        }

        // Tab Switch Navigation
        function switchTab(tab) {
            state.activeTab = tab;
            ['items', 'files', 'ai'].forEach(t => {
                const btn = document.getElementById(`tab-btn-${t}`);
                const content = document.getElementById(`tab-content-${t}`);
                if (t === tab) {
                    content.classList.remove('hidden');
                    btn.className = "flex-1 md:flex-none px-4 py-2 text-xs font-semibold rounded-lg transition-all flex items-center justify-center gap-2 bg-white dark:bg-slate-800 text-blue-600 dark:text-blue-400 shadow-sm";
                } else {
                    content.classList.add('hidden');
                    btn.className = "flex-1 md:flex-none px-4 py-2 text-xs font-semibold rounded-lg transition-all flex items-center justify-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white";
                }
            });
        }

        // Render Dashboard Metrics
        function renderStats() {
            document.getElementById('stat-total-items').innerText = state.items.length;
            document.getElementById('stat-total-files').innerText = state.files.length;
            document.getElementById('stat-ai-runs').innerText = state.aiRunsCount;

            // Calculate storage used
            const totalBytes = state.files.reduce((acc, f) => acc + (f.sizeBytes || 0), 0);
            const totalMB = (totalBytes / (1024 * 1024)).toFixed(2);
            document.getElementById('storage-used-text').innerText = `${totalMB} MB / 100 MB Used`;
            const percentage = Math.min((totalBytes / (100 * 1024 * 1024)) * 100, 100);
            document.getElementById('storage-bar').style.width = `${Math.max(percentage, 5)}%`;
        }

        // CRUD OPERATIONS: ITEM MANAGEMENT
        function renderItems() {
            const tbody = document.getElementById('items-table-body');
            const emptyState = document.getElementById('items-empty-state');
            tbody.innerHTML = '';

            let filtered = state.items.filter(item => {
                const matchesSearch = state.searchQuery === '' || 
                    item.name.toLowerCase().includes(state.searchQuery.toLowerCase()) ||
                    item.description.toLowerCase().includes(state.searchQuery.toLowerCase()) ||
                    item.tags.some(t => t.toLowerCase().includes(state.searchQuery.toLowerCase()));
                
                const matchesCat = state.categoryFilter === 'ALL' || item.category === state.categoryFilter;
                return matchesSearch && matchesCat;
            });

            // Sorting
            if (state.sortBy === 'newest') {
                filtered.sort((a,b) => new Date(b.createdAt) - new Date(a.createdAt));
            } else if (state.sortBy === 'oldest') {
                filtered.sort((a,b) => new Date(a.createdAt) - new Date(b.createdAt));
            } else if (state.sortBy === 'name') {
                filtered.sort((a,b) => a.name.localeCompare(b.name));
            }

            document.getElementById('items-count-badge').innerText = filtered.length;

            if (filtered.length === 0) {
                emptyState.classList.remove('hidden');
                return;
            } else {
                emptyState.classList.add('hidden');
            }

            filtered.forEach(item => {
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-slate-50/80 dark:hover:bg-slate-900/40 transition-colors group';

                // Priority Badge Color
                let priorityClass = 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300';
                if (item.priority === 'High') priorityClass = 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20';
                if (item.priority === 'Urgent') priorityClass = 'bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20';
                if (item.priority === 'Low') priorityClass = 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400';

                tr.innerHTML = `
                    <td class="p-3.5 pl-5">
                        <div class="font-semibold text-slate-800 dark:text-white">${escapeHtml(item.name)}</div>
                        <div class="text-slate-500 dark:text-slate-400 text-[11px] mt-0.5 line-clamp-1">${escapeHtml(item.description)}</div>
                    </td>
                    <td class="p-3.5">
                        <span class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-[11px] font-medium">
                            ${escapeHtml(item.category)}
                        </span>
                    </td>
                    <td class="p-3.5">
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold ${priorityClass}">
                            ${item.priority}
                        </span>
                    </td>
                    <td class="p-3.5">
                        <div class="flex flex-wrap gap-1">
                            ${item.tags.map(t => `<span class="px-2 py-0.5 rounded bg-blue-500/10 text-blue-600 dark:text-blue-400 text-[10px]">#${escapeHtml(t)}</span>`).join('')}
                        </div>
                    </td>
                    <td class="p-3.5 text-slate-500 dark:text-slate-400 text-[11px]">
                        ${item.createdAt}
                    </td>
                    <td class="p-3.5 pr-5 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick="triggerAiAnalyzeItem('${item.id}')" title="AI Quick Analyze" class="p-1.5 text-purple-600 hover:text-purple-700 dark:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900/30 rounded-lg transition-colors">
                                <i class="fa-solid fa-sparkles text-xs"></i>
                            </button>
                            <button onclick="openEditModal('${item.id}')" title="Edit Item" class="p-1.5 text-slate-600 hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </button>
                            <button onclick="handleDeleteItem('${item.id}')" title="Delete Item" class="p-1.5 text-slate-600 hover:text-rose-600 dark:text-slate-400 dark:hover:text-rose-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        // Add Item Form Handler
        function handleAddItem(e) {
            e.preventDefault();
            const name = document.getElementById('item-name-input').value.trim();
            const category = document.getElementById('item-category-input').value;
            const priority = document.getElementById('item-priority-input').value;
            const tagsRaw = document.getElementById('item-tags-input').value.trim();
            const description = document.getElementById('item-description-input').value.trim();

            const tags = tagsRaw ? tagsRaw.split(',').map(t => t.trim()) : ['general'];

            const newItem = {
                id: Date.now().toString(),
                name,
                category,
                priority,
                tags,
                description: description || 'No details specified.',
                createdAt: new Date().toISOString().split('T')[0]
            };

            state.items.unshift(newItem);
            renderItems();
            renderStats();
            document.getElementById('add-item-form').reset();
            showFlash(`Item "${name}" created successfully!`);
        }

        // Delete Item Handler
        function handleDeleteItem(id) {
            const item = state.items.find(i => i.id === id);
            if (!item) return;

            if (confirm(`Are you sure you want to delete "${item.name}"?`)) {
                state.items = state.items.filter(i => i.id !== id);
                renderItems();
                renderStats();
                showFlash(`Item "${item.name}" deleted.`);
            }
        }

        // Edit Item Modal handlers
        function openEditModal(id) {
            const item = state.items.find(i => i.id === id);
            if (!item) return;

            document.getElementById('edit-item-id').value = item.id;
            document.getElementById('edit-item-name').value = item.name;
            document.getElementById('edit-item-category').value = item.category;
            document.getElementById('edit-item-priority').value = item.priority;
            document.getElementById('edit-item-tags').value = item.tags.join(', ');
            document.getElementById('edit-item-description').value = item.description;

            document.getElementById('edit-modal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
        }

        function handleSaveEditedItem(e) {
            e.preventDefault();
            const id = document.getElementById('edit-item-id').value;
            const item = state.items.find(i => i.id === id);
            if (!item) return;

            item.name = document.getElementById('edit-item-name').value.trim();
            item.category = document.getElementById('edit-item-category').value;
            item.priority = document.getElementById('edit-item-priority').value;
            const tagsRaw = document.getElementById('edit-item-tags').value.trim();
            item.tags = tagsRaw ? tagsRaw.split(',').map(t => t.trim()) : [];
            item.description = document.getElementById('edit-item-description').value.trim();

            renderItems();
            closeEditModal();
            showFlash(`Item "${item.name}" updated successfully.`);
        }

        // FILE MANAGER OPERATIONS
        function renderFiles() {
            const fileGrid = document.getElementById('file-grid');
            const emptyState = document.getElementById('files-empty-state');
            fileGrid.innerHTML = '';

            let filtered = state.files.filter(file => {
                const matchesSearch = state.searchQuery === '' || file.name.toLowerCase().includes(state.searchQuery.toLowerCase());
                const matchesType = state.fileFilter === 'ALL' || file.type === state.fileFilter;
                return matchesSearch && matchesType;
            });

            if (filtered.length === 0) {
                emptyState.classList.remove('hidden');
                return;
            } else {
                emptyState.classList.add('hidden');
            }

            filtered.forEach(file => {
                const card = document.createElement('div');
                card.className = 'glass-panel p-4 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-md transition-all group flex flex-col justify-between';
                card.innerHTML = `
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-900 flex items-center justify-center text-xl">
                                <i class="fa-solid ${file.icon}"></i>
                            </div>
                            <button onclick="deleteFile('${file.id}')" class="text-slate-400 hover:text-rose-500 text-xs p-1">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        <h4 class="text-xs font-bold text-slate-800 dark:text-white truncate" title="${escapeHtml(file.name)}">${escapeHtml(file.name)}</h4>
                        <p class="text-[11px] text-slate-400 mt-0.5">${file.size} • ${file.uploadedAt}</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-200/60 dark:border-slate-800/60 flex items-center justify-between">
                        <button onclick="aiAnalyzeFile('${file.name}')" class="text-[11px] text-purple-600 dark:text-purple-400 font-semibold hover:underline flex items-center gap-1">
                            <i class="fa-solid fa-wand-magic-sparkles"></i> AI Summary
                        </button>
                        <button onclick="simulateDownload('${file.name}')" class="text-xs text-slate-500 hover:text-slate-800 dark:hover:text-white">
                            <i class="fa-solid fa-download"></i>
                        </button>
                    </div>
                `;
                fileGrid.appendChild(card);
            });
        }

        // Drag and Drop Logic
        function handleDragOver(e) {
            e.preventDefault();
            document.getElementById('drop-zone').classList.add('border-blue-500', 'bg-blue-50/50');
        }

        function handleDragLeave(e) {
            e.preventDefault();
            document.getElementById('drop-zone').classList.remove('border-blue-500', 'bg-blue-50/50');
        }

        function handleDrop(e) {
            e.preventDefault();
            document.getElementById('drop-zone').classList.remove('border-blue-500', 'bg-blue-50/50');
            if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                processUploadedFiles(e.dataTransfer.files);
            }
        }

        function handleFileInputChange(e) {
            if (e.target.files && e.target.files.length > 0) {
                processUploadedFiles(e.target.files);
            }
        }

        function processUploadedFiles(fileList) {
            Array.from(fileList).forEach(file => {
                let icon = 'fa-file text-slate-500';
                let type = 'document';

                if (file.type.startsWith('image/')) {
                    icon = 'fa-file-image text-emerald-500';
                    type = 'image';
                } else if (file.name.endsWith('.pdf')) {
                    icon = 'fa-file-pdf text-rose-500';
                    type = 'document';
                } else if (file.name.endsWith('.csv') || file.name.endsWith('.json') || file.name.endsWith('.js')) {
                    icon = 'fa-file-code text-indigo-500';
                    type = 'code';
                }

                const newFile = {
                    id: 'f_' + Date.now() + Math.random().toString(36).substring(2, 5),
                    name: file.name,
                    type: type,
                    size: (file.size / 1024).toFixed(1) + ' KB',
                    sizeBytes: file.size,
                    uploadedAt: new Date().toISOString().split('T')[0],
                    icon: icon
                };

                state.files.unshift(newFile);
            });

            renderFiles();
            renderStats();
            showFlash(`${fileList.length} file(s) uploaded successfully!`);
        }

        function deleteFile(id) {
            state.files = state.files.filter(f => f.id !== id);
            renderFiles();
            renderStats();
            showFlash('File removed.');
        }

        function filterFiles(type) {
            state.fileFilter = type;
            document.querySelectorAll('.file-filter-btn').forEach(btn => {
                if (btn.innerText.toLowerCase().includes(type.toLowerCase()) || (type==='ALL' && btn.innerText==='All Files')) {
                    btn.className = 'file-filter-btn active px-3 py-1.5 text-xs rounded-xl bg-blue-600 text-white font-medium shadow-sm';
                } else {
                    btn.className = 'file-filter-btn px-3 py-1.5 text-xs rounded-xl bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-medium hover:bg-slate-300 transition-all';
                }
            });
            renderFiles();
        }

        function simulateDownload(filename) {
            showFlash(`Downloading ${filename}...`);
        }

        // GLOBAL SEARCH & FILTERS
        function handleGlobalSearch() {
            const input = document.getElementById('global-search-input').value;
            state.searchQuery = input.trim();
            
            const clearBtn = document.getElementById('clear-search-btn');
            if (state.searchQuery) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }

            renderItems();
            renderFiles();
        }

        function clearSearch() {
            document.getElementById('global-search-input').value = '';
            handleGlobalSearch();
        }

        function applyFilters() {
            state.categoryFilter = document.getElementById('category-filter').value;
            state.sortBy = document.getElementById('sort-order').value;
            renderItems();
        }

        // GEMINI AI INTEGRATION LOGIC
        // Calling Gemini API via gemini-3-flash-preview endpoint
        async function callGeminiAPI(userQuery, systemInstruction = '') {
            state.aiRunsCount++;
            renderStats();

            const apiKey = state.geminiApiKey || '';
            const apiUrl = `https://generativelanguage.googleapis.com/v1beta/models/gemini-3-flash-preview:generateContent?key=${apiKey}`;

            const payload = {
                contents: [{ parts: [{ text: userQuery }] }]
            };

            if (systemInstruction) {
                payload.systemInstruction = {
                    parts: [{ text: systemInstruction }]
                };
            }

            try {
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });

                if (!response.ok) {
                    throw new Error(`API response status: ${response.status}`);
                }

                const data = await response.json();
                const reply = data.candidates?.[0]?.content?.parts?.[0]?.text;
                if (reply) return reply;
                throw new Error('Empty AI response');
            } catch (err) {
                console.warn('Gemini API call fallback:', err);
                // Smart fallback mode if API key is not supplied or fails
                return generateFallbackAiResponse(userQuery);
            }
        }

        function generateFallbackAiResponse(query) {
            const q = query.toLowerCase();
            if (q.includes('summarize')) {
                return `**Inventory Summary Report**\n\n- **Total Active Items:** ${state.items.length}\n- **Total Uploaded Files:** ${state.files.length}\n- **Categories Represented:** ${Array.from(new Set(state.items.map(i=>i.category))).join(', ')}\n\n*Recommendation:* Items marked Urgent or High priority should be audited first. Storage usage is normal.`;
            } else if (q.includes('description')) {
                return `High-efficiency product designed for optimal workflow integration, featuring high durability, ergonomic aesthetics, and seamless operational reliability.`;
            } else {
                return `Based on your inventory records:\nYou currently have **${state.items.length} items** stored across ${Array.from(new Set(state.items.map(i=>i.category))).length} categories. All system CRUD components are operational.`;
            }
        }

        // AI Assistant Feature Implementations
        async function aiAutoGenerateDescription() {
            const name = document.getElementById('item-name-input').value.trim();
            const category = document.getElementById('item-category-input').value;

            if (!name) {
                alert('Please enter an Item Name first to generate a description!');
                return;
            }

            const prompt = `Write a concise 2-sentence professional product description for an item named "${name}" in category "${category}".`;
            const sys = `You are a helpful product description copywriter.`;

            showFlash('Gemini AI generating description...');
            const result = await callGeminiAPI(prompt, sys);
            document.getElementById('item-description-input').value = result.trim();
        }

        async function aiSummarizeDatabase() {
            switchTab('ai');
            appendChatMessage('user', 'Please generate a comprehensive summary of my inventory database.');

            const itemsContext = JSON.stringify(state.items);
            const filesContext = JSON.stringify(state.files);

            const prompt = `Analyze this dataset:\nItems: ${itemsContext}\nFiles: ${filesContext}\n\nProvide a structured summary, breakdown of priorities, and recommendations.`;
            const sys = `You are an expert AI inventory analyst. Provide concise, well-formatted Markdown bullet points.`;

            const response = await callGeminiAPI(prompt, sys);
            appendChatMessage('ai', response);
        }

        async function aiAuditAndTag() {
            switchTab('ai');
            appendChatMessage('user', 'Run auto-tag and category audit on all items.');
            
            let count = 0;
            state.items.forEach(item => {
                if (!item.tags.includes('audited')) {
                    item.tags.push('audited');
                    count++;
                }
            });

            renderItems();
            appendChatMessage('ai', `Audit completed successfully! Tagged ${count} items with \`#audited\`. Category distribution is balanced across ${Array.from(new Set(state.items.map(i=>i.category))).length} categories.`);
        }

        async function triggerAiAnalyzeItem(id) {
            const item = state.items.find(i => i.id === id);
            if (!item) return;

            switchTab('ai');
            appendChatMessage('user', `Analyze item: "${item.name}"`);

            const prompt = `Item Details:\nName: ${item.name}\nCategory: ${item.category}\nPriority: ${item.priority}\nDescription: ${item.description}\n\nGive 2 actionable suggestions for this item.`;
            const sys = `You are a helpful inventory manager.`;

            const reply = await callGeminiAPI(prompt, sys);
            appendChatMessage('ai', reply);
        }

        async function aiAnalyzeFile(filename) {
            switchTab('ai');
            appendChatMessage('user', `Summarize document: "${filename}"`);
            const reply = await callGeminiAPI(`Provide a brief preview summary for document "${filename}".`);
            appendChatMessage('ai', reply);
        }

        // Chat Interface Helpers
        function appendChatMessage(sender, text) {
            const chatBox = document.getElementById('ai-chat-messages');
            const msgDiv = document.createElement('div');
            msgDiv.className = 'flex gap-3';

            if (sender === 'user') {
                msgDiv.innerHTML = `
                    <div class="ml-auto bg-blue-600 text-white p-3 rounded-2xl rounded-tr-none text-xs leading-relaxed max-w-[85%] shadow-sm">
                        ${escapeHtml(text)}
                    </div>
                `;
            } else {
                msgDiv.innerHTML = `
                    <div class="w-7 h-7 rounded-lg bg-purple-600 text-white flex items-center justify-center text-xs shrink-0">
                        <i class="fa-solid fa-sparkles"></i>
                    </div>
                    <div class="bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 p-3 rounded-2xl rounded-tl-none text-xs leading-relaxed max-w-[85%] space-y-1">
                        ${formatMarkdown(text)}
                    </div>
                `;
            }

            chatBox.appendChild(msgDiv);
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        async function handleAIChatSubmit(e) {
            e.preventDefault();
            const input = document.getElementById('ai-chat-input');
            const userMsg = input.value.trim();
            if (!userMsg) return;

            appendChatMessage('user', userMsg);
            input.value = '';

            const sys = `You are Gemini, an intelligent inventory & document management assistant. Respond clearly and concisely. Context: User has ${state.items.length} items and ${state.files.length} files.`;
            const reply = await callGeminiAPI(userMsg, sys);
            appendChatMessage('ai', reply);
        }

        function clearChatLog() {
            document.getElementById('ai-chat-messages').innerHTML = '';
        }

        // API Key Settings Modal
        function toggleKeyModal() {
            const modal = document.getElementById('key-modal');
            modal.classList.toggle('hidden');
            if (!modal.classList.contains('hidden')) {
                document.getElementById('user-gemini-key').value = state.geminiApiKey;
            }
        }

        function saveApiKey() {
            const key = document.getElementById('user-gemini-key').value.trim();
            state.geminiApiKey = key;
            localStorage.setItem('gemini_api_key', key);
            checkApiKeyBadge();
            toggleKeyModal();
            showFlash('Gemini API key updated!');
        }

        function checkApiKeyBadge() {
            const badge = document.getElementById('api-key-badge');
            if (state.geminiApiKey) {
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }

        // Utility Helpers
        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
        }

        function formatMarkdown(text) {
            if (!text) return '';
            let formatted = escapeHtml(text);
            formatted = formatted.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            formatted = formatted.replace(/\*(.*?)\*/g, '<em>$1</em>');
            formatted = formatted.replace(/`([^`]+)`/g, '<code class="bg-slate-200 dark:bg-slate-700 px-1 py-0.5 rounded text-[11px]">$1</code>');
            formatted = formatted.replace(/\n/g, '<br>');
            return formatted;
        }
    </script>
</body>
</html>