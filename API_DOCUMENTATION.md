# API Sistema de Reciclaje Electrónico

## Base URL
http://localhost:8000/api

## Endpoints

### 1. USUARIOS
- GET /api/usuarios - Listar usuarios
- POST /api/usuarios - Crear usuario
- GET /api/usuarios/{id} - Ver usuario
- PUT /api/usuarios/{id} - Actualizar usuario
- DELETE /api/usuarios/{id} - Eliminar usuario

**Campos:** nombre, apellido, correo, contraseña, rol, estado

### 2. CATEGORÍAS
- GET /api/categorias
- POST /api/categorias
- GET /api/categorias/{id}
- PUT /api/categorias/{id}
- DELETE /api/categorias/{id}

**Campos:** nombre, descripcion

### 3. ENTREGANTES
- GET /api/entregantes
- POST /api/entregantes
- GET /api/entregantes/{id}
- PUT /api/entregantes/{id}
- DELETE /api/entregantes/{id}

**Campos:** nombre, apellido, ci, telefono, direccion

### 4. RECEPCIONES
- GET /api/recepciones
- POST /api/recepciones
- GET /api/recepciones/{id}
- PUT /api/recepciones/{id}
- DELETE /api/recepciones/{id}

**Campos:** fecha, observaciones, estado, usuario_id, entregante_id

### 5. MATERIALES RECIBIDOS
- GET /api/materiales-recibidos
- POST /api/materiales-recibidos
- GET /api/materiales-recibidos/{id}
- PUT /api/materiales-recibidos/{id}
- DELETE /api/materiales-recibidos/{id}

**Campos:** nombre, tipo, marca, modelo, descripcion, cantidad, categoria_id, recepcion_id

### 6. RECUPERACIONES
- GET /api/recuperaciones
- POST /api/recuperaciones
- GET /api/recuperaciones/{id}
- PUT /api/recuperaciones/{id}
- DELETE /api/recuperaciones/{id}

**Campos:** fecha, observaciones, resultado, material_recibido_id

### 7. COMPONENTES
- GET /api/componentes
- POST /api/componentes
- GET /api/componentes/{id}
- PUT /api/componentes/{id}
- DELETE /api/componentes/{id}

**Campos:** nombre, descripcion, cantidad, estado, recuperacion_id

### 8. INVENTARIOS
- GET /api/inventarios
- POST /api/inventarios
- GET /api/inventarios/{id}
- PUT /api/inventarios/{id}
- DELETE /api/inventarios/{id}

**Campos:** cantidadDisponible, cantidadMinima, componente_id

### 9. ASIGNACIONES
- GET /api/asignaciones
- POST /api/asignaciones
- GET /api/asignaciones/{id}
- PUT /api/asignaciones/{id}
- DELETE /api/asignaciones/{id}

**Campos:** numeroTurno, fechaInicio, fechaFinalizacion, prioridad, estado, observacion, usuario_id, material_recibido_id

## Ejemplos de uso

### Crear categoría
POST http://localhost:8000/api/categorias
Body JSON:
{
  "nombre": "Computadoras",
  "descripcion": "Equipos de cómputo"
}

### Listar usuarios
GET http://localhost:8000/api/usuarios

### Respuesta JSON
{
  "current_page": 1,
  "data": [...],
  "total": 10,
  "per_page": 10
}
