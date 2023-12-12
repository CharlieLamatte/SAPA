<?php

namespace Sportsante86\Sapa\tests\Unit;

use Sportsante86\Sapa\Outils\FilesManager;
use Tests\Support\UnitTester;

class FilesManagerTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private string $data_folder = __DIR__ . '/../Support/Data/';

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testFind_all_filesOk1()
    {
        $folder = $this->data_folder . "test_folder1";

        $expected_file1 = "/test_folder1/a.txt";
        $expected_file2 = "/test_folder1/test_folder2/b.txt";

        $files = FilesManager::find_all_files($folder);
        $this->assertIsArray($files);
        $this->assertCount(2, $files);

        $first_file_found = false;
        $second_file_found = false;

        if (str_contains($files[0], $expected_file1) || str_contains($files[1], $expected_file1)) {
            $first_file_found = true;
        }
        if (str_contains($files[0], $expected_file2) || str_contains($files[1], $expected_file2)) {
            $second_file_found = true;
        }

        $this->assertTrue($first_file_found);
        $this->assertTrue($second_file_found);
    }

    public function testFind_all_filesOk2()
    {
        $folder = $this->data_folder . "test_folder1/test_folder2";

        $expected_file1 = "/test_folder1/test_folder2/b.txt";

        $files = FilesManager::find_all_files($folder);
        $this->assertIsArray($files);
        $this->assertCount(1, $files);
        $this->assertStringContainsString($expected_file1, $files[0]);
    }

    public function testFiles_equalsOk()
    {
        $path_file1 = $this->data_folder . "file1.txt";
        $file1_copy_file1 = $this->data_folder . "file1_copy.txt";

        $this->assertTrue(FilesManager::files_equals($path_file1, $file1_copy_file1));
    }

    public function testFiles_equalsNotOkFileSameSize()
    {
        $path_file1 = $this->data_folder . "file1.txt";
        $path_file2 = $this->data_folder . "file2.txt";

        $this->assertFalse(FilesManager::files_equals($path_file1, $path_file2));
    }

    public function testFiles_equalsNotOkFileDifferentSize()
    {
        $path_file1 = $this->data_folder . "file1.txt";
        $path_file2 = $this->data_folder . "logoCHA.jpg";

        $this->assertFalse(FilesManager::files_equals($path_file1, $path_file2));
    }
}