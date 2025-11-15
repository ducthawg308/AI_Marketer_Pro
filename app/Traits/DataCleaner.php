<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait DataCleaner
{
    protected function cleanText($text)
    {
        if (empty($text)) return '';
        $text = strip_tags($text);
        $text = trim(preg_replace('/\s+/', ' ', $text));
        $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
        return Str::limit($text, 500, '...');
    }

    protected function cleanArrayItems($items, $textFields = ['title', 'description', 'content', 'text', 'query'])
    {
        return array_map(function ($item) use ($textFields) {
            foreach ($textFields as $field) {
                if (isset($item[$field])) {
                    $item[$field] = $this->cleanText($item[$field]);
                }
            }
            return $item;
        }, $items);
    }

    protected function removeEmptyAndDuplicates($items, $keyField = 'title', $minValue = null, $valueField = 'value')
    {
        return array_values(array_filter($items, function ($item) use ($keyField, $minValue, $valueField) {
            // Bỏ nếu thiếu key
            if (empty($item[$keyField] ?? '')) return false;
            // Bỏ nếu value < min
            if ($minValue !== null && ($item[$valueField] ?? 0) < $minValue) return false;
            return true;
        }));
    }

    protected function normalizeDatesInArray($items, $dateFields = ['date', 'published_at', 'created'])
    {
        return array_map(function ($item) use ($dateFields) {
            foreach ($dateFields as $field) {
                if (isset($item[$field])) {
                    $item[$field] = $this->normalizeDate($item[$field]);
                }
            }
            return $item;
        }, $items);
    }

    protected function normalizeDate($date)
    {
        if (empty($date)) return null;
        if (is_numeric($date)) return date('Y-m-d H:i:s', $date);
        $time = strtotime($date);
        return $time ? date('Y-m-d H:i:s', $time) : null;
    }
}