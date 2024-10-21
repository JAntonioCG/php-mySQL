document.addEventListener('DOMContentLoaded', () => {
  const params = new URLSearchParams(window.location.search);
  const mensaje = params.get('mensaje');
  const error = params.get('error');
  const success = params.get('success');

  if (mensaje) {
      mostrarNotificacion(mensaje);
  }

  // Mostrar notificación de error si existe
  if (error) {
      mostrarNotificacion('Error: ' + error);
  }

  // Mostrar notificación de éxito si existe
  if (success) {
      mostrarNotificacion('Éxito: ' + success);
  }
});

function mostrarNotificacion(mensaje) {
  const notificacionesDiv = document.getElementById('notificaciones');
  const notificacion = document.createElement('div');
  notificacion.className = 'notificacion success'; // Cambia a 'error' según sea necesario
  notificacion.innerText = mensaje;

  // Muestra la notificación
  notificacion.style.display = 'block';
  notificacionesDiv.appendChild(notificacion);

  // Remueve la notificación después de 5 segundos
  setTimeout(() => {
      notificacion.remove();
  }, 5000);
}
