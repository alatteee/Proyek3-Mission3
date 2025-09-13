@props(['name' => 'circle', 'class' => 'size-5'])
@php
  $paths = [
    'home' => 'M3 10.5L12 3l9 7.5V21a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1v-10.5z',
    'layers' => 'M12 3l9 5-9 5-9-5 9-5zm-9 9l9 5 9-5M3 21l9 5 9-5',
    'users' => 'M16 14a4 4 0 1 0-8 0M3 21a7 7 0 0 1 14 0M19 8a3 3 0 1 1-6 0',
    'chart' => 'M4 20h16M7 16V9m5 7V5m5 11v-8',
    'crown' => 'M3 18l2-9 5 4 4-4 3 9H3z',
    'circle' => 'M12 21a9 9 0 1 1 0-18 9 9 0 0 1 0 18z'
  ];
@endphp
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
     class="{{ $class }}"><path d="{{ $paths[$name] ?? $paths['circle'] }}" stroke-linecap="round" stroke-linejoin="round"/></svg>
