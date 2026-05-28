@extends('layout.app')

@section('title', 'Storage - MiniStack Cloud')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <div class="mb-10">
        <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 hover:underline flex items-center gap-1 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to dashboard
        </a>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-bold mb-2">Storage Management</h2>
            <p class="text-slate-600 dark:text-slate-400">Monitor your active storage buckets and access credentials.</p>
        </div>
        <button onclick="toggleModal('credentialModal')" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200 flex items-center gap-2 shadow-md">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Create New Bucket
        </button>
    </div>

    <div class="mb-6">
        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wide flex items-center gap-2 mb-4">
            <span class="w-2 h-2 rounded-full bg-green-500"></span> Active products
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                <div class="flex justify-between items-start mb-6">
                    <h4 class="text-lg font-bold text-slate-900 dark:text-white">project-alpha.io</h4>
                    <button class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                    </button>
                </div>

                <div class="space-y-4 text-sm">
                    <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 pb-2">
                        <span class="text-slate-500 dark:text-slate-400">Used</span>
                        <span class="font-semibold text-slate-900 dark:text-white">7.4 GB of 50 GB</span>
                    </div>
                    <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 pb-2">
                        <span class="text-slate-500 dark:text-slate-400">URL</span>
                        <a href="#" class="text-blue-600 hover:underline">https://alpha.ministack.cloud</a>
                    </div>
                    <div class="flex justify-between items-center pt-1">
                        <span class="text-slate-500 dark:text-slate-400">Access key</span>
                        <div class="flex items-center gap-2">
                            <span class="font-mono text-xs bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded">MINI73059C347</span>
                            <button onclick="copyToClipboard('MINI73059C347', 'btn-key-1')" id="btn-key-1-btn" class="text-slate-400 hover:text-blue-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                <div class="flex justify-between items-start mb-6">
                    <h4 class="text-lg font-bold text-slate-900 dark:text-white">backup-storage</h4>
                    <button class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                    </button>
                </div>

                <div class="space-y-4 text-sm">
                    <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 pb-2">
                        <span class="text-slate-500 dark:text-slate-400">Used</span>
                        <span class="font-semibold text-slate-900 dark:text-white">12.0 GB of 50 GB</span>
                    </div>
                    <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 pb-2">
                        <span class="text-slate-500 dark:text-slate-400">URL</span>
                        <a href="#" class="text-blue-600 hover:underline">https://backup.ministack.cloud</a>
                    </div>
                    <div class="flex justify-between items-center pt-1">
                        <span class="text-slate-500 dark:text-slate-400">Access key</span>
                        <div class="flex items-center gap-2">
                            <span class="font-mono text-xs bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded">MINI83701G9H4</span>
                            <button onclick="copyToClipboard('MINI83701G9H4', 'btn-key-2')" id="btn-key-2-btn" class="text-slate-400 hover:text-blue-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="credentialModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="toggleModal('credentialModal')"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="relative inline-block align-bottom bg-white dark:bg-slate-800 rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200 dark:border-slate-700 z-10">
            <div class="bg-white dark:bg-slate-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900/30 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-bold text-slate-900 dark:text-white" id="modal-title">
                            Request New Credentials
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-slate-500 dark:text-slate-400">
                                Create a new storage bucket to generate a fresh Access Key and Secret Key for your API integration.
                            </p>
                        </div>

                        <form class="mt-5 space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Bucket Name</label>
                                <input type="text" placeholder="e.g., my-app-assets" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Access Level</label>
                                <select class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 dark:text-white">
                                    <option>Read & Write (Full Access)</option>
                                    <option>Read Only</option>
                                </select>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <div class="bg-slate-50 dark:bg-slate-700/30 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-200 dark:border-slate-700">
                <button type="button" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition">
                    Generate Credentials
                </button>
                <button type="button" onclick="toggleModal('credentialModal')" class="mt-3 w-full inline-flex justify-center rounded-lg border border-slate-300 dark:border-slate-600 shadow-sm px-4 py-2 bg-white dark:bg-slate-800 text-base font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // fungsi untuk menyalin kredensial
    function copyToClipboard(text, elementId) {
        navigator.clipboard.writeText(text).then(() => {
            const button = document.getElementById(elementId + '-btn');
            const originalHTML = button.innerHTML;
            button.innerHTML = '<svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
            setTimeout(() => {
                button.innerHTML = originalHTML;
            }, 2000);
        });
    }

    // fungsi untuk membuka dan menutup modal
    function toggleModal(modalID) {
        const modal = document.getElementById(modalID);
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }
</script>
@endpush
