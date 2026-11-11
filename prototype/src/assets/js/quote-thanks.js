// BRG-84 §3.7: the thank-you text follows ?servicio= from a fixed map, set with textContent; any other value keeps the generic text.
(() => {
  const TEXT = {
    traduccion: 'y los documentos que adjuntó.',
    interpretacion: 'y los datos de su evento: fecha, idiomas, asistentes y lugar.',
  };
  const service = new URLSearchParams(location.search).get('servicio');
  const detail = document.getElementById('gracias-detalle');
  if (detail && Object.hasOwn(TEXT, service)) detail.textContent = TEXT[service];
})();
