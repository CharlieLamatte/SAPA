<?php

namespace Sportsante86\Sapa\tests\Unit;

use Faker\Factory;
use Sportsante86\Sapa\Outils\EncryptionManager;
use Sportsante86\Sapa\Outils\FilesManager;
use Tests\Support\UnitTester;
use Dotenv\Dotenv;

class EncryptionManagerTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private string $data_folder = __DIR__ . '/../Support/Data/';
    private string $root = __DIR__ . '/../..';

    private $faker;

    protected function _before()
    {
        // use the factory to create a Faker\Generator instance
        $this->faker = Factory::create();
        $this->faker->seed(42);

        $dotenv = Dotenv::createImmutable($this->root);
        $dotenv->load();
        $dotenv->required([
            'ENVIRONNEMENT',
            'VERSION',
            'DATE',
            'KEY',
        ]);
    }

    protected function _after()
    {
        $files_to_delete = [
            $this->data_folder . "file1_encrypted.txt",
            $this->data_folder . "file1_decrypted.txt",
            $this->data_folder . "logoCHA_encrypted.jpg",
            $this->data_folder . "logoCHA_decrypted.jpg",
            $this->data_folder . "big_file.txt",
            $this->data_folder . "big_file_encrypted.txt",
            $this->data_folder . "big_file_decrypted.txt",
            $this->data_folder . "random_size_file.txt",
            $this->data_folder . "random_size_file_encrypted.txt",
            $this->data_folder . "random_size_file_decrypted.txt",
        ];

        foreach ($files_to_delete as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }

    protected function _failed()
    {
    }

    public function testEncryptAndDecryptOk()
    {
        $data = "Bob Dupond";
        $encrypted_data = EncryptionManager::encrypt($data);

        $this->assertNotEquals($data, $encrypted_data, "f");

        $parts = explode(':', $encrypted_data);
        $this->assertCount(3, $parts);

        $this->assertNotEmpty($parts[0]);
        $this->assertNotEmpty($parts[1]);
        $this->assertNotEmpty($parts[2]);

        // decrypt data
        $decrypted_data = EncryptionManager::decrypt($encrypted_data);
        $this->assertEquals($data, $decrypted_data);
    }

    public function testEncryptAndDecryptOkRandomSizeString()
    {
        for ($i = 0; $i < 100; $i++) {
            $rand_number = $this->faker->numberBetween(5, 1000);
            $data = $this->faker->text($rand_number);

            $encrypted_data = EncryptionManager::encrypt($data);

            $this->assertNotEquals($data, $encrypted_data, "text_size=" . $rand_number);

            $parts = explode(':', $encrypted_data);
            $this->assertCount(3, $parts);

            $this->assertNotEmpty($parts[0]);
            $this->assertNotEmpty($parts[1]);
            $this->assertNotEmpty($parts[2]);

            // decrypt data
            $decrypted_data = EncryptionManager::decrypt($encrypted_data);
            $this->assertEquals($data, $decrypted_data);
        }
    }

    public function testEncryptAndDecryptNotOkEmptyString()
    {
        $data = "";
        $encrypted_data = EncryptionManager::encrypt($data);
        $this->assertFalse($encrypted_data);
    }

    public function testGenerate_keyOk()
    {
        $this->assertNotFalse(EncryptionManager::generate_key());
    }

    public function testEncryptFileAndDecryptFileOkTextFile()
    {
        $file = $this->data_folder . "file1.txt";
        $encrypted_file = $this->data_folder . "file1_encrypted.txt";

        // encrypt file
        EncryptionManager::encrypt_file($file, $encrypted_file);
        $this->assertTrue(file_exists($encrypted_file));
        $this->assertFalse(FilesManager::files_equals($file, $encrypted_file));

        // decrypt file
        $decrypted_file = $this->data_folder . "file1_decrypted.txt";

        EncryptionManager::decrypt_file($encrypted_file, $decrypted_file);
        $this->assertTrue(file_exists($decrypted_file));

        $this->assertTrue(FilesManager::files_equals($file, $decrypted_file));
    }

    public function testEncryptFileAndDecryptFileOkJpgFile()
    {
        $file = $this->data_folder . "logoCHA.jpg";
        $encrypted_file = $this->data_folder . "logoCHA_encrypted.jpg";

        // encrypt file
        EncryptionManager::encrypt_file($file, $encrypted_file);
        $this->assertTrue(file_exists($encrypted_file));
        $this->assertFalse(FilesManager::files_equals($file, $encrypted_file));

        // decrypt file
        $decrypted_file = $this->data_folder . "logoCHA_decrypted.jpg";

        EncryptionManager::decrypt_file($encrypted_file, $decrypted_file);
        $this->assertTrue(file_exists($decrypted_file));

        $this->assertTrue(FilesManager::files_equals($file, $decrypted_file));
    }

    public function testEncryptFileAndDecryptFileOkBigFile()
    {
        $file = $this->data_folder . "big_file.txt";
        $encrypted_file = $this->data_folder . "big_file_encrypted.txt";

        // création d'un fichier d'environ 96Mo
        for ($i = 0; $i < 100; $i++) {
            file_put_contents($file, $this->faker->text(1000000, true), FILE_APPEND);
        }

        // encrypt file
        EncryptionManager::encrypt_file($file, $encrypted_file);
        $this->assertTrue(file_exists($encrypted_file));
        $this->assertFalse(FilesManager::files_equals($file, $encrypted_file));

        // decrypt file
        $decrypted_file = $this->data_folder . "big_file_decrypted.txt";

        EncryptionManager::decrypt_file($encrypted_file, $decrypted_file);
        $this->assertTrue(file_exists($decrypted_file));

        $this->assertTrue(FilesManager::files_equals($file, $decrypted_file));
    }

    public function testEncryptFileAndDecryptFileOkRandomFileSize()
    {
        $file = $this->data_folder . "random_size_file.txt";
        $encrypted_file = $this->data_folder . "random_size_file_encrypted.txt";

        for ($i = 0; $i < 100; $i++) {
            $rand_number = $this->faker->numberBetween(5, 1000);
            $data = $this->faker->text($rand_number);

            file_put_contents($file, $data);

            // encrypt file
            EncryptionManager::encrypt_file($file, $encrypted_file);
            $this->assertTrue(file_exists($encrypted_file));
            $this->assertFalse(FilesManager::files_equals($file, $encrypted_file));

            // decrypt file
            $decrypted_file = $this->data_folder . "random_size_file_decrypted.txt";

            EncryptionManager::decrypt_file($encrypted_file, $decrypted_file);
            $this->assertTrue(file_exists($decrypted_file));

            $this->assertTrue(FilesManager::files_equals($file, $decrypted_file));
        }
    }
}