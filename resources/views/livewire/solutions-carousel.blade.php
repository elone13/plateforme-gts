<div>
    <!-- Contrôles du carrousel -->
    <div class="flex justify-center space-x-4 mb-6">
        <button 
            wire:click="pauseAnimation"
            class="px-4 py-2 bg-primary text-white rounded-md hover:bg-yellow-500 transition-colors duration-200"
        >
            <i class="fas fa-pause mr-2"></i>Pause
        </button>
        
        <button 
            wire:click="resumeAnimation"
            class="px-4 py-2 bg-primary text-white rounded-md hover:bg-yellow-500 transition-colors duration-200"
        >
            <i class="fas fa-play mr-2"></i>Reprendre
        </button>
        
        <button 
            wire:click="startManualScroll"
            class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors duration-200"
        >
            <i class="fas fa-hand-paper mr-2"></i>Contrôle manuel
        </button>
    </div>

    <!-- Indicateur de statut -->
    <div class="text-center mb-4">
        @if($isPaused)
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                <i class="fas fa-pause mr-2"></i>Animation en pause
            </span>
        @else
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                <i class="fas fa-play mr-2"></i>Animation en cours
            </span>
        @endif
        
        @if($isManualScrolling)
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 ml-2">
                <i class="fas fa-hand-paper mr-2"></i>Mode manuel actif
            </span>
        @endif
    </div>

    <!-- Instructions pour le contrôle manuel -->
    @if($isManualScrolling)
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <i class="fas fa-info-circle text-blue-500 mr-3 text-xl"></i>
                <div>
                    <h4 class="font-medium text-blue-900">Mode contrôle manuel activé</h4>
                    <p class="text-blue-700 text-sm mt-1">
                        Cliquez et glissez sur le carrousel pour contrôler manuellement le défilement. 
                        L'animation automatique reprendra dans 2 secondes après avoir relâché.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Script pour gérer les événements Livewire -->
    <script>
        document.addEventListener('livewire:init', () => {
            const container = document.getElementById('solutions-container');
            const track = document.getElementById('solutions-track');
            let isMouseDown = false;
            let startX = 0;
            let currentTransform = 0;

            // Écouter les événements Livewire
            Livewire.on('carousel-paused', () => {
                track.style.animationPlayState = 'paused';
            });

            Livewire.on('carousel-resume', () => {
                track.style.animationPlayState = 'running';
            });

            Livewire.on('carousel-resume-delayed', () => {
                // Reprendre l'animation après 2 secondes
                setTimeout(() => {
                    track.style.animationPlayState = 'running';
                }, 2000);
            });

            Livewire.on('carousel-reset-position', () => {
                // Réinitialiser la position du carrousel
                track.style.transform = 'translateX(0)';
            });

            // Détection du clic de souris
            container.addEventListener('mousedown', function(e) {
                if (!@this.isManualScrolling) return;
                
                isMouseDown = true;
                startX = e.pageX - container.offsetLeft;
                currentTransform = getComputedStyle(track).transform;
                container.style.cursor = 'grabbing';
            });

            // Détection du relâchement de la souris
            container.addEventListener('mouseup', function() {
                if (!@this.isManualScrolling) return;
                
                isMouseDown = false;
                container.style.cursor = 'grab';
                @this.stopManualScroll();
            });

            // Détection du mouvement de la souris
            container.addEventListener('mousemove', function(e) {
                if (!isMouseDown || !@this.isManualScrolling) return;
                
                e.preventDefault();
                const x = e.pageX - container.offsetLeft;
                const walk = (x - startX) * 2;
                
                // Calculer la nouvelle position
                const matrix = new DOMMatrix(currentTransform);
                const newX = matrix.m41 - walk;
                track.style.transform = `translateX(${newX}px)`;
            });

            // Détection de la sortie de la souris
            container.addEventListener('mouseleave', function() {
                if (!@this.isManualScrolling) return;
                
                isMouseDown = false;
                container.style.cursor = 'grab';
                @this.stopManualScroll();
            });

            // Curseur par défaut
            container.style.cursor = 'grab';
        });
    </script>
</div>
