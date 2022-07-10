
var TIEMPO_CONSULTA = 1000;

var CRONOMETRO = TIEMPO_CONSULTA;

var LIST_INVITADOS = new Array();

var Nuevo = {

	quitarInvitado: function(usuarioid){

		for(var i=0; i<LIST_INVITADOS.length; i++){

			if(usuarioid == LIST_INVITADOS[i].usuarioid)

				LIST_INVITADOS.splice(i,1);

		}

		Nuevo.listarUsuariosInvitados();

	},

	agregarUsuario: function(usuarioid,nombre,email){

		//LIST_INVITADOS.push({'usuarioid':usuarioid,'nombre':nombre});

		//alert(email);

		var $correos = $('#emails');

		var htmlCorreos = $correos.val().replace(/\s/g,'');

		if(htmlCorreos == '')

			$correos.val(email.replace(/\s/g,''));

		else

			$correos.val(htmlCorreos + ';' + email.replace(/\s/g,''));

		$('#modalListaUsuarios').modal('hide');

		//Nuevo.listarUsuariosInvitados();

	},

	listarUsuariosInvitados: function(){

		var htmlLista = '';

		for(var i=0; i<LIST_INVITADOS.length; i++){

			var item = LIST_INVITADOS[i];

			htmlLista += '<a class="labelInvitado" onclick="Nuevo.quitarInvitado('+item.usuarioid+')">'+item.nombre+'</a> | ';

		}

		$('#listaInvitados').html(htmlLista);

	}

};