<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\Support\DotenvEditor;

use PHPUnit\Framework\TestCase;
use UserFrosting\Support\DotenvEditor\DotenvEditor;

class DotenvEditorTest extends TestCase
{
    protected string $basePath = __DIR__ . '/data/';

    public function testLoad(): void
    {
        $editor = new DotenvEditor();
        $editor->load($this->basePath . '.env');
        $this->assertEquals('dbpass', $editor->getValue('DB_PASSWORD'));
    }

    /**
     * @depends testLoad
     */
    public function testBackup(): void
    {
        $editor = new DotenvEditor();
        $editor->setBackupPath($this->basePath . '.env-backups/');
        $editor->load($this->basePath . '.env');

        $backups_before = $editor->getBackups();
        $editor->backup();
        $backups_after = $editor->getBackups();
        $this->assertEquals(1, count($backups_after) - count($backups_before));

        $editor->deleteBackups();
        $this->assertCount(0, $editor->getBackups());

        // Reset our test dir
        touch($this->basePath . '.env-backups/.gitkeep');
    }

    public function testLoadPathNotExist(): void
    {
        $editor = new DotenvEditor($this->basePath . '.env-backups/');
        $result = $editor->load($this->basePath . '.fakeEnv');
        $this->assertEquals($editor, $result);
    }

    public function testLoadPathIsNull(): void
    {
        $editor = new DotenvEditor($this->basePath . '.env-backups/');
        $this->expectException(\InvalidArgumentException::class);
        $editor->load();
    }

    public function testLoadPathNotExistAndRestore(): void
    {
        // Create a backup
        $editor = new DotenvEditor($this->basePath . '.env-backups/');
        $editor->load($this->basePath . '.env');
        $editor->backup();

        $result = $editor->load($this->basePath . '.fakeEnv', true);
        $this->assertEquals($editor, $result);

        // Reset our test dir
        unlink($this->basePath . '.fakeEnv');
        $editor->deleteBackups();
        touch($this->basePath . '.env-backups/.gitkeep');
    }
}
