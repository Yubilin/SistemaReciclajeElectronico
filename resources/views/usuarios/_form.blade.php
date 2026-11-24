{{--
    Formulario compartido de usuarios.
    Variable: $usuario (null al crear, modelo al editar).
--}}
<form action="{{ $usuario ? route('usuarios.update', $usuario) : route('usuarios.store') }}"
      method="POST" class="card-body p-4">
    @csrf
    @if ($usuario)
        @method('PUT')
    @endif

    @if ($errors->any())
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <i class="bi bi-exclamation-octagon-fill me-2" aria-hidden="true"></i>
            <div>Revisa los campos marcados en rojo antes de continuar.</div>
        </div>
    @endif

    <div class="row g-3">
        <div class="col-md-6">
            <label for="nombre" class="form-label">Nombre</label>
            <input id="nombre" name="nombre" type="text" value="{{ old('nombre', $usuario?->nombre) }}"
                   class="form-control @error('nombre') is-invalid @enderror" required>
            @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6">
            <label for="apellido" class="form-label">Apellido</label>
            <input id="apellido" name="apellido" type="text" value="{{ old('apellido', $usuario?->apellido) }}"
                   class="form-control @error('apellido') is-invalid @enderror" required>
            @error('apellido') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6">
            <label for="correo" class="form-label">Correo electrónico</label>
            <input id="correo" name="correo" type="email" value="{{ old('correo', $usuario?->correo) }}"
                   class="form-control @error('correo') is-invalid @enderror" autocomplete="off" required>
            @error('correo') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6">
            <label for="contraseña" class="form-label">
                {{ $usuario ? 'Nueva contraseña (opcional)' : 'Contraseña' }}
            </label>
            <input id="contraseña" name="contraseña" type="password" minlength="8"
                   class="form-control @error('contraseña') is-invalid @enderror"
                   autocomplete="new-password" @unless ($usuario) required @endunless>
            @error('contraseña')
                <div class="invalid-feedback">{{ $message }}</div>
            @else
                <div class="form-text">
                    {{ $usuario ? 'Déjala en blanco para conservar la actual. Mínimo 8 caracteres.' : 'Mínimo 8 caracteres.' }}
                </div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="rol" class="form-label">Rol</label>
            @php($rolActual = old('rol', $usuario?->rol))
            <select id="rol" name="rol" class="form-select @error('rol') is-invalid @enderror" required>
                <option value="">Selecciona un rol</option>
                @foreach ($roles as $valor => $etiqueta)
                    <option value="{{ $valor }}" @selected((string) $rolActual === (string) $valor)>{{ $etiqueta }}</option>
                @endforeach
                @if ($rolActual && ! array_key_exists($rolActual, $roles))
                    <option value="{{ $rolActual }}" selected>{{ $rolActual }} (valor actual)</option>
                @endif
            </select>
            @error('rol') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6">
            <label for="estado" class="form-label">Estado</label>
            @php($estadoActual = old('estado', $usuario?->estado))
            <select id="estado" name="estado" class="form-select @error('estado') is-invalid @enderror" required>
                <option value="">Selecciona un estado</option>
                @foreach ($estados as $valor => $etiqueta)
                    <option value="{{ $valor }}" @selected((string) $estadoActual === (string) $valor)>{{ $etiqueta }}</option>
                @endforeach
                @if ($estadoActual && ! array_key_exists($estadoActual, $estados))
                    <option value="{{ $estadoActual }}" selected>{{ $estadoActual }} (valor actual)</option>
                @endif
            </select>
            @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg me-1" aria-hidden="true"></i>{{ $usuario ? 'Guardar cambios' : 'Guardar' }}
        </button>
    </div>
</form>
