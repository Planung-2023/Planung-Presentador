<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Pestaña presentación</title>
		<link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>" />
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<style>
			html.fullscreen-enabled {
				overflow: hidden;
			}
			body {
				margin: 0;
			}
			.center-screen {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
    	</style>
	</head>
	<body>
		<input type="file" id="pdfInput" accept=".pdf" hidden/>
		<div style="text-align: center;">
        	<button onclick="convertToImages()" class="btn btn-primary" id="iniciar" hidden>Iniciar</button>
    	</div>
		<div id="output">
		</div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"></script>
		<script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/canvasjs/1.7.0/canvasjs.min.js"></script>
		<script>
			document.addEventListener("DOMContentLoaded", function() {
				var fileInput = document.getElementById("pdfInput");

				// Ruta del archivo preexistente
				var filePath = "<?php echo e(asset($referenciaArchivo)); ?>";
                console.log(filePath);

				// Simular el evento de cambio del campo de carga de archivos
				var changeEvent = new Event("change");

				// Crear un objeto Blob con el contenido del archivo
				fetch(filePath)
					.then(response => response.blob())
					.then(blob => {
						// Crear un objeto File a partir del Blob
						var file = new File([blob], "PlanungSlides.pdf", { type: blob.type });

						// Crear un objeto FileList que contiene el archivo
						var fileList = new DataTransfer();
						fileList.items.add(file);

						// Asignar el objeto FileList al campo de carga de archivos
						fileInput.files = fileList.files;

						// Disparar el evento de cambio para activar cualquier lógica asociada al cambio del campo de carga de archivos
						fileInput.dispatchEvent(changeEvent);
					})
					.catch(error => {
						console.error("Error al cargar el archivo:", error);
					});

			});
		</script>
		<script>
			let currentIndex = 0;
			const imageUrls = []; // Array para almacenar las URL de las imágenes
			const outputDiv = document.getElementById('output');
			let fullscreenImageElement = null; // Mantén una referencia al elemento de imagen en pantalla completa
						
			async function convertToImages() {
				
				const pdfInput = document.getElementById('pdfInput');
				const button = document.getElementById('iniciar');

				button.style.display = 'none'; // Ocultar el botón
				
				outputDiv.innerHTML = ''; // Limpiar el contenido anterior
				
				const file = pdfInput.files[0];
				console.log(file);
				if (!file) {
					alert('Por favor, seleccione un archivo PDF.');
					return;
				}
				
				const reader = new FileReader();
				reader.onload = async (event) => {
				const pdfData = new Uint8Array(event.target.result);
				const pdf = await pdfjsLib.getDocument(pdfData).promise;
				
									
				for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
				const page = await pdf.getPage(pageNum);
				const viewport = page.getViewport({ scale: 1.67});
				
				const canvasElement = document.createElement('canvas');
				const canvasContext = canvasElement.getContext('2d');
				
				/* Obtener las dimensiones de la pantalla
				
				const screenWidth = window.innerWidth;
				const screenHeight = window.innerHeight;
				
				viewport.width = screenWidth;
				viewport.height = screenHeight;
				*/
				canvasElement.width = 2000;
				canvasElement.height = 1200;
				
				const renderContext = {
					canvasContext,
					viewport,
				};
				
				await page.render(renderContext).promise;
				
				const imageUrl = canvasElement.toDataURL('image/png');
				imageUrls.push(imageUrl); // Agregar la URL de la imagen al array
				}
				
				displayImage(0); // Inicia la secuencia de visualización
				};
				// Decir de manera anticipada la resolucion de la pantalla
				reader.readAsArrayBuffer(file);
			}

			function showPreviousSlide() {
			    if (currentIndex > 0) {
			        currentIndex--;
			        displayImage(currentIndex);
			    }
			}
			
			function showNextSlide() {
			    if (currentIndex < imageUrls.length - 1) {
			        currentIndex++;
			        displayImage(currentIndex);

				} 
							
			}
			
			function displayImage(currentIndex) {
			    if (currentIndex < imageUrls.length) {
					const imageElement = document.createElement("img");
					imageElement.src = imageUrls[currentIndex];
					outputDiv.innerHTML = ''; // Limpiar el contenido anterior
						
					outputDiv.appendChild(imageElement);

					if (document.documentElement.requestFullscreen) {
						document.documentElement.classList.add("fullscreen-enabled");
						document.documentElement.requestFullscreen();
					}					
			    }
			}

			function toggleFullscreen() {
				if (fullscreenImageElement) {
					if (document.fullscreenElement) {
						document.documentElement.classList.add("fullscreen-enabled");
						document.exitFullscreen();
					} else {
						document.documentElement.classList.add("fullscreen-enabled");
						fullscreenImageElement.requestFullscreen();
					}
				}
			}

			document.addEventListener("click", function() {
				// Verificar si la página no está en pantalla completa
				if (!document.fullscreenElement) {
					// Solicitar el modo de pantalla completa
					document.documentElement.requestFullscreen();
				}
			});		
	
		</script>
		<script type="module">
			import { io } from "https://cdn.socket.io/4.3.2/socket.io.esm.min.js";
			
			const socket = io("http://localhost:8000/presentador/socket");

			socket.on("Mensaje", (arg) => {
			    console.log(arg); // world
			});
			
			socket.on ("enviar", (currentIndex) => {
				displayImage(currentIndex);
			});	

			socket.on ("empezar", (currentIndex) => {
				convertToImages();
			});				
		</script>
	</body>
</html><?php /**PATH D:\Xumpp\htdocs\presentador-laravel\resources\views/presentador/presentacion.blade.php ENDPATH**/ ?>