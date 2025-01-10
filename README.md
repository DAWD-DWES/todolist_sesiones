# todolist_sesiones
Desarrolla un programa que permita al usuario mantener una pequeña agenda en una única página web.
La agenda almacenará únicamente dos datos de cada persona: su nombre y un número de teléfono. Además, no podrá haber nombres repetidos en la agenda.
En la parte superior de la página web se mostrará el contenido de la agenda. 
En la parte inferior debe figurar un sencillo formulario con dos cuadros de texto, uno para el nombre y otro para el número de teléfono.
Cada vez que se envíe el formulario:
* Si el nombre está vacío, se mostrará una advertencia.
* Si el nombre que se introdujo no existe en la agenda, y el número de teléfono no está vacío, se añadirá a la agenda.
* Si el nombre que se introdujo ya existe en la agenda y se indica un número de teléfono, se sustituirá el número de teléfono anterior.
* Si el nombre que se introdujo ya existe en la agenda y no se indica número de teléfono, se eliminará de la agenda la entrada correspondiente a ese nombre.
* En el momento que la agenda tenga un nombre nos aparecerá un nuevo formulario que nos permitirá vaciar todos los contactos. Para ello mandaremos en la url una variable a la misma página de la agenda (fíjate en la url de la primera imagen). Al procesar la página comprobaremos si nos ha llegado o no esta variable (acuérdate de $_GET)