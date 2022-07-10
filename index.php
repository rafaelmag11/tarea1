<?php
session_start();
define('tmAu347djsa', true);
require 'parametros/seguridad.php';
require 'parametros/diseno.php';
require 'parametros/conexion.php';
require 'clases-externas/Generica.php';

if(isset($_GET["page"])){	
	$id = $_GET["page"];	
	if($id == 'inicio'){		
		mostrarInicio();	
	}	elseif($id == 'nuevo-ticket'){		
		if(comprobarLogueo() == FALSE)			
			mostrarLogueo();		
		else{		    		    
			echo "Si entra";			
			encabezado(TRUE,2,'');			
			require 'vistas/nuevo-ticket.php';		
		}	
	}	elseif($id == 'monitor'){		
		if(comprobarLogueo() == FALSE)			
			mostrarLogueo();		
		else{			
			encabezado(TRUE,3,'');			
			require 'vistas/monitor2.php';		
		}	
	}	elseif($id == 'monitor2'){		
		if(comprobarLogueo() == FALSE)			
			mostrarLogueo();		
		else{			
			encabezado(TRUE,3,'');			
			require 'vistas/monitor2.php';		
		}	
	}	elseif($id == 'cat-usuarios'){		
		if(comprobarLogueo() == FALSE)			
			mostrarLogueo();		
		else{			
			encabezado(TRUE,4,'');			
			require 'vistas/cat-usuarios.php';		
		}	
	}	elseif($id == 'cat-aplicaciones'){		
		if(comprobarLogueo() == FALSE)			
			mostrarLogueo();		
		else{			
			encabezado(TRUE,5,'');			
			require 'vistas/cat-aplicaciones.php';		
		}	
	}	elseif($id == 'cat-empresas'){		
		if(comprobarLogueo() == FALSE)			
			mostrarLogueo();		
		else{			
			encabezado(TRUE,6,'');			
			require 'vistas/cat-empresas.php';		
		}	
	}	elseif($id == 'cat-areas'){		
		if(comprobarLogueo() == FALSE)			
			mostrarLogueo();		
		else{			
			encabezado(TRUE,7,'');			
			require 'vistas/cat-areas.php';		
		}	
	}	elseif($id == 'cat-permisos'){		
		if(comprobarLogueo() == FALSE)			
			mostrarLogueo();		
		else{			
			encabezado(TRUE,8,'');			
			require 'vistas/cat-permisos.php';		
		}	
	}
	elseif($id == 'cat-correos'){
		if(comprobarLogueo() == FALSE)
			mostrarLogueo();
		else{
			encabezado(TRUE,9,'');
			require 'vistas/cat-correos.php';
		}

	}
	elseif($id == 'nuevo-usuario'){
		if(comprobarLogueo() == FALSE)
			mostrarLogueo();
		else{
			encabezado(TRUE,10,'');
			require 'vistas/nuevo-usuario.php';
		}

	}
	elseif($id == 'nueva-area'){
		if(comprobarLogueo() == FALSE)
			mostrarLogueo();
		else{
			encabezado(TRUE,11,'');
			require 'vistas/nueva-area.php';
		}

	}
	elseif($id == 'nueva-aplicacion'){
		if(comprobarLogueo() == FALSE)
			mostrarLogueo();
		else{
			encabezado(TRUE,12,'');
			require 'vistas/nueva-aplicacion.php';
		}

	}
	elseif($id == 'ordenes-trabajo'){
		if(comprobarLogueo() == FALSE)
			mostrarLogueo();
		else{
			encabezado(TRUE,13,'');
			require 'vistas/ordenes-trabajo.php';
		}

	}
}
else	
//die('Error en la conexion : ');	
	mostrarInicio();
pie();

function mostrarInicio(){	
	if(comprobarLogueo() == FALSE){		
		mostrarLogueo();	
	}	else{		
		encabezado(TRUE,1,'');		
		require 'vistas/inicio.php';	
	}
}

function mostrarLogueo(){	
	require 'parametros/diseno2.php';	
	encabezado2(FALSE,0,'');	
	require 'vistas/logueo.php';
}

?>