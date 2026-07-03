@extends('layouts.app')

@php
  $registrosJson = $infraestructuras->map(function ($i) {
      return [
          'id' => $i->id,
          'nombre' => $i->denominacion,
          'dir' => $i->direccion,
          'tipo' => $i->tipo,
          'sector' => $i->sector,
          'aforo' => $i->aforo ?? 0,
          'modalidad' => str_contains($i->modalidad ?? '', 'Vecinal') ? 'vec' : 'dir',
      ];
  })->values();
@endphp

@section('title', 'REGINDE · Panel principal')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/reginde-panel.css') }}">
@endpush

@section('content')

  <header class="masthead">
    <div class="crest"><img src="{{ asset('images/reginde_logo.png') }}" alt="REGINDE"></div>
    <div>
      <h1>REGISTRO DE INVENTARIO DE LA SUBGERENCIA DE DEPORTE</h1>
      <p>Sub Gerencia de Deporte, Recreación y Juventud · Nuevo Chimbote</p>
    </div>
    <div class="spacer"></div>
    <a class="btn btn-new" href="{{ route('reginde.create') }}">＋ Nuevo registro</a>
  </header>

  <!-- Resumen -->
  @php
    $sectoresCubiertos = $infraestructuras->pluck('sector')->filter()->unique()->count();
    $administracionDirecta = $infraestructuras->filter(fn ($i) => str_contains($i->modalidad ?? '', 'Directa'))->count();
    $administracionVecinal = $infraestructuras->filter(fn ($i) => str_contains($i->modalidad ?? '', 'Vecinal'))->count();
  @endphp
  <div class="stats">
    <div class="stat"><div class="num">{{ $infraestructuras->count() }}</div><div class="lbl">Infraestructuras</div></div>
    <div class="stat"><div class="num">{{ $sectoresCubiertos }}</div><div class="lbl">Sectores cubiertos</div></div>
    <div class="stat"><div class="num">{{ $administracionDirecta }}</div><div class="lbl">Administración directa</div></div>
    <div class="stat accent"><div class="num">{{ $administracionVecinal }}</div><div class="lbl">Administración vecinal</div></div>
  </div>

  <!-- Buscador y filtros -->
  <div class="toolbar">
    <div class="search"><input id="q" placeholder="Buscar por nombre o dirección…"></div>
    <select id="fTipo">
      <option value="">Todos los tipos</option>
      <option>Estadio</option><option>Complejo Deportivo</option><option>Coliseo Deportivo</option>
      <option>Losa Multiuso</option><option>Piscina</option>
    </select>
    <select id="fSector">
      <option value="">Todos los sectores</option>
      <option>Sector 1</option><option>Sector 2</option><option>Sector 3</option>
      <option>Sector 4</option><option>Sector 5</option><option>Sector 6</option>
    </select>
    <select id="fModalidad">
      <option value="">Cualquier modalidad</option>
      <option value="dir">Administración directa</option>
      <option value="vec">Administración vecinal</option>
    </select>
  </div>

  <!-- Tabla de registros -->
  <div class="tablecard">
    <table>
      <thead>
        <tr>
          <th>Infraestructura</th>
          <th class="hide-sm">Tipo</th>
          <th>Sector</th>
          <th class="hide-sm">Aforo</th>
          <th>Modalidad</th>
          <th></th>
        </tr>
      </thead>
      <tbody id="rows"></tbody>
    </table>
  </div>

  <div class="table-footer">
    <div class="foot" id="count"></div>
    <nav class="pagination" id="pagination"></nav>
  </div>

  <form id="deleteForm" method="POST" style="display:none">
    @csrf
    @method('DELETE')
  </form>

@endsection

@push('scripts')
<script>
  // Registros reales, provistos por InfraestructuraController@index
  const registros = @json($registrosJson);

  const PER_PAGE = 10;
  const regindeBase = "{{ url('/reginde') }}";
  const modalidadLbl = {dir:["dir","Directa"], vec:["vec","Vecinal"]};
  const rowsEl = document.getElementById('rows');
  const countEl = document.getElementById('count');
  const paginationEl = document.getElementById('pagination');
  const q=document.getElementById('q'), fTipo=document.getElementById('fTipo'),
        fSector=document.getElementById('fSector'), fModalidad=document.getElementById('fModalidad');

  let currentPage = 1;

  function getPageList(current, total){
    const delta = 1;
    const range = [];
    for(let i=1;i<=total;i++){
      if(i===1 || i===total || (i>=current-delta && i<=current+delta)) range.push(i);
    }
    const withDots = [];
    let prev = 0;
    range.forEach(p=>{
      if(prev && p-prev>1) withDots.push('...');
      withDots.push(p);
      prev = p;
    });
    return withDots;
  }

  function renderPagination(totalPages){
    let html = `<button data-page="${currentPage-1}" ${currentPage===1?'disabled':''} aria-label="Anterior">‹</button>`;
    getPageList(currentPage, totalPages).forEach(p=>{
      html += p==='...'
        ? `<span class="ellipsis">…</span>`
        : `<button data-page="${p}" class="${p===currentPage?'active':''}">${p}</button>`;
    });
    html += `<button data-page="${currentPage+1}" ${currentPage===totalPages?'disabled':''} aria-label="Siguiente">›</button>`;
    paginationEl.innerHTML = html;
    paginationEl.querySelectorAll('button[data-page]').forEach(btn=>{
      btn.addEventListener('click', ()=>{
        currentPage = parseInt(btn.dataset.page, 10);
        render();
      });
    });
  }

  function render(){
    const term=q.value.trim().toLowerCase();
    const list=registros.filter(r=>
      (!term || (r.nombre+r.dir).toLowerCase().includes(term)) &&
      (!fTipo.value   || r.tipo===fTipo.value) &&
      (!fSector.value || r.sector===fSector.value) &&
      (!fModalidad.value || r.modalidad===fModalidad.value)
    );

    const totalPages = Math.max(1, Math.ceil(list.length / PER_PAGE));
    if (currentPage > totalPages) currentPage = totalPages;
    const start = (currentPage - 1) * PER_PAGE;
    const pageItems = list.slice(start, start + PER_PAGE);

    rowsEl.innerHTML = pageItems.map(r=>{
      const [cls,txt]=modalidadLbl[r.modalidad];
      return `<tr>
        <td><div class="name">${r.nombre}<small>${r.dir}</small></div></td>
        <td class="hide-sm">${r.tipo}</td>
        <td><span class="tag sector">${r.sector}</span></td>
        <td class="hide-sm">${r.aforo.toLocaleString('es-PE')}</td>
        <td><span class="st ${cls}"><span class="dot"></span>${txt}</span></td>
        <td>
          <div class="actions-cell">
            <a class="btn-view" href="${regindeBase}/${r.id}/ver" title="Ver">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"/><circle cx="12" cy="12" r="3"/></svg>
              Ver
            </a>
            <a class="btn-edit" href="${regindeBase}/${r.id}/editar" title="Editar">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
              Editar
            </a>
            <button type="button" class="btn-delete" data-id="${r.id}" data-nombre="${r.nombre}" title="Eliminar">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
              Eliminar
            </button>
          </div>
        </td>
      </tr>`;
    }).join('') || `<tr><td colspan="6" style="text-align:center;padding:26px;color:var(--muted)">
        No se encontraron infraestructuras con esos criterios.</td></tr>`;

    countEl.textContent = list.length
      ? `Mostrando ${start+1}–${start+pageItems.length} de ${list.length} infraestructuras registradas`
      : `Mostrando 0 de ${registros.length} infraestructuras registradas`;

    renderPagination(totalPages);
  }

  [q,fTipo,fSector,fModalidad].forEach(el=>el.addEventListener('input', ()=>{ currentPage = 1; render(); }));
  render();

  rowsEl.addEventListener('click', async (e)=>{
    const btn = e.target.closest('.btn-delete');
    if (!btn) return;
    const ok = await regindeConfirm({
      title: '¿Eliminar este registro?',
      text: `Esta acción eliminará "${btn.dataset.nombre}" de forma permanente.`,
      confirmText: 'Eliminar',
      danger: true,
    });
    if (!ok) return;
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `${regindeBase}/${btn.dataset.id}`;
    deleteForm.submit();
  });

  @if(session('status'))
    regindeToast(@json(session('status')));
  @endif
</script>
@endpush
