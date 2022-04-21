<h1> Instalaciones requeridas</h1>
<ul>
    <li><strong> Composer </strong></li>
    <li><strong> Git </strong></li>
    <li><strong> Xampp</strong> o MySql + PHP</li>
</ul>

<h2>Abrir XAMPP e iniciar Apache y MySql</h2>
<h2>Crear una base de datos llamada <strong>apihaulmerpuntos</strong> en mysql</h2>

<h2>Clonar el proyecto</h2>

<h2>Abrir la terminal en la carpeta donde se clonó el proyecto y ejecutar los siguientes comandos</h2>

<ul>
    <li><strong> composer install </strong></li>
    <li>
        <strong> cp .env.example .env </strong>
        <ul>
            <li>Este comando copia el archivo .env.example y le cambia el nombre a .env </li>
            <li>Luego se deben modificar el valor de DB_DATABASE=apihaulmerpuntos </li>
        </ul>
    </li>
    <li><strong> php artisan key:generate</strong></li>
    <li><strong> pphp artisan migrate</strong></li>
    <li><strong> pphp artisan db:seed</strong></li>
    <li><strong> pphp artisan serve</strong></li>
</ul>
