<?php
namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

class ImageDownloader
{
    private string $uploadDir;

    public function __construct(string $uploadDir)
    {
        $this->uploadDir = $uploadDir;
    }

    public function download(string $imageUrl): ?string
    {
        // Generate a unique filename
        $imageName = uniqid('img_') . '.' . pathinfo($imageUrl, PATHINFO_EXTENSION);
        $imagePath = $this->uploadDir . '/' . $imageName;

        // Ensure directory exists
        $filesystem = new Filesystem();
        if (!$filesystem->exists($this->uploadDir)) {
            $filesystem->mkdir($this->uploadDir, 0755);
        }

        // Download the image
        try {
            $imageContent = file_get_contents($imageUrl);
            if ($imageContent === false) {
                throw new \Exception("Failed to download image.");
            }
            file_put_contents($imagePath, $imageContent);
            return $imageName; // Return saved image filename
        } catch (\Exception $e) {
            return null; // Return null if download fails
        }
    }
}

