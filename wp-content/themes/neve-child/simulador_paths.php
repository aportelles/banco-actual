<?php

if (!function_exists('simulador_upload_path')) {
    function simulador_upload_path($filename = '')
    {
        // Reducir el nombre a un basename evita que el argumento escape del directorio de cargas.
        $normalizedFilename = str_replace('\\', '/', (string) $filename);
        $safeFilename = basename($normalizedFilename);
        $directories = array();

        if (function_exists('wp_upload_dir')) {
            $uploads = wp_upload_dir();
            if (!empty($uploads['basedir'])) {
                $directories[] = rtrim($uploads['basedir'], '/\\');
            }
        }

        if (defined('WP_CONTENT_DIR')) {
            $directories[] = rtrim(WP_CONTENT_DIR, '/\\') . DIRECTORY_SEPARATOR . 'uploads';
        }

        $directories[] = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads';
        $directories[] = __DIR__ . DIRECTORY_SEPARATOR . 'uploads';
        $directories = array_values(array_unique($directories));

        // Preferir la ubicación configurada por WordPress y probar ubicaciones compatibles con instalaciones antiguas.
        foreach ($directories as $directory) {
            $candidate = $directory . DIRECTORY_SEPARATOR . $safeFilename;
            if ($safeFilename !== '' && is_file($candidate)) {
                return $candidate;
            }
        }

        foreach ($directories as $directory) {
            if (is_dir($directory)) {
                return $directory . DIRECTORY_SEPARATOR . $safeFilename;
            }
        }

        return reset($directories) . DIRECTORY_SEPARATOR . $safeFilename;
    }
}

if (!function_exists('simulador_asset_url')) {
    function simulador_asset_url($relativePath = '')
    {
        // Generar URLs desde el tema activo evita dependencias de rutas fijas del sitio.
        $safeRelativePath = ltrim((string) $relativePath, '/');

        if (function_exists('get_theme_file_uri')) {
            return rtrim(get_theme_file_uri(), '/') . '/' . $safeRelativePath;
        }

        if ($safeRelativePath !== '' && file_exists(__DIR__ . '/' . $safeRelativePath)) {
            return '/' . $safeRelativePath;
        }

        if ($safeRelativePath !== '' && file_exists(__DIR__ . '/uploads/' . $safeRelativePath)) {
            return '/uploads/' . $safeRelativePath;
        }

        return '/' . $safeRelativePath;
    }
}
