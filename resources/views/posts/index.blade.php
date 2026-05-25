<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Posts
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Nuevo Post</a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Categoría</th>
                            <th>Autor</th>
                            <th>Publicado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                            <tr>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->category->name }}</td>
                                <td>{{ $post->author->name }}</td>
                                <td>{{ $post->published_at ? $post->published_at->format('d/m/Y') : 'Borrador' }}</td>
                                <td>
                                    <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-info">Ver</a>
                                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-warning">Editar</a>
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('¿Eliminar?')" class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No hay posts aún.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $posts->links() }}

            </div>
        </div>
    </div>
</x-app-layout>