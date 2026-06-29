<?php

namespace App\Http\Controllers;

use App\Repositories\BucketRepository;
use App\Repositories\CredentialRepository;
use App\Repositories\SubscriptionOrderRepository;
use App\Repositories\SubscriptionPackageRepository;
use App\Repositories\ObjectRepository;
use App\Repositories\LogRepository;
use App\Repositories\UserSubscriptionRepository;
use App\Services\StorageService;
use App\Services\SubscriptionService;
use App\Services\UserSetupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

/**
 * Controller untuk dashboard utama, storage, dan subscription.
 * Thin controller — semua business logic didelegasikan ke Service classes.
 */
class DashboardController extends Controller
{
    public function __construct(
        private UserSetupService $userSetupService,
        private StorageService $storageService,
        private SubscriptionService $subscriptionService
    ) {}

    /**
     * Halaman utama dashboard — overview akun, subscription, storage, credentials.
     */
    public function index()
    {
        $user = Auth::user();
        $activeSub = $this->userSetupService->ensureUserIsReady($user->id);
        $package = SubscriptionPackageRepository::findById($activeSub->package_id);
        $credentials = CredentialRepository::findByUserId($user->id);

        $userData = [
            'name' => $user->name,
            'email' => $user->email,
            'username' => $user->username,
            'joinedDate' => $user->created_at->format('M d, Y'),
            'status' => ucfirst($user->status ?? 'active'),
        ];

        $subscriptionData = [
            'plan' => $package->name,
            'status' => ucfirst($activeSub->status),
            'storage' => $package->storage_limit_gb . ' GB',
            'renewalDate' => \Carbon\Carbon::parse($activeSub->end_date)->format('M d, Y'),
            'price' => 'Rp ' . number_format($package->price_per_month, 0, ',', '.'),
        ];

        $storageData = $this->storageService->getStorageOverview($user->id, $package);

        $credentialsData = [
            'accessKey' => $credentials->access_key,
            'secretKey' => $credentials->secret_key,
        ];

        return view('dashboard.index', compact('userData', 'subscriptionData', 'storageData', 'credentialsData'));
    }

    /**
     * Halaman storage management — list bucket + upload files.
     */
    public function storage()
    {
        $user = Auth::user();

        $activeSub = $this->userSetupService
            ->ensureUserIsReady($user->id);

        $package = SubscriptionPackageRepository::findById(
            $activeSub->package_id
        );

        $storageData = $this->storageService
            ->getStorageOverview($user->id, $package);

        $storageData['buckets_count'] =
            BucketRepository::countByUserId($user->id);

        $buckets = $this->storageService
            ->getBucketsWithObjects($user->id);

        $credentials = CredentialRepository::findByUserId($user->id);

        $logs = LogRepository::getByUserId($user->id, 10);

        return view(
            'dashboard.storage',
            compact(
                'storageData',
                'buckets',
                'credentials',
                'logs'
            )
        );
    }

    /**
     * Halaman subscription management — pilih paket + order history.
     */
    public function subscription()
    {
        $user = Auth::user();
        $activeSub = $this->userSetupService->ensureUserIsReady($user->id);
        $currentPackage = SubscriptionPackageRepository::findById($activeSub->package_id);
        $usedGB = $this->storageService->getUsedStorageGb($user->id);

        $packages = SubscriptionPackageRepository::getAllActive();
        $orders = SubscriptionOrderRepository::getRecentByUserId($user->id, 5);

        return view('dashboard.subscription', compact('activeSub', 'currentPackage', 'packages', 'orders', 'usedGB'));
    }

    /**
     * Buat bucket storage baru.
     */
    public function storeBucket(Request $request)
    {
        $user = Auth::user();
        $activeSub = $this->userSetupService->ensureUserIsReady($user->id);

        $request->validate([
            'bucket_name' => [
                'required', 'string', 'min:3', 'max:63',
                'regex:/^[a-z0-9.-]+$/',
            ],
        ]);

        // Cek duplikat nama bucket
        if (BucketRepository::findByBucketName($request->input('bucket_name'))) {
            return redirect()->back()->withInput()->withErrors(['bucket_name' => 'Nama bucket sudah digunakan.']);
        }

        try {
            $this->storageService->createBucket($user->id, $activeSub->id, $request->input('bucket_name'));
            return redirect()->route('dashboard.storage')->with('success', "Bucket '{$request->input('bucket_name')}' berhasil dibuat!");
        } catch (RuntimeException $e) {
            return redirect()->back()->withInput()->withErrors(['bucket_name' => $e->getMessage()]);
        }
    }

    /**
     * Upload file ke bucket.
     */
    public function uploadObject(Request $request)
    {
        $request->validate([
            'bucket_id' => 'required|integer',
            'dokumen' => 'required|array',
            'dokumen.*' => 'file|max:20480|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,zip,txt',
        ], [
            'dokumen.required' => 'Anda harus memilih minimal 1 file.',
            'dokumen.file' => 'File yang dipilih tidak valid.',
            'dokumen.max' => 'Ukuran file tidak boleh lebih dari 20MB.',
            'dokumen.mimes' => 'Format file tidak diizinkan.',
        ]);

        $files = $request->file('dokumen');

        foreach ($files as $file) {
            if (!$file->isValid()) {
                return redirect()->back()->withErrors(['dokumen' => 'File yang dipilih tidak valid.']);
            }

            try {
                $this->storageService->uploadObject(
                    Auth::id(),
                    (int) $request->input('bucket_id'),
                    $file
                );
            } catch (RuntimeException $e) {
                return redirect()->back()->withErrors(['dokumen' => $e->getMessage()]);
            }
        }
        $count = count($request->file('dokumen'));
        return redirect()->back()->with('success', "{$count} file berhasil diupload.");
    }

    /**
     * Buat order upgrade subscription (AJAX).
     */
    public function createSubscriptionOrder(Request $request)
    {
        $validated = $request->validate([
            'package_id' => ['required', 'integer'],
        ]);

        $usedGb = $this->storageService->getUsedStorageGb(Auth::id());

        try {
            $result = $this->subscriptionService->createUpgradeOrder(
                Auth::id(),
                (int) $validated['package_id'],
                $usedGb
            );

            return response()->json($result);
        } catch (RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    /**
     * Sinkronisasi status order dari Midtrans (AJAX).
     */
    public function syncSubscriptionOrder(Request $request)
    {
        $validated = $request->validate([
            'order_id' => ['required', 'string'],
        ]);

        try {
            $result = $this->subscriptionService->syncOrderStatus(Auth::id(), $validated['order_id']);
            return response()->json($result);
        } catch (RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    /**
     * Handle notifikasi webhook Midtrans.
     */
    public function handleMidtransNotification(Request $request)
    {
        try {
            $this->subscriptionService->handleNotification($request->all());
            return response()->json(['message' => 'Notification processed']);
        } catch (RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getMessage() === 'Invalid signature' ? 403 : 404);
        }
    }

    /**
     * Hapus file dari bucket.
     */
    public function deleteObject(int $id)
    {
        try {
            $object = ObjectRepository::findById($id);

            if (! $object) {
                throw new RuntimeException('File tidak ditemukan.');
            }

            LogRepository::create([
                'user_id' => Auth::id(),
                'action' => 'DELETE_OBJECT',
                'target_type' => 'object',
                'target_id' => $object->id,
                'description' => 'Menghapus file "' . $object->original_filename . '"',
            ]);

            $this->storageService->deleteObject(
                Auth::id(),
                $id
            );

            return back()->with(
                'success',
                'File berhasil dihapus.'
            );
        } catch (RuntimeException $e) {
            return back()->withErrors([
                'object' => $e->getMessage()
            ]);
        }
    }

    /**
     * Download file dari bucket.
     */
    public function downloadObject(int $id)
    {
        try {
            $object = ObjectRepository::findById($id);

            if (! $object) {
                throw new RuntimeException('File tidak ditemukan.');
            }

            LogRepository::create([
                'user_id' => Auth::id(),
                'action' => 'DOWNLOAD_OBJECT',
                'target_type' => 'object',
                'target_id' => $object->id,
                'description' => 'Mengunduh file "' . $object->original_filename . '"',
            ]);

            return $this->storageService->downloadObject(
                Auth::id(),
                $id
            );
        } catch (RuntimeException $e) {
            return back()->withErrors([
                'object' => $e->getMessage()
            ]);
        }
    }
}
