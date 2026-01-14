<?php

namespace App\Services;

use App\Services\Interfaces\FileStorageServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * File Storage Service Implementation
 * Following Single Responsibility Principle - only handles file storage operations
 * Following Dependency Inversion Principle - implements interface
 */
class FileStorageService implements FileStorageServiceInterface
{
    /**
     * Store an uploaded file
     * Returns the stored file path
     */
    public function storeFile(UploadedFile $file, string $directory = 'resumes'): string
    {
        return $file->store($directory, 'public');
    }

    /**
     * Check if a file exists
     * Returns true if file exists
     */
    public function fileExists(string $filePath): bool
    {
        return Storage::disk('public')->exists($filePath);
    }

    /**
     * Download a file
     * Returns StreamedResponse for download (Laravel's Storage::download returns StreamedResponse)
     */
    public function downloadFile(string $filePath, string $downloadName): StreamedResponse
    {
        return Storage::disk('public')->download($filePath, $downloadName);
    }

    /**
     * Delete a file
     * Returns true if deleted successfully
     */
    public function deleteFile(string $filePath): bool
    {
        return Storage::disk('public')->delete($filePath);
    }
}
