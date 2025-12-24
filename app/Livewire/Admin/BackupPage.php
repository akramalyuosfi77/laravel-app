<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use ZipArchive;

class BackupPage extends Component
{
    public $autoBackupEnabled = false;
    public $backups = [];
    public $totalSize = '0 MB';
    public $showRestoreModal = false;
    public $selectedBackup = null;
    public $confirmRestore = false;

    public function mount()
    {
        $this->loadBackups();
        $this->autoBackupEnabled = config('backup.auto_backup_enabled', false);
    }

    public function loadBackups()
    {
        $backupPath = storage_path('app/backups');
        
        if (!File::exists($backupPath)) {
            File::makeDirectory($backupPath, 0755, true);
        }

        $files = File::files($backupPath);
        $this->backups = [];
        $totalBytes = 0;

        foreach ($files as $file) {
            $size = $file->getSize();
            $totalBytes += $size;
            
            $this->backups[] = [
                'name' => $file->getFilename(),
                'file' => $file->getFilename(),
                'date' => date('Y-m-d H:i:s', $file->getMTime()),
                'size' => $this->formatBytes($size),
                'type' => 'كامل'
            ];
        }

        // Sort by date descending
        usort($this->backups, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        $this->totalSize = $this->formatBytes($totalBytes);
    }

    public function createBackup()
    {
        try {
            $backupPath = storage_path('app/backups');
            
            if (!File::exists($backupPath)) {
                File::makeDirectory($backupPath, 0755, true);
            }

            $filename = 'backup_' . date('Y-m-d_H-i-s') . '.zip';
            $zipPath = $backupPath . '/' . $filename;

            $zip = new ZipArchive();
            
            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                // Backup database
                $this->backupDatabase($zip);
                
                // Backup important directories (excluding large/unnecessary ones)
                $this->addDirectoryToZip($zip, app_path(), 'app');
                $this->addDirectoryToZip($zip, config_path(), 'config');
                $this->addDirectoryToZip($zip, database_path(), 'database');
                $this->addDirectoryToZip($zip, resource_path(), 'resources');
                $this->addDirectoryToZip($zip, public_path('uploads'), 'public/uploads');
                
                // Add .env file
                if (File::exists(base_path('.env'))) {
                    $zip->addFile(base_path('.env'), '.env');
                }
                
                $zip->close();
                
                $this->loadBackups();
                $this->dispatch('show-notification', [
                    'type' => 'success',
                    'message' => 'تم إنشاء النسخة الاحتياطية بنجاح!'
                ]);
            } else {
                throw new \Exception('فشل في إنشاء ملف النسخة الاحتياطية');
            }
            
        } catch (\Exception $e) {
            $this->dispatch('show-notification', [
                'type' => 'error',
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ]);
        }
    }

    private function backupDatabase($zip)
    {
        // Export database to SQL
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');

        $sqlFile = storage_path('app/temp_db_backup.sql');
        
        // Using Laravel's mysqldump
        try {
            Artisan::call('db:backup', [
                '--path' => $sqlFile
            ]);
        } catch (\Exception $e) {
            // Fallback: manual mysqldump
            $command = sprintf(
                'mysqldump --user=%s --password=%s --host=%s %s > %s',
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($host),
                escapeshellarg($database),
                escapeshellarg($sqlFile)
            );
            
            exec($command);
        }

        if (File::exists($sqlFile)) {
            $zip->addFile($sqlFile, 'database/backup.sql');
        }
    }

    private function addDirectoryToZip($zip, $source, $destination)
    {
        if (!File::exists($source)) {
            return;
        }

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($source),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = $destination . '/' . substr($filePath, strlen($source) + 1);
                
                // Skip certain files/directories
                if ($this->shouldSkipFile($filePath)) {
                    continue;
                }
                
                $zip->addFile($filePath, $relativePath);
            }
        }
    }

    private function shouldSkipFile($filePath)
    {
        $skipPatterns = [
            '/node_modules/',
            '/vendor/',
            '/.git/',
            '/storage/framework/cache/',
            '/storage/framework/sessions/',
            '/storage/framework/views/',
            '/storage/logs/',
        ];

        foreach ($skipPatterns as $pattern) {
            if (strpos($filePath, $pattern) !== false) {
                return true;
            }
        }

        return false;
    }

    public function downloadBackup($filename)
    {
        $path = storage_path('app/backups/' . $filename);
        
        if (File::exists($path)) {
            return Response::download($path);
        }

        $this->dispatch('show-notification', [
            'type' => 'error',
            'message' => 'الملف غير موجود'
        ]);
    }

    public function deleteBackup($filename)
    {
        $path = storage_path('app/backups/' . $filename);
        
        if (File::exists($path)) {
            File::delete($path);
            $this->loadBackups();
            
            $this->dispatch('show-notification', [
                'type' => 'success',
                'message' => 'تم حذف النسخة الاحتياطية بنجاح'
            ]);
        } else {
            $this->dispatch('show-notification', [
                'type' => 'error',
                'message' => 'الملف غير موجود'
            ]);
        }
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }

    public function updatedAutoBackupEnabled($value)
    {
        // Update config file (you can implement this based on your needs)
        $this->dispatch('show-notification', [
            'type' => 'success',
            'message' => $value ? 'تم تفعيل النسخ الاحتياطي التلقائي' : 'تم تعطيل النسخ الاحتياطي التلقائي'
        ]);
    }

    public function openRestoreModal($filename)
    {
        $this->selectedBackup = $filename;
        $this->confirmRestore = false;
        $this->showRestoreModal = true;
    }

    public function closeRestoreModal()
    {
        $this->showRestoreModal = false;
        $this->selectedBackup = null;
        $this->confirmRestore = false;
    }

    public function restoreBackup()
    {
        if (!$this->confirmRestore) {
            $this->dispatch('show-notification', [
                'type' => 'error',
                'message' => 'يجب تأكيد الاستعادة أولاً'
            ]);
            return;
        }

        try {
            $backupPath = storage_path('app/backups/' . $this->selectedBackup);
            
            if (!File::exists($backupPath)) {
                throw new \Exception('الملف غير موجود');
            }

            // Create a temporary extraction directory
            $extractPath = storage_path('app/temp_restore');
            
            if (File::exists($extractPath)) {
                File::deleteDirectory($extractPath);
            }
            
            File::makeDirectory($extractPath, 0755, true);

            // Extract the backup
            $zip = new ZipArchive();
            if ($zip->open($backupPath) === TRUE) {
                $zip->extractTo($extractPath);
                $zip->close();

                // Restore database
                $this->restoreDatabase($extractPath);

                // Restore files
                $this->restoreFiles($extractPath);

                // Clean up
                File::deleteDirectory($extractPath);

                $this->closeRestoreModal();
                $this->loadBackups();

                $this->dispatch('show-notification', [
                    'type' => 'success',
                    'message' => 'تمت استعادة النسخة الاحتياطية بنجاح!'
                ]);
            } else {
                throw new \Exception('فشل في فتح ملف النسخة الاحتياطية');
            }
        } catch (\Exception $e) {
            $this->dispatch('show-notification', [
                'type' => 'error',
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ]);
        }
    }

    private function restoreDatabase($extractPath)
    {
        $sqlFile = $extractPath . '/database/backup.sql';
        
        if (File::exists($sqlFile)) {
            $database = env('DB_DATABASE');
            $username = env('DB_USERNAME');
            $password = env('DB_PASSWORD');
            $host = env('DB_HOST');

            // Restore using mysql command
            $command = sprintf(
                'mysql --user=%s --password=%s --host=%s %s < %s',
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($host),
                escapeshellarg($database),
                escapeshellarg($sqlFile)
            );

            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                throw new \Exception('فشل في استعادة قاعدة البيانات');
            }
        }
    }

    private function restoreFiles($extractPath)
    {
        $restoreMappings = [
            'app' => app_path(),
            'config' => config_path(),
            'resources' => resource_path(),
            'public/uploads' => public_path('uploads'),
        ];

        foreach ($restoreMappings as $source => $destination) {
            $sourcePath = $extractPath . '/' . $source;
            
            if (File::exists($sourcePath)) {
                // Backup current files before overwriting
                $backupCurrentPath = $destination . '_backup_' . time();
                
                if (File::exists($destination)) {
                    File::copyDirectory($destination, $backupCurrentPath);
                    File::deleteDirectory($destination);
                }
                
                try {
                    File::copyDirectory($sourcePath, $destination);
                    
                    // Remove backup if successful
                    if (File::exists($backupCurrentPath)) {
                        File::deleteDirectory($backupCurrentPath);
                    }
                } catch (\Exception $e) {
                    // Restore from backup if failed
                    if (File::exists($backupCurrentPath)) {
                        File::copyDirectory($backupCurrentPath, $destination);
                        File::deleteDirectory($backupCurrentPath);
                    }
                    throw $e;
                }
            }
        }

        // Restore .env file
        $envSource = $extractPath . '/.env';
        if (File::exists($envSource)) {
            File::copy($envSource, base_path('.env'));
        }
    }

    public function render()
    {
        return view('livewire.admin.backup-page');
    }
}
