<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin - Ver Post
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <h2>{{ $post->title }}</h2>
                <p class="text-muted">
                    Por <strong>{{ $post->author->name }}</strong> |
                    Categoría: <strong>{{ $post->category->name }}</strong> |
                    {{ $post->published_at ? $post->published_at->format('d/m/Y') : 'Borrador' }}
                </p>

                <div class="mb-3">
                    @foreach($post->tags as $tag)
                        <span class="badge bg-secondary">{{ $tag->name }}</span>
                    @endforeach
                </div>

                <p>{{ $post->content }}</p>

                <div class="mt-3">
                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('¿Eliminar?')" class="btn btn-danger">Eliminar</button>
                    </form>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Volver</a>
                </div>

                <hr class="my-4">

                <h4>Historial de Auditoría</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Acción</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($audits as $audit)
                            <tr>
                                <td>{{ $audit->user_name }}</td>
                                <td>{{ $audit->action }}</td>
                                <td>{{ $audit->created_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center">Sin registros</td></tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>