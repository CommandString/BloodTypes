<?php

namespace Common;

use CommandString\Blood\Enums\BloodType;
use CommandString\Utils\ArrayUtils;
use Common\Exceptions\InvalidBloodType;
use HttpSoft\Response\HtmlResponse;
use function strtoupper;

function render(string $path, array $context = [], int $code = 200): HtmlResponse
{
    return new HtmlResponse(renderHtml($path, $context), $code);
}

function renderHtml(string $path, array $context = []): string
{
    $html = env()->twig->render(
        str_replace(".", "/", $path) . ".twig",
        $context
    );

    if (!env()->DEV_MODE) {
        $html = implode("", ArrayUtils::trimValues(explode("\n", $html)));
    }

    return $html;
}

function env(): Env
{
    return Env::get();
}

function getMimeFromExtension(string $extensionToFindMimeFor): ?string
{
    $mimes = json_decode(file_get_contents(__ROOT__ . "/mimes.json"));

    foreach ($mimes as $mime => $extensions) {
        foreach ($extensions as $extension) {
            if ($extension == $extensionToFindMimeFor) {
                return $mime;
            }
        }
    }

    return null;
}

/**
 * @throws InvalidBloodType
 */
function bloodTypeThrowFrom(string $from): BloodType
{
    $type = BloodType::tryFrom(strtoupper($from));

    if ($type === null) {
        throw new InvalidBloodType($type);
    }

    return $type;
}
