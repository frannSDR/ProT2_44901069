// esperamos a que toda la página se termine de cargar antes de ejecutar nuestro código
document.addEventListener('DOMContentLoaded', function() {
    
    //* ----------------------- NAVBAR MENU (MENÚ HAMBURGUESA) -----------------------

    const hamburger = document.querySelector('.hamburger');
    const navbar = document.querySelector('.site-navbar');
    
    if (hamburger && navbar) {
        
        hamburger.addEventListener('click', function() {
            
            // si el menu esta cerrado lo abrimos, si esta abierto lo cerramos
            this.classList.toggle('active');         
            navbar.classList.toggle('active');       
            
            // parte de accesibilidad para lectores de pantalla
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);
        });
        
        // buscamos TODOS los enlaces dentro del menu de navegacion
        const navLinks = document.querySelectorAll('.site-navbar a');
        
        // para CADA enlace del menu...
        navLinks.forEach(link => {
            
            // cuando hagan click en cualquier enlace del menu...
            link.addEventListener('click', function() {
                // cerramos automáticamente el menú movil
                hamburger.classList.remove('active');      
                navbar.classList.remove('active');         
                hamburger.setAttribute('aria-expanded', 'false'); 
            });
        });
    }

    //* ----------------------- ADMIN USUARIOS (GESTION DE USUARIOS) -----------------------

    // variable global para recordar qué usuario queremos eliminar (la usamos en diferentes funciones, por eso es global)
    window.usuarioAEliminar = null;

    //* FUNCIÓN: Mostrar el modal de confirmacion antes de eliminar
    window.confirmarEliminacion = function(userId) {
        
        // guardamos el id del usuario que queremos eliminar
        window.usuarioAEliminar = userId;
        
        const modal = document.getElementById('deleteModal');
        
        if (modal) {
            modal.style.display = 'flex';
        }
    };

    //* FUNCION: Cerrar el modal sin eliminar nada
    window.cerrarModal = function() {
        
        const modal = document.getElementById('deleteModal');
        
        if (modal) {
            modal.style.display = 'none';
        }
        
        // borramos la variable porque cancelamos la eliminacion
        window.usuarioAEliminar = null;
    };

    //* FUNCION: realmente eliminar el usuario (cuando confirman en el modal)
    window.eliminarUsuario = function() {
        
        // solo ejecutamos si hay un usuario seleccionado para eliminar
        if (window.usuarioAEliminar) {
            
            // obtenemos la URL base de nuestro sitio web
            const baseUrl = getBaseUrl();
            
            // enviamos una peticion al servidor para eliminar el usuario
            // fetch = "ir a buscar" - como hacer una llamada telefonica al servidor
            fetch(`${baseUrl}admin/usuarios/eliminar/${window.usuarioAEliminar}`, {
                method: 'DELETE',  // hacemos una peticion del tipo DELETE (eliminar)
                headers: {         // informacion adicional que enviamos
                    'X-Requested-With': 'XMLHttpRequest',  // le decimos que es AJAX
                    'Content-Type': 'application/json'     // formato de datos JSON
                }
            })
            // cuando el servidor nos responda...
            .then(response => response.json())  // convertimos la respuesta a JSON
            
            // cuando ya tenemos los datos del servidor...
            .then(data => {
                
                // si todo salio bien (servidor dice "success: true")
                if (data.success) {
                    
                    // buscamos la fila del usuario en la tabla HTML
                    const userRow = document.getElementById(`usuario-${window.usuarioAEliminar}`);
                    
                    // si encontramos la fila...
                    if (userRow) {
                        // la eliminamos de la pantalla (ya no se ve)
                        userRow.remove();
                    }
                    
                    // mostramos mensaje de exito en verde
                    showAlert('success', data.message);
                    
                } else {
                    // si hubo un error, mostramos mensaje en rojo
                    showAlert('error', data.message);
                }
                
                // cerramos el modal de confirmacion
                window.cerrarModal();
            })
            // si algo sale mal con la conexion al servidor...
            .catch(error => {
                // mostramos mensaje de error generico
                showAlert('error', 'Error al eliminar el usuario.');
                
                // cerramos el modal
                window.cerrarModal();
            });
        }
    };

    //* FUNCION: activar o desactivar un usuario (cambiar su estado)
    window.cambiarEstado = function(userId) {
        
        // obtenemos la URL base de nuestra pagina web
        const baseUrl = getBaseUrl();
        
        // enviamos una peticion al servidor para cambiar el estado del usuario
        fetch(`${baseUrl}admin/usuarios/cambiar-estado/${userId}`, {
            method: 'POST',  // hacemos un tipo de peticion POST (enviar datos)
            headers: {       // informacion adicional
                'X-Requested-With': 'XMLHttpRequest',  // es una petición AJAX
                'Content-Type': 'application/json'     // formato JSON
            }
        })
        // cuando el servidor responda...
        .then(response => response.json())  // convertimos respuesta a JSON
        
        // cuando tengamos los datos...
        .then(data => {
            
            // si todo salio bien...
            if (data.success) {
                // recargamos toda la pagina para ver los cambios
                location.reload();
                
            } else {
                // si hubo error, mostramos mensaje en rojo
                showAlert('error', data.message);
            }
        })
        // si hay problemas de conexion...
        .catch(error => {
            // mensaje de error generico
            showAlert('error', 'Error al cambiar el estado del usuario.');
        });
    };

    //* FUNCION: mostrar mensajes de exito o error en la pantalla
    window.showAlert = function(type, message) {
        
        // creamos un nuevo elemento HTML (como un cuadrito de mensaje)
        const alert = document.createElement('div');
        
        // le damos clases CSS 
        alert.className = `alert alert-${type}`;
        
        // si type = 'success' → icono de check ✅
        // si type = 'error' → ícono de exclamación ❌
        alert.innerHTML = `<i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle"></i> ${message}`;

        // buscamos el contenedor principal de la pagina de admin
        const container = document.querySelector('.admin-container');
        
        // si encontramos el contenedor...
        if (container) {
            
            // insertamos el mensaje AL PRINCIPIO del contenedor
            // (arriba de todo, para que se vea primero)
            container.insertBefore(alert, container.firstChild);

            // despues de 5 segundos...
            setTimeout(() => {
                
                // si el mensaje todavia esta en la pantalla...
                if (alert.parentNode) {
                    // (desaparece)
                    alert.remove();
                }
            }, 5000);  // 5 segundos
        }
    };

    //* FUNCION: Obtener la URL base de nuestro sitio web
    // ejemplo: si estamos en "http://localhost/FilmStream/admin/usuarios"
    // esta funcion nos devuelve "http://localhost/FilmStream/"
    function getBaseUrl() {
        const metaBase = document.querySelector('meta[name="base-url"]');
        
        if (metaBase) {
            return metaBase.getAttribute('content');
        } else {
            // si no hay meta tag, mostrar error
            console.error('Meta tag base-url no encontrado');
            return '/'; // URL por defecto
        }
    }

    //* EVENTO: cerramos el modal si se hace click afuera del mismo
    window.addEventListener('click', function(event) {
        
        const modal = document.getElementById('deleteModal');
        
        // si existe el modal y el usuario clikea fuera de el...
        if (modal && event.target === modal) {
            // cerramos el modal automaticamente
            window.cerrarModal();
        }
    });

    //* EVENTO: cerramos el modal si se presiona la tecla "Esc"
    document.addEventListener('keydown', function(event) {
        
        if (event.key === 'Escape') {
            
            const modal = document.getElementById('deleteModal');
            
            // si existe y esta visible...
            if (modal && modal.style.display === 'flex') {
                // lo cerramos
                window.cerrarModal();
            }
        }
    });

    // Funciones del reproductor
    const playBtn = document.getElementById('play-movie-btn');
    const playerContainer = document.getElementById('movie-player-container');
    const closeBtn = document.getElementById('close-player-btn');
    const fullscreenBtn = document.getElementById('fullscreen-btn');

    // Mostrar reproductor
    if (playBtn) {
        playBtn.addEventListener('click', function() {
            if (window.magnetLink) {
                playerContainer.style.display = 'block';
                playBtn.style.display = 'none';
                // Aquí se integrará WebTorrent cuando lo implementes
                initializePlayer();
            } else {
                alert('Esta película no está disponible para reproducir en línea.');
            }
        });
    }

    // Cerrar reproductor
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            playerContainer.style.display = 'none';
            playBtn.style.display = 'inline-flex';
            // Detener reproducción
            stopPlayer();
        });
    }

    // Pantalla completa
    if (fullscreenBtn) {
        fullscreenBtn.addEventListener('click', function() {
            const videoElement = document.querySelector('#video-player video');
            if (videoElement) {
                if (videoElement.requestFullscreen) {
                    videoElement.requestFullscreen();
                } else if (videoElement.webkitRequestFullscreen) {
                    videoElement.webkitRequestFullscreen();
                }
            }
        });
    }

    function initializePlayer() {
        // Aquí irá la lógica de WebTorrent
        document.getElementById('loading-text').textContent = 'Conectando...';

        // Simulación de carga (remover cuando implementes WebTorrent)
        setTimeout(() => {
            document.querySelector('.player-loading').style.display = 'none';
            document.getElementById('video-player').innerHTML = '<p style="text-align: center; color: #ccc; padding: 2rem;">Reproductor listo para WebTorrent</p>';
        }, 2000);
    }

    function stopPlayer() {
        // Aquí irá la lógica para detener WebTorrent
        document.querySelector('.player-loading').style.display = 'flex';
        document.getElementById('video-player').innerHTML = '';
    }

});