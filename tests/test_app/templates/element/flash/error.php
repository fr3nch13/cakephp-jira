<?php

declare(strict_types=1);

/**
 * @var \App\View\AppView $this
 * @var string $message
 * @var array<string, mixed> $params
 */

$message = $this->get('message', '');

if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="message error" onclick="this.classList.add('hidden');"><?= $message ?></div>
