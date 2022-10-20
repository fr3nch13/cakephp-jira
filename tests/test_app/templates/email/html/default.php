<?php
declare(strict_types=1);
/**
 * @var \App\View\AppView $this
 * @var string $content
 */

$content ?? '';
$content = explode("\n", $content);

foreach ($content as $line) :
    echo '<p> ' . $line . "</p>\n";
endforeach;
