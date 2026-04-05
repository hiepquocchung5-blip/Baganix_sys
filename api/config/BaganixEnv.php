<?php
/**
 * 🌟 Baganix OOP Environment Parser
 * File: config/BaganixEnv.php
 * Purpose: Securely parses the root .env file without using external Composer packages.
 */

class BaganixEnv {
    /**
     * Load and parse the .env file.
     * @param string $path Absolute path to the .env file
     */
    public static function load(string $path): void {
        if (!file_exists($path)) {
            throw new Exception("Baganix Security Error: .env file is missing at {$path}");
        }

        // Read file into an array, ignoring empty lines and newlines
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            // Skip comments
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Parse Key=Value
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value);

                // Strip quotes if they exist around the value
                $value = trim($value, '"\'');

                // Load into PHP superglobals safely
                if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                    $_ENV[$name] = $value;
                    $_SERVER[$name] = $value;
                }
            }
        }
    }

    /**
     * Get an environment variable safely with an optional fallback.
     */
    public static function get(string $key, $default = null) {
        return $_ENV[$key] ?? $default;
    }
}
?>