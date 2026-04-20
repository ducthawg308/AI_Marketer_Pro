<?php

namespace App\Services\AI\Contracts;

interface AIProviderInterface
{
    /**
     * Generate content based on a prompt.
     *
     * @param string $prompt
     * @param array $options
     * @return array ['success' => bool, 'content' => string, 'raw' => mixed, 'error' => string]
     */
    public function generate(string $prompt, array $options = []): array;
}
