<?php

declare(strict_types=1);

/**
 * @var \App\View\AppView $this
 * @var string $message
 * @var array<string, mixed> $params
 */

$message = $this->get('message', '');

$class = 'message';
if (!empty($params['class'])) {
    $class .= ' ' . $params['class'];
}
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="<?= h($class) ?>" onclick="this.classList.add('hidden');"><?= $message ?></div>
