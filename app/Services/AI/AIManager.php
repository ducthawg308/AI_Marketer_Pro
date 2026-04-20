<?php

namespace App\Services\AI;

use App\Services\AI\Contracts\AIProviderInterface;
use App\Services\AI\Drivers\GeminiDriver;
use Illuminate\Support\Facades\Log;

class AIManager
{
    protected array $drivers = [];

    /**
     * Get an AI driver instance.
     *
     * @param string|null $driver
     * @return AIProviderInterface
     */
    public function driver(?string $driver = null): AIProviderInterface
    {
        $driver = $driver ?: config('services.ai.default', 'gemini');

        if (!isset($this->drivers[$driver])) {
            $this->drivers[$driver] = $this->createDriver($driver);
        }

        return $this->drivers[$driver];
    }

    /**
     * Create a new driver instance.
     *
     * @param string $driver
     * @return AIProviderInterface
     * @throws \Exception
     */
    protected function createDriver(string $driver): AIProviderInterface
    {
        switch ($driver) {
            case 'gemini':
                return new GeminiDriver();
            // case 'openai':
            //     return new OpenAIDriver();
            default:
                throw new \Exception("AI Driver [{$driver}] not supported.");
        }
    }
}
