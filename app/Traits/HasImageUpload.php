<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;

trait HasImageUpload
{
    /**
     * Sube una imagen, crea su miniatura y devuelve ambas rutas.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @param int $thumbnailWidth
     * @param string|null $driver  'gd' or 'imagick'
     * @return array
     */
    protected function uploadImage($file, string $folder = 'uploads', int $thumbnailWidth = 300, ?string $driver = null): array
    {
        $driver = $driver ?? env('IMAGE_DRIVER', 'gd');

        // Crear manager según el driver
        $manager = match ($driver) {
            'imagick' => new ImageManager(new ImagickDriver()),
            default => new ImageManager(new Driver()),
        };

        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();

        // Rutas relativas
        $imageRelativePath = "{$folder}/{$filename}";
        $thumbnailRelativePath = "{$folder}/thumbnails/{$filename}";

        // Leer la imagen directamente del archivo subido
        $image = $manager->read($file->getRealPath());

        // Guardar la imagen original (como JPG/PNG segun formato)
        Storage::disk('public')->put($imageRelativePath, (string) $image->encode());

        // Generar la miniatura: en v3 los métodos devuelven nueva instancia, no mutan
        $thumbnail = $image
            ->scaleDown($thumbnailWidth, $thumbnailWidth)
            ->cover($thumbnailWidth, $thumbnailWidth);

        Storage::disk('public')->put($thumbnailRelativePath, (string) $thumbnail->encode());

        return [
            'image' => $imageRelativePath,
            'thumbnail' => $thumbnailRelativePath,
        ];
    }

    /**
     * Elimina imagen y miniatura del almacenamiento.
     */
    protected function deleteImage(?string $imagePath, ?string $thumbnailPath): void
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
        if ($thumbnailPath && Storage::disk('public')->exists($thumbnailPath)) {
            Storage::disk('public')->delete($thumbnailPath);
        }
    }
}
