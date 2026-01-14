<?php

namespace App\Services\Interfaces;

use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * File Storage Service Interface
 * Following Interface Segregation Principle - focused interface for file operations
 * Following Dependency Inversion Principle - abstraction for file storage
 */
interface FileStorageServiceInterface
{
    /**
     * Store an uploaded file
     * Returns the stored file path
     */
    public function storeFile(UploadedFile $file, string $directory = 'resumes'): string;

    /**
     * Check if a file exists
     * Returns true if file exists
     */
    public function fileExists(string $filePath): bool;

    /**
     * Download a file
     * Returns StreamedResponse for download (Laravel's Storage::download returns StreamedResponse)
     */
    public function downloadFile(string $filePath, string $downloadName): StreamedResponse;

    /**
     * Delete a file
     * Returns true if deleted successfully
     */
    public function deleteFile(string $filePath): bool;
}
