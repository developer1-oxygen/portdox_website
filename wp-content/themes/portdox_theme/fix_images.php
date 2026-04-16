
<?php

function get_contents($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);
    if(curl_errno($ch)) {
        echo "cURL error: " . curl_error($ch) . "\n"; // Print cURL error if any
    }
    curl_close($ch);

    return $response;
}

function downloadImagesWithStructure($directory, $baseUrl) {
    // Use glob to find all .jpg and .png files recursively
    $files = glob($directory . '/**/*.{jpg,png}', GLOB_BRACE);

    foreach ($files as $file) {
        // Get the relative path of the file based on the directory
        $relativePath = str_replace($directory . '/', '', $file);
        
        // Create the full URL for the remote file
        $fullUrl = rtrim($baseUrl, '/') . '/' . $relativePath;

        // Define the local path for saving the file to match the URL path
        $localPath = __DIR__ . '/' . $relativePath;
        $localDir = dirname($localPath);

        // Create the directory if it doesn't exist
        if (!file_exists($localDir)) {
            mkdir($localDir, 0755, true);
        }

        // Download the file content
        $fileContent = get_contents($fullUrl);

        // Check if the file was retrieved successfully
        if ($fileContent === false || empty($fileContent)) {
            echo "Failed to download: $fullUrl\n"; // Print error if download failed
        } else {
            // Save the file to the correct location
            file_put_contents($localPath, $fileContent);
            echo "Downloaded: $fullUrl to $localPath\n";
        }
    }
}

// Specify the local directory to scan and the base URL
$directoryToScan = __DIR__ . '/assets/images';
$baseUrl = "https://unicktheme.com/2024/logistiq/main-html/assets/images";

echo "Starting to download image files:\n";
downloadImagesWithStructure($directoryToScan, $baseUrl);

echo "\nDownload completed.\n";
