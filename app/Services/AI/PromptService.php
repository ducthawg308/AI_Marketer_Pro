<?php

namespace App\Services\AI;

use App\Models\Dashboard\AiPrompt;
use Illuminate\Support\Facades\Schema;

class PromptService
{
    /**
     * Get a formatted prompt by its slug.
     *
     * @param string $slug
     * @param array $variables
     * @return string
     */
    public function getPrompt(string $slug, array $variables = []): string
    {
        $content = '';

        // Try to get from DB if table exists (avoids crashes during migration/setup)
        if (Schema::hasTable('ai_prompts')) {
            $prompt = AiPrompt::where('slug', $slug)->first();
            if ($prompt) {
                $content = $prompt->content;
            }
        }

        // If not found in DB, we could have hardcoded fallbacks or throw error
        if (empty($content)) {
            return $this->getHardcodedFallback($slug, $variables);
        }

        return $this->replaceVariables($content, $variables);
    }

    /**
     * Replace placeholders like {product_name} with actual values.
     *
     * @param string $content
     * @param array $variables
     * @return string
     */
    protected function replaceVariables(string $content, array $variables): string
    {
        foreach ($variables as $key => $value) {
            $content = str_replace('{' . $key . '}', $value, $content);
        }

        return $content;
    }

    /**
     * Fallback logic to keep system running even if DB seed fails.
     */
    protected function getHardcodedFallback(string $slug, array $variables): string
    {
        // For now, return a basic string or the variables for debugging
        // Ideally, we populate all 3 main prompts here as well.
        return "Prompt for {$slug} not found in database.";
    }
}
