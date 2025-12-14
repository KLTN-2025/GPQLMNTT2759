<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

trait DisableForeignKeys
{
    /**
     * Tắt foreign key checks trước khi seed
     */
    protected function disableForeignKeys(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    }

    /**
     * Bật lại foreign key checks sau khi seed
     */
    protected function enableForeignKeys(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Chạy seeder với foreign keys disabled
     */
    protected function runWithDisabledForeignKeys(callable $callback): void
    {
        $this->disableForeignKeys();

        try {
            $callback();
        } finally {
            $this->enableForeignKeys();
        }
    }
}
