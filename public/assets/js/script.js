// esperamos a que toda la página se termine de cargar antes de ejecutar nuestro código
document.addEventListener('DOMContentLoaded', function() {
    
    // ----------------------- NAVBAR MENU (MENÚ HAMBURGUESA) -----------------------
    const hamburger = document.querySelector('.hamburger');
    const navbar = document.querySelector('.site-navbar');
    // ... (tu lógica de navbar aquí, si aplica) ...
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

    // manejo de pestañas de idioma
    const languageTabs = document.querySelectorAll('.language-tab');
    const serverOptions = document.querySelectorAll('.server-options');
    
    languageTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const language = this.getAttribute('data-language');
            
            // Actualizar pestañas activas
            languageTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Mostrar las opciones de servidor correspondientes
            serverOptions.forEach(option => {
                option.classList.remove('active');
                if (option.getAttribute('data-language') === language) {
                    option.classList.add('active');
                }
            });
        });
    });
    
    // manejo de selección de servidor
    serverOptions.forEach(option => {
        option.addEventListener('click', function() {
            serverOptions.forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // creamos el reproductor dependiendo de la url de cada link
    const player = document.getElementById('video-player');
    document.querySelectorAll('.play-server-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            player.innerHTML = `<iframe src="${url}" width="100%" height="100%" frameborder="0" allowfullscreen allow="autoplay"></iframe>`;
            player.scrollIntoView({behavior: "smooth"});
        });
    });

    // cambio de temporada
    const seasonSelect = document.getElementById('season-select');
    const seasonEpisodes = document.querySelectorAll('.season-episodes-modern');
    
    function showSeason(seasonNumber) {
        seasonEpisodes.forEach(season => {
            season.classList.remove('active');
            if (season.dataset.season === seasonNumber) {
                season.classList.add('active');
            }
        });

        setTimeout(() => {
            initializeLanguageFilter();
        }, 100);
    }
    
    seasonSelect.addEventListener('change', function() {
        showSeason(this.value);
    });
    
    // mostrar primera temporada por defecto
    if (seasonEpisodes.length > 0) {
        seasonEpisodes[0].classList.add('active');
    }
    
    // filtro de idioma
    const langTabs = document.querySelectorAll('.lang-tab');
    const serverItems = document.querySelectorAll('.server-item');

    function applyLanguageFilter(selectedLang) {
        serverItems.forEach(item => {
            const itemLang = item.dataset.language;
            if (selectedLang === 'all' || itemLang === selectedLang) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function initializeLanguageFilter() {
        const activeLangTab = document.querySelector('.lang-tab.active');
        if (activeLangTab) {
            const initialLang = activeLangTab.dataset.language;
            applyLanguageFilter(initialLang);
        }
    }

    initializeLanguageFilter();
    
    langTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const selectedLang = this.dataset.language;
            
            // Actualizar tabs activos
            langTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Filtrar servidores por idioma
            applyLanguageFilter(selectedLang);
        });
    });
    
    // dropdown de servidores
    const serversToggles = document.querySelectorAll('.servers-toggle');
    
    serversToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = this.closest('.servers-dropdown');
            
            // Cerrar otros dropdowns
            document.querySelectorAll('.servers-dropdown').forEach(d => {
                if (d !== dropdown) d.classList.remove('active');
            });
            
            dropdown.classList.toggle('active');
        });
    });
    
    // cerrar dropdowns al hacer click fuera
    document.addEventListener('click', function() {
        document.querySelectorAll('.servers-dropdown').forEach(d => {
            d.classList.remove('active');
        });
    });
    
    // reproducir episodios
    const playButtons = document.querySelectorAll('.play-episode-btn');
    
    function playVideo(url) {
        const videoContainer = document.getElementById('video-player');
        videoContainer.innerHTML = `<iframe src="${url}" width="100%" height="100%" allowfullscreen></iframe>`;
        videoContainer.classList.add('active');
        videoContainer.scrollIntoView({ behavior: 'smooth' });
    }
    
    serverItems.forEach(item => {
        item.addEventListener('click', function() {
            const url = this.dataset.url;
            playVideo(url);
            this.closest('.servers-dropdown').classList.remove('active');
        });
    });
    
    playButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const episodeId = this.dataset.episode;
            const firstServer = this.closest('.episode-item-modern').querySelector('.server-item');
            if (firstServer) {
                const url = firstServer.dataset.url;
                playVideo(url);
            }
        });
    });
});