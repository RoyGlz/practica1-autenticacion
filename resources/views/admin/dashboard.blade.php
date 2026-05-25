<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Administrativo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-white shadow-sm rounded-lg p-6 text-center">
                    <h5 class="text-gray-500">Total Posts</h5>
                    <p class="text-4xl font-bold">{{ $total_posts }}</p>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-6 text-center">
                    <h5 class="text-gray-500">Total Usuarios</h5>
                    <p class="text-4xl font-bold">{{ $total_users }}</p>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-6 text-center">
                    <h5 class="text-gray-500">Total Comentarios</h5>
                    <p class="text-4xl font-bold">{{ $total_comments }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-3">Posts Recientes</h3>
                    <table class="table table-striped w-full">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Autor</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_posts as $post)
                                <tr>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->author->name }}</td>
                                    <td>{{ $post->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center">Sin posts</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-3">Auditoría Reciente</h3>
                    <table class="table table-striped w-full">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Acción</th>
                                <th>Modelo</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_audits as $audit)
                                <tr>
                                    <td>{{ $audit->user_name }}</td>
                                    <td>{{ $audit->action }}</td>
                                    <td>{{ $audit->model_type }}</td>
                                    <td>{{ $audit->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center">Sin registros</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <a href="{{ route('admin.audits.index') }}" class="btn btn-sm btn-secondary mt-2">Ver todo</a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>