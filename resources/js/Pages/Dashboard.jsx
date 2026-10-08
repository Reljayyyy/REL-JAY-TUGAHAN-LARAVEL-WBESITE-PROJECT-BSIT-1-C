import React, { useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm, router } from '@inertiajs/react';
import { 
    Search, Plus, Trash2, Edit3, FileText, Sparkles, 
    Upload, Folder, Bot, X, File 
} from 'lucide-react';

export default function Dashboard({ auth, items = [] }) {
    const [searchTerm, setSearchTerm] = useState('');
    const [filterCategory, setFilterCategory] = useState('All');
    const [editingItem, setEditingItem] = useState(null);
    const [aiQuery, setAiQuery] = useState('');
    const [aiResponse, setAiResponse] = useState('');
    const [isAiLoading, setIsAiLoading] = useState(false);

    // Form setup for creating items
    const createForm = useForm({
        name: '',
        category: 'General',
        description: '',
        file: null,
    });

    // Form setup for editing items
    const editForm = useForm({
        name: '',
        category: 'General',
        description: '',
        file: null,
        _method: 'PUT',
    });

    const handleCreate = (e) => {
        e.preventDefault();
        createForm.post(route('items.store'), {
            onSuccess: () => createForm.reset(),
        });
    };

    const handleStartEdit = (item) => {
        setEditingItem(item);
        editForm.clearErrors();
        editForm.setData({
            name: item.name || '',
            category: item.category || 'General',
            description: item.description || '',
            file: null,
            _method: 'PUT',
        });
    };

    const handleUpdate = (e) => {
        e.preventDefault();
        // Method spoofing: using .post with _method: 'PUT' allows multipart file submission
        editForm.post(route('items.update', editingItem.id), {
            onSuccess: () => {
                setEditingItem(null);
                editForm.reset();
            },
        });
    };

    const handleCloseEditModal = () => {
        setEditingItem(null);
        editForm.reset();
        editForm.clearErrors();
    };

    const handleDelete = (id) => {
        if (confirm('Are you sure you want to delete this record?')) {
            router.delete(route('items.destroy', id));
        }
    };

    // Filter items based on search and category
    const filteredItems = items.filter(item => {
        const matchesSearch = item.name.toLowerCase().includes(searchTerm.toLowerCase()) || 
                              (item.description && item.description.toLowerCase().includes(searchTerm.toLowerCase()));
        const matchesCategory = filterCategory === 'All' || item.category === filterCategory;
        return matchesSearch && matchesCategory;
    });

    // Mock AI Assistant integration
    const handleAskAI = () => {
        if (!aiQuery.trim()) return;
        setIsAiLoading(true);
        setTimeout(() => {
            const query = aiQuery.toLowerCase();
            if (query.includes('summarize') || query.includes('summary')) {
                setAiResponse(`You currently have ${items.length} total item(s) logged in your system.`);
            } else if (query.includes('file') || query.includes('upload')) {
                const fileCount = items.filter(i => i.file_path).length;
                setAiResponse(`There are ${fileCount} item(s) with attached files available for download.`);
            } else {
                setAiResponse(`AI Assistant suggestion for "${aiQuery}": Ensure all items are categorized properly to optimize quick searches.`);
            }
            setIsAiLoading(false);
        }, 800);
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Rel Jay Tugahan CRUD Project</h2>}
        >
            <Head title="Dashboard" />

            <div className="py-12 bg-gray-50/50 min-h-screen">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                    {/* Stats Overview */}
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div className="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between transition-all hover:shadow-md">
                            <div>
                                <p className="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Entries</p>
                                <p className="text-3xl font-extrabold text-gray-800 mt-1">{items.length}</p>
                            </div>
                            <div className="p-3 bg-blue-50 text-blue-600 rounded-xl">
                                <Folder className="w-6 h-6" />
                            </div>
                        </div>

                        <div className="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between transition-all hover:shadow-md">
                            <div>
                                <p className="text-xs font-semibold uppercase tracking-wider text-gray-400">Filtered Results</p>
                                <p className="text-3xl font-extrabold text-gray-800 mt-1">{filteredItems.length}</p>
                            </div>
                            <div className="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                                <FileText className="w-6 h-6" />
                            </div>
                        </div>

                        <div className="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between transition-all hover:shadow-md">
                            <div>
                                <p className="text-xs font-semibold uppercase tracking-wider text-gray-400">Attached Files</p>
                                <p className="text-3xl font-extrabold text-gray-800 mt-1">
                                    {items.filter(i => i.file_path).length}
                                </p>
                            </div>
                            <div className="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                                <Upload className="w-6 h-6" />
                            </div>
                        </div>
                    </div>

                    {/* AI Assistant Section */}
                    <div className="bg-gradient-to-r from-slate-900 to-indigo-950 text-white rounded-2xl p-6 shadow-xl relative overflow-hidden">
                        <div className="flex items-center gap-2 text-indigo-400 font-semibold mb-2">
                            <Sparkles className="w-5 h-5 animate-pulse" />
                            <span>AI Assistant Powered Overview</span>
                        </div>
                        <p className="text-gray-300 text-sm mb-4">Ask Gemini AI to analyze, summarize, or query your items list.</p>

                        <div className="flex gap-2">
                            <input 
                                type="text" 
                                value={aiQuery}
                                onChange={(e) => setAiQuery(e.target.value)}
                                placeholder="e.g., Summarize my inventory or count items..." 
                                className="w-full px-4 py-2 bg-slate-800/80 border border-slate-700 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            />
                            <button 
                                onClick={handleAskAI}
                                disabled={isAiLoading}
                                className="bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-2 rounded-xl font-semibold transition-all flex items-center gap-2 shrink-0 disabled:opacity-50"
                            >
                                <Bot className="w-4 h-4" />
                                {isAiLoading ? 'Analyzing...' : 'Ask AI'}
                            </button>
                        </div>

                        {aiResponse && (
                            <div className="mt-4 p-4 bg-slate-800/90 rounded-xl border border-indigo-500/30 text-sm text-indigo-100 flex items-start gap-3">
                                <Sparkles className="w-5 h-5 text-indigo-400 shrink-0 mt-0.5" />
                                <div className="flex-1">{aiResponse}</div>
                                <button onClick={() => setAiResponse('')} className="text-gray-400 hover:text-white">
                                    <X className="w-4 h-4" />
                                </button>
                            </div>
                        )}
                    </div>

                    {/* Main Content Area */}
                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">

                        {/* Left Column: Create Form */}
                        <div className="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm h-fit">
                            <h3 className="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <Plus className="w-5 h-5 text-indigo-600" />
                                Add New Item
                            </h3>

                            <form onSubmit={handleCreate} className="space-y-4">
                                <div>
                                    <label className="block text-xs font-semibold text-gray-500 uppercase mb-1">Item Title</label>
                                    <input 
                                        type="text" 
                                        value={createForm.data.name}
                                        onChange={(e) => createForm.setData('name', e.target.value)}
                                        required
                                        placeholder="e.g., System Design Document"
                                        className="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    />
                                    {createForm.errors.name && <p className="text-red-500 text-xs mt-1">{createForm.errors.name}</p>}
                                </div>

                                <div>
                                    <label className="block text-xs font-semibold text-gray-500 uppercase mb-1">Category</label>
                                    <select 
                                        value={createForm.data.category}
                                        onChange={(e) => createForm.setData('category', e.target.value)}
                                        className="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                                    >
                                        <option value="General">General</option>
                                        <option value="Documents">Documents</option>
                                        <option value="Projects">Projects</option>
                                        <option value="Archive">Archive</option>
                                    </select>
                                </div>

                                <div>
                                    <label className="block text-xs font-semibold text-gray-500 uppercase mb-1">Description</label>
                                    <textarea 
                                        rows="3"
                                        value={createForm.data.description}
                                        onChange={(e) => createForm.setData('description', e.target.value)}
                                        placeholder="Add context or notes..."
                                        className="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                                    ></textarea>
                                </div>

                                <div>
                                    <label className="block text-xs font-semibold text-gray-500 uppercase mb-1">Attachment (File)</label>
                                    <input 
                                        type="file" 
                                        onChange={(e) => createForm.setData('file', e.target.files[0])}
                                        className="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                    />
                                    {createForm.errors.file && <p className="text-red-500 text-xs mt-1">{createForm.errors.file}</p>}
                                </div>

                                <button 
                                    type="submit" 
                                    disabled={createForm.processing}
                                    className="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg transition-colors flex items-center justify-center gap-2"
                                >
                                    <Plus className="w-4 h-4" /> Save Record
                                </button>
                            </form>
                        </div>

                        {/* Right Column: Search, Filter & Items Table */}
                        <div className="lg:col-span-2 space-y-4">
                            
                            {/* Search and Filters Bar */}
                            <div className="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex flex-col md:flex-row gap-3 items-center justify-between">
                                <div className="relative w-full md:w-72">
                                    <Search className="w-4 h-4 text-gray-400 absolute left-3 top-3" />
                                    <input 
                                        type="text" 
                                        value={searchTerm}
                                        onChange={(e) => setSearchTerm(e.target.value)}
                                        placeholder="Search title, details, files..." 
                                        className="w-full pl-9 pr-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500"
                                    />
                                </div>

                                <div className="flex items-center gap-2 w-full md:w-auto overflow-x-auto">
                                    {['All', 'General', 'Documents', 'Projects', 'Archive'].map(cat => (
                                        <button 
                                            key={cat}
                                            onClick={() => setFilterCategory(cat)}
                                            className={`px-3 py-1.5 text-xs font-semibold rounded-lg transition-all ${
                                                filterCategory === cat 
                                                    ? 'bg-indigo-600 text-white shadow-sm' 
                                                    : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
                                            }`}
                                        >
                                            {cat}
                                        </button>
                                    ))}
                                </div>
                            </div>

                            {/* Table */}
                            <div className="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                                <table className="w-full text-left text-sm text-gray-600">
                                    <thead className="bg-gray-50 text-gray-700 uppercase text-xs font-semibold border-b">
                                        <tr>
                                            <th className="p-4">Item Details</th>
                                            <th className="p-4">Category</th>
                                            <th className="p-4">File Attachment</th>
                                            <th className="p-4 text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody className="divide-y divide-gray-100">
                                        {filteredItems.length > 0 ? (
                                            filteredItems.map(item => (
                                                <tr key={item.id} className="hover:bg-gray-50/80 transition-colors">
                                                    <td className="p-4">
                                                        <p className="font-bold text-gray-900">{item.name}</p>
                                                        {item.description && <p className="text-xs text-gray-500 mt-0.5">{item.description}</p>}
                                                    </td>
                                                    <td className="p-4">
                                                        <span className="px-2.5 py-1 bg-indigo-50 text-indigo-700 text-xs font-medium rounded-full">
                                                            {item.category || 'General'}
                                                        </span>
                                                    </td>
                                                    <td className="p-4">
                                                        {item.file_path ? (
                                                            <a 
                                                                href={`/storage/${item.file_path}`} 
                                                                target="_blank" 
                                                                rel="noreferrer"
                                                                className="inline-flex items-center gap-1 text-xs text-indigo-600 hover:underline font-semibold"
                                                            >
                                                                <File className="w-3.5 h-3.5" /> View File
                                                            </a>
                                                        ) : (
                                                            <span className="text-xs text-gray-400">None</span>
                                                        )}
                                                    </td>
                                                    <td className="p-4 text-right space-x-2">
                                                        <button 
                                                            onClick={() => handleStartEdit(item)}
                                                            className="text-indigo-600 hover:text-indigo-800 p-1 rounded transition-colors"
                                                            title="Edit"
                                                        >
                                                            <Edit3 className="w-4 h-4 inline" />
                                                        </button>
                                                        <button 
                                                            onClick={() => handleDelete(item.id)}
                                                            className="text-red-500 hover:text-red-700 p-1 rounded transition-colors"
                                                            title="Delete"
                                                        >
                                                            <Trash2 className="w-4 h-4 inline" />
                                                        </button>
                                                    </td>
                                                </tr>
                                            ))
                                        ) : (
                                            <tr>
                                                <td colSpan="4" className="p-8 text-center text-gray-400">
                                                    No items found matching your filters.
                                                </td>
                                            </tr>
                                        )}
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            {/* Edit Modal */}
            {editingItem && (
                <div className="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 z-50">
                    <div className="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl relative">
                        <button 
                            onClick={handleCloseEditModal} 
                            className="absolute top-4 right-4 text-gray-400 hover:text-gray-600"
                        >
                            <X className="w-5 h-5" />
                        </button>
                        <h3 className="text-lg font-bold text-gray-800 mb-4">Edit Item #{editingItem.id}</h3>

                        <form onSubmit={handleUpdate} className="space-y-4">
                            <div>
                                <label className="block text-xs font-semibold text-gray-500 uppercase mb-1">Item Title</label>
                                <input 
                                    type="text" 
                                    value={editForm.data.name}
                                    onChange={(e) => editForm.setData('name', e.target.value)}
                                    required
                                    className="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                                />
                                {editForm.errors.name && <p className="text-red-500 text-xs mt-1">{editForm.errors.name}</p>}
                            </div>

                            <div>
                                <label className="block text-xs font-semibold text-gray-500 uppercase mb-1">Category</label>
                                <select 
                                    value={editForm.data.category}
                                    onChange={(e) => editForm.setData('category', e.target.value)}
                                    className="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                                >
                                    <option value="General">General</option>
                                    <option value="Documents">Documents</option>
                                    <option value="Projects">Projects</option>
                                    <option value="Archive">Archive</option>
                                </select>
                            </div>

                            <div>
                                <label className="block text-xs font-semibold text-gray-500 uppercase mb-1">Description</label>
                                <textarea 
                                    rows="3"
                                    value={editForm.data.description}
                                    onChange={(e) => editForm.setData('description', e.target.value)}
                                    className="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                                ></textarea>
                            </div>

                            <div>
                                <label className="block text-xs font-semibold text-gray-500 uppercase mb-1">Replace File (Optional)</label>
                                <input 
                                    type="file" 
                                    onChange={(e) => editForm.setData('file', e.target.files[0])}
                                    className="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                />
                                {editForm.errors.file && <p className="text-red-500 text-xs mt-1">{editForm.errors.file}</p>}
                            </div>

                            <div className="flex gap-2 pt-2">
                                <button 
                                    type="button" 
                                    onClick={handleCloseEditModal}
                                    className="w-1/2 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 font-semibold hover:bg-gray-50"
                                >
                                    Cancel
                                </button>
                                <button 
                                    type="submit" 
                                    disabled={editForm.processing}
                                    className="w-1/2 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg transition-colors"
                                >
                                    Update Item
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </AuthenticatedLayout>
    );
}