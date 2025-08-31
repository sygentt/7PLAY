@props([
    'name' => 'home',
    'type' => 'outline', // outline, solid, mini, micro
    'size' => 'default', // micro, small, default, medium, large, xl
    'color' => 'default' // default, primary, success, danger, warning, muted
])

@php
    // Map size to Tailwind classes
    $sizeClasses = [
        'micro' => 'w-3 h-3',
        'small' => 'w-4 h-4', 
        'default' => 'w-5 h-5',
        'medium' => 'w-6 h-6',
        'large' => 'w-8 h-8',
        'xl' => 'w-10 h-10'
    ];

    // Map color to Tailwind classes
    $colorClasses = [
        'default' => 'text-gray-700',
        'primary' => 'text-blue-600',
        'success' => 'text-green-600',
        'danger' => 'text-red-600', 
        'warning' => 'text-yellow-600',
        'muted' => 'text-gray-400'
    ];

    // Map type to icon prefix
    $typePrefix = [
        'outline' => 'o',
        'solid' => 's', 
        'mini' => 'm',
        'micro' => 'c'
    ];

    $iconComponent = "heroicon-{$typePrefix[$type]}-{$name}";
    $classes = trim(($sizeClasses[$size] ?? $sizeClasses['default']) . ' ' . ($colorClasses[$color] ?? $colorClasses['default']) . ' ' . ($attributes['class'] ?? ''));
@endphp

<x-dynamic-component 
    :component="$iconComponent" 
    {{ $attributes->merge(['class' => $classes]) }} 
/>
