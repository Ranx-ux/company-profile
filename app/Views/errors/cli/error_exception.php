<?php
// Minimal CLI error view to avoid missing-file errors during migrations.
echo "An error occurred while running the CLI command.\n";
if (isset($exception)) {
    echo $exception::class . ': ' . $exception->getMessage() . "\n";
}
