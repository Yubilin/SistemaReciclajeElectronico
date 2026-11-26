<x-filament-widgets::widget class="w-full">
<div class="rounded-xl shadow-lg overflow-hidden w-full max-w-none"
     style="background: linear-gradient(135deg, #116D64 0%, #056C8E 100%);">
    <div class="p-5 md:p-6 flex flex-col gap-5" style="padding: 24px;">
        
        <!-- Columna izquierda -->
        <div class="flex-1">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-white/15 text-white border border-white/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Centro de Control RAEE
            </span>
            <h2 class="mt-3 text-2xl md:text-3xl font-extrabold text-white leading-tight">
                De la recepción a<br>la recuperación
            </h2>
            <p class="mt-2 text-sm md:text-base text-white/85 max-w-2xl leading-relaxed" style="color: rgba(255, 255, 255, 0.88);">
                Supervisa el recorrido de los materiales electrónicos y accede rápidamente a las tareas principales.
            </p>
            <p class="mt-2 text-xs font-semibold text-white/70" style="color: rgba(255, 255, 255, 0.75);">
                {{ now()->format('d/m/Y') }}
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 w-full">
            <a href="/admin/recepciones/create"
               class="flex min-h-20 items-center justify-between gap-2 px-3 py-3 rounded-lg bg-white/10 hover:bg-white/20 border border-white/25 transition-all text-white group">
                <div class="flex min-w-0 items-center gap-3">
                    <span class="w-9 h-9 shrink-0 rounded-lg bg-white/15 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </span>
                    <div>
                        <p class="text-sm font-bold leading-tight">Nueva recepción</p>
                        <p class="text-xs text-white/70 mt-1 leading-snug">Registrar el ingreso de equipos</p>
                    </div>
                </div>
                <svg class="w-4 h-4 shrink-0 opacity-70 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>

            <a href="/admin/material-recibidos/create"
               class="flex min-h-20 items-center justify-between gap-2 px-3 py-3 rounded-lg bg-white/10 hover:bg-white/20 border border-white/25 transition-all text-white group">
                <div class="flex min-w-0 items-center gap-3">
                    <span class="w-9 h-9 shrink-0 rounded-lg bg-white/15 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </span>
                    <div>
                        <p class="text-sm font-bold leading-tight">Registrar material</p>
                        <p class="text-xs text-white/70 mt-1 leading-snug">Clasificar lo recibido</p>
                    </div>
                </div>
                <svg class="w-4 h-4 shrink-0 opacity-70 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>

            <a href="/admin/inventarios"
               class="flex min-h-20 items-center justify-between gap-2 px-3 py-3 rounded-lg bg-white/10 hover:bg-white/20 border border-white/25 transition-all text-white group">
                <div class="flex min-w-0 items-center gap-3">
                    <span class="w-9 h-9 shrink-0 rounded-lg bg-white/15 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </span>
                    <div>
                        <p class="text-sm font-bold leading-tight">Revisar inventario</p>
                        <p class="text-xs text-white/70 mt-1 leading-snug">Consultar existencias y mínimos</p>
                    </div>
                </div>
                <svg class="w-4 h-4 shrink-0 opacity-70 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</div>
</x-filament-widgets::widget>