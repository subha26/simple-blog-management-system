<?php

function createSlug($title)
{
    $slug = strtolower(trim($title));

    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);

    return trim($slug, '-');
}