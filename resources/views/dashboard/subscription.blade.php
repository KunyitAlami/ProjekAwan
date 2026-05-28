@extends('layout.app')

@section('title', 'Subscription - MiniStack Cloud')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <div class="mb-10">
        <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 hover:underline flex items-center gap-1 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to dashboard
        </a>
        <h2 class="text-3xl font-bold">Configure your Subscription</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 p-8">
                <p class="text-slate-600 dark:text-slate-400 mb-8">Fill out the form below to select your cloud tier. Our system will automatically provision your resources.</p>

                <form class="space-y-8">
                    <div>
                        <label class="block text-sm font-semibold mb-2">Name your environment</label>
                        <input type="text" value="ProjekAwan" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-600 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Select location</label>
                        <select class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-600 dark:text-white appearance-none">
                            <option>Asia Pacific (Jakarta) - ap-southeast-3</option>
                            <option>Asia Pacific (Singapore) - ap-southeast-1</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-3">Type of tier</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                            <label class="cursor-pointer">
                                <input type="radio" name="tier" value="lite" class="peer sr-only tier-selector">
                                <div class="rounded-lg border-2 border-slate-200 dark:border-slate-700 p-5 text-center hover:bg-slate-50 dark:hover:bg-slate-700 transition peer-checked:border-blue-600 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20">
                                    <div class="font-bold text-slate-900 dark:text-white mb-1">Lite (Bronze)</div>
                                    <div class="text-xs text-slate-500">5 GB Storage</div>
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="tier" value="pro" class="peer sr-only tier-selector" checked>
                                <div class="rounded-lg border-2 border-slate-200 dark:border-slate-700 p-5 text-center hover:bg-slate-50 dark:hover:bg-slate-700 transition peer-checked:border-blue-600 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20">
                                    <div class="font-bold text-slate-900 dark:text-white mb-1">Pro (Silver)</div>
                                    <div class="text-xs text-slate-500">50 GB Storage</div>
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="tier" value="max" class="peer sr-only tier-selector">
                                <div class="rounded-lg border-2 border-slate-200 dark:border-slate-700 p-5 text-center hover:bg-slate-50 dark:hover:bg-slate-700 transition peer-checked:border-blue-600 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20">
                                    <div class="font-bold text-slate-900 dark:text-white mb-1">Max (Gold)</div>
                                    <div class="text-xs text-slate-500">200 GB Storage</div>
                                </div>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 p-8 sticky top-24">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Price estimate</h3>

                <div class="text-4xl font-bold text-slate-900 dark:text-white mb-8 border-b border-slate-200 dark:border-slate-700 pb-6">
                    <span id="summary-price">Rp 150.000</span>
                    <span class="text-base font-normal text-slate-500 block mt-1">monthly</span>
                </div>

                <div class="space-y-4 text-sm mb-8">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600 dark:text-slate-400">Plan selected</span>
                        <span id="summary-plan" class="font-semibold text-slate-900 dark:text-white">Pro (Silver)</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600 dark:text-slate-400">Storage capacity</span>
                        <span id="summary-storage" class="font-semibold text-slate-900 dark:text-white">50 GB</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600 dark:text-slate-400">Data Transfer</span>
                        <span class="font-semibold text-slate-900 dark:text-white">Unlimited</span>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-semibold text-slate-500 mb-2">Currency</label>
                    <select id="currency-selector" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 dark:text-white">
                        <option value="IDR">IDR (Rp)</option>
                        <option value="USD">USD ($)</option>
                    </select>
                </div>

                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition duration-200 shadow-md">
                    Subscribe
                </button>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    // data referensi harga dan paket
    const tierData = {
        'lite': { name: 'Lite (Bronze)', storage: '5 GB', priceIdr: 50000 },
        'pro':  { name: 'Pro (Silver)',  storage: '50 GB', priceIdr: 150000 },
        'max':  { name: 'Max (Gold)',    storage: '200 GB', priceIdr: 300000 }
    };

    const exchangeRate = 17900; // 1 USD = Rp 17.900

    // elemen HTML yang akan diubah
    const summaryPrice   = document.getElementById('summary-price');
    const summaryPlan    = document.getElementById('summary-plan');
    const summaryStorage = document.getElementById('summary-storage');
    const currencySelect = document.getElementById('currency-selector');
    const tierRadios     = document.querySelectorAll('.tier-selector');

    // fungsi utama untuk memperbarui tampilan
    function updateSummary() {
        // cari paket mana yang sedang dipilih
        let selectedTierValue = 'pro';
        tierRadios.forEach(radio => {
            if (radio.checked) selectedTierValue = radio.value;
        });

        const selectedTier = tierData[selectedTierValue];
        const selectedCurrency = currencySelect.value;

        // ubah teks
        summaryPlan.textContent = selectedTier.name;
        summaryStorage.textContent = selectedTier.storage;

        // hitung harga
        if (selectedCurrency === 'IDR') {
            const formattedIDR = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(selectedTier.priceIdr);

            summaryPrice.textContent = formattedIDR;
        } else {
            const priceUsd = selectedTier.priceIdr / exchangeRate;
            const formattedUSD = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format(priceUsd);

            summaryPrice.textContent = formattedUSD;
        }
    }

    // pendeteksi perubahan
    tierRadios.forEach(radio => {
        radio.addEventListener('change', updateSummary);
    });
    currencySelect.addEventListener('change', updateSummary);

    // panggil sekali saat halaman pertama kali dimuat
    updateSummary();
</script>
@endpush
