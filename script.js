document.getElementById('suggestionForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita que el formulario se envíe de forma tradicional

    // Obtiene los valores de los campos del formulario
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const message = document.getElementById('message').value;

    // Crea un nuevo elemento de lista para mostrar la sugerencia
    const suggestionList = document.getElementById('suggestionList');
    const listItem = document.createElement('li');
    listItem.textContent = `Nombre: ${name} | Correo: ${email} | Sugerencia: ${message}`;
    suggestionList.appendChild(listItem);

    // Muestra un mensaje de éxito
    document.getElementById('responseMessage').innerText = `Gracias, ${name}! Tu sugerencia ha sido enviada.`;

    // Reiniciar el formulario
    document.getElementById('suggestionForm').reset();
});