<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-4">¡Bienvenido al Dashboard!</h1>
                    <p class="text-lg">Has iniciado sesión correctamente.</p>
                    
                    @if(auth()->user()->hasRole('admin'))
                        <p class="mt-3 text-green-600 font-semibold">✅ Tienes rol de <strong>Administrador</strong></p>
                    @elseif(auth()->user()->hasRole('editor'))
                        <p class="mt-3 text-blue-600 font-semibold">✅ Tienes rol de <strong>Editor</strong></p>
                    @else
                        <p class="mt-3 text-gray-500">Rol: Viewer</p>
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="text-red-600 hover:underline">
                            Cerrar Sesión
                        </a>
                    </div>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>