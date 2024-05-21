<?php

use function Laravel\Folio\middleware;

middleware('auth');

?>

<x-layouts.app>
    <h1 class="text-3xl font-bold underline">
        {{ auth()->user()->email }}
    </h1>
</x-layouts.app>
