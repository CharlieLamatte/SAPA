<?php

namespace Sportsante86\Sapa\tests\Benchmark;

use Sportsante86\Sapa\Outils\EncryptionManager;

class EncryptionManagerBench
{
    public function benchEncrypt()
    {
        $data = "Josianne";
        EncryptionManager::encrypt($data);
    }

    public function benchDecrypt()
    {
        $encrypted_data = "aHDn/lk3J+M=:pY48KaTyaq8CUHJ4:TrLVAu5D1J7zAz2RbZ+bdA==";
        EncryptionManager::decrypt($encrypted_data);
    }

    /**
     * @Skip
     */
    public function benchEncrypt_file()
    {
        $data_folder = __DIR__ . "/../Support/Data/";
        EncryptionManager::encrypt_file($data_folder . "bench_file.txt", $data_folder . "bench_file_encrypted.txt");
    }

    /**
     * @Skip
     */
    public function benchDecrypt_file()
    {
        $data_folder = __DIR__ . "/../Support/Data/";
        EncryptionManager::decrypt_file(
            $data_folder . "bench_file_encrypted.txt",
            $data_folder . "bench_file_decrypted.txt"
        );
    }

    public function benchGenerate_key()
    {
        EncryptionManager::generate_key();
    }
}