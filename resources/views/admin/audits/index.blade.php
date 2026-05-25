<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registro de Auditoría
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Modelo</th>
                            <th>ID</th>
                            <th>Acción</th>
                            <th>IP</th>
                            <th>Fecha</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($audits as $audit)
                            <tr>
                                <td>{{ $audit->user_name }}</td>
                                <td>{{ $audit->model_type }}</td>
                                <td>{{ $audit->model_id }}</td>
                                <td>
                                    <span class="badge bg-{{ $audit->action === 'create' ? 'success' : ($audit->action === 'update' ? 'warning' : 'danger') }}">
                                        {{ $audit->action }}
                                    </span>
                                </td>
                                <td>{{ $audit->ip_address }}</td>
                                <td>{{ $audit->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>
                                    <a href="{{ route('admin.audits.show', $audit) }}" class="btn btn-sm btn-info">Ver</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center">Sin registros</td></tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $audits->links() }}

            </div>
        </div>
    </div>
</x-app-layout>