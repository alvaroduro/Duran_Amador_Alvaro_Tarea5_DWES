<!--Grupos de Links-->
@php
    // Array de grupos de elementos y sus links
    $links = [
        [
            'nombre' => 'Home',
            'icono' => 'layout-grid',
            'ruta' => route('home'),
            'current' => request()->routeIs('home'),
        ]
    ];

    if (auth()->check()) {
        if (auth()->user()->rol === 'admin') {
            $links[] = [
                'nombre' => 'Categorías',
                'icono' => 'queue-list',
                'ruta' => route('admin.categorias.index'),
                'current' => request()->routeIs('admin.categorias.*'),
            ];
            $links[] = [
                'nombre' => 'Usuarios',
                'icono' => 'user',
                'ruta' => route('admin.usuarios.index'),
                'current' => request()->routeIs('admin.usuarios.*'),
            ];
            $links[] = [
                'nombre' => 'Entradas',
                'icono' => 'clipboard-document-list',
                'ruta' => route('admin.entradas.index'),
                'current' => request()->routeIs('admin.entradas.*'),
            ];
        } elseif (auth()->user()->rol === 'user') {
            $links[] = [
                'nombre' => 'Mis Entradas',
                'icono' => 'clipboard-document-list',
                'ruta' => route('user.entradas.index'),
                'current' => request()->routeIs('user.entradas.*'),
            ];
        }
    }
@endphp


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        
        <title>{{ $title ?? config('app.name') }}</title>
        
        <link rel="icon" href="/img/faviconblog.png" sizes="any">
        <link rel="icon" href="/img/faviconblog.png" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @fluxAppearance
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <!--LOGOTIPO-->
            <a href="{{ route('home') }}" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0" wire:navigate>
                {{-- <--RUTA DEL LOGOTIPO--> --}}
                <x-app-logo />
            </a>

            <!----NAV FLUX ICONO---->
            <flux:navbar class="-mb-px max-lg:hidden">
                <!--Iteramos los items en el nav-->
                @foreach ($links as $link)                                 
                <flux:navbar.item :icon="$link['icono']" :href="$link['ruta']" 
                :current="$link['current']" wire:navigate>
                    {{ ($link['nombre']) }}
                </flux:navbar.item>
                @endforeach
            </flux:navbar>

            <!--Espaciador-->
            <flux:spacer />

            <!-- Desktop User Menu -->
            <!--Mostrar solo cuando estemos autenticados-->
            @auth
                <flux:dropdown position="top" align="end">
                    <flux:profile
                        class="cursor-pointer"
                        :initials="auth()->user()->initials()"
                    />

                    <flux:menu>
                        <flux:menu.radio.group>
                            <div class="p-0 text-sm font-normal">
                                <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                    <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                        <span
                                            class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                        >
                                            {{ auth()->user()->initials() }}
                                        </span>
                                    </span>

                                    <div class="grid flex-1 text-start text-sm leading-tight">
                                        <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                        <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                    </div>
                                </div>
                            </div>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Opciones') }}</flux:menu.item>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                                {{ __('Cerrar Sesión') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>

            <!--Si no estamos autenticados menu para ello-->    
            @else
            <flux:dropdown position="top" align="end">
                    <flux:button
                        class="cursor-pointer"
                        icon="user"/>

                    <!--menu iconos top-derecha-->
                    <flux:menu>
                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('login')"
                             wire:navigate>{{ __('Iniciar Sesión') }}
                            </flux:menu.item>
                            <flux:menu.item :href="route('register')"
                             wire:navigate>{{ __('Registrate') }}
                            </flux:menu.item>
                        </flux:menu.radio.group>
                    </flux:menu>

                </flux:dropdown>
            @endauth
        </flux:header>
       

        <!-- Mobile Menu -->
        <flux:sidebar stashable sticky class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('home') }}" class="ms-1 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Blog')">
                    <flux:navlist.item icon="layout-grid" :href="route('home')" :current="request()->routeIs('dashboard')" wire:navigate>
                    {{ __('Dashboard') }}
                    </flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />
        </flux:sidebar>

        <flux:main>
         <!--Mensaje de Bienvenida-->
        <div class="flex items-center justify-center min-h-[60vh] px-4">
            <div class="text-center max-w-2xl w-full">
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-zinc-800 dark:text-white mb-4">
                    ¡Bienvenido al Blog gestionado por Álvaro Durán!
                </h1>

                <p class="text-base md:text-lg lg:text-xl text-zinc-600 dark:text-zinc-300 mb-6">
                    Explora publicaciones, descubre nuevas categorías y conoce a nuestros autores. Este es tu espacio para compartir y aprender.
                </p>

                @guest
                    <p class="text-base bg-yellow-200 md:text-lg lg:text-xl text-zinc-600 dark:text-zinc-300 mb-6 p-3 rounded">
                        Inicia sesión o regístrate con nosotros
                    </p>
                @else
                    <p class="text-base bg-green-100 md:text-lg lg:text-xl text-zinc-700 dark:text-zinc-300 mb-6 p-3 rounded">
                        ¡Hola {{ auth()->user()->nombre }}! Navega por tu blog desde las pestañas en la parte superior de la web.
                    </p>
                @endguest

                <div class="flex justify-center">
                    <img src="{{ asset('/img/hello.jpg') }}" alt="Bienvenida al blog"
                        class="rounded-2xl shadow-lg w-full max-w-[500px] h-auto dark:shadow-zinc-700 transition-all duration-300">
                </div>
            </div>
        </div>

        </flux:main>

        @fluxScripts
    </body>
</html>
