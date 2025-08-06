<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 * Updated for PHP 8.x compatibility
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A KeyCache which streams to and from disk.
 * Updated for modern PHP compatibility (PHP 8.x)
 * 
 * @package Swift
 * @subpackage KeyCache
 * @author Chris Corbyn
 */
class Swift_KeyCache_DiskKeyCache implements Swift_KeyCache
{
    /** Signal to place pointer at start of file */
    public const POSITION_START = 0;

    /** Signal to place pointer at end of file */
    public const POSITION_END = 1;

    /**
     * An InputStream for cloning.
     */
    private Swift_KeyCache_KeyCacheInputStream $_stream;

    /**
     * A path to write to.
     */
    private string $_path;

    /**
     * Stored keys and their file handles.
     */
    private array $_keys = [];

    /**
     * File permissions for created directories
     */
    private int $_dirPermissions = 0755;

    /**
     * File permissions for created cache files
     */
    private int $_filePermissions = 0644;

    /**
     * Create a new DiskKeyCache with the given $stream for cloning to make
     * InputByteStreams, and the given $path to save to.
     * 
     * @param Swift_KeyCache_KeyCacheInputStream $stream
     * @param string $path Path to save cache files to
     * @param int $dirPermissions Directory permissions (default: 0755)
     * @param int $filePermissions File permissions (default: 0644)
     * @throws Swift_IoException
     */
    public function __construct(
        Swift_KeyCache_KeyCacheInputStream $stream, 
        $path,
        $dirPermissions = 0755,
        $filePermissions = 0644
    ) {
        if (empty($path)) {
            throw new Swift_IoException('Cache path cannot be empty');
        }
        
        $this->_stream = $stream;
        $this->_path = rtrim($path, '/\\');
        $this->_dirPermissions = $dirPermissions;
        $this->_filePermissions = $filePermissions;
        
        // Ensure base cache directory exists
        if (!is_dir($this->_path)) {
            if (!mkdir($this->_path, $this->_dirPermissions, true)) {
                throw new Swift_IoException('Failed to create base cache directory: ' . $this->_path);
            }
        }
    }

    /**
     * Set a string into the cache under $itemKey for the namespace $nsKey.
     * 
     * @param string $nsKey Namespace key
     * @param string $itemKey Item key
     * @param string $string Data to store
     * @param int $mode Write mode (MODE_WRITE or MODE_APPEND)
     * @throws Swift_IoException
     * @throws InvalidArgumentException
     */
    public function setString($nsKey, $itemKey, $string, $mode)
    {
        $this->_validateKeys($nsKey, $itemKey);
        $this->_prepareCache($nsKey);
        
        switch ($mode) {
            case self::MODE_WRITE:
                $position = self::POSITION_START;
                break;
            case self::MODE_APPEND:
                $position = self::POSITION_END;
                break;
            default:
                throw new Swift_SwiftException(
                    "Invalid mode [{$mode}] used to set nsKey={$nsKey}, itemKey={$itemKey}"
                );
        }

        $fp = $this->_getHandle($nsKey, $itemKey, $position);
        
        $bytesWritten = fwrite($fp, $string);
        if ($bytesWritten === false) {
            throw new Swift_IoException("Failed to write data to cache file: {$nsKey}/{$itemKey}");
        }
        
        fflush($fp);
    }

    /**
     * Set a ByteStream into the cache under $itemKey for the namespace $nsKey.
     * 
     * @param string $nsKey Namespace key
     * @param string $itemKey Item key
     * @param Swift_OutputByteStream $os Output byte stream
     * @param int $mode Write mode (MODE_WRITE or MODE_APPEND)
     * @throws Swift_IoException
     * @throws InvalidArgumentException
     */
    public function importFromByteStream(
        $nsKey, 
        $itemKey, 
        Swift_OutputByteStream $os,
        $mode
    ) {
        $this->_validateKeys($nsKey, $itemKey);
        $this->_prepareCache($nsKey);
        
        switch ($mode) {
            case self::MODE_WRITE:
                $position = self::POSITION_START;
                break;
            case self::MODE_APPEND:
                $position = self::POSITION_END;
                break;
            default:
                throw new Swift_SwiftException(
                    "Invalid mode [{$mode}] used to set nsKey={$nsKey}, itemKey={$itemKey}"
                );
        }

        $fp = $this->_getHandle($nsKey, $itemKey, $position);
        
        while (($bytes = $os->read(8192)) !== false && !empty($bytes)) {
            $bytesWritten = fwrite($fp, $bytes);
            if ($bytesWritten === false) {
                throw new Swift_IoException("Failed to write stream data to cache file: {$nsKey}/{$itemKey}");
            }
        }
        
        fflush($fp);
    }

    /**
     * Provides a ByteStream which when written to, writes data to $itemKey.
     * NOTE: The stream will always write in append mode.
     * 
     * @param string $nsKey Namespace key
     * @param string $itemKey Item key
     * @param Swift_InputByteStream|null $writeThrough Optional write-through stream
     * @return Swift_InputByteStream
     */
    public function getInputByteStream(
        $nsKey, 
        $itemKey,
        Swift_InputByteStream $writeThrough = null
    ) {
        $this->_validateKeys($nsKey, $itemKey);
        
        $is = clone $this->_stream;
        $is->setKeyCache($this);
        $is->setNsKey($nsKey);
        $is->setItemKey($itemKey);
        
        if (isset($writeThrough)) {
            $is->setWriteThroughStream($writeThrough);
        }
        
        return $is;
    }

    /**
     * Get data back out of the cache as a string.
     * 
     * @param string $nsKey Namespace key
     * @param string $itemKey Item key
     * @return string|null Returns null if key doesn't exist
     * @throws Swift_IoException
     */
    public function getString($nsKey, $itemKey)
    {
        $this->_validateKeys($nsKey, $itemKey);
        $this->_prepareCache($nsKey);
        
        if (!$this->hasKey($nsKey, $itemKey)) {
            return null;
        }

        $fp = $this->_getHandle($nsKey, $itemKey, self::POSITION_START);
        $str = '';
        
        while (!feof($fp)) {
            $bytes = fread($fp, 8192);
            if ($bytes === false) {
                throw new Swift_IoException("Failed to read from cache file: {$nsKey}/{$itemKey}");
            }
            $str .= $bytes;
        }
        
        return $str;
    }

    /**
     * Get data back out of the cache as a ByteStream.
     * 
     * @param string $nsKey Namespace key
     * @param string $itemKey Item key
     * @param Swift_InputByteStream $is Input stream to write the data to
     * @throws Swift_IoException
     */
    public function exportToByteStream($nsKey, $itemKey, Swift_InputByteStream $is)
    {
        $this->_validateKeys($nsKey, $itemKey);
        
        if (!$this->hasKey($nsKey, $itemKey)) {
            return;
        }

        $fp = $this->_getHandle($nsKey, $itemKey, self::POSITION_START);
        
        while (!feof($fp)) {
            $bytes = fread($fp, 8192);
            if ($bytes === false) {
                throw new Swift_IoException("Failed to read from cache file: {$nsKey}/{$itemKey}");
            }
            if (!empty($bytes)) {
                $is->write($bytes);
            }
        }
    }

    /**
     * Check if the given $itemKey exists in the namespace $nsKey.
     * 
     * @param string $nsKey Namespace key
     * @param string $itemKey Item key
     * @return bool
     */
    public function hasKey($nsKey, $itemKey)
    {
        $this->_validateKeys($nsKey, $itemKey);
        return is_file($this->_getCacheFilePath($nsKey, $itemKey));
    }

    /**
     * Clear data for $itemKey in the namespace $nsKey if it exists.
     * 
     * @param string $nsKey Namespace key
     * @param string $itemKey Item key
     * @throws Swift_IoException
     */
    public function clearKey($nsKey, $itemKey)
    {
        $this->_validateKeys($nsKey, $itemKey);
        
        if (!$this->hasKey($nsKey, $itemKey)) {
            return;
        }

        // Close file handle if it exists
        if (isset($this->_keys[$nsKey][$itemKey])) {
            fclose($this->_keys[$nsKey][$itemKey]);
            unset($this->_keys[$nsKey][$itemKey]);
        }

        $filePath = $this->_getCacheFilePath($nsKey, $itemKey);
        if (!unlink($filePath)) {
            throw new Swift_IoException("Failed to delete cache file: {$filePath}");
        }
    }

    /**
     * Clear all data in the namespace $nsKey if it exists.
     * 
     * @param string $nsKey Namespace key
     * @throws Swift_IoException
     */
    public function clearAll($nsKey)
    {
        if (empty($nsKey)) {
            throw new Swift_SwiftException('Namespace key cannot be empty');
        }

        if (!array_key_exists($nsKey, $this->_keys)) {
            return;
        }

        // Close all file handles for this namespace
        foreach ($this->_keys[$nsKey] as $itemKey => $handle) {
            if (is_resource($handle)) {
                fclose($handle);
            }
        }

        // Remove all cache files in the namespace directory
        $nsPath = $this->_getNamespacePath($nsKey);
        if (is_dir($nsPath)) {
            $files = glob($nsPath . '/*');
            foreach ($files ?: [] as $file) {
                if (is_file($file) && !unlink($file)) {
                    throw new Swift_IoException("Failed to delete cache file: {$file}");
                }
            }
            
            if (!rmdir($nsPath)) {
                throw new Swift_IoException("Failed to remove namespace directory: {$nsPath}");
            }
        }

        unset($this->_keys[$nsKey]);
    }

    /**
     * Get cache statistics for a namespace.
     * 
     * @param string $nsKey Namespace key
     * @return array Statistics array with file count and total size
     */
    public function getStats($nsKey)
    {
        $stats = ['file_count' => 0, 'total_size' => 0];
        
        if (empty($nsKey) || !array_key_exists($nsKey, $this->_keys)) {
            return $stats;
        }

        $nsPath = $this->_getNamespacePath($nsKey);
        if (!is_dir($nsPath)) {
            return $stats;
        }

        $files = glob($nsPath . '/*');
        foreach ($files ?: [] as $file) {
            if (is_file($file)) {
                $stats['file_count']++;
                $stats['total_size'] += filesize($file) ?: 0;
            }
        }

        return $stats;
    }

    // -- Private methods

    /**
     * Validate namespace and item keys.
     * 
     * @param string $nsKey Namespace key
     * @param string $itemKey Item key
     * @throws Swift_SwiftException
     */
    private function _validateKeys($nsKey, $itemKey): void
    {
        if (empty($nsKey)) {
            throw new Swift_SwiftException('Namespace key cannot be empty');
        }
        if (empty($itemKey)) {
            throw new Swift_SwiftException('Item key cannot be empty');
        }
        
        // Prevent path traversal attacks
        if (strpos($nsKey, '..') !== false || strpos($nsKey, '/') !== false || strpos($nsKey, '\\') !== false) {
            throw new Swift_SwiftException('Invalid characters in namespace key');
        }
        if (strpos($itemKey, '..') !== false || strpos($itemKey, '/') !== false || strpos($itemKey, '\\') !== false) {
            throw new Swift_SwiftException('Invalid characters in item key');
        }
    }

    /**
     * Initialize the namespace of $nsKey if needed.
     * 
     * @param string $nsKey Namespace key
     * @throws Swift_IoException
     */
    private function _prepareCache($nsKey): void
    {
        if (!array_key_exists($nsKey, $this->_keys)) {
            $this->_keys[$nsKey] = [];
        }

        $cacheDir = $this->_getNamespacePath($nsKey);
        if (!is_dir($cacheDir)) {
            if (!mkdir($cacheDir, $this->_dirPermissions, true)) {
                throw new Swift_IoException("Failed to create cache directory: {$cacheDir}");
            }
        }
    }

    /**
     * Get a file handle on the cache item.
     * 
     * @param string $nsKey Namespace key
     * @param string $itemKey Item key
     * @param int $position File position (POSITION_START or POSITION_END)
     * @return resource File handle
     * @throws Swift_IoException
     */
    private function _getHandle($nsKey, $itemKey, $position)
    {
        if (!isset($this->_keys[$nsKey][$itemKey])) {
            $filePath = $this->_getCacheFilePath($nsKey, $itemKey);
            $fp = fopen($filePath, 'c+b'); // Create or open for read/write, don't truncate
            
            if ($fp === false) {
                throw new Swift_IoException("Failed to open cache file: {$filePath}");
            }
            
            // Set file permissions
            chmod($filePath, $this->_filePermissions);
            
            $this->_keys[$nsKey][$itemKey] = $fp;
        }

        $handle = $this->_keys[$nsKey][$itemKey];
        
        if ($position === self::POSITION_START) {
            fseek($handle, 0, SEEK_SET);
        } else {
            fseek($handle, 0, SEEK_END);
        }

        return $handle;
    }

    /**
     * Get the full path for a namespace directory.
     * 
     * @param string $nsKey Namespace key
     * @return string Full directory path
     */
    private function _getNamespacePath($nsKey): string
    {
        return $this->_path . DIRECTORY_SEPARATOR . $nsKey;
    }

    /**
     * Get the full path for a cache file.
     * 
     * @param string $nsKey Namespace key
     * @param string $itemKey Item key
     * @return string Full file path
     */
    private function _getCacheFilePath($nsKey, $itemKey): string
    {
        return $this->_getNamespacePath($nsKey) . DIRECTORY_SEPARATOR . $itemKey;
    }

    /**
     * Destructor - Clean up open file handles.
     */
    public function __destruct()
    {
        foreach ($this->_keys as $nsKey => $items) {
            foreach ($items as $itemKey => $handle) {
                if (is_resource($handle)) {
                    fclose($handle);
                }
            }
        }
        $this->_keys = [];
    }
}