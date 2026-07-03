<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Ficha · {{ $data['denominacion'] ?? 'Infraestructura' }}</title>
<style>
  body{font-family:"Helvetica","Arial",sans-serif;color:#12211a;font-size:11px;margin:0;padding:24px}
  .header{border-bottom:3px solid #0f6b45;padding-bottom:12px;margin-bottom:16px}
  .header h1{margin:0;font-size:16px;color:#0a4d31;text-transform:uppercase}
  .header p{margin:3px 0 0;font-size:10px;color:#5c6b63}
  .titulo-ficha{font-size:20px;font-weight:bold;margin:14px 0 2px;color:#12211a}
  .subtitulo-ficha{font-size:11px;color:#5c6b63;margin:0 0 14px}
  .foto{margin:0 0 16px}
  .foto img{max-width:220px;max-height:160px;border:1px solid #d9e0db}
  h2.seccion{
    background:#f4f7f5;color:#0a4d31;font-size:12px;text-transform:uppercase;
    padding:6px 10px;margin:16px 0 0;border-left:4px solid #0f6b45;
  }
  table.campos{width:100%;border-collapse:collapse;margin-top:0}
  table.campos tr{border-bottom:1px solid #eef2ef}
  table.campos td{padding:6px 10px;vertical-align:top}
  table.campos td.label{width:42%;color:#5c6b63;font-weight:bold}
  table.campos td.valor{color:#12211a}
  .footer{margin-top:20px;font-size:9px;color:#93a09a;text-align:center}
</style>
</head>
<body>

  <div class="header">
    <h1>Registro de Inventario de la Subgerencia de Deporte</h1>
    <p>Sub Gerencia de Deporte, Recreación y Juventud · Nuevo Chimbote</p>
  </div>

  <div class="titulo-ficha">{{ $data['denominacion'] ?? 'Sin denominación' }}</div>
  <div class="subtitulo-ficha">Ficha técnica de infraestructura deportiva</div>

  @if(!empty($data['imagen_referencia']))
    <div class="foto">
      <img src="{{ public_path('storage/'.$data['imagen_referencia']) }}" alt="Referencia">
    </div>
  @endif

  @foreach($secciones as $titulo => $campos)
    <h2 class="seccion">{{ $titulo }}</h2>
    <table class="campos">
      @foreach($campos as $label => $key)
        <tr>
          <td class="label">{{ $label }}</td>
          <td class="valor">{{ ($data[$key] ?? '') !== '' ? $data[$key] : '—' }}</td>
        </tr>
      @endforeach
    </table>
  @endforeach

  <div class="footer"></div>

</body>
</html>
