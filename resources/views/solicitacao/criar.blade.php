@extends('layouts.app')

@section('content')
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Formulário de Nova Solicitação -->
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Nova Solicitação</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('solicitacoes.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título:</label>
                                <input id="titulo" name="titulo" class="form-control" type="text" placeholder="Digite o título" required>
                            </div>
                            <div class="mb-3">
                                <label for="mensagem" class="form-label">Mensagem:</label>
                                <textarea id="mensagem" name="mensagem" class="form-control" placeholder="Digite a mensagem" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="tipo_id" class="form-label">Tipo:</label>
                                <select id="tipo_id" name="tipo_id" class="form-control" required>
                                    <option value="">Selecione um tipo</option>
                                    @foreach($tipos as $tipo)
                                        <option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Lista de Solicitações do Usuário -->
            <div class="col-md-6">
                <div class="card shadow mb-6">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Minhas Solicitações</h6>
                    </div>
                    <div class="card-body">
                        <div class="tile">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Título</th>
                                            <th>Mensagem</th>
                                            <th>Tipo</th>
                                            <th>Resposta</th>
                                            <th>Excluir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($solicitacoes as $item)
                                            <tr>
                                                <td>{{ $item->titulo }}</td>
                                                <td>{{ $item->mensagem }}</td>
                                                <td>{{ $item->tipo->nome }}</td>
                                                <td>
                                                    @if ($item->resposta)
                                                        <button class="btn btn-success" data-toggle="modal" data-target="#respostaModal" data-resposta="{{ $item->resposta }}">Respondido</button>
                                                    @else
                                                        <button class="btn btn-warning" disabled>Solicitado</button>
                                                    @endif
                                                </td>
                                                <td>
                                                    <form action="{{ route('solicitacoes.destroy', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="respostaModal" tabindex="-1" role="dialog" aria-labelledby="respostaModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="respostaModalLabel">Resposta</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3 col-md-12">
                                                                <label class="form-label">Resposta</label>
                                                                <textarea name="resposta" id="resposta{{ $item->resposta }}"
                                                                    class="form-control valor" type="text"
                                                                    placeholder="" >{{ $item->resposta }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Script para manipular o modal -->
    <script>
        $('#respostaModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Botão que acionou o modal
            var resposta = button.data('resposta') // Extrai a informação da resposta

            var modal = $(this)
            modal.find('.modal-body').text(resposta)
        })
    </script>
</body>
@endsection
