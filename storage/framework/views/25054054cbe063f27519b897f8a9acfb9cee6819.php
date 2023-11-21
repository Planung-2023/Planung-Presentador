<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pestaña presentador</title>
        <link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>" />
        <link id="theme-style" rel="stylesheet" href="<?php echo e(asset('css/styles3.css')); ?>">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/> 
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">   
    </head>

    <body style="background-color: #3a3a3a;">
        <nav class="navbar navbar-dark bg-dark navbar-expand-lg fixed-top">
            <div class="container-fluid">
                <a href="<?php echo e(route('volver')); ?>" class="btn btn-secondary">Volver</a>
                <div id="contenedor-estado" class="bg-secondary p-2 rounded ml-auto d-flex align-items-center" style="margin-right: 45%">
                    <div class="">
                        <span id="texto-presentacion">No está presentando</span>
                    </div>
                </div>
            </div>
        </nav>

        <div class="sussy d-flex container-fluid justify-content-between">
            <div class="collapse navbar-collapse" id="navbarNav">
                <form class="d-flex container-fluid justify-content-between">
                    <input type="file" id="pdfInput" accept=".pdf"/>
                </form>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-around h-100">
            <div id="output1" class="d-flex p-2 bg-secondary rounded-2"></div>
            <div class="side-boxes d-flex flex-column align-items-center">
                <div id="output2" class="d-flex p-2 bg-secondary rounded-2"></div>
                <div id="infoDiv">
                    <span class="d-flex text-white align-items-center my-5">
                        <h1 id="currentIndexValue" class="m-0">   
                            -                     
                        </h1>
                        <h1 class="m-0 px-2">
                             / 
                        </h1>
                        <h1 id="imgUrlsLengthValue" class="m-0">
                            -
                        </h1>
                    </span>
                </div>
                <div class="bg-secondary px-4 py-2 rounded-2">
                    <p class="text-white fs-3 text-center m-0" id="tiempo">00:00:00.00</p>
                    <div class="d-flex justify-content-around">
                        <div class="btn" onclick="togglePausar()">
                            <i class="fas fa-pause text-white"></i>
                        </div>
                        <div class="btn" onclick="reiniciar()">
                            <i class="fas fa-undo-alt text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom-buttons d-flex flex-row justify-content-center">
            <div>
                <p class="labels mx-0 text-center">Atrás</p>
                <button class="btn btn-secondary rounded-button custom-arrow-button" onclick="showPreviousSlide()" id="btn-anterior" disabled><i class="material-icons">keyboard_arrow_left</i></button>
            </div>
            <div class="mx-3" id="conteiner-empezar">
                <p class="labels mx-0 text-center" id="empezar">Empezar</p>
                <button class="btn btn-secondary custom-play-button" onclick="empezarPresentacion(), iniciar()" id="btn-empezar" disabled><i class="material-icons">play_arrow</i></button>
            </div>
            <div>
                <p class="labels mx-0 text-center">Siguiente</p>
                <button class="btn btn-secondary custom-arrow-button" onclick="showNextSlide()" id="btn-siguiente" disabled><i class="material-icons">keyboard_arrow_right</i></button>
            </div>
            <div class="mx-3" id="conteiner-iniciar"> 
                <p class="labels mx-0 text-center" id="iniciar">Iniciar</p>
                <button class="btn btn-secondary custom-arrow-button" onclick="iniciarPresentacion(), convertFileToImagesAndShow()" id="btn-iniciar"><i class="bi bi-display fs-4 d-flex"></i></button>
            </div>

        <!-- JS (Parte Lógica) -->

        <script>
            let newTab;
            let tiempoRef = Date.now()
            let cronometrar = false
            let acumulado = 0
            let habilitarFuncionalidades = false;

            function iniciar() {
                habilitarFuncionalidades = true;
                cronometrar = true
            }

            function pausar() {
                habilitarFuncionalidades = false;
                cronometrar = false
            }

            function reiniciar() {
                acumulado = 0
            }

            setInterval(() => {
                let tiempo = document.getElementById("tiempo")
                if (cronometrar && habilitarFuncionalidades) {
                    acumulado += Date.now() - tiempoRef
                }
                tiempoRef = Date.now()
                tiempo.innerHTML = formatearMS(acumulado)
            }, 1000 / 60);

            function formatearMS(tiempo_ms) {
                let MS = tiempo_ms % 1000

                //Agregué la variable St para solucionar el problema de contar los minutos y horas.

                let St = Math.floor(((tiempo_ms - MS) / 1000))

                let S = St % 60
                let M = Math.floor((St / 60) % 60)
                let H = Math.floor((St / 60 / 60))
                Number.prototype.ceros = function(n) {
                    return (this + "").padStart(n, 0)
                }

                return H.ceros(2) + ":" + M.ceros(2) + ":" + S.ceros(2) +
                    "." + MS.ceros(3)
            }

            function togglePausar() {
                if (cronometrar) {
                    pausar();
                } else {
                    iniciar();
                }
            }
                   
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"></script>
        <script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/canvasjs/1.7.0/canvasjs.min.js"></script>
        <script>
			document.addEventListener("DOMContentLoaded", function() {
				var fileInput = document.getElementById("pdfInput");

				// ACA DEBERÍA IR EL FILEPATH SACADO DE LA DB
				var filePath = "<?php echo e(asset($referenciaArchivo)); ?>";
                console.log(filePath);

				// Simular el evento de cambio del campo de carga de archivos
				var changeEvent = new Event("change");

				// Crear un objeto Blob con el contenido del archivo
				fetch(filePath)
					.then(response => response.blob())
					.then(blob => {
						// Crear un objeto File a partir del Blob
						var file = new File([blob], "archivo.pdf", { type: blob.type });

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
            //var currentIndex1 = 0;
            //var currentIndex2 = 1;
            var currentIndexes = [0, 1];
            const imageUrls1 = [];
            const imageUrls2 = [];

            const outputDiv1 = document.getElementById('output1');
            outputDiv1.style.width = "698px";
            outputDiv1.style.height = "400px";
            const outputDiv2 = document.getElementById('output2');
            outputDiv2.style.width = "280px";
            outputDiv2.style.height = "150px";
            function enableButton(idButton) {
                document.getElementById(idButton).disabled = false;
            }

            function disableButton(idButton) {
                document.getElementById(idButton).disabled = true;
            }



            function convertFileToImagesAndShow(input) {
                convertToImages(outputDiv1, 0, 0.62, 710, 400, imageUrls1, input);
                convertToImages(outputDiv2, 1, 0.23, 265, 150, imageUrls2, input);


                enableButton("btn-siguiente");
            } 

            async function convertToImages(outputDiv, initialIndex, scale, width, height, imagesUrls, input) {
                outputDiv.innerHTML = ''; // Limpiar el contenido anterior
                
                const file = input ? input.files[0] : document.getElementById('pdfInput').files[0];
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
                        const viewport = page.getViewport({ scale: scale});
                        
                        const canvasElement = document.createElement('canvas');
                        const canvasContext = canvasElement.getContext('2d');
                
                        // Obtener las dimensiones de la pantalla
                
                        const screenWidth = window.innerWidth;
                        const screenHeight = window.innerHeight;

                        viewport.width = screenWidth;
                        viewport.height = screenHeight;

                        canvasElement.width = width;
                        canvasElement.height = height;

                        const renderContext = {
                            canvasContext,
                            viewport,
                        };
                
                        await page.render(renderContext).promise;
                        
                        imageUrl = canvasElement.toDataURL('image/png');
                        imagesUrls.push(imageUrl); // Agregar la URL de la imagen al array
                    }
                
                    displayImage(initialIndex, outputDiv, imagesUrls); // Inicia la secuencia de visualización
                };
                // Decir de manera anticipada la resolucion de la pantalla
                reader.readAsArrayBuffer(file); 
                
            }

        </script>       
        <script>
            function showPreviousSlide() {
                displayPreviousSlide(outputDiv1, imageUrls1, 0);
                displayPreviousSlide(outputDiv2, imageUrls2, 1);
            }

            function displayPreviousSlide(outputDiv, imageUrls, indexOfCurrentIndexes) {
                const currentIndex = currentIndexes[indexOfCurrentIndexes];
                if (currentIndex > 0) {
                    currentIndexes[indexOfCurrentIndexes] = currentIndex - 1;
                    updateIndexInfo();
                    console.log(indexOfCurrentIndexes === 0? "Grande" : "Chico", currentIndex, currentIndexes);
                    displayImage(currentIndex -1 , outputDiv, imageUrls);
                    enableButton("btn-siguiente");

                    if (currentIndex - 1 === 0) {
                        disableButton("btn-anterior");
                    }
                }
            }

            function showNextSlide() {
                displayNextSlide(outputDiv1, imageUrls1, 0);
                displayNextSlide(outputDiv2, imageUrls2, 1);        
            }

            function displayNextSlide(outputDiv, imageUrls, indexOfCurrentIndexes) {
                const currentIndex = currentIndexes[indexOfCurrentIndexes];
                if (currentIndex < imageUrls.length - 1) {
                    currentIndexes[indexOfCurrentIndexes] = currentIndex +1;
                    updateIndexInfo();
                    console.log(indexOfCurrentIndexes === 0? "Grande" : "Chico", currentIndex, currentIndexes);
                    displayImage(currentIndex +1, outputDiv, imageUrls);
                    enableButton("btn-anterior");
                } 
                else {
                    currentIndexes[indexOfCurrentIndexes] = currentIndex +1;

                    disableButton("btn-siguiente");

                    var imagenNegra = document.createElement("div");
                    imagenNegra.id = "imagenNegra";
                    imagenNegra.style.width = "100%";
                    imagenNegra.style.height = "100%";
                    imagenNegra.style.backgroundColor = "black";

                    var output2Div = document.getElementById("output2");
                    output2Div.innerHTML = '';
                    output2Div.appendChild(imagenNegra);
                }
            }

            function displayImage(currentIndex, outputDiv, imageUrls) {
                if (currentIndex < imageUrls.length) {
                    const imageElement = document.createElement("img");
                    imageElement.src = imageUrls[currentIndex];
                    outputDiv.innerHTML = ''; // Limpiar el contenido anterior                        
                    outputDiv.appendChild(imageElement);
                }
            }

            function displayImage(currentIndex, outputDiv, imageUrls) {
                if (currentIndex < imageUrls.length) {
                    const imageElement = document.createElement("img");
                    imageElement.src = imageUrls[currentIndex];
                    outputDiv.innerHTML = ''; // Limpiar el contenido anterior						
                    outputDiv.appendChild(imageElement);
                    updateIndexInfo();
                }
            }

            function updateIndexInfo() {
                // Actualiza el valor del índice actual y la longitud de imgUrls en el HTML
                document.getElementById("currentIndexValue").innerText = currentIndexes[0] + 1; // Cambia [0] por [1] si necesitas el índice del segundo array
                document.getElementById("imgUrlsLengthValue").innerText = imageUrls1.length; // Cambia a imageUrls2.length si necesitas la longitud del segundo array
            }

            async function iniciarPresentacion() {
                const newTab = window.open('<?php echo e(route("presentacion")); ?>' , '_blank');
                const btnIniciar = document.getElementById("btn-iniciar");
                const iniciar = document.getElementById("iniciar");
                const contIniciar = document.getElementById("conteiner-iniciar");
                btnIniciar.style.display = "none";
                iniciar.style.display = "none";
                contIniciar.style.display = "none";
                enableButton("btn-empezar")
            }
            
            async function empezarPresentacion() {
                const btnEmpezar = document.getElementById("btn-empezar");
                const Empezar = document.getElementById("empezar");
                const contEmpezar = document.getElementById("conteiner-empezar");
                btnEmpezar.style.display = "none";
                Empezar.style.display = "none";
                contEmpezar.style.display = "none";
                const textoPresentacion = document.getElementById("texto-presentacion");
                const contenedorEstado = document.getElementById("contenedor-estado");
                contenedorEstado.classList.remove("bg-secondary");
                contenedorEstado.classList.add("bg-primary");
                textoPresentacion.innerText = "Presentando";    
            }

        </script>
        <script type="module">
            import { io } from "https://cdn.socket.io/4.3.2/socket.io.esm.min.js";
            
            const socket = io("http://localhost:8000/presentador/socket");
            
            export function empezarPresentacion() {
                const condicion = "empezar";
                socket.emit("leer", condicion);
            }
            export function showPreviousSlide(indexOfCurrentIndexes) {
                const currentIndex = currentIndexes[indexOfCurrentIndexes];
                socket.emit("leer", currentIndex);
            }            
            export function showNextSlide(indexOfCurrentIndexes) {
                const currentIndex = currentIndexes[indexOfCurrentIndexes];
                socket.emit("leer", currentIndex);
            }

            document.getElementById("btn-empezar").addEventListener("click", () => {
                empezarPresentacion();
            });
            document.getElementById("btn-anterior").addEventListener("click", () => {
                showPreviousSlide(0);
            });
            document.getElementById("btn-siguiente").addEventListener("click", () => {
                showNextSlide(0);
            });
        </script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>
<?php /**PATH C:\xampp\htdocs\presentador-laravel\resources\views/presentador/presentador.blade.php ENDPATH**/ ?>