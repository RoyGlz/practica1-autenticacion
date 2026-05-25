<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

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
                    @can('update', $post)
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning">Editar</a>
                    @endcan

                    @can('delete', $post)
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('¿Eliminar este post?')" class="btn btn-danger">Eliminar</button>
                        </form>
                    @endcan

                    <a href="{{ route('posts.index') }}" class="btn btn-secondary">Volver</a>
                </div>

                <hr class="my-4">

                <h4>Archivos adjuntos</h4>
                @forelse($post->attachments as $file)
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div>
                            <a href="{{ asset('storage/' . $file->path) }}" target="_blank">
                                {{ $file->original_name }}
                            </a>
                            <small class="text-muted">({{ number_format($file->size / 1024, 2) }} KB)</small>
                        </div>
                        @can('delete', $post)
                            <form action="{{ route('attachments.destroy', $file) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('¿Eliminar archivo?')" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        @endcan
                    </div>
                @empty
                    <p class="text-muted">Sin archivos adjuntos.</p>
                @endforelse

                <hr class="my-4">

                <h3>Comentarios ({{ $post->comments->count() }})</h3>
                @forelse($post->comments as $comment)
                    <div class="card mb-2">
                        <div class="card-body">
                            <strong>{{ $comment->author->name }}</strong>
                            <small class="text-muted">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                            <p class="mb-0 mt-1">{{ $comment->content }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Sin comentarios aún.</p>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>