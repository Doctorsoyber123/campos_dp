@extends('layouts.app')

@php
  $mode = $mode ?? 'new';
  $data = $data ?? [];
  $id = $id ?? null;
  $tituloModo = ['new' => 'Nuevo registro', 'ver' => 'Ver registro', 'editar' => 'Editar registro'][$mode];
@endphp

@section('title', 'REGINDE · '.$tituloModo)

@section('content')

  <header class="masthead">
    <div class="crest"><img src="{{ asset('images/reginde_logo.png') }}" alt="REGINDE"></div>
    <div>
      <h1>REGISTRO DE INVENTARIO DE LA SUBGERENCIA DE DEPORTE</h1>
      <p>Sub Gerencia de Deporte, Recreación y Juventud · Nuevo Chimbote — {{ $tituloModo }}</p>
    </div>
  </header>

  <form id="reginde" action="{{ $mode === 'editar' ? route('reginde.update', $id) : route('reginde.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($mode === 'editar')
      @method('PUT')
    @endif

    <!-- 1. DATOS GENERALES -->
    <section class="card">
      <h2><span class="n">1</span> Datos generales</h2>
      <div class="body grid">
        <div class="field full">
          <label>Denominación <span class="hint">— nombre de la infraestructura</span></label>
          <input name="denominacion" value="{{ $data['denominacion'] ?? '' }}" @disabled($mode === 'ver')>
        </div>
        <div class="field">
          <label class="toggle-field"><input type="hidden" name="es_polideportivo" value="No"><input type="checkbox" name="es_polideportivo" value="Sí" class="toggle-input" data-reveal="nombre_polideportivo_reveal" @checked(($data['es_polideportivo'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Forma parte de un polideportivo?</span></label>
        </div>
        <div class="field" id="nombre_polideportivo_reveal" @if(($data['es_polideportivo'] ?? 'No') !== 'Sí') style="display:none" @endif>
          <label>Nombre del polideportivo</label>
          <input name="nombre_polideportivo" value="{{ $data['nombre_polideportivo'] ?? '' }}" @disabled($mode === 'ver')>
        </div>
        <div class="field">
          <label>Tipo de infraestructura</label>
          <select name="tipo" @disabled($mode === 'ver')>
            <option @selected(($data['tipo'] ?? '') === 'Estadio')>Estadio</option><option @selected(($data['tipo'] ?? '') === 'Complejo Deportivo')>Complejo Deportivo</option>
            <option @selected(($data['tipo'] ?? '') === 'Coliseo Deportivo')>Coliseo Deportivo</option><option @selected(($data['tipo'] ?? '') === 'Losa Multiuso')>Losa Multiuso</option>
            <option @selected(($data['tipo'] ?? '') === 'Losa Unideporte')>Losa Unideporte</option><option @selected(($data['tipo'] ?? '') === 'Piscina')>Piscina</option>
            <option @selected(($data['tipo'] ?? '') === 'Salón deportivo')>Salón deportivo</option><option @selected(($data['tipo'] ?? '') === 'Espacio físico con potencial deportivo')>Espacio físico con potencial deportivo</option>
          </select>
        </div>
        <div class="field">
          <label>Sector</label>
          <select name="sector" @disabled($mode === 'ver')>
            <option @selected(($data['sector'] ?? '') === 'Sector 1')>Sector 1</option><option @selected(($data['sector'] ?? '') === 'Sector 2')>Sector 2</option><option @selected(($data['sector'] ?? '') === 'Sector 3')>Sector 3</option>
            <option @selected(($data['sector'] ?? '') === 'Sector 4')>Sector 4</option><option @selected(($data['sector'] ?? '') === 'Sector 5')>Sector 5</option><option @selected(($data['sector'] ?? '') === 'Sector 6')>Sector 6</option>
          </select>
        </div>
        <div class="field">
          <label>Dirección</label>
          <input name="direccion" value="{{ $data['direccion'] ?? '' }}" @disabled($mode === 'ver')>
        </div>
        <div class="field">
          <label>Referencia de dirección</label>
          <input name="referencia" value="{{ $data['referencia'] ?? '' }}" @disabled($mode === 'ver')>
        </div>
        <div class="field full">
          <label>Google Maps <span class="hint">— link de georeferencia</span></label>
          <input name="googlemap" value="{{ $data['googlemap'] ?? '' }}" @disabled($mode === 'ver') type="url">
        </div>
        <div class="field">
          <label>Año de inauguración</label>
          <input name="anio_inauguracion" value="{{ $data['anio_inauguracion'] ?? '' }}" @disabled($mode === 'ver') type="number">
        </div>
        <div class="field">
          <label>Año de último mantenimiento / remodelación</label>
          <input name="anio_mantenimiento" value="{{ $data['anio_mantenimiento'] ?? '' }}" @disabled($mode === 'ver') type="number">
        </div>
      </div>
    </section>

    <!-- 2. ADMINISTRACIÓN -->
    <section class="card">
      <h2><span class="n">2</span> Datos administrativos</h2>
      <div class="body grid">
        <div class="field">
          <label>Modalidad de administración</label>
          <select name="modalidad" @disabled($mode === 'ver')>
            <option @selected(($data['modalidad'] ?? '') === 'Administración Directa de la IPD')>Administración Directa de la IPD</option>
            <option @selected(($data['modalidad'] ?? '') === 'Administración Vecinal de la IPD')>Administración Vecinal de la IPD</option>
          </select>
        </div>
        <div class="field">
          <label class="toggle-field"><input type="hidden" name="tiene_comite" value="No"><input type="checkbox" name="tiene_comite" value="Sí" class="toggle-input" @checked(($data['tiene_comite'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Cuenta con comité deportivo vecinal?</span></label>
        </div>
        <div class="field">
          <label>N° resolución del comité vecinal</label>
          <input name="res_comite" value="{{ $data['res_comite'] ?? '' }}" @disabled($mode === 'ver')>
        </div>
        <div class="field">
          <label>Vigencia del comité</label>
          <input name="vigencia_comite" value="{{ $data['vigencia_comite'] ?? '' }}" @disabled($mode === 'ver')>
        </div>

        <div class="subhead">Presidente del comité</div>
        <div class="field">
          <label>Apellidos y nombres</label>
          <input name="pres_nombre" value="{{ $data['pres_nombre'] ?? '' }}" @disabled($mode === 'ver')>
        </div>
        <div class="field">
          <label>DNI</label>
          <input name="pres_dni" value="{{ $data['pres_dni'] ?? '' }}" @disabled($mode === 'ver') maxlength="8">
        </div>
        <div class="field">
          <label>Celular</label>
          <input name="pres_cel" value="{{ $data['pres_cel'] ?? '' }}" @disabled($mode === 'ver')>
        </div>
        <div class="field">
          <label>Dirección</label>
          <input name="pres_dir" value="{{ $data['pres_dir'] ?? '' }}" @disabled($mode === 'ver')>
        </div>

        <div class="subhead">Secretario</div>
        <div class="field"><label>Apellidos y nombres</label><input name="secretario_nombre" value="{{ $data['secretario_nombre'] ?? '' }}" @disabled($mode === 'ver')></div>
        <div class="field"><label>DNI</label><input name="secretario_dni" value="{{ $data['secretario_dni'] ?? '' }}" @disabled($mode === 'ver') maxlength="8"></div>
        <div class="field"><label>Celular</label><input name="secretario_cel" value="{{ $data['secretario_cel'] ?? '' }}" @disabled($mode === 'ver')></div>

        <div class="subhead">Fiscalizador</div>
        <div class="field"><label>Apellidos y nombres</label><input name="fiscalizador_nombre" value="{{ $data['fiscalizador_nombre'] ?? '' }}" @disabled($mode === 'ver')></div>
        <div class="field"><label>DNI</label><input name="fiscalizador_dni" value="{{ $data['fiscalizador_dni'] ?? '' }}" @disabled($mode === 'ver') maxlength="8"></div>
        <div class="field"><label>Celular</label><input name="fiscalizador_cel" value="{{ $data['fiscalizador_cel'] ?? '' }}" @disabled($mode === 'ver')></div>

        <div class="field">
          <label class="toggle-field"><input type="hidden" name="entrega_ordenanza" value="No"><input type="checkbox" name="entrega_ordenanza" value="Sí" class="toggle-input" @checked(($data['entrega_ordenanza'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Entregó copia de ordenanza / reglamentación?</span></label>
        </div>

        <div class="subhead">Gestión y uso del espacio</div>
        <div class="field">
          <label class="toggle-field"><input type="hidden" name="copia_llaves_sgdrj" value="No"><input type="checkbox" name="copia_llaves_sgdrj" value="Sí" class="toggle-input" @checked(($data['copia_llaves_sgdrj'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">Existe una copia de las llaves en la SGDRJ</span></label>
        </div>
        <div class="field">
          <label class="toggle-field"><input type="hidden" name="usa_formulario_unico" value="No"><input type="checkbox" name="usa_formulario_unico" value="Sí" class="toggle-input" @checked(($data['usa_formulario_unico'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">Usa Formulario Único de Autorización</span></label>
        </div>
        <div class="field">
          <label class="toggle-field"><input type="hidden" name="tiene_pta" value="No"><input type="checkbox" name="tiene_pta" value="Sí" class="toggle-input" @checked(($data['tiene_pta'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">Tiene Plan de Trabajo Anual (PTA)</span></label>
        </div>
        <div class="field">
          <label>Último informe económico de ingresos</label>
          <input name="ultimo_informe_economico" value="{{ $data['ultimo_informe_economico'] ?? '' }}" @disabled($mode === 'ver') type="date">
        </div>
        <div class="field">
          <label>Costo de alquiler día (S/)</label>
          <input name="costo_alquiler_dia" value="{{ $data['costo_alquiler_dia'] ?? '' }}" @disabled($mode === 'ver') type="number" step="0.01">
        </div>
        <div class="field">
          <label>Costo de alquiler noche (S/)</label>
          <input name="costo_alquiler_noche" value="{{ $data['costo_alquiler_noche'] ?? '' }}" @disabled($mode === 'ver') type="number" step="0.01">
        </div>
      </div>
    </section>

    <!-- 3. USO DE ESPACIO -->
    <section class="card">
      <h2><span class="n">3</span> Uso de espacio</h2>
      <div class="body grid">
        <div class="field"><label class="toggle-field"><input type="hidden" name="letrero" value="No"><input type="checkbox" name="letrero" value="Sí" class="toggle-input" data-reveal="letrero_cond_reveal" @checked(($data['letrero'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Cuenta con letrero de denominación?</span></label></div>
        <div class="field" id="letrero_cond_reveal" @if(($data['letrero'] ?? 'No') !== 'Sí') style="display:none" @endif><label>Condiciones del letrero</label><input name="letrero_cond" value="{{ $data['letrero_cond'] ?? '' }}" @disabled($mode === 'ver')></div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="letrero_horarios" value="No"><input type="checkbox" name="letrero_horarios" value="Sí" class="toggle-input" @checked(($data['letrero_horarios'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Cuenta con letrero de horarios de uso?</span></label></div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="letrero_reglas" value="No"><input type="checkbox" name="letrero_reglas" value="Sí" class="toggle-input" @checked(($data['letrero_reglas'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Cuenta con letrero de reglas de uso?</span></label></div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="almacen" value="No"><input type="checkbox" name="almacen" value="Sí" class="toggle-input" @checked(($data['almacen'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Cuenta con almacén?</span></label></div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="perimetro" value="No"><input type="checkbox" name="perimetro" value="Sí" class="toggle-input" data-reveal="perimetro_mat_reveal" @checked(($data['perimetro'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Cuenta con perímetro?</span></label></div>
        <div class="field" id="perimetro_mat_reveal" @if(($data['perimetro'] ?? 'No') !== 'Sí') style="display:none" @endif><label>Material del perímetro</label><select name="perimetro_mat" @disabled($mode === 'ver')><option @selected(($data['perimetro_mat'] ?? '') === 'Pared')>Pared</option><option @selected(($data['perimetro_mat'] ?? '') === 'Tubo metálico')>Tubo metálico</option><option @selected(($data['perimetro_mat'] ?? '') === 'Reja')>Reja</option></select></div>

        <div class="subhead">Servicios higiénicos</div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="sshh_damas" value="No"><input type="checkbox" name="sshh_damas" value="Sí" class="toggle-input" @checked(($data['sshh_damas'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">SS.HH. Damas</span></label></div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="sshh_varones" value="No"><input type="checkbox" name="sshh_varones" value="Sí" class="toggle-input" @checked(($data['sshh_varones'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">SS.HH. Varones</span></label></div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="duchas" value="No"><input type="checkbox" name="duchas" value="Sí" class="toggle-input" @checked(($data['duchas'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Cuenta con duchas?</span></label></div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="gimnasio" value="No"><input type="checkbox" name="gimnasio" value="Sí" class="toggle-input" @checked(($data['gimnasio'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Cuenta con gimnasio?</span></label></div>

        <div class="subhead">Techado — espacio de competencia</div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="techo_comp" value="No"><input type="checkbox" name="techo_comp" value="Sí" class="toggle-input" @checked(($data['techo_comp'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Techado del espacio de competencia?</span></label></div>
        <div class="field"><label>Material del techo</label><select name="techo_comp_mat" @disabled($mode === 'ver')><option @selected(($data['techo_comp_mat'] ?? '') === 'Policarbonato')>Policarbonato</option><option @selected(($data['techo_comp_mat'] ?? '') === 'Metal')>Metal</option></select></div>
        <div class="field"><label>Estado del techo</label><select name="techo_comp_estado" @disabled($mode === 'ver')><option @selected(($data['techo_comp_estado'] ?? '') === 'Muy bueno')>Muy bueno</option><option @selected(($data['techo_comp_estado'] ?? '') === 'Bueno')>Bueno</option><option @selected(($data['techo_comp_estado'] ?? '') === 'Regular')>Regular</option><option @selected(($data['techo_comp_estado'] ?? '') === 'Malo')>Malo</option><option @selected(($data['techo_comp_estado'] ?? '') === 'Muy malo')>Muy malo</option></select></div>
        <div class="field full"><label>Observaciones</label><textarea name="techo_comp_obs" @disabled($mode === 'ver')>{{ $data['techo_comp_obs'] ?? '' }}</textarea></div>

        <div class="subhead">Techado — tribuna</div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="techo_trib" value="No"><input type="checkbox" name="techo_trib" value="Sí" class="toggle-input" @checked(($data['techo_trib'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Techado de tribuna?</span></label></div>
        <div class="field"><label>Material del techo</label><select name="techo_trib_mat" @disabled($mode === 'ver')><option @selected(($data['techo_trib_mat'] ?? '') === 'Policarbonato')>Policarbonato</option><option @selected(($data['techo_trib_mat'] ?? '') === 'Metal')>Metal</option></select></div>
        <div class="field"><label>Estado del techo</label><select name="techo_trib_estado" @disabled($mode === 'ver')><option @selected(($data['techo_trib_estado'] ?? '') === 'Muy bueno')>Muy bueno</option><option @selected(($data['techo_trib_estado'] ?? '') === 'Bueno')>Bueno</option><option @selected(($data['techo_trib_estado'] ?? '') === 'Regular')>Regular</option><option @selected(($data['techo_trib_estado'] ?? '') === 'Malo')>Malo</option><option @selected(($data['techo_trib_estado'] ?? '') === 'Muy malo')>Muy malo</option></select></div>
        <div class="field full"><label>Observaciones</label><textarea name="techo_trib_obs" @disabled($mode === 'ver')>{{ $data['techo_trib_obs'] ?? '' }}</textarea></div>

        <div class="subhead">Escenario y otros</div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="escenario" value="No"><input type="checkbox" name="escenario" value="Sí" class="toggle-input" @checked(($data['escenario'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Cuenta con escenario?</span></label></div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="escenario_escaleras" value="No"><input type="checkbox" name="escenario_escaleras" value="Sí" class="toggle-input" @checked(($data['escenario_escaleras'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">Escaleras de acceso al escenario</span></label></div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="escenario_techo" value="No"><input type="checkbox" name="escenario_techo" value="Sí" class="toggle-input" @checked(($data['escenario_techo'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Escenario tiene techo?</span></label></div>
        <div class="field">
          <label class="toggle-field"><input type="hidden" name="parque" value="No"><input type="checkbox" name="parque" value="Sí" class="toggle-input" data-reveal="parque_reveal" @checked(($data['parque'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Parque colindante?</span></label>
        </div>
        <div class="field" id="parque_reveal" @if(($data['parque'] ?? 'No') !== 'Sí') style="display:none" @endif>
          <label>Nombre del parque</label>
          <input name="parque_nombre" value="{{ $data['parque_nombre'] ?? '' }}" @disabled($mode === 'ver')>
        </div>

        <div class="field">
          <label class="toggle-field"><input type="hidden" name="kioskos" value="No"><input type="checkbox" name="kioskos" value="Sí" class="toggle-input" data-reveal="kioskos_reveal" @checked(($data['kioskos'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Cuenta con kioskos?</span></label>
        </div>
        <div class="field" id="kioskos_reveal" @if(($data['kioskos'] ?? 'No') !== 'Sí') style="display:none" @endif>
          <label>Kioskos disponibles (#)</label>
          <input name="kioskos_cantidad" value="{{ $data['kioskos_cantidad'] ?? '' }}" @disabled($mode === 'ver') type="number">
        </div>

        <div class="field">
          <label class="toggle-field"><input type="hidden" name="parqueo" value="No"><input type="checkbox" name="parqueo" value="Sí" class="toggle-input" data-reveal="parqueo_reveal" @checked(($data['parqueo'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Cuenta con parqueo?</span></label>
        </div>
        <div class="field" id="parqueo_reveal" @if(($data['parqueo'] ?? 'No') !== 'Sí') style="display:none" @endif>
          <label>Capacidad de parqueo (# vehículos)</label>
          <input name="parqueo_cantidad" value="{{ $data['parqueo_cantidad'] ?? '' }}" @disabled($mode === 'ver') type="number">
        </div>

        <div class="field">
          <label class="toggle-field"><input type="hidden" name="ambientes_multiuso" value="No"><input type="checkbox" name="ambientes_multiuso" value="Sí" class="toggle-input" data-reveal="ambientes_multiuso_reveal" @checked(($data['ambientes_multiuso'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Cuenta con ambientes multiusos y salones?</span></label>
        </div>
        <div class="field" id="ambientes_multiuso_reveal" @if(($data['ambientes_multiuso'] ?? 'No') !== 'Sí') style="display:none" @endif>
          <label>Cantidad de ambientes multiusos</label>
          <input name="ambientes_multiuso_cantidad" value="{{ $data['ambientes_multiuso_cantidad'] ?? '' }}" @disabled($mode === 'ver') type="number">
        </div>
      </div>
    </section>

    <!-- 4. FICHA TÉCNICA -->
    <section class="card">
      <h2><span class="n">4</span> Ficha técnica deportiva</h2>
      <div class="body grid">
        <div class="subhead">Medidas del campo (m)</div>
        <div class="field"><label>Ancho — específico de juego</label><input name="med_ancho_juego" value="{{ $data['med_ancho_juego'] ?? '' }}" @disabled($mode === 'ver')></div>
        <div class="field"><label>Largo — específico de juego</label><input name="med_largo_juego" value="{{ $data['med_largo_juego'] ?? '' }}" @disabled($mode === 'ver')></div>
        <div class="field"><label>Ancho — general</label><input name="med_ancho_gen" value="{{ $data['med_ancho_gen'] ?? '' }}" @disabled($mode === 'ver')></div>
        <div class="field"><label>Largo — general</label><input name="med_largo_gen" value="{{ $data['med_largo_gen'] ?? '' }}" @disabled($mode === 'ver')></div>

        <div class="subhead">Arcos</div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="arcos" value="No"><input type="checkbox" name="arcos" value="Sí" class="toggle-input" @checked(($data['arcos'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Cuenta con arcos?</span></label></div>
        <div class="field"><label>Material de los arcos</label><input name="arcos_mat" value="{{ $data['arcos_mat'] ?? '' }}" @disabled($mode === 'ver')></div>
        <div class="field"><label>Ancho del arco (m)</label><input name="arcos_ancho" value="{{ $data['arcos_ancho'] ?? '' }}" @disabled($mode === 'ver')></div>
        <div class="field"><label>Alto del arco (m)</label><input name="arcos_alto" value="{{ $data['arcos_alto'] ?? '' }}" @disabled($mode === 'ver')></div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="arcos_mallas" value="No"><input type="checkbox" name="arcos_mallas" value="Sí" class="toggle-input" @checked(($data['arcos_mallas'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Arcos con mallas?</span></label></div>

        <div class="field">
          <label class="toggle-field"><input type="hidden" name="arcos_moviles" value="No"><input type="checkbox" name="arcos_moviles" value="Sí" class="toggle-input" data-reveal="arcos_moviles_reveal" @checked(($data['arcos_moviles'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Cuenta con arcos móviles?</span></label>
        </div>
        <div class="field" id="arcos_moviles_reveal" @if(($data['arcos_moviles'] ?? 'No') !== 'Sí') style="display:none" @endif>
          <label>Cantidad de arcos móviles (#)</label>
          <input name="arcos_moviles_cantidad" value="{{ $data['arcos_moviles_cantidad'] ?? '' }}" @disabled($mode === 'ver') type="number">
        </div>

        <div class="subhead">Palcos</div>
        <div class="field">
          <label class="toggle-field"><input type="hidden" name="palcos" value="No"><input type="checkbox" name="palcos" value="Sí" class="toggle-input" data-reveal="palcos_reveal" @checked(($data['palcos'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Cuenta con palcos?</span></label>
        </div>
        <div class="field" id="palcos_reveal" @if(($data['palcos'] ?? 'No') !== 'Sí') style="display:none" @endif>
          <label>Número de asientos en palco</label>
          <input name="palcos_asientos" value="{{ $data['palcos_asientos'] ?? '' }}" @disabled($mode === 'ver') type="number">
        </div>

        <div class="subhead">Tribunas y aforo</div>
        <div class="field"><label>Número de tribunas (#)</label><input name="num_tribunas" value="{{ $data['num_tribunas'] ?? '' }}" @disabled($mode === 'ver') type="number"></div>
        <div class="field"><label>Capacidad de aforo</label><input name="aforo" value="{{ $data['aforo'] ?? '' }}" @disabled($mode === 'ver') type="number"></div>
        <div class="field full"><label>Observaciones de tribunas</label><textarea name="tribunas_obs" @disabled($mode === 'ver')>{{ $data['tribunas_obs'] ?? '' }}</textarea></div>

        <div class="subhead">Vestuarios</div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="vest_damas" value="No"><input type="checkbox" name="vest_damas" value="Sí" class="toggle-input" @checked(($data['vest_damas'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">Vestuarios damas</span></label></div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="vest_caballeros" value="No"><input type="checkbox" name="vest_caballeros" value="Sí" class="toggle-input" @checked(($data['vest_caballeros'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">Vestuarios varones</span></label></div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="vest_banos" value="No"><input type="checkbox" name="vest_banos" value="Sí" class="toggle-input" @checked(($data['vest_banos'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">Vestuarios con baños</span></label></div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="vest_duchas" value="No"><input type="checkbox" name="vest_duchas" value="Sí" class="toggle-input" @checked(($data['vest_duchas'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">Vestuarios con duchas</span></label></div>

        <div class="subhead">Espacio de competencia</div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="malla_perim" value="No"><input type="checkbox" name="malla_perim" value="Sí" class="toggle-input" @checked(($data['malla_perim'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Malla perimétrica del espacio de competencia?</span></label></div>
        <div class="field"><label>Material del espacio de competencia</label>
          <select name="mat_competencia" @disabled($mode === 'ver')>
            <option @selected(($data['mat_competencia'] ?? '') === 'Cemento')>Cemento</option><option @selected(($data['mat_competencia'] ?? '') === 'Polipropileno')>Polipropileno</option>
            <option @selected(($data['mat_competencia'] ?? '') === 'Césped nivel básico')>Césped nivel básico</option><option @selected(($data['mat_competencia'] ?? '') === 'Césped premium')>Césped premium</option>
            <option @selected(($data['mat_competencia'] ?? '') === 'Césped natural')>Césped natural</option><option @selected(($data['mat_competencia'] ?? '') === 'Arena')>Arena</option>
          </select>
        </div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="medidas_oficiales" value="No"><input type="checkbox" name="medidas_oficiales" value="Sí" class="toggle-input" @checked(($data['medidas_oficiales'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Tiene medidas oficiales?</span></label></div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="casilleros" value="No"><input type="checkbox" name="casilleros" value="Sí" class="toggle-input" @checked(($data['casilleros'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Cuenta con casilleros / guardarropa?</span></label></div>

        <div class="subhead">Solo piscinas</div>
        <div class="field"><label>¿Cuenta con andariveles?</label><select name="andariveles" @disabled($mode === 'ver')><option @selected(($data['andariveles'] ?? '') === 'No aplica')>No aplica</option><option @selected(($data['andariveles'] ?? '') === 'Sí')>Sí</option><option @selected(($data['andariveles'] ?? '') === 'No')>No</option></select></div>
        <div class="field"><label>¿Pisos seguros?</label><select name="pisos_seguros" @disabled($mode === 'ver')><option @selected(($data['pisos_seguros'] ?? '') === 'No aplica')>No aplica</option><option @selected(($data['pisos_seguros'] ?? '') === 'Sí')>Sí</option><option @selected(($data['pisos_seguros'] ?? '') === 'No')>No</option></select></div>
      </div>
    </section>

    <!-- 5. SERVICIOS BÁSICOS -->
    <section class="card">
      <h2><span class="n">5</span> Servicios básicos</h2>
      <div class="body grid">
        <div class="field"><label class="toggle-field"><input type="hidden" name="agua" value="No"><input type="checkbox" name="agua" value="Sí" class="toggle-input" data-reveal="agua_cod_reveal" @checked(($data['agua'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">Servicio de agua</span></label></div>
        <div class="field" id="agua_cod_reveal" @if(($data['agua'] ?? 'No') !== 'Sí') style="display:none" @endif><label>Código de suministro (agua)</label><input name="agua_cod" value="{{ $data['agua_cod'] ?? '' }}" @disabled($mode === 'ver')></div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="agua_independiente" value="No"><input type="checkbox" name="agua_independiente" value="Sí" class="toggle-input" @checked(($data['agua_independiente'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">Suministro de agua independiente de otra infraestructura</span></label></div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="agua_pagado" value="No"><input type="checkbox" name="agua_pagado" value="Sí" class="toggle-input" @checked(($data['agua_pagado'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">La administración ya paga su servicio de agua</span></label></div>

        <div class="field"><label class="toggle-field"><input type="hidden" name="luz" value="No"><input type="checkbox" name="luz" value="Sí" class="toggle-input" data-reveal="luz_cod_reveal" @checked(($data['luz'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">Servicio de luz</span></label></div>
        <div class="field" id="luz_cod_reveal" @if(($data['luz'] ?? 'No') !== 'Sí') style="display:none" @endif><label>Código de suministro (luz)</label><input name="luz_cod" value="{{ $data['luz_cod'] ?? '' }}" @disabled($mode === 'ver')></div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="luz_independiente" value="No"><input type="checkbox" name="luz_independiente" value="Sí" class="toggle-input" @checked(($data['luz_independiente'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">Suministro de luz independiente de otra infraestructura</span></label></div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="luz_pagado" value="No"><input type="checkbox" name="luz_pagado" value="Sí" class="toggle-input" @checked(($data['luz_pagado'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">La administración ya paga su servicio de luz</span></label></div>

        <div class="subhead">Instalación eléctrica</div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="ilum_general" value="No"><input type="checkbox" name="ilum_general" value="Sí" class="toggle-input" @checked(($data['ilum_general'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">Iluminación general de la infraestructura</span></label></div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="llave_dif" value="No"><input type="checkbox" name="llave_dif" value="Sí" class="toggle-input" @checked(($data['llave_dif'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Cuenta con llave diferencial?</span></label></div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="llaves_term" value="No"><input type="checkbox" name="llaves_term" value="Sí" class="toggle-input" @checked(($data['llaves_term'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Cuenta con llaves térmicas?</span></label></div>

        <div class="subhead">Iluminación del campo</div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="ilum_campo" value="No"><input type="checkbox" name="ilum_campo" value="Sí" class="toggle-input" data-reveal="ilum_tipo_reveal,ilum_estado_reveal" @checked(($data['ilum_campo'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">Iluminación del campo deportivo</span></label></div>
        <div class="field"><label>Número de postes (#)</label><input name="postes" value="{{ $data['postes'] ?? '' }}" @disabled($mode === 'ver') type="number"></div>
        <div class="field" id="ilum_tipo_reveal" @if(($data['ilum_campo'] ?? 'No') !== 'Sí') style="display:none" @endif><label>Tipo de iluminación</label><select name="ilum_tipo" @disabled($mode === 'ver')><option @selected(($data['ilum_tipo'] ?? '') === 'LED')>LED</option><option @selected(($data['ilum_tipo'] ?? '') === 'Halógena')>Halógena</option><option @selected(($data['ilum_tipo'] ?? '') === 'Otro')>Otro</option></select></div>
        <div class="field" id="ilum_estado_reveal" @if(($data['ilum_campo'] ?? 'No') !== 'Sí') style="display:none" @endif><label>Estado de iluminación</label><select name="ilum_estado" @disabled($mode === 'ver')><option @selected(($data['ilum_estado'] ?? '') === 'Muy bueno')>Muy bueno</option><option @selected(($data['ilum_estado'] ?? '') === 'Bueno')>Bueno</option><option @selected(($data['ilum_estado'] ?? '') === 'Regular')>Regular</option><option @selected(($data['ilum_estado'] ?? '') === 'Malo')>Malo</option><option @selected(($data['ilum_estado'] ?? '') === 'Muy malo')>Muy malo</option></select></div>

        <div class="field"><label class="toggle-field"><input type="hidden" name="tomacorrientes" value="No"><input type="checkbox" name="tomacorrientes" value="Sí" class="toggle-input" @checked(($data['tomacorrientes'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Tomacorrientes para eventos?</span></label></div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="videovigilancia" value="No"><input type="checkbox" name="videovigilancia" value="Sí" class="toggle-input" @checked(($data['videovigilancia'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Sistema de videovigilancia?</span></label></div>
      </div>
    </section>

    <!-- 6. DEFENSA CIVIL -->
    <section class="card">
      <h2><span class="n">6</span> Defensa civil</h2>
      <div class="body grid">
        <div class="field"><label class="toggle-field"><input type="hidden" name="plan_conting" value="No"><input type="checkbox" name="plan_conting" value="Sí" class="toggle-input" @checked(($data['plan_conting'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Cuenta con plan de contingencia?</span></label></div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="topico" value="No"><input type="checkbox" name="topico" value="Sí" class="toggle-input" data-reveal="topico_estado_reveal" @checked(($data['topico'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Cuenta con espacio para tópico?</span></label></div>
        <div class="field" id="topico_estado_reveal" @if(($data['topico'] ?? 'No') !== 'Sí') style="display:none" @endif><label>Estado del tópico</label><select name="topico_estado" @disabled($mode === 'ver')><option @selected(($data['topico_estado'] ?? '') === 'Muy bueno')>Muy bueno</option><option @selected(($data['topico_estado'] ?? '') === 'Bueno')>Bueno</option><option @selected(($data['topico_estado'] ?? '') === 'Regular')>Regular</option><option @selected(($data['topico_estado'] ?? '') === 'Malo')>Malo</option><option @selected(($data['topico_estado'] ?? '') === 'Muy malo')>Muy malo</option></select></div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="extintor" value="No"><input type="checkbox" name="extintor" value="Sí" class="toggle-input" @checked(($data['extintor'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">¿Cuenta con extintor?</span></label></div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="senal_seguridad" value="No"><input type="checkbox" name="senal_seguridad" value="Sí" class="toggle-input" @checked(($data['senal_seguridad'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">Señalización de seguridad</span></label></div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="senal_salidas" value="No"><input type="checkbox" name="senal_salidas" value="Sí" class="toggle-input" @checked(($data['senal_salidas'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">Señalización de salidas</span></label></div>
        <div class="field"><label class="toggle-field"><input type="hidden" name="senal_banos" value="No"><input type="checkbox" name="senal_banos" value="Sí" class="toggle-input" @checked(($data['senal_banos'] ?? 'No') === 'Sí') @disabled($mode === 'ver')><span class="toggle-switch"></span><span class="toggle-text">Señalización de baños</span></label></div>
      </div>
    </section>

    <!-- 7. IMAGEN DE REFERENCIA -->
    <section class="card">
      <h2><span class="n">7</span> Imagen de referencia</h2>
      <div class="body grid">
        @if(!empty($data['imagen_referencia']))
          <div class="field full">
            <label>Imagen actual</label>
            <img src="{{ asset('storage/'.$data['imagen_referencia']) }}" alt="Referencia del campo deportivo" style="max-width:280px;border-radius:8px;border:1px solid var(--line)">
          </div>
        @endif
        @if($mode !== 'ver')
          <div class="field full">
            <label>{{ !empty($data['imagen_referencia']) ? 'Reemplazar fotografía' : 'Subir fotografía' }}</label>
            <label for="imagen_referencia_input" class="dropzone" id="dropzone">
              <input type="file" name="imagen_referencia" id="imagen_referencia_input" accept="image/jpeg,image/png" hidden>
              <img id="dropzone-preview" class="dropzone-preview" alt="Vista previa de la fotografía seleccionada" style="display:none">
              <svg class="dropzone-icon" id="dropzone-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M7 18a4.5 4.5 0 0 1-1.44-8.77A5.5 5.5 0 0 1 16.3 7.02 4 4 0 0 1 18 15h-2"/>
                <path d="M12 12v9"/>
                <path d="m9 15 3-3 3 3"/>
              </svg>
              <div class="dropzone-title" id="dropzone-title">Subir una fotografía</div>
              <div class="dropzone-sub" id="dropzone-sub">Arrastra y suelta aquí, o haz clic para seleccionar — JPG o PNG</div>
              <div class="dropzone-filename" id="dropzone-filename"></div>
            </label>
          </div>
        @endif
      </div>
    </section>

    <div class="actions">
      <a href="{{ route('reginde.panel') }}" class="btn-ghost btn-link">Cancelar</a>
      @if($id)
        <a href="{{ route('reginde.pdf', $id) }}" class="btn-ghost btn-link">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="15" height="15" style="margin-right:6px"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M12 18v-6"/><path d="m9 15 3 3 3-3"/></svg>
          Descargar PDF
        </a>
      @endif
      @if($mode !== 'ver')
        <button type="submit" class="btn-primary">{{ $mode === 'editar' ? 'Guardar cambios' : 'Guardar registro' }}</button>
      @endif
    </div>
  </form>

@endsection

@if($mode !== 'ver')
@push('scripts')
<script>
  document.querySelectorAll('.toggle-input[data-reveal]').forEach(toggle=>{
    const targets = toggle.dataset.reveal.split(',')
      .map(id => document.getElementById(id.trim()))
      .filter(Boolean);
    if (!targets.length) return;
    toggle.addEventListener('change', ()=>{
      targets.forEach(t => { t.style.display = toggle.checked ? '' : 'none'; });
    });
  });

  const dropzone = document.getElementById('dropzone');
  if (dropzone) {
    const fileInput = document.getElementById('imagen_referencia_input');
    const filenameEl = document.getElementById('dropzone-filename');
    const previewEl = document.getElementById('dropzone-preview');
    const iconEl = document.getElementById('dropzone-icon');
    const titleEl = document.getElementById('dropzone-title');
    const subEl = document.getElementById('dropzone-sub');

    function mostrarArchivo(file) {
      if (!file) {
        filenameEl.textContent = '';
        previewEl.style.display = 'none';
        iconEl.style.display = '';
        titleEl.style.display = '';
        subEl.style.display = '';
        return;
      }
      previewEl.src = URL.createObjectURL(file);
      previewEl.style.display = '';
      iconEl.style.display = 'none';
      titleEl.style.display = 'none';
      subEl.style.display = 'none';
      filenameEl.textContent = `${file.name} — haz clic para cambiarla`;
    }

    fileInput.addEventListener('change', () => mostrarArchivo(fileInput.files[0]));

    ['dragover', 'dragenter'].forEach(evt => {
      dropzone.addEventListener(evt, (e) => {
        e.preventDefault();
        dropzone.classList.add('drag-over');
      });
    });
    ['dragleave', 'dragend'].forEach(evt => {
      dropzone.addEventListener(evt, () => dropzone.classList.remove('drag-over'));
    });
    dropzone.addEventListener('drop', (e) => {
      e.preventDefault();
      dropzone.classList.remove('drag-over');
      const file = e.dataTransfer.files[0];
      if (!file) return;
      if (!['image/jpeg', 'image/png'].includes(file.type)) {
        regindeToast('Solo se aceptan imágenes JPG o PNG', 'danger');
        return;
      }
      fileInput.files = e.dataTransfer.files;
      mostrarArchivo(file);
    });
  }

  @if($mode === 'editar')
  const form = document.getElementById('reginde');
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    regindeConfirm({
      title: '¿Guardar los cambios?',
      text: 'Se actualizará la información de este registro.',
      confirmText: 'Guardar cambios',
    }).then((ok) => { if (ok) form.submit(); });
  });
  @endif
</script>
@endpush
@endif
