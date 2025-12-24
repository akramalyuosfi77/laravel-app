<?php

namespace App\Services;

use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PdfService
{
    public function extractText($filePath)
    {
        try {
            // Ensure we get the full path whether it's stored in public or local
            $fullPath = null;
            
            if (Storage::disk('public')->exists($filePath)) {
                $fullPath = Storage::disk('public')->path($filePath);
            } elseif (file_exists($filePath)) {
                 $fullPath = $filePath;
            }

            if (!$fullPath) {
                Log::warning("PDF Service: File not found at $filePath");
                return null;
            }

            $parser = new Parser();
            $pdf = $parser->parseFile($fullPath);
            return $pdf->getText();

        } catch (\Exception $e) {
            Log::error('PDF Parse Error: ' . $e->getMessage());
            // Return null or empty string so operation can continue or fail gracefully
            return null;
        }
    }
}
