<?php

declare(strict_types=1);

namespace App\Services\Exercise;

final readonly class TemplateService
{
    /**
     * @param string $langCode
     * @param string $subject
     * @param string $type
     * @return array
     */
    public function getExerciseTemplate(string $langCode, string $type, string $subject): array
    {
        $template = config("exercises.templates.{$langCode}.{$type}.{$subject}");

        if (isset($template['message_file']))
        {
            $template['message'] = file_get_contents(
                resource_path("templates/{$template['message_file']}")
            );
        }

        return $template;
    }
}
