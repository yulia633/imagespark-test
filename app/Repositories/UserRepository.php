<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * @throws Exception
     */
    public function getUserChunks(int $count)
    {
        $totalCount = random_int(1000, 100000);
        $generatedCount = 0;
        do {
            $currentChunkCount = min($count, $totalCount - $generatedCount);
            $generatedCount += $currentChunkCount;
            // yield User::factory()->count($currentChunkCount)->make();
            return User::factory()->count($currentChunkCount)->make();

        } while ($totalCount < $generatedCount);
    }

}
