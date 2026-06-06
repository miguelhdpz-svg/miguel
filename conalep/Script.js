// Función para simular el registro del estudiante
function mostrarMensaje() {
    const mensaje = document.getElementById('mensaje-exito');
    
    // Quitamos la clase 'hidden' para que el mensaje aparezca en pantalla
    mensaje.classList.remove('hidden');
    
    // Hacemos un pequeño efecto de animación en la consola
    console.log("¡Un estudiante está interesado en unirse al club del Conalep 129!");
}