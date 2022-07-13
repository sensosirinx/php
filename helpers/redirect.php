<?php

function redirect(string $endpoint): void
{
    header("Location: /{$endpoint}");
}
